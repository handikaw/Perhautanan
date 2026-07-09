<?php

namespace App\Http\Controllers;

use App\Models\ForestLand;
use App\Models\PlanFeature;
use App\Services\PlanLimitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForestLandController extends Controller
{
    protected PlanLimitService $planLimit;

    public function __construct(PlanLimitService $planLimit)
    {
        $this->planLimit = $planLimit;
    }

    // 1. Menampilkan Halaman Dashboard Utama dengan Daftar Tabel Lahan
    public function index()
    {
        $forestLands = ForestLand::where('user_id', Auth::id())->latest()->get();
        $planFeatures = PlanFeature::orderBy('sort_order')->get();

        return view('dashboard', compact('forestLands', 'planFeatures'));
    }

    // 2. Menampilkan Halaman Form Tambah Lahan
    public function create()
    {
        return view('forest.create');
    }

    // 3. Memproses Data Form dan Disimpan ke MySQL
    public function store(Request $request)
    {
        // Cek dulu apakah user masih boleh nambah lahan (limit paket Free)
        if (! $this->planLimit->canAddLahan(Auth::user())) {
            return redirect()
                ->route('dashboard')
                ->with('error', $this->planLimit->lahanLimitMessage());
        }

        $request->validate([
            'nama_lahan'  => 'required|string|max:255',
            'luas_hektar' => 'required|numeric|min:0.1',
            'status'      => 'required|in:Konservasi,Produksi,Reboisasi',
        ], [
            'nama_lahan.required'  => 'Nama lahan wajib diisi ya!',
            'luas_hektar.required' => 'Luas hektar tidak boleh kosong.',
            'luas_hektar.numeric'  => 'Luas hektar harus diisi dengan angka.',
            'status.required'      => 'Pilih salah satu status lahan.',
        ]);

        ForestLand::create([
            'user_id'     => Auth::id(),
            'nama_lahan'  => $request->nama_lahan,
            'luas_hektar' => $request->luas_hektar,
            'status'      => $request->status,
        ]);

        return redirect()->route('dashboard')->with('success', 'Lahan perhutanan baru berhasil disimpan!');
    }

    // 4. Menampilkan Halaman Form Edit Lahan
    public function edit($id)
    {
        $lahan = ForestLand::findOrFail($id);
        return view('forest.edit', compact('lahan'));
    }

    // 5. Memproses Update Data Lahan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lahan'  => 'required|string|max:255',
            'luas_hektar' => 'required|numeric|min:0.1',
            'status'      => 'required|in:Konservasi,Produksi,Reboisasi',
        ], [
            'nama_lahan.required'  => 'Nama lahan wajib diisi ya!',
            'luas_hektar.required' => 'Luas hektar tidak boleh kosong.',
            'luas_hektar.numeric'  => 'Luas hektar harus diisi dengan angka.',
            'status.required'      => 'Pilih salah satu status lahan.',
        ]);

        $lahan = ForestLand::findOrFail($id);
        $lahan->update([
            'nama_lahan'  => $request->nama_lahan,
            'luas_hektar' => $request->luas_hektar,
            'status'      => $request->status,
        ]);

        return redirect()->route('dashboard')->with('success', 'Data lahan berhasil diperbarui!');
    }

    // 6. Menghapus Data Lahan
    public function destroy($id)
    {
        $lahan = ForestLand::findOrFail($id);
        $namaLahan = $lahan->nama_lahan;
        $lahan->delete();

        return redirect()->route('dashboard')->with('success', "Lahan '{$namaLahan}' berhasil dihapus!");
    }
}
