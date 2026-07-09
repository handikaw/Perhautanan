<?php

namespace App\Exports;

use App\Models\LandActivity;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LandActivityExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    use Exportable;

    protected ?string $filterLahan;
    protected ?string $filterJenis;

    public function __construct(?string $filterLahan = null, ?string $filterJenis = null)
    {
        $this->filterLahan = $filterLahan;
        $this->filterJenis = $filterJenis;
    }

    public function collection()
    {
        $query = LandActivity::whereHas('forestLand', function ($q) {
            $q->where('user_id', Auth::id());
        })->with('forestLand');

        if ($this->filterLahan && $this->filterLahan !== 'all') {
            $query->where('forest_land_id', $this->filterLahan);
        }

        if ($this->filterJenis && $this->filterJenis !== 'all') {
            $query->where('jenis', $this->filterJenis);
        }

        return $query->orderBy('tanggal', 'desc')->get();
    }

    public function headings(): array
    {
        $user = Auth::user();
        $data = $this->collection();
        $totalPending = $data->filter(function ($item) {
            return $item->tindak_lanjut && $item->tindak_lanjut->isPast();
        })->count();

        return [
            ['RIWAYAT KEGIATAN LAHAN'],
            ['Diekspor oleh: ' . ($user->name ?? '-') . ' | Tanggal: ' . now()->format('d/m/Y H:i')],
            ['Total Kegiatan: ' . $data->count() . ' | Perlu Tindak Lanjut: ' . $totalPending],
            [],
            ['No', 'Tanggal', 'Nama Lahan', 'Jenis Kegiatan', 'Petugas', 'Catatan', 'Tindak Lanjut', 'Status'],
        ];
    }

    public function map($kegiatan): array
    {
        static $i = 0;
        $i++;

        $statusTindakLanjut = '-';
        if ($kegiatan->tindak_lanjut) {
            if ($kegiatan->tindak_lanjut->isPast()) {
                $statusTindakLanjut = 'Terlewat';
            } elseif ($kegiatan->tindak_lanjut->isToday()) {
                $statusTindakLanjut = 'Hari Ini';
            } else {
                $statusTindakLanjut = 'Akan Datang';
            }
        }

        return [
            $i,
            optional($kegiatan->tanggal)->format('d/m/Y'),
            $kegiatan->forestLand->nama_lahan ?? '-',
            $kegiatan->jenis,
            $kegiatan->petugas ?? '-',
            $kegiatan->catatan ?? '-',
            optional($kegiatan->tindak_lanjut)->format('d/m/Y') ?? '-',
            $statusTindakLanjut,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->collection()->count();
        $lastDataRow = $rowCount + 5;

        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4B6B3F'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
        $sheet->mergeCells('A1:H1');
        $sheet->getRowDimension(1)->setRowHeight(35);

        $sheet->getStyle('A2:H2')->applyFromArray([
            'font' => ['size' => 10, 'color' => ['rgb' => '555555']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $sheet->mergeCells('A2:H2');

        $sheet->getStyle('A3:H3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '333333']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $sheet->mergeCells('A3:H3');

        $sheet->getStyle('A5:H5')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '5A7C4A'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A6:H' . $lastDataRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A6:A' . $lastDataRow)->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getStyle('B6:B' . $lastDataRow)->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getStyle('G6:G' . $lastDataRow)->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getStyle('H6:H' . $lastDataRow)->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $jenisColors = [
            'Penanaman' => 'E8F5E9',
            'Pemeliharaan' => 'E3F2FD',
            'Penebangan' => 'FFEBEE',
            'Panen' => 'FFF3E0',
            'Inspeksi' => 'F3E5F5',
            'Lainnya' => 'F5F5F5',
        ];

        for ($row = 6; $row <= $lastDataRow; $row++) {
            $jenis = $sheet->getCell('D' . $row)->getValue();
            $color = $jenisColors[$jenis] ?? 'FFFFFF';
            $sheet->getStyle('D' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'font' => ['bold' => true],
            ]);

            $status = $sheet->getCell('H' . $row)->getValue();
            if ($status === 'Terlewat') {
                $sheet->getStyle('H' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFCDD2'],
                    ],
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'C62828'],
                    ],
                ]);
            } elseif ($status === 'Hari Ini') {
                $sheet->getStyle('H' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFF9C4'],
                    ],
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'F57F17'],
                    ],
                ]);
            } elseif ($status === 'Akan Datang') {
                $sheet->getStyle('H' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'C8E6C9'],
                    ],
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '2E7D32'],
                    ],
                ]);
            }
        }

        $sheet->getStyle('A6:H' . $lastDataRow)->applyFromArray([
            'font' => ['size' => 10],
        ]);

        $sheet->setAutoFilter('A5:H' . $lastDataRow);
        $sheet->freezePane('A6');

        return [];
    }

    public function title(): string
    {
        return 'Kegiatan Lahan';
    }
}
