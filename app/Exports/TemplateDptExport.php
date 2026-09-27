<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class TemplateDptExport implements
    FromArray,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle
{
    public function array(): array
    {
        // Contoh data di bawah header
        return [
            ['3312010101800001', '3312010101100001', 'Ahmad Fauzi', 'Wonogiri', '1980-01-15', 'L', 'RT 01 RW 01', '1', '1', 'Dusun Krajan', 'TPS 1'],
            ['3312010101820002', '3312010101100002', 'Sri Wahyuni', 'Wonogiri', '1982-03-20', 'P', 'RT 01 RW 01', '1', '1', 'Dusun Krajan', 'TPS 1'],
        ];
    }

    public function headings(): array
    {
        return [
            'nik', 'nkk', 'nama', 'tempat_lahir', 'tanggal_lahir',
            'jenis_kelamin', 'alamat', 'rt', 'rw', 'dusun', 'tps',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // nik
            'B' => 20, // nkk
            'C' => 25, // nama
            'D' => 15, // tempat_lahir
            'E' => 15, // tanggal_lahir
            'F' => 15, // jenis_kelamin
            'G' => 25, // alamat
            'H' => 6,  // rt
            'I' => 6,  // rw
            'J' => 18, // dusun
            'K' => 10, // tps
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header (baris 1)
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '10B981'], // emerald-500
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
            ],
        ]);

        // Tinggi header
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Freeze header
        $sheet->freezePane('A2');

        // Kolom NIK & NKK berformat TEXT agar tidak jadi notasi ilmiah
        $sheet->getStyle('A2:B1000')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        // Kolom tanggal berformat date
        $sheet->getStyle('E2:E1000')
            ->getNumberFormat()
            ->setFormatCode('YYYY-MM-DD');

        // Border untuk semua sel (opsional)
        $sheet->getStyle('A1:K1000')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'DDDDDD'],
                ],
            ],
        ]);

        // Baris pertama: warna putih, tidak ikut border abu-abu
        $sheet->getStyle('A1:K1')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
            ],
        ]);
    }

    public function title(): string
    {
        return 'Template DPT';
    }
}