<?php

namespace App\Http\Controllers;

use App\Models\ForestProduction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ForestProductionController extends Controller
{
    /**
     * GET /produksi
     * Returns the full production list, already shaped for the dashboard JS.
     */
    public function index()
    {
        $items = ForestProduction::with('forestLand')
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->get()
            ->map(fn (ForestProduction $item) => $item->toDashboardArray());

        return response()->json($items);
    }

    /**
     * POST /produksi
     */
    public function store(Request $request)
    {
        $validated = $this->validated($request);

        $production = ForestProduction::create($validated)->load('forestLand');

        return response()->json($production->toDashboardArray(), 201);
    }

    /**
     * PUT /produksi/{forestProduction}
     */
    public function update(Request $request, ForestProduction $forestProduction)
    {
        $validated = $this->validated($request);

        $forestProduction->update($validated);
        $forestProduction->load('forestLand');

        return response()->json($forestProduction->toDashboardArray());
    }

    /**
     * DELETE /produksi/{forestProduction}
     */
    public function destroy(ForestProduction $forestProduction)
    {
        $forestProduction->delete();

        return response()->json(null, 204);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'forest_land_id' => ['required', 'exists:forest_lands,id'],
            'komoditas' => ['required', 'string', 'max:255'],
            'jumlah' => ['required', 'numeric', 'min:0.01'],
            'satuan' => ['required', Rule::in(['m3', 'kg', 'batang', 'liter'])],
            'tanggal' => ['required', 'date'],
            'catatan' => ['nullable', 'string'],
        ]);
    }
}
