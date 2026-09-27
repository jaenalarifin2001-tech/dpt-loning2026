<?php

namespace App\Http\Controllers;

use App\Models\AksesLog;
use App\Models\Pemilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class DptController extends Controller
{
    /**
     * Halaman utama — generate captcha penjumlahan
     */
    public function index()
    {
        $stats = [
            'total' => Pemilih::aktif()->count(),
            'dusun' => Pemilih::aktif()->distinct('dusun')->count('dusun'),
            'tps'   => Pemilih::aktif()->distinct('tps')->count('tps'),
        ];

        // Generate captcha baru
        $captcha = $this->generateCaptcha();

        return view('dpt.index', compact('stats', 'captcha'));
    }

    /**
     * Proses pencarian dengan proteksi berlapis
     */
    public function cari(Request $request)
    {
        // ─── LAYER 1: Rate Limiting per IP ───
        $rateKey = 'cek-dpt:' . $request->ip();
        if (RateLimiter::tooManyAttempts($rateKey, 5)) {
            $seconds = RateLimiter::availableIn($rateKey);
            throw ValidationException::withMessages([
                'nik' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
            ]);
        }

        // ─── LAYER 2: Honeypot Check ───
        if ($request->filled('website')) {
            // Bot mengisi field tersembunyi → blokir
            AksesLog::create([
                'nik_dicari' => null,
                'ip_address' => $request->ip(),
                'user_agent' => 'HONEYPOT_BOT',
                'berhasil'   => false,
            ]);
            RateLimiter::hit($rateKey, 300); // block 5 menit

            throw ValidationException::withMessages([
                'nik' => 'Aktivitas mencurigakan terdeteksi.',
            ]);
        }

        // ─── LAYER 3: Time-based Check (min 2 detik) ───
        $formLoadedAt = Session::get('form_loaded_at');
        if ($formLoadedAt && (time() - $formLoadedAt) < 2) {
            RateLimiter::hit($rateKey, 60);
            throw ValidationException::withMessages([
                'nik' => 'Formulir disubmit terlalu cepat. Mohon coba lagi.',
            ]);
        }

        // ─── LAYER 4: Validasi Input ───
        $validated = $request->validate([
            'nik'      => ['required', 'string', 'digits:16', 'regex:/^[0-9]+$/'],
            'captcha'  => ['required', 'numeric'],
        ], [
            'nik.required'     => 'NIK wajib diisi.',
            'nik.digits'       => 'NIK harus 16 digit angka.',
            'nik.regex'        => 'NIK hanya boleh berisi angka.',
            'captcha.required' => 'Jawaban verifikasi wajib diisi.',
            'captcha.numeric'  => 'Jawaban verifikasi harus berupa angka.',
        ]);

        // ─── LAYER 5: Verifikasi Captcha ───
        $expected = Session::get('captcha_answer');
        if ((int) $validated['captcha'] !== (int) $expected) {
            RateLimiter::hit($rateKey, 60);
            Session::forget('captcha_answer'); // hanguskan captcha

            throw ValidationException::withMessages([
                'captcha' => 'Jawaban verifikasi salah. Silakan coba lagi.',
            ]);
        }

        // Captcha benar → hanguskan (one-time use)
        Session::forget('captcha_answer');
        Session::forget('form_loaded_at');

        // ─── LAYER 6: Hit Rate Limiter ───
        RateLimiter::hit($rateKey, 60);

        // ─── PROSES PENCARIAN ───
        $pemilih = Pemilih::aktif()->where('nik', $validated['nik'])->first();

        AksesLog::create([
            'nik_dicari' => $validated['nik'],
            'ip_address' => $request->ip(),
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
            'berhasil'   => (bool) $pemilih,
        ]);

        if (!$pemilih) {
            return back()
                ->withInput()
                ->with('error', 'Data tidak ditemukan. Pastikan NIK benar atau hubungi panitia pemilihan.');
        }

        return view('dpt.hasil', compact('pemilih'));
    }

    /**
     * Generate captcha penjumlahan + simpan jawaban di session
     */
    private function generateCaptcha(): array
    {
        $a = random_int(1, 9);
        $b = random_int(1, 9);

        Session::put('captcha_answer', $a + $b);
        Session::put('form_loaded_at', time());

        return [
            'soal' => "{$a} + {$b} = ?",
        ];
    }
}