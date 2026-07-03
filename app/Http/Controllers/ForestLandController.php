<?php

namespace App\Http\Controllers;

use App\Models\ForestLand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForestLandController extends Controller
{
    // 1. Menampilkan Halaman Dashboard Utama dengan Daftar Tabel Lahan
    public function index()
    {
        // Mengambil data lahan khusus milik user yang sedang login saja (Prinsip SaaS)
        $forestLands = ForestLand::where('user_id', Auth::id())->latest()->get();
        
        // Mengirim data ke file resources/views/dashboard.blade.php
        return view('dashboard', compact('forestLands'));
    }

    // 2. Menampilkan Halaman Form Tambah Lahan
    public function create()
    {
        return view('forest.create');
    }

    // 3. Memproses Data Form dan Disimpan ke MySQL XAMPP
    public function store(Request $request)
    {
        // Validasi input ketat sesuai ketentuan UAS
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

        // Menyimpan data dengan mengikat user_id yang sedang login aktif
        ForestLand::create([
            'user_id'       => Auth::id(), 
            'nama_lahan'    => $request->nama_lahan,
            'luas_hektar'   => $request->luas_hektar,
            'status'        => $request->status,
        ]);

        // Kembali ke dashboard dengan pesan sukses
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