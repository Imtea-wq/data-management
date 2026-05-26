<?php

namespace App\Exports;

use App\Models\Cargo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CargoExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    public function collection()
    {
        $query = Cargo::query();

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Perusahaan',
            'No BL',
            'Party',
            'Marking',
            'Cargo',
            'Lokasi',
            'Status',
            'Tanggal Input',
        ];
    }

    public function map($cargo): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $cargo->nama_perusahaan,
            $cargo->no_bl,
            $cargo->party,
            $cargo->marking,
            $cargo->cargo,
            $cargo->lokasi,
            ucfirst($cargo->status),
            $cargo->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
            ],
        ];
    }
}
