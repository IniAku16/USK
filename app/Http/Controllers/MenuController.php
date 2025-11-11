<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Menampilkan semua menu.
     */
    public function index()
    {
        $filterJenis = request('jenis'); // 'makanan' | 'minuman' | null
        $menus = Menu::when($filterJenis, fn($q) => $q->where('jenis', $filterJenis))
            ->orderBy('idmenu', 'asc')
            ->get();

        // Tandai menu yang soldout dari session
        $soldOutMenus = session('soldout_menus', []);
        foreach ($menus as $menu) {
            $menu->is_soldout = in_array($menu->idmenu, $soldOutMenus);
        }

        return view('fitur.menu', compact('menus', 'filterJenis'));
    }

    /**
     * Menampilkan form tambah menu.
     */
    public function create()
    {
        return view('fitur.menu');
    }

    /**
     * Menyimpan menu baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:50',
            'jenis'     => 'required|in:makanan,minuman',
            'harga'     => 'required|integer|min:0',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/menu'), $filename);
            $validated['foto'] = 'uploads/menu/' . $filename;
        }

        Menu::create($validated);

        return redirect()
            ->route('menu.index')
            ->with('success', 'Menu baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit menu.
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('fitur.menu', compact('menu'));
    }

    /**
     * Mengupdate data menu.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_menu' => 'required|string|max:50',
            'jenis'     => 'required|in:makanan,minuman',
            'harga'     => 'required|integer|min:0',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $menu = Menu::findOrFail($id);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($menu->foto && file_exists(public_path($menu->foto))) {
                unlink(public_path($menu->foto));
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/menu'), $filename);
            $validated['foto'] = 'uploads/menu/' . $filename;
        }

        $menu->update($validated);

        return redirect()
            ->route('menu.index')
            ->with('success', 'Data menu berhasil diperbarui!');
    }

    /**
     * Menghapus menu.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()
            ->route('menu.index')
            ->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * Toggle status Sold Out tanpa menyimpan di database.
     */
    public function toggleSoldOut($id)
    {
        $soldOutMenus = session('soldout_menus', []);

        if (in_array($id, $soldOutMenus)) {
            // Jika sebelumnya soldout, jadikan tersedia
            $soldOutMenus = array_diff($soldOutMenus, [$id]);
            $message = 'Menu tersedia kembali.';
        } else {
            // Jika tersedia, tandai sebagai soldout
            $soldOutMenus[] = $id;
            $message = 'Menu ditandai sebagai sold out.';
        }

        // Simpan kembali ke session
        session(['soldout_menus' => $soldOutMenus]);

        return redirect()->route('menu.index')->with('success', $message);
    }
}
