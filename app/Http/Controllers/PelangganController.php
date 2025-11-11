<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    // 📋 Menampilkan semua pelanggan
    public function index()
    {
        $pelanggan = DB::table('pelanggan')->orderBy('idpelanggan', 'asc')->get();
        return view('fitur.pelanggan', compact('pelanggan'));
    }

    // ➕ Simpan pelanggan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:1,0',
            'no_hp' => 'nullable|string|max:12',
            'alamat' => 'nullable|string|max:95',
        ]);

        DB::table('pelanggan')->insert([
            'nama_pelanggan' => $request->nama_pelanggan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('pelanggan.index')->with('success', '✅ Pelanggan berhasil ditambahkan!');
    }

    // 💾 Update pelanggan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:50',
            'jenis_kelamin' => 'required|in:1,0',
            'no_hp' => 'nullable|string|max:12',
            'alamat' => 'nullable|string|max:95',
        ]);

        DB::table('pelanggan')->where('idpelanggan', $id)->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'updated_at' => now(),
        ]);

        return redirect()->route('pelanggan.index')->with('success', ' Data pelanggan berhasil diperbarui!');
    }

    // ❌ Hapus pelanggan
    public function destroy($id)
    {
        DB::table('pelanggan')->where('idpelanggan', $id)->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus!');
    }
}
