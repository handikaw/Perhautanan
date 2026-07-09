<?php

namespace App\Exports;

use App\Models\ForestProduction;
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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ForestProductionExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    use Exportable;

    public function collection()
    {
        return ForestProduction::whereHas('forestLand', function ($q) {
            $q->where('user_id', Auth::id());
        })->with('forestLand')->orderBy('tanggal', 'desc')->get();
    }

    public function headings(): array
    {
        $user = Auth::user();
        $data = $this->collection();

        $summary = [];
        foreach ($data->groupBy('satuan') as $satuan => $items) {
            $summary[] = number_format($items->sum('jumlah'), 2) . ' ' . $satuan;
        }

        return [
            ['PRODUKSI HASIL HUTAN'],
            ['Diekspor oleh: ' . ($user->name ?? '-') . ' | Tanggal: ' . now()->format('d/m/Y H:i')],
            ['Total Entri: ' . $data->count() . ' | Ringkasan: ' . (empty($summary) ? '-' : implode(', ', $summary))],
            [],
            ['No', 'Tanggal', 'Nama Lahan', 'Komoditas', 'Jumlah', 'Satuan', 'Catatan'],
        ];
    }

    public function map($produksi): array
    {
        static $i = 0;
        $i++;

        return [
            $i,
            optional($produksi->tanggal)->format('d/m/Y'),
            $produksi->forestLand->nama_lahan ?? '-',
            $produksi->komoditas,
            (float) $produksi->jumlah,
            $produksi->satuan,
            $produksi->catatan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->collection()->count();
        $lastDataRow = $rowCount + 5;

        $sheet->getStyle('A1:G1')->applyFromArray([
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
        $sheet->mergeCells('A1:G1');
        $sheet->getRowDimension(1)->setRowHeight(35);

        $sheet->getStyle('A2:G2')->applyFromArray([
            'font' => ['size' => 10, 'color' => ['rgb' => '555555']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $sheet->mergeCells('A2:G2');

        $sheet->getStyle('A3:G3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '333333']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $sheet->mergeCells('A3:G3');

        $sheet->getStyle('A5:G5')->applyFromArray([
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

        $sheet->getStyle('A6:G' . $lastDataRow)->applyFromArray([
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

        $sheet->getStyle('E6:E' . $lastDataRow)->applyFromArray([
            'numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        ]);

        $sheet->getStyle('F6:F' . $lastDataRow)->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $komoditasColors = [
            'Kayu Jati' => 'EFEBE9',
            'Kayu Pinus' => 'EFEBE9',
            'Kayu Mahoni' => 'EFEBE9',
            'Getah Pinus' => 'FFF8E1',
            'Bambu' => 'E8F5E9',
            'Madu Hutan' => 'FFF3E0',
            'Lainnya' => 'F5F5F5',
        ];

        for ($row = 6; $row <= $lastDataRow; $row++) {
            $komoditas = $sheet->getCell('D' . $row)->getValue();
            $color = $komoditasColors[$komoditas] ?? 'FFFFFF';
            $sheet->getStyle('D' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'font' => ['bold' => true],
            ]);
        }

        $sheet->getStyle('A6:G' . $lastDataRow)->applyFromArray([
            'font' => ['size' => 10],
        ]);

        $sheet->setAutoFilter('A5:G' . $lastDataRow);
        $sheet->freezePane('A6');

        return [];
    }

    public function title(): string
    {
        return 'Produksi Hutan';
    }
}
