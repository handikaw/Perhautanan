<?php

namespace App\Http\Controllers;

use App\Models\LandActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LandActivityController extends Controller
{
    /**
     * GET /kegiatan
     * Returns the full activity list, already shaped for the dashboard JS.
     */
    public function index()
    {
        $items = LandActivity::with('forestLand')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get()
            ->map(fn (LandActivity $item) => $item->toDashboardArray());

        return response()->json($items);
    }

    /**
     * POST /kegiatan
     */
    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $activity = LandActivity::create($validated)->load('forestLand');

        return response()->json($activity->toDashboardArray(), 201);
    }

    /**
     * PUT /kegiatan/{landActivity}
     */
    public function update(Request $request, LandActivity $landActivity)
    {
        $validated = $this->validated($request);

        $landActivity->update($validated);
        $landActivity->load('forestLand');

        return response()->json($landActivity->toDashboardArray());
    }

    /**
     * DELETE /kegiatan/{landActivity}
     */
    public function destroy(LandActivity $landActivity)
    {
        $landActivity->delete();

        return response()->json(null, 204);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'forest_land_id' => ['required', 'exists:forest_lands,id'],
            'jenis' => ['required', Rule::in(['Penanaman', 'Pemeliharaan', 'Penebangan', 'Panen', 'Inspeksi', 'Lainnya'])],
            'tanggal' => ['required', 'date'],
            'tindak_lanjut' => ['nullable', 'date'],
            'petugas' => ['required', 'string', 'max:255'],
            'catatan' => ['nullable', 'string'],
        ]);
    }
}
