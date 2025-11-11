<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MejaController extends Controller
{
    // 🪑 Tampilkan semua meja dari cache (shared untuk semua role)
    public function index()
    {
        $meja = Cache::get('data_meja', []);
        return view('fitur.meja', compact('meja'));
    }

    // ➕ Tambah meja baru (disimpan di cache global)
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|string|max:50',
            'kapasitas' => 'required|integer|min:1'
        ]);

        $meja = Cache::get('data_meja', []);
        $idBaru = count($meja) + 1;

        $meja[] = [
            'id' => $idBaru,
            'nomor_meja' => $request->nomor_meja,
            'kapasitas' => $request->kapasitas,
            'created_at' => now()->format('Y-m-d H:i:s')
        ];

        Cache::forever('data_meja', $meja);
        return redirect()->route('meja.index')->with('success', 'Meja berhasil ditambahkan!');
    }

    // ❌ Hapus meja dari cache
    public function destroy($id)
    {
        $meja = Cache::get('data_meja', []);
        $meja = array_filter($meja, fn($m) => $m['id'] != $id);
        Cache::forever('data_meja', array_values($meja));

        return redirect()->route('meja.index')->with('success', 'Meja berhasil dihapus!');
    }
}
