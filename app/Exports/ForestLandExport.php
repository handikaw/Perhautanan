<?php

namespace App\Exports;

use App\Models\ForestLand;
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
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ForestLandExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    use Exportable;

    protected array $ids;
    protected string $startDate;
    protected string $endDate;

    public function __construct(?string $ids = null, ?string $startDate = null, ?string $endDate = null)
    {
        $this->ids = $ids ? explode(',', $ids) : [];
        $this->startDate = $startDate ?? '';
        $this->endDate = $endDate ?? '';
    }

    public function collection()
    {
        $query = ForestLand::where('user_id', Auth::id());

        if (!empty($this->ids)) {
            $query->whereIn('id', $this->ids);
        }

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        $user = Auth::user();
        return [
            ['DATA LAHAN PERHUTANAN'],
            ['Diekspor oleh: ' . ($user->name ?? '-') . ' | Tanggal: ' . now()->format('d/m/Y H:i')],
            ['Total Lahan: ' . $this->collection()->count() . ' | Total Luas: ' . number_format($this->collection()->sum('luas_hektar'), 2) . ' Ha'],
            [],
            ['No', 'Nama Lahan', 'Luas (Ha)', 'Status', 'Tanggal Dibuat', 'Terakhir Diupdate'],
        ];
    }

    public function map($land): array
    {
        static $i = 0;
        $i++;

        return [
            $i,
            $land->nama_lahan,
            (float) $land->luas_hektar,
            $land->status,
            $land->created_at ? $land->created_at->format('d/m/Y') : '-',
            $land->updated_at ? $land->updated_at->format('d/m/Y') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $rowCount = $this->collection()->count();
        $lastDataRow = $rowCount + 5;

        $sheet->getStyle('A1:F1')->applyFromArray([
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
        $sheet->mergeCells('A1:F1');
        $sheet->getRowDimension(1)->setRowHeight(35);

        $sheet->getStyle('A2:F2')->applyFromArray([
            'font' => ['size' => 10, 'color' => ['rgb' => '555555']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $sheet->mergeCells('A2:F2');

        $sheet->getStyle('A3:F3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '333333']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
        ]);
        $sheet->mergeCells('A3:F3');

        $sheet->getStyle('A5:F5')->applyFromArray([
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
            'borders' => [
                'allBorders' => [
                ],
            ],
        ]);

        $sheet->getStyle('A6:F' . $lastDataRow)->applyFromArray([
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

        $sheet->getStyle('C6:C' . $lastDataRow)->applyFromArray([
            'numberFormat' => ['formatCode' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        ]);

        $sheet->getStyle('E6:F' . $lastDataRow)->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        for ($row = 6; $row <= $lastDataRow; $row++) {
            $status = $sheet->getCell('D' . $row)->getValue();
            $color = match ($status) {
                'Konservasi' => 'E8F5E9',
                'Produksi' => 'EFEBE9',
                'Reboisasi' => 'FFF8E1',
                default => 'FFFFFF',
            };
            $sheet->getStyle('D' . $row)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'font' => ['bold' => true],
            ]);
        }

        $sheet->getStyle('A6:F' . $lastDataRow)->applyFromArray([
            'font' => ['size' => 10],
        ]);

        $sheet->setAutoFilter('A5:F' . $lastDataRow);
        $sheet->freezePane('A6');

        return [];
    }

    public function title(): string
    {
        return 'Data Lahan';
    }
}
