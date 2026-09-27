<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cek DPT - Pilkades Desa Loning</title>

    {{-- Tailwind CSS via CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'Inter', 'sans-serif']
                    },
                    animation: {
                        'float': 'float 8s ease-in-out infinite',
                        'float-slow': 'float 12s ease-in-out infinite',
                        'fade-up': 'fadeUp 0.6s ease-out',
                        'fade-in': 'fadeIn 0.4s ease-out',
                        'shimmer': 'shimmer 2.5s infinite',
                        'pulse-red': 'pulseRed 2s ease-in-out infinite',
                        'glow': 'glow 3s ease-in-out infinite',
                        'shine-red': 'shineRed 3s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0) translateX(0)' },
                            '50%': { transform: 'translateY(-30px) translateX(20px)' },
                        },
                        fadeUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        shimmer: {
                            '0%': { backgroundPosition: '-1000px 0' },
                            '100%': { backgroundPosition: '1000px 0' },
                        },
                        pulseRed: {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(220, 38, 38, 0.4)' },
                            '50%': { boxShadow: '0 0 35px rgba(220, 38, 38, 0.7)' },
                        },
                        glow: {
                            '0%, 100%': { opacity: '0.6' },
                            '50%': { opacity: '1' },
                        },
                        shineRed: {
                            '0%': { left: '-150%' },
                            '60%': { left: '150%' },
                            '100%': { left: '150%' },
                        },
                    }
                }
            }
        }
    </script>

    {{-- Font: Inter + Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ═══ BACKGROUND ELEGAN ═══ */
        .bg-elegant {
            background:
                radial-gradient(circle at 20% 10%, #065f46 0%, transparent 50%),
                radial-gradient(circle at 80% 90%, #7f1d1d 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, #064e3b 0%, #0f172a 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Pattern titik halus */
        .bg-elegant::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 1px 1px, rgba(255, 255, 255, 0.08) 1px, transparent 0);
            background-size: 32px 32px;
            pointer-events: none;
        }

        /* Garis diagonal dekoratif */
        .bg-elegant::after {
            content: '';
            position: absolute;
            inset: 0;
            background:
                linear-gradient(45deg, transparent 48%, rgba(255,255,255,0.02) 49%, rgba(255,255,255,0.02) 51%, transparent 52%),
                linear-gradient(-45deg, transparent 48%, rgba(255,255,255,0.02) 49%, rgba(255,255,255,0.02) 51%, transparent 52%);
            background-size: 80px 80px;
            pointer-events: none;
        }

        /* Blob ornamen */
        .blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(80px);
            opacity: 0.4;
            z-index: 0;
            pointer-events: none;
        }

        /* ═══ TOMBOL MERAH KEMILAU ═══ */
        .btn-red-gold {
            position: relative;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 40%, #991b1b 100%);
            overflow: hidden;
            box-shadow:
                0 10px 30px rgba(220, 38, 38, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.1) inset,
                0 -20px 40px rgba(0, 0, 0, 0.2) inset;
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

        .btn-red-gold::after {
            content: '';
            position: absolute;
            inset: 2px;
            border-radius: inherit;
            background: linear-gradient(180deg, rgba(255,255,255,0.15) 0%, transparent 50%);
            pointer-events: none;
        }

        .btn-red-gold:hover {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 40%, #b91c1c 100%);
            box-shadow:
                0 15px 40px rgba(220, 38, 38, 0.6),
                0 0 0 1px rgba(255, 215, 0, 0.3) inset,
                0 -20px 40px rgba(0, 0, 0, 0.3) inset;
            transform: translateY(-2px);
        }

        /* Efek glow merah untuk aksen */
        .red-glow {
            box-shadow: 0 0 30px rgba(220, 38, 38, 0.5), 0 0 60px rgba(220, 38, 38, 0.2);
        }

        /* Kartu kaca gelap */
        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(254, 242, 242, 0.95) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.05) inset;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #dc2626; border-radius: 4px; }
    </style>
</head>
<body class="bg-elegant antialiased relative">

    {{-- ═══ ORNAMEN BLOB ═══ --}}
    <div class="blob bg-red-600 w-96 h-96 top-0 -left-32 animate-float"></div>
    <div class="blob bg-emerald-500 w-[500px] h-[500px] top-1/3 -right-40 animate-float-slow"></div>
    <div class="blob bg-red-500 w-80 h-80 bottom-0 left-1/4 animate-float"></div>
    <div class="blob bg-amber-500 w-64 h-64 top-1/2 left-1/2 animate-float-slow opacity-20"></div>

    {{-- ═══ HEADER ═══ --}}
    <header class="relative bg-black/30 backdrop-blur-xl shadow-lg sticky top-0 z-50 border-b border-white/10">
        <div class="max-w-6xl mx-auto px-4 py-3.5 flex items-center justify-between">

            {{-- Logo & Nama Desa --}}
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-500 via-red-600 to-red-700 flex items-center justify-center shadow-lg shadow-red-900/50 ring-2 ring-red-400/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <span class="absolute -top-1 -right-1 flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                </div>
                <div>
                    <h1 class="font-display font-bold text-white leading-tight text-base sm:text-lg">Cek DPT</h1>
                    <p class="text-xs text-red-300 font-semibold">Desa Loning</p>
                </div>
            </div>

            {{-- Badge tahun --}}
            <div class="hidden sm:flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 rounded-full border border-red-400/50 shadow-lg shadow-red-900/50">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-300 animate-pulse"></span>
                <span class="text-xs font-bold text-white tracking-wider">PILKADES 2026</span>
            </div>
        </div>
    </header>

    {{-- ═══ HERO SECTION ═══ --}}
    <main class="relative max-w-6xl mx-auto px-4 py-10 sm:py-16 z-10">

        <div class="text-center mb-10 sm:mb-14 animate-fade-up">

            {{-- Badge Pilkades --}}
            <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-red-600/90 to-red-700/90 backdrop-blur-sm border-2 border-amber-400/40 rounded-full shadow-2xl shadow-red-900/50 mb-6">
                <span class="text-lg">🗳️</span>
                <span class="text-xs sm:text-sm font-bold text-white tracking-wide">
                    PEMILIHAN KEPALA DESA LONING
                </span>
                <span class="px-2.5 py-0.5 bg-gradient-to-r from-amber-400 to-amber-500 text-red-900 text-[10px] font-extrabold rounded-full shadow">
                    2026
                </span>
            </div>

            {{-- Judul Utama --}}
            <h2 class="font-display text-4xl sm:text-5xl md:text-6xl font-extrabold text-white mb-5 leading-[1.1] tracking-tight drop-shadow-2xl">
                Cek Status
                <span class="relative inline-block">
                    <span class="bg-gradient-to-r from-amber-300 via-red-300 to-amber-300 bg-clip-text text-transparent drop-shadow-lg">
                        DPT Anda
                    </span>
                    <svg class="absolute -bottom-2 left-0 w-full h-3" viewBox="0 0 200 12" fill="none" preserveAspectRatio="none">
                        <path d="M2 8.5C50 2.5 150 2.5 198 8.5" stroke="url(#gradient-red)" stroke-width="3" stroke-linecap="round"/>
                        <defs>
                            <linearGradient id="gradient-red" x1="0" y1="0" x2="200" y2="0">
                                <stop offset="0%" stop-color="#dc2626"/>
                                <stop offset="50%" stop-color="#fbbf24"/>
                                <stop offset="100%" stop-color="#dc2626"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </span>
            </h2>

            {{-- Deskripsi --}}
            <p class="text-gray-200 max-w-xl mx-auto text-sm sm:text-base px-4 mt-6 leading-relaxed drop-shadow-lg">
                Pastikan Anda terdaftar sebagai pemilih pada <span class="font-semibold text-amber-300">Pilkades Desa Loning 2026</span>.
                Masukkan NIK Anda untuk memeriksa status.
            </p>

            {{-- Info Pills --}}
            <div class="flex flex-wrap items-center justify-center gap-2 mt-6">
                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur rounded-full border border-white/20 text-xs text-white">
                    <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">Cepat</span>
                </div>
                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur rounded-full border border-white/20 text-xs text-white">
                    <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">Aman</span>
                </div>
                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur rounded-full border border-white/20 text-xs text-white">
                    <svg class="w-3.5 h-3.5 text-amber-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">Real-time</span>
                </div>
            </div>
        </div>

        {{-- ═══ CARD FORM ═══ --}}
        <div class="max-w-2xl mx-auto">

            <div class="relative glass-card rounded-3xl p-6 sm:p-9 animate-fade-up">

                {{-- Aksen border atas merah-amber --}}
                <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-32 h-1.5 bg-gradient-to-r from-red-500 via-amber-400 to-red-500 rounded-b-full shadow-lg shadow-red-500/50"></div>

                @if (session('error'))
                    <div class="mb-5 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl flex items-start gap-3 animate-fade-in">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                <form action="{{ route('dpt.cari') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Honeypot --}}
                    <div style="position:absolute; left:-9999px;" aria-hidden="true">
                        <label for="website">Website</label>
                        <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                    </div>

                    {{-- Input NIK --}}
                    <div>
                        <label for="nik" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2.5">
                            <span class="w-6 h-6 rounded-lg bg-red-100 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                            Nomor Induk Kependudukan (NIK)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.418.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                            </div>
                            <input
                                type="text"
                                name="nik"
                                id="nik"
                                inputmode="numeric"
                                maxlength="16"
                                pattern="[0-9]{16}"
                                value="{{ old('nik') }}"
                                placeholder="0000 0000 0000 0000"
                                autocomplete="off"
                                class="w-full pl-12 pr-4 py-4 rounded-2xl border-2 @error('nik') border-red-300 focus:border-red-500 @else border-red-100 focus:border-red-500 @enderror focus:ring-4 focus:ring-red-100/60 outline-none transition-all duration-200 text-base font-mono tracking-widest bg-red-50/30 focus:bg-white"
                                required
                            >
                        </div>
                        @error('nik')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1 animate-fade-in">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Input Captcha --}}
                    <div>
                        <label for="captcha" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-2.5">
                            <span class="w-6 h-6 rounded-lg bg-red-100 flex items-center justify-center">
                                <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </span>
                            Verifikasi Keamanan
                        </label>
                        <div class="flex items-stretch gap-3">
                            {{-- Soal --}}
                            <div class="relative flex-shrink-0 px-5 py-4 bg-gradient-to-br from-red-600 via-red-700 to-red-800 rounded-2xl shadow-lg shadow-red-500/40 ring-1 ring-amber-400/30">
                                <div class="text-white font-display font-extrabold text-xl tracking-wider whitespace-nowrap select-none drop-shadow">
                                    {{ $captcha['soal'] }}
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-amber-400 rounded-full flex items-center justify-center shadow ring-2 ring-white">
                                    <svg class="w-2.5 h-2.5 text-red-700" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Jawaban --}}
                            <input
                                type="text"
                                name="captcha"
                                id="captcha"
                                inputmode="numeric"
                                maxlength="3"
                                value="{{ old('captcha') }}"
                                placeholder="?"
                                autocomplete="off"
                                class="flex-1 min-w-0 px-4 py-4 rounded-2xl border-2 @error('captcha') border-red-300 focus:border-red-500 @else border-red-100 focus:border-red-500 @enderror focus:ring-4 focus:ring-red-100/60 outline-none transition-all duration-200 text-base font-mono text-center tracking-widest font-bold text-red-700 bg-red-50/30 focus:bg-white"
                                required
                            >
                        </div>
                        @error('captcha')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1 animate-fade-in">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500 flex items-center gap-1.5">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Jawab untuk membuktikan Anda bukan robot
                        </p>
                    </div>

                    {{-- ═══ TOMBOL MERAH KEMILAU ═══ --}}
                    <button type="submit"
                        class="btn-red-gold group w-full text-white font-display font-bold text-base sm:text-lg py-4.5 py-4 rounded-2xl transition-all duration-300 active:scale-[0.98] flex items-center justify-center gap-3 relative z-10">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <span class="relative z-10 drop-shadow">Cek Sekarang</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </form>

                {{-- Info keamanan --}}
                <div class="mt-6 pt-5 border-t border-red-100">
                    <div class="flex items-start gap-3 text-xs text-gray-500">
                        <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <p class="leading-relaxed pt-1">
                            Data Anda <span class="font-semibold text-red-700">aman & terenkripsi</span>. NIK tidak disimpan dalam log dan hanya digunakan untuk pencarian DPT.
                        </p>
                    </div>
                </div>
            </div>

            {{-- ═══ STATISTIK CARDS ═══ --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8 animate-fade-up">

                {{-- Total DPT --}}
                <div class="group relative bg-white/95 backdrop-blur-lg rounded-2xl p-5 border border-white shadow-xl shadow-black/30 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-red-100 to-transparent rounded-full -mr-8 -mt-8 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center shadow-lg shadow-red-300 ring-1 ring-amber-300/50">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-display text-2xl font-extrabold text-red-600 leading-none">
                                {{ number_format(\App\Models\Pemilih::aktif()->count()) }}
                            </div>
                            <div class="text-xs text-gray-600 mt-1.5 font-medium">Total DPT</div>
                        </div>
                    </div>
                </div>

                {{-- Dusun --}}
                <div class="group relative bg-white/95 backdrop-blur-lg rounded-2xl p-5 border border-white shadow-xl shadow-black/30 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-100 to-transparent rounded-full -mr-8 -mt-8 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center shadow-lg shadow-emerald-300 ring-1 ring-amber-300/50">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-display text-2xl font-extrabold text-emerald-600 leading-none">
                                {{ \App\Models\Pemilih::aktif()->distinct('dusun')->count('dusun') }}
                            </div>
                            <div class="text-xs text-gray-600 mt-1.5 font-medium">Dusun</div>
                        </div>
                    </div>
                </div>

                {{-- TPS --}}
                <div class="group relative bg-white/95 backdrop-blur-lg rounded-2xl p-5 border border-white shadow-xl shadow-black/30 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-100 to-transparent rounded-full -mr-8 -mt-8 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center shadow-lg shadow-amber-300 ring-1 ring-red-300/50">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-display text-2xl font-extrabold text-amber-600 leading-none">
                                {{ \App\Models\Pemilih::aktif()->distinct('tps')->count('tps') }}
                            </div>
                            <div class="text-xs text-gray-600 mt-1.5 font-medium">TPS</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    {{-- ═══ FOOTER ═══ --}}
    <footer class="relative z-10 mt-12 border-t border-white/10 bg-black/30 backdrop-blur-sm">
        <div class="max-w-6xl mx-auto px-4 py-8 text-center">

            {{-- Logo mini --}}
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center ring-1 ring-amber-400/40">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div class="text-left">
                    <div class="font-display font-bold text-white text-sm leading-tight">Cek DPT</div>
                    <div class="text-[10px] text-red-300 font-semibold">Desa Loning</div>
                </div>
            </div>

            <p class="text-xs text-gray-300">
                © {{ date('Y') }} <span class="font-semibold text-white">Panitia Pilkades Desa Loning</span>
            </p>
            <p class="text-[11px] text-gray-400 mt-1">
                Dikelola oleh Pemerintah Desa Loning
            </p>

            <div class="flex items-center justify-center gap-2 mt-4">
                <span class="w-8 h-px bg-gradient-to-r from-transparent to-red-400"></span>
                <span class="text-[10px] text-amber-300 font-bold tracking-widest">PILKADES 2026</span>
                <span class="w-8 h-px bg-gradient-to-l from-transparent to-red-400"></span>
            </div>
        </div>
    </footer>

    {{-- ═══ SCRIPT ═══ --}}
    <script>
        const nikInput = document.getElementById('nik');
        if (nikInput) {
            nikInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 16);
            });
            window.addEventListener('load', function () {
                if (!nikInput.value) setTimeout(() => nikInput.focus(), 300);
            });
        }

        const captchaInput = document.getElementById('captcha');
        if (captchaInput) {
            captchaInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 3);
            });
        }
    </script>
</body>
</html>