<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Data DPT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(-5px);} to {opacity:1; transform:translateY(0);} }
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 antialiased">

    {{-- Header --}}
    <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-emerald-100">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-200">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <div>
                <h1 class="font-bold text-gray-800 leading-tight">Admin Panel</h1>
                <p class="text-xs text-gray-500">Import Data DPT</p>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 py-8">

        {{-- Judul --}}
        <div class="mb-6">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800">
                📥 Import Data DPT
            </h2>
            <p class="text-gray-600 text-sm mt-2">
                Upload file Excel (.xlsx/.xls) atau CSV untuk memasukkan data pemilih secara massal.
            </p>
        </div>

        {{-- Statistik saat ini --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white/70 backdrop-blur rounded-xl p-4 border border-white">
                <div class="text-xs text-gray-500 mb-1">Total DPT saat ini</div>
                <div class="text-2xl font-bold text-emerald-600">{{ number_format($totalDpt) }}</div>
            </div>
            <div class="bg-white/70 backdrop-blur rounded-xl p-4 border border-white">
                <div class="text-xs text-gray-500 mb-1">Format diterima</div>
                <div class="text-sm font-semibold text-gray-800 mt-1">XLSX, XLS, CSV</div>
            </div>
            <div class="bg-white/70 backdrop-blur rounded-xl p-4 border border-white">
                <div class="text-xs text-gray-500 mb-1">Ukuran maks</div>
                <div class="text-sm font-semibold text-gray-800 mt-1">10 MB</div>
            </div>
        </div>

        {{-- Pesan sukses --}}
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-5 animate-fade-in">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="font-semibold text-green-800">{{ session('success') }}</p>

                        @if (session('info'))
                            <p class="text-sm text-green-700 mt-1">{{ session('info') }}</p>
                        @endif

                        @if (session('ringkasan'))
                            @php $r = session('ringkasan'); @endphp
                            <div class="mt-3 grid grid-cols-3 gap-3">
                                <div class="bg-white rounded-lg p-3 text-center">
                                    <div class="text-2xl font-bold text-green-600">{{ $r['berhasil'] }}</div>
                                    <div class="text-xs text-gray-500">Berhasil</div>
                                </div>
                                <div class="bg-white rounded-lg p-3 text-center">
                                    <div class="text-2xl font-bold text-red-500">{{ $r['gagal'] }}</div>
                                    <div class="text-xs text-gray-500">Gagal / Duplikat</div>
                                </div>
                                <div class="bg-white rounded-lg p-3 text-center">
                                    <div class="text-2xl font-bold text-emerald-600">{{ number_format($r['total']) }}</div>
                                    <div class="text-xs text-gray-500">Total di Database</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- Pesan error --}}
        @if (session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 animate-fade-in">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Error validasi --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 animate-fade-in">
                <p class="font-semibold text-red-800 mb-2">Periksa kembali:</p>
                <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Card Form Import --}}
        <div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-xl shadow-emerald-100/50 border border-white p-6 sm:p-8">

            <form action="{{ route('admin.import.upload') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                {{-- Pilih File --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Pilih File Excel / CSV
                    </label>

                    <div class="relative border-2 border-dashed border-emerald-300 rounded-xl p-8 text-center hover:border-emerald-500 hover:bg-emerald-50/50 transition-all cursor-pointer"
                         onclick="document.getElementById('file').click()">
                        <input type="file"
                               name="file"
                               id="file"
                               accept=".xlsx,.xls,.csv"
                               class="hidden"
                               onchange="updateFileName(this)">

                        <svg class="w-12 h-12 mx-auto text-emerald-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>

                        <p id="fileName" class="text-sm font-semibold text-gray-700">
                            Klik untuk pilih file
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            Format: .xlsx, .xls, .csv — Maks 10 MB
                        </p>
                    </div>
                </div>

                {{-- Mode Import --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Mode Import
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="relative flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer hover:border-emerald-400 transition-all has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50">
                            <input type="radio" name="mode" value="append" checked class="mt-1">
                            <div>
                                <div class="font-semibold text-gray-800 text-sm">Tambah Data</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    Tambahkan ke data yang ada. NIK duplikat otomatis di-skip.
                                </div>
                            </div>
                        </label>

                        <label class="relative flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer hover:border-red-400 transition-all has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                            <input type="radio" name="mode" value="replace" class="mt-1">
                            <div>
                                <div class="font-semibold text-gray-800 text-sm">Replace Total</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    ⚠️ Hapus SEMUA data lama, ganti dengan data baru.
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-4 rounded-xl shadow-lg shadow-emerald-200 hover:shadow-xl transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        Import Sekarang
                    </button>

                    <a href="{{ route('admin.import.template') }}"
                       class="sm:w-auto text-center bg-white border-2 border-emerald-500 text-emerald-600 font-semibold py-4 px-6 rounded-xl hover:bg-emerald-50 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Template
                    </a>
                </div>
            </form>

            {{-- Panduan --}}
            <div class="mt-8 pt-6 border-t border-gray-100">
                <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Panduan Format File
                </h3>

                <div class="bg-gray-50 rounded-xl p-4 text-sm">
                    <p class="text-gray-600 mb-3">
                        Baris pertama file <strong>harus</strong> berisi header dengan nama kolom persis seperti ini:
                    </p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead class="bg-emerald-100 text-emerald-800">
                                <tr>
                                    <th class="px-3 py-2 text-left font-semibold">nik</th>
                                    <th class="px-3 py-2 text-left font-semibold">nkk</th>
                                    <th class="px-3 py-2 text-left font-semibold">nama</th>
                                    <th class="px-3 py-2 text-left font-semibold">tempat_lahir</th>
                                    <th class="px-3 py-2 text-left font-semibold">tanggal_lahir</th>
                                    <th class="px-3 py-2 text-left font-semibold">jenis_kelamin</th>
                                    <th class="px-3 py-2 text-left font-semibold">alamat</th>
                                    <th class="px-3 py-2 text-left font-semibold">rt</th>
                                    <th class="px-3 py-2 text-left font-semibold">rw</th>
                                    <th class="px-3 py-2 text-left font-semibold">dusun</th>
                                    <th class="px-3 py-2 text-left font-semibold">tps</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr class="border-t">
                                    <td class="px-3 py-2 font-mono">3312010101800001</td>
                                    <td class="px-3 py-2 font-mono">3312010101100001</td>
                                    <td class="px-3 py-2">Ahmad Fauzi</td>
                                    <td class="px-3 py-2">Wonogiri</td>
                                    <td class="px-3 py-2">1980-01-15</td>
                                    <td class="px-3 py-2">L</td>
                                    <td class="px-3 py-2">RT 01 RW 01</td>
                                    <td class="px-3 py-2">1</td>
                                    <td class="px-3 py-2">1</td>
                                    <td class="px-3 py-2">Dusun Krajan</td>
                                    <td class="px-3 py-2">TPS 1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 space-y-2 text-xs text-gray-600">
                        <p>⚠️ <strong>Aturan penting:</strong></p>
                        <ul class="list-disc list-inside space-y-1 ml-2">
                            <li>Header huruf <strong>kecil semua</strong>, pakai <strong>underscore</strong> (<code class="bg-gray-200 px-1 rounded">_</code>)</li>
                            <li>Format tanggal: <strong>YYYY-MM-DD</strong> (contoh: <code class="bg-gray-200 px-1 rounded">1980-01-15</code>)</li>
                            <li>Jenis kelamin: <strong>L</strong> (laki-laki) atau <strong>P</strong> (perempuan)</li>
                            <li>NIK & NKK: <strong>16 digit angka</strong> — pastikan kolom di Excel berformat <strong>Text</strong></li>
                            <li>File tidak boleh sedang dibuka di Excel saat di-upload</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Link kembali --}}
            <div class="mt-6 text-center">
                <a href="{{ url('/') }}"
                   class="text-sm text-emerald-600 hover:text-emerald-700 hover:underline">
                    ← Kembali ke halaman cek DPT
                </a>
            </div>
        </div>
    </main>

    <script>
        function updateFileName(input) {
            const label = document.getElementById('fileName');
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const sizeMB = (file.size / 1024 / 1024).toFixed(2);
                label.innerHTML = '✅ <strong>' + file.name + '</strong> (' + sizeMB + ' MB)';
                label.classList.add('text-emerald-600');
                label.classList.remove('text-gray-700');
            }
        }
    </script>
</body>
</html>