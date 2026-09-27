<?php

namespace App\Imports;

use App\Models\Pemilih;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class PemilihImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnError,
    SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    public int $berhasil = 0;
    public int $gagal = 0;

    /**
     * Setiap baris diproses di sini
     */
    public function model(array $row)
    {
        try {
            $this->berhasil++;

            return new Pemilih([
                'nik'           => $this->bersihkan($row['nik'] ?? ''),
                'nkk'           => $this->bersihkan($row['nkk'] ?? ''),
                'nama'          => trim($row['nama'] ?? ''),
                'tempat_lahir'  => trim($row['tempat_lahir'] ?? ''),
                'tanggal_lahir' => $this->parseTanggal($row['tanggal_lahir'] ?? null),
                'jenis_kelamin' => strtoupper(trim($row['jenis_kelamin'] ?? '')),
                'alamat'        => trim($row['alamat'] ?? ''),
                'rt'            => trim((string) ($row['rt'] ?? '')),
                'rw'            => trim((string) ($row['rw'] ?? '')),
                'dusun'         => trim($row['dusun'] ?? ''),
                'tps'           => trim($row['tps'] ?? ''),
                'status'        => 'aktif',
            ]);
        } catch (\Exception $e) {
            $this->gagal++;
            return null;
        }
    }

    /**
     * Validasi tiap baris
     */
    public function rules(): array
    {
        return [
            'nik'           => 'required|digits:16|unique:pemilih,nik',
            'nkk'           => 'required|digits:16',
            'nama'          => 'required|string|max:100',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'dusun'         => 'required',
            'tps'           => 'required',
        ];
    }

    /**
     * Pesan error custom (opsional)
     */
    public function customValidationMessages(): array
    {
        return [
            'nik.unique' => 'NIK :input sudah terdaftar (duplikat).',
            'nik.digits' => 'NIK :input harus 16 digit.',
            'nik.required' => 'NIK tidak boleh kosong.',
        ];
    }

    /**
     * Bersihkan angka dari karakter aneh (spasi, tanda hubung)
     */
    private function bersihkan($value): string
    {
        return preg_replace('/[^0-9]/', '', (string) $value);
    }

    /**
     * Parse tanggal: bisa format string atau Excel serial number
     */
    private function parseTanggal($value): string
    {
        if (empty($value)) {
            return now()->format('Y-m-d');
        }

        // Kalau Excel mengirim angka serial (contoh: 25569)
        if (is_numeric($value)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                    ->format('Y-m-d');
            } catch (\Exception $e) {
                // fall through
            }
        }

        // Kalau string biasa
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return now()->format('Y-m-d');
        }
    }

    /**
     * Handler jika ada error
     */
    public function onError(Throwable $e)
    {
        $this->gagal++;
    }

    /**
     * Handler kalau validasi gagal
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->gagal++;
        }
    }
}