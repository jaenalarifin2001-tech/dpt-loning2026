<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Cek DPT - {{ $pemilih->nama }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* ═══════════════════════════════════════
           STYLE KHUSUS CETAK (PRINT)
           ═══════════════════════════════════════ */
        @media print {
            /* Reset background */
            @page {
                size: A4 portrait;
                margin: 15mm 12mm;
            }

            html, body {
                background: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Sembunyikan elemen yang tidak perlu dicetak */
            .no-print,
            header,
            footer,
            nav,
            button {
                display: none !important;
            }

            /* Card jadi rapi di kertas */
            .print-card {
                box-shadow: none !important;
                border: 1.5px solid #10b981 !important;
                border-radius: 12px !important;
                page-break-inside: avoid;
                max-width: 100% !important;
                margin: 0 auto !important;
            }

            /* Gradient header tetap muncul */
            .print-header {
                background: linear-gradient(135deg, #10b981 0%, #0d9488 100%) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Background abu-abu tetap muncul */
            .print-bg {
                background: #f9fafb !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Highlight TPS */
            .print-tps {
                background: linear-gradient(135deg, #ecfdf5 0%, #ccfbf1 100%) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Watermark / judul cetak */
            .print-title {
                display: block !important;
                text-align: center;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 2px solid #10b981;
            }

            /* Hilangkan link underline */
            a { text-decoration: none !important; color: inherit !important; }

            /* Font sedikit lebih kecil agar 1 halaman */
            body { font-size: 12px; }
        }

        /* Default: judul cetak disembunyikan di layar */
        .print-title { display: none; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 antialiased">

    {{-- ═══════════ HEADER (tidak dicetak) ═══════════ --}}
    <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-emerald-100 no-print">
        <div class="max-w-5xl mx-auto px-4 py-4 flex items-center gap-3">
            <a href="{{ route('dpt.index') }}" class="p-2 rounded-lg hover:bg-emerald-50 transition">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="font-bold text-gray-800">Hasil Pengecekan DPT</h1>
        </div>
    </header>

    {{-- ═══════════ KONTEN UTAMA ═══════════ --}}
    <main class="max-w-2xl mx-auto px-4 py-8 print-container">

        {{-- Judul khusus cetak (muncul di kertas saja) --}}
        <div class="print-title">
            <h1 style="font-size: 18px; font-weight: 800; color: #065f46; margin: 0;">
                BUKTI PENGECEKAN DPT
            </h1>
            <p style="font-size: 12px; color: #047857; margin: 4px 0 0 0;">
                PEMILIHAN KEPALA DESA LONING {{ date('Y') }}
            </p>
        </div>

        {{-- Badge status (tidak dicetak) --}}
        <div class="flex justify-center mb-6 no-print">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-100 text-emerald-700 rounded-full font-semibold shadow-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Terdaftar sebagai Pemilih
            </div>
        </div>

        {{-- ═══════════ KARTU PEMILIH ═══════════ --}}
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-xl shadow-emerald-100/50 overflow-hidden border border-white print-card">

            {{-- Header Kartu (gradient) --}}
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-8 text-white text-center print-header">
                <div class="w-20 h-20 mx-auto bg-white/20 backdrop-blur rounded-full flex items-center justify-center mb-3 border-2 border-white/40">
                    <span class="text-3xl font-bold">{{ strtoupper(substr($pemilih->nama, 0, 1)) }}</span>
                </div>
                <h2 class="text-xl sm:text-2xl font-bold">{{ $pemilih->nama }}</h2>
                <p class="text-emerald-100 text-sm mt-1 font-mono">{{ $pemilih->nik_tersensor }}</p>
            </div>

            {{-- Detail --}}
            <div class="p-6 space-y-4">

                {{-- Grid: Jenis Kelamin & Tanggal Lahir --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4 print-bg">
                        <div class="text-xs text-gray-500 mb-1">Jenis Kelamin</div>
                        <div class="font-semibold text-gray-800">
                            {{ $pemilih->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 print-bg">
                        <div class="text-xs text-gray-500 mb-1">Tanggal Lahir</div>
                        <div class="font-semibold text-gray-800">
                            {{ $pemilih->tanggal_lahir->translatedFormat('d F Y') }}
                        </div>
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="bg-gray-50 rounded-xl p-4 print-bg">
                    <div class="text-xs text-gray-500 mb-1">Alamat</div>
                    <div class="font-semibold text-gray-800">
                        RT {{ $pemilih->rt }} / RW {{ $pemilih->rw }}, {{ $pemilih->dusun }}
                    </div>
                </div>

                {{-- TPS --}}
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-200 rounded-xl p-5 print-tps">
                    <div class="text-xs text-emerald-600 font-semibold mb-1">TEMPAT PEMUNGUTAN SUARA</div>
                    <div class="text-2xl font-bold text-emerald-700">{{ $pemilih->tps }}</div>
                </div>

                {{-- ═══ INFO KHUSUS CETAK ═══ --}}
                <div class="hidden print:block pt-4 border-t-2 border-dashed border-gray-300 mt-6">
                    <div class="grid grid-cols-2 gap-4 text-xs text-gray-600">
                        <div>
                            <p class="mb-1"><strong>Waktu Cek:</strong></p>
                            <p>{{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
                        </div>
                        <div class="text-right">
                            <p class="mb-1"><strong>Kode Verifikasi:</strong></p>
                            <p class="font-mono">{{ strtoupper(substr(md5($pemilih->nik . now()->format('Ymd')), 0, 12)) }}</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <p class="text-xs text-gray-500 leading-relaxed text-center">
                            Dokumen ini dicetak otomatis dari sistem Cek DPT Pilkades Desa Loning.<br>
                            Harap bawa dokumen ini saat hari pemungutan suara jika diperlukan.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Footer info dalam kartu --}}
            <div class="px-6 pb-6">
                <div class="text-xs text-gray-400 text-center leading-relaxed">
                    Data ini bersifat rahasia. Jangan bagikan screenshot kepada orang lain.<br>
                    Jika terdapat kesalahan data, hubungi panitia Pilkades Desa Loning.
                </div>
            </div>
        </div>

        {{-- ═══════════ TOMBOL (tidak dicetak) ═══════════ --}}
        <div class="mt-6 flex flex-col sm:flex-row gap-3 no-print">
            <a href="{{ route('dpt.index') }}"
                class="flex-1 text-center bg-white border-2 border-emerald-500 text-emerald-600 font-semibold py-3.5 rounded-xl hover:bg-emerald-50 transition-all active:scale-[0.98]">
                Cek NIK Lain
            </a>
            <button onclick="window.print()"
                class="flex-1 text-center bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold py-3.5 rounded-xl shadow-lg shadow-emerald-200 hover:shadow-xl transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </main>

    {{-- Footer (tidak dicetak) --}}
    <footer class="text-center py-8 text-xs text-gray-500 no-print">
        <p>© {{ date('Y') }} Panitia Pilkades Desa Loning</p>
    </footer>

</body>
</html>