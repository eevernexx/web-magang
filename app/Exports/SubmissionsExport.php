<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubmissionsExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $submissions;

    public function __construct(array $submissions)
    {
        $this->submissions = $submissions;
    }

    public function array(): array
    {
        return $this->submissions;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama',
            'Email',
            'Universitas',
            'Judul Tugas',
            'Status',
            'Waktu Pengumpulan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E9ECEF']
                ]
            ]
        ];
    }
} 