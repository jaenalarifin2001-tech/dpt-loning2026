<?php

namespace App\Http\Controllers;

use App\Imports\PemilihImport;
use App\Models\Pemilih;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateDptExport;

class AdminImportController extends Controller
{
    /**
     * Halaman form upload
     */
    public function index()
    {
        $totalDpt = Pemilih::aktif()->count();

        return view('admin.import', compact('totalDpt'));
    }

    /**
     * Proses upload & import
     */
    public function upload(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240', // max 10 MB
            ],
        ], [
            'file.required' => 'Pilih file terlebih dahulu.',
            'file.mimes'    => 'Format file harus XLSX, XLS, atau CSV.',
            'file.max'      => 'Ukuran file maksimal 10 MB.',
        ]);

        // Mode: append atau replace
        $mode = $request->input('mode', 'append');

        // Kalau mode replace → hapus data lama dulu
        if ($mode === 'replace') {
            $jumlahLama = Pemilih::count();
            Pemilih::truncate();
            session()->flash('info', "🗑️ {$jumlahLama} data lama dihapus.");
        }

        // Proses import
        $import = new PemilihImport();

        try {
            Excel::import($import, $request->file('file'));

            return redirect()->route('admin.import.index')
                ->with('success', "Import selesai!")
                ->with('ringkasan', [
                    'berhasil' => $import->berhasil,
                    'gagal'    => $import->gagal,
                    'total'    => Pemilih::count(),
                ]);

        } catch (\Exception $e) {
            return redirect()->route('admin.import.index')
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel
     */
   public function template()
{
    return Excel::download(new TemplateDptExport(), 'template-dpt.xlsx');
}
}