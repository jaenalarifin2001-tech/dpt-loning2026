<?php

namespace App\Console\Commands;

use App\Imports\PemilihImport;
use App\Models\Pemilih;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportDpt extends Command
{
    protected $signature = 'dpt:import
                            {file : Path file Excel/CSV (contoh: data-dpt.xlsx)}
                            {--fresh : Hapus semua data pemilih dulu sebelum import}';

    protected $description = 'Import data DPT dari file Excel atau CSV';

    public function handle(): int
    {
        $file = $this->argument('file');

        // ═══ Cek file ada atau tidak ═══
        if (!file_exists($file)) {
            $this->error("❌ File tidak ditemukan: {$file}");
            $this->newLine();
            $this->line("💡 Pastikan path benar, contoh:");
            $this->line("   php artisan dpt:import storage/data-dpt.xlsx");
            $this->line("   php artisan dpt:import C:\\Users\\Jaenal\\data-dpt.xlsx");
            return 1;
        }

        // ═══ Konfirmasi kalau mode --fresh ═══
        if ($this->option('fresh')) {
            $jumlahLama = Pemilih::count();
            if ($jumlahLama > 0) {
                $this->warn("⚠️  Ada {$jumlahLama} data pemilih lama.");
                if (!$this->confirm('Yakin hapus semua dan replace dengan data baru?', false)) {
                    $this->info('Dibatalkan.');
                    return 0;
                }
                Pemilih::truncate();
                $this->info('🗑️  Data lama dihapus.');
            }
        }

        // ═══ Mulai import ═══
        $this->info("📥 Mengimport data dari: {$file}");
        $this->info("⏳ Mohon tunggu...");
        $this->newLine();

        $import = new PemilihImport();

        $bar = $this->output->createProgressBar();
        $bar->start();

        try {
            Excel::import($import, $file);
            $bar->finish();
            $this->newLine(2);

            $totalAkhir = Pemilih::count();

            $this->info('✅ Import selesai!');
            $this->newLine();
            $this->table(
                ['Status', 'Jumlah'],
                [
                    ['Berhasil diimport', $import->berhasil],
                    ['Gagal / Duplikat', $import->gagal],
                    ['Total DPT di database', $totalAkhir],
                ]
            );

            // Ringkasan per dusun
            $this->newLine();
            $this->info('📊 Ringkasan per Dusun:');
            $perDusun = Pemilih::aktif()
                ->selectRaw('dusun, COUNT(*) as jumlah')
                ->groupBy('dusun')
                ->orderByDesc('jumlah')
                ->get();

            $this->table(
                ['Dusun', 'Jumlah Pemilih'],
                $perDusun->map(fn($d) => [$d->dusun, $d->jumlah])->toArray()
            );

            return 0;

        } catch (\Exception $e) {
            $bar->finish();
            $this->newLine(2);
            $this->error('❌ Gagal import: ' . $e->getMessage());
            $this->newLine();
            $this->line('💡 Kemungkinan penyebab:');
            $this->line('   • Format header tidak sesuai (harus: nik, nkk, nama, ...)');
            $this->line('   • Format tanggal salah (gunakan YYYY-MM-DD)');
            $this->line('   • File Excel corrupt / terkunci');
            return 1;
        }
    }
}