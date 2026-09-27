<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Cek DPT - {{ $pemilih->nama }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ═══════════════════════════════════
           BACKGROUND ELEGAN (LAYAR)
           ═══════════════════════════════════ */
        .bg-elegant {
            background:
                radial-gradient(circle at 20% 10%, #065f46 0%, transparent 50%),
                radial-gradient(circle at 80% 90%, #7f1d1d 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, #064e3b 0%, #0f172a 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        .bg-elegant::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.08) 1px, transparent 0);
            background-size: 32px 32px;
            pointer-events: none;
        }

        .blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(80px);
            opacity: 0.4;
            z-index: 0;
            pointer-events: none;
        }

        /* ═══════════════════════════════════
           TOMBOL MERAH KEMILAU
           ═══════════════════════════════════ */
        .btn-red-gold {
            position: relative;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 40%, #991b1b 100%);
            overflow: hidden;
            box-shadow:
                0 10px 30px rgba(220, 38, 38, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            transition: all 0.3s ease;
        }

        .btn-red-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -150%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.4),
                rgba(255, 215, 0, 0.5),
                rgba(255, 255, 255, 0.4),
                transparent
            );
            transform: skewX(-25deg);
            animation: shineRed 3.5s infinite;
        }

        @keyframes shineRed {
            0% { left: -150%; }
            60% { left: 150%; }
            100% { left: 150%; }
        }

        .btn-red-gold:hover {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 40%, #b91c1c 100%);
            box-shadow: 0 15px 40px rgba(220, 38, 38, 0.6);
            transform: translateY(-2px);
        }

        /* ═══════════════════════════════════
           KARTU GLASS (LAYAR)
           ═══════════════════════════════════ */
        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(254, 242, 242, 0.96) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* ═══════════════════════════════════
           PRINT — 1 HALAMAN A4, WARNA SESUAI
           ═══════════════════════════════════ */
        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm 10mm;
            }

            /* Paksa semua warna muncul */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            html, body {
                background: #ffffff !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                font-size: 10.5px !important;
                line-height: 1.3 !important;
                page-break-after: avoid !important;
            }

            /* Sembunyikan elemen layar */
            .no-print,
            header,
            footer,
            nav,
            button,
            .blob,
            .animate-fade-in,
            .animate-fade-up {
                display: none !important;
            }

            /* Reset background elegan */
            .bg-elegant {
                background: #ffffff !important;
                min-height: auto !important;
                padding: 0 !important;
                overflow: visible !important;
            }
            .bg-elegant::before { display: none !important; }

            main {
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 auto !important;
            }

            /* ═══ KARTU ═══ */
            .print-card {
                background: #ffffff !important;
                box-shadow: none !important;
                border: 1.5px solid #b91c1c !important;
                border-radius: 8px !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                max-width: 100% !important;
                margin: 0 auto !important;
                overflow: hidden !important;
            }

            /* Header kartu merah */
            .print-header {
                background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%) !important;
                padding: 10px 14px !important;
                text-align: center !important;
            }

            .print-header .w-20 {
                width: 44px !important;
                height: 44px !important;
                margin-bottom: 4px !important;
            }
            .print-header .w-20 span {
                font-size: 18px !important;
            }
            .print-header h2 {
                font-size: 15px !important;
                margin: 2px 0 !important;
            }
            .print-header p {
                font-size: 10px !important;
                margin: 0 !important;
            }
            .print-header .mb-4,
            .print-header .mb-3 {
                margin-bottom: 4px !important;
            }

            /* Kartu detail abu */
            .print-bg {
                background: #f9fafb !important;
                border: 1px solid #e5e7eb !important;
                padding: 6px 8px !important;
            }

            /* TPS merah */
            .print-tps {
                background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%) !important;
                padding: 8px 12px !important;
                margin: 0 !important;
                box-shadow: none !important;
            }
            .print-tps .text-3xl,
            .print-tps .sm\:text-4xl {
                font-size: 20px !important;
            }

            /* Judul cetak */
            .print-title {
                display: block !important;
                text-align: center !important;
                margin-bottom: 8px !important;
                padding-bottom: 6px !important;
                border-bottom: 2px solid #b91c1c !important;
            }
            .print-title h1 {
                font-size: 14px !important;
                margin: 0 !important;
                color: #7f1d1d !important;
            }
            .print-title p {
                font-size: 9.5px !important;
                margin: 2px 0 0 0 !important;
                color: #991b1b !important;
            }

            /* Info tambahan cetak */
            .print-info {
                display: block !important;
                padding-top: 6px !important;
                margin-top: 6px !important;
                border-top: 1.5px dashed #9ca3af !important;
                font-size: 9px !important;
            }

            /* Footer card */
            .print-footer {
                padding: 6px 10px !important;
                font-size: 8.5px !important;
                background: #fef3c7 !important;
                border-top: 1px solid #fcd34d !important;
            }

            /* Perkecil spacing global */
            .p-6 { padding: 8px 10px !important; }
            .px-6 { padding-left: 10px !important; padding-right: 10px !important; }
            .pb-6 { padding-bottom: 6px !important; }
            .py-8 { padding-top: 8px !important; padding-bottom: 8px !important; }
            .pt-6 { padding-top: 6px !important; }
            .pt-4 { padding-top: 4px !important; }
            .pb-5 { padding-bottom: 6px !important; }
            .mt-6 { margin-top: 6px !important; }
            .mt-4 { margin-top: 4px !important; }
            .mt-2 { margin-top: 2px !important; }
            .mb-6 { margin-bottom: 6px !important; }
            .mb-4 { margin-bottom: 4px !important; }
            .mb-2 { margin-bottom: 3px !important; }
            .mb-1 { margin-bottom: 1px !important; }
            .gap-4 { gap: 5px !important; }
            .gap-3 { gap: 4px !important; }
            .space-y-4 > * + * { margin-top: 5px !important; }

            /* Perkecil font */
            .text-3xl { font-size: 18px !important; }
            .text-2xl { font-size: 14px !important; }
            .text-xl { font-size: 12px !important; }
            .text-sm { font-size: 10px !important; }
            .text-xs { font-size: 9px !important; }
            .text-\[10px\] { font-size: 8px !important; }
            .text-\[11px\] { font-size: 9px !important; }

            /* Border radius kecil */
            .rounded-3xl,
            .rounded-2xl { border-radius: 6px !important; }
            .rounded-xl { border-radius: 5px !important; }

            /* Link */
            a { text-decoration: none !important; color: inherit !important; }

            /* Anti page-break */
            .print-card,
            .print-card * {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }

        /* Default: sembunyikan judul cetak & info cetak di layar */
        .print-title, .print-info { display: none; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #dc2626; border-radius: 4px; }
    </style>
</head>
<body class="bg-elegant antialiased relative">

    {{-- ═══ ORNAMEN BLOB ═══ --}}
    <div class="blob bg-red-600 w-96 h-96 top-0 -left-32"></div>
    <div class="blob bg-emerald-500 w-[500px] h-[500px] top-1/3 -right-40"></div>
    <div class="blob bg-red-500 w-80 h-80 bottom-0 left-1/4"></div>
    <div class="blob bg-amber-500 w-64 h-64 top-1/2 left-1/2 opacity-20"></div>

    {{-- ═══ HEADER (tidak dicetak) ═══ --}}
    <header class="relative bg-black/30 backdrop-blur-xl shadow-lg sticky top-0 z-50 border-b border-white/10 no-print">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center gap-3">
            <a href="{{ route('dpt.index') }}" class="p-2 rounded-lg hover:bg-white/10 transition">
                <svg class="w-5 h-5 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center ring-1 ring-amber-400/40">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <div>
                <h1 class="font-display font-bold text-white leading-tight">Hasil Pengecekan</h1>
                <p class="text-xs text-red-300 font-semibold">Pilkades Desa Loning 2026</p>
            </div>
        </div>
    </header>

    {{-- ═══ KONTEN UTAMA ═══ --}}
    <main class="relative max-w-2xl mx-auto px-4 py-8 z-10">

        {{-- Judul khusus cetak --}}
        <div class="print-title">
            <h1>BUKTI PENGECEKAN DPT</h1>
            <p>PEMILIHAN KEPALA DESA LONING {{ date('Y') }}</p>
        </div>

        {{-- Badge status (layar) --}}
        <div class="flex justify-center mb-6 no-print">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-full font-display font-bold shadow-xl shadow-emerald-900/40 border border-emerald-300/50">
                <svg class="w-5 h-5 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>TERDAFTAR SEBAGAI PEMILIH</span>
            </div>
        </div>

        {{-- ═══ KARTU PEMILIH ═══ --}}
        <div class="glass-card rounded-2xl sm:rounded-3xl overflow-hidden print-card">

            {{-- Header Kartu Merah --}}
            <div class="relative bg-gradient-to-r from-red-600 via-red-700 to-red-800 px-6 py-8 text-white text-center print-header overflow-hidden">

                {{-- Ornamen dalam header --}}
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-amber-400/30 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-red-400/30 rounded-full blur-3xl"></div>

                {{-- Badge Pilkades --}}
                <div class="relative inline-flex items-center gap-1.5 px-3 py-1 bg-amber-400/20 backdrop-blur rounded-full border border-amber-300/50 mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-300 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-amber-100 tracking-widest">PILKADES LONING 2026</span>
                </div>

                {{-- Avatar --}}
                <div class="relative w-20 h-20 mx-auto bg-white/20 backdrop-blur rounded-full flex items-center justify-center mb-3 border-2 border-amber-300/60 shadow-lg shadow-red-900/50">
                    <span class="text-3xl font-display font-extrabold text-white">{{ strtoupper(substr($pemilih->nama, 0, 1)) }}</span>
                </div>

                <h2 class="relative text-xl sm:text-2xl font-display font-extrabold tracking-tight">{{ $pemilih->nama }}</h2>
                <p class="relative text-amber-200 text-sm mt-1 font-mono tracking-wider">{{ $pemilih->nik_tersensor }}</p>
            </div>

            {{-- Detail --}}
            <div class="p-6 space-y-4">

                {{-- Grid JK & Tanggal Lahir --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl p-4 print-bg border border-red-100">
                        <div class="flex items-center gap-2 text-xs text-red-600 font-bold mb-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            JENIS KELAMIN
                        </div>
                        <div class="font-display font-bold text-gray-800">
                            {{ $pemilih->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl p-4 print-bg border border-red-100">
                        <div class="flex items-center gap-2 text-xs text-red-600 font-bold mb-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            TANGGAL LAHIR
                        </div>
                        <div class="font-display font-bold text-gray-800">
                            {{ $pemilih->tanggal_lahir->translatedFormat('d F Y') }}
                        </div>
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl p-4 print-bg border border-red-100">
                    <div class="flex items-center gap-2 text-xs text-red-600 font-bold mb-1">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                        ALAMAT
                    </div>
                    <div class="font-display font-bold text-gray-800">
                        RT {{ $pemilih->rt }} / RW {{ $pemilih->rw }}, {{ $pemilih->dusun }}
                    </div>
                </div>

                {{-- TPS — Highlight --}}
                <div class="relative bg-gradient-to-br from-red-600 via-red-700 to-red-800 rounded-2xl p-6 print-tps overflow-hidden shadow-xl shadow-red-900/40">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-400/30 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-red-400/30 rounded-full blur-2xl"></div>

                    <div class="relative">
                        <div class="flex items-center gap-2 text-xs text-amber-300 font-bold tracking-widest mb-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a6 6 0 00-6 6c0 1.887-.454 3.665-1.257 5.234a.75.75 0 00.515 1.076 32.91 32.91 0 003.256.508 3.5 3.5 0 006.972 0 32.903 32.903 0 003.256-.508.75.75 0 00.515-1.076A11.448 11.448 0 0116 8a6 6 0 00-6-6zM8.05 14.943a33.54 33.54 0 003.9 0 2 2 0 01-3.9 0z" clip-rule="evenodd"/>
                            </svg>
                            TEMPAT PEMUNGUTAN SUARA
                        </div>
                        <div class="text-3xl sm:text-4xl font-display font-extrabold text-white drop-shadow-lg">{{ $pemilih->tps }}</div>
                        <div class="text-xs text-amber-200 mt-2">Silakan datang ke TPS ini pada hari pemungutan suara</div>
                    </div>
                </div>

                {{-- ═══ INFO KHUSUS CETAK ═══ --}}
                <div class="print-info">
                    <div style="display: flex; justify-content: space-between;">
                        <div>
                            <strong>Waktu Cek:</strong> {{ now()->translatedFormat('d F Y, H:i') }} WIB
                        </div>
                        <div style="text-align: right;">
                            <strong>Kode Verifikasi:</strong> <span style="font-family: monospace;">{{ strtoupper(substr(md5($pemilih->nik . now()->format('Ymd')), 0, 12)) }}</span>
                        </div>
                    </div>
                    <p style="margin-top: 6px; text-align: center; color: #4b5563;">
                        Dokumen ini dicetak otomatis dari sistem Cek DPT Pilkades Desa Loning. Harap bawa dokumen ini saat hari pemungutan suara jika diperlukan.
                    </p>
                </div>
            </div>

            {{-- Footer dalam kartu --}}
            <div class="px-6 pb-6 print-footer">
                <div class="text-xs text-gray-700 text-center leading-relaxed bg-amber-50/80 rounded-xl py-3 px-4 border border-amber-200">
                    <span class="font-bold text-red-700">⚠️ Penting:</span> Data ini bersifat rahasia. Jangan bagikan screenshot kepada orang lain.
                    Jika terdapat kesalahan data, hubungi panitia Pilkades Desa Loning.
                </div>
            </div>
        </div>

        {{-- ═══ TOMBOL (tidak dicetak) ═══ --}}
        <div class="mt-6 flex flex-col sm:flex-row gap-3 no-print">

            {{-- Tombol Kembali --}}
            <a href="{{ route('dpt.index') }}"
                class="flex-1 text-center bg-white/10 backdrop-blur border-2 border-white/30 text-white font-display font-bold py-4 rounded-2xl hover:bg-white/20 hover:border-white/50 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cek NIK Lain
            </a>

            {{-- Tombol Cetak Merah Kemilau --}}
            <button onclick="window.print()"
                class="btn-red-gold flex-1 text-white font-display font-bold py-4 rounded-2xl active:scale-[0.98] flex items-center justify-center gap-2 relative z-10">
                <svg class="w-5 h-5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span class="relative z-10 drop-shadow">Cetak / Simpan PDF</span>
            </button>
        </div>

        {{-- Info tambahan --}}
        <div class="mt-6 text-center no-print">
            <p class="text-xs text-gray-400">
                Halaman ini dapat dicetak sebagai bukti pengecekan DPT
            </p>
        </div>
    </main>

    {{-- ═══ FOOTER (tidak dicetak) ═══ --}}
    <footer class="relative z-10 mt-12 border-t border-white/10 bg-black/30 backdrop-blur-sm no-print">
        <div class="max-w-5xl mx-auto px-4 py-6 text-center">
            <div class="flex items-center justify-center gap-2 mb-2">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center ring-1 ring-amber-400/40">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <div class="font-display font-bold text-white text-xs leading-tight">Cek DPT</div>
                    <div class="text-[10px] text-red-300 font-semibold">Desa Loning</div>
                </div>
            </div>

            <p class="text-xs text-gray-300">
                © {{ date('Y') }} <span class="font-semibold text-white">Panitia Pilkades Desa Loning</span>
            </p>

            <div class="flex items-center justify-center gap-2 mt-3">
                <span class="w-8 h-px bg-gradient-to-r from-transparent to-red-400"></span>
                <span class="text-[10px] text-amber-300 font-bold tracking-widest">PILKADES 2026</span>
                <span class="w-8 h-px bg-gradient-to-l from-transparent to-red-400"></span>
            </div>
        </div>
    </footer>

</body>
</html>