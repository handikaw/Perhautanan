<?php

namespace App\Http\Controllers;

use App\Exports\ForestLandExport;
use App\Exports\ForestProductionExport;
use App\Exports\LandActivityExport;
use App\Services\PlanLimitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    protected PlanLimitService $planLimit;

    public function __construct(PlanLimitService $planLimit)
    {
        $this->planLimit = $planLimit;
    }

    public function exportLahan(Request $request)
    {
        $user = Auth::user();

        if (!$this->planLimit->canExportPdf($user)) {
            return response()->json([
                'message' => $this->planLimit->pdfLimitMessage(),
            ], 403);
        }

        $export = new ForestLandExport(
            ids: $request->query('ids'),
            startDate: $request->query('start_date'),
            endDate: $request->query('end_date'),
        );

        $this->planLimit->recordPdfExport($user);

        return $export->download('Data-Lahan-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportKegiatan(Request $request)
    {
        $user = Auth::user();

        if (!$this->planLimit->canExportPdf($user)) {
            return response()->json([
                'message' => $this->planLimit->pdfLimitMessage(),
            ], 403);
        }

        $export = new LandActivityExport(
            filterLahan: $request->query('lahan'),
            filterJenis: $request->query('jenis'),
        );

        $this->planLimit->recordPdfExport($user);

        return $export->download('Riwayat-Kegiatan-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportProduksi(Request $request)
    {
        $user = Auth::user();

        if (!$this->planLimit->canExportPdf($user)) {
            return response()->json([
                'message' => $this->planLimit->pdfLimitMessage(),
            ], 403);
        }

        $export = new ForestProductionExport();

        $this->planLimit->recordPdfExport($user);

        return $export->download('Riwayat-Produksi-' . now()->format('Y-m-d') . '.xlsx');
    }
}
