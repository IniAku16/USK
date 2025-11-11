<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar menu untuk dipesan (fitur waiter)
     */
    public function index(Request $request)
    {
        // Ambil semua menu yang tidak soldout dari session
        $soldOutMenus = session('soldout_menus', []);

        // Filter jenis (makanan/minuman) dan hanya tampilkan menu yang tidak soldout
        $jenis = $request->query('jenis');
        $menus = Menu::when($jenis, fn($q) => $q->where('jenis', $jenis))
                     ->whereNotIn('idmenu', $soldOutMenus)
                     ->orderBy('nama_menu', 'asc')
                     ->get();

        // Ambil daftar pelanggan untuk pilihan pelanggan
        $pelanggans = Pelanggan::orderBy('idpelanggan', 'asc')->get();

        // Ambil layout meja dari session (fitur Manajemen Meja)
        // Ambil layout meja dari cache agar terlihat oleh semua role
        $meja = Cache::get('data_meja', []);
        $preselectedMeja = $request->query('id_meja');
        
        // Tambahkan status meja (tersedia/terisi)
        foreach ($meja as &$m) {
            $pesananAktif = Pesanan::where('id_meja', $m['id'])
                ->whereHas('transaksi', function($query) {
                    $query->where('bayar', 0);
                })
                ->exists();
            
            $m['status'] = $pesananAktif ? 'terisi' : 'tersedia';
        }

        return view('fitur.pesanan', compact('menus', 'pelanggans', 'meja', 'preselectedMeja'));
    }

    /**
     * Menyimpan pesanan yang dipilih waiter
     */
    public function store(Request $request)
    {
        $request->validate([
            'idpelanggan' => 'required|exists:pelanggan,idpelanggan',
            'id_meja' => 'required|integer',
            'items' => 'required|array',
        ]);

        $idUser = session('id_user');
        if (!$idUser) {
            return redirect('/login')->with('error', 'Sesi berakhir, silakan login kembali.');
        }

        $items = $request->input('items', []);
        $menuIds = array_keys($items);
        if (empty($menuIds)) {
            return back()->withErrors(['items' => 'Pilih minimal satu menu.'])->withInput();
        }

        $menus = Menu::whereIn('idmenu', $menuIds)->get()->keyBy('idmenu');
        $grandTotal = 0;
        $rowsCreated = 0;

        foreach ($items as $menuId => $item) {
            $qty = isset($item['qty']) ? (int)$item['qty'] : 0;
            if ($qty <= 0) {
                continue; // skip items with zero or negative qty
            }
            if (!isset($menus[$menuId])) {
                continue; // menu not found, skip
            }

            $menu = $menus[$menuId];
            $subtotal = $menu->harga * $qty;
            $grandTotal += $subtotal;

            $pesanan = Pesanan::create([
                'idmenu' => $menuId,
                'idpelanggan' => $request->idpelanggan,
                'jumlah' => $qty, // jumlah disimpan sebagai kuantitas item
                'id_meja' => $request->id_meja,
                'iduser' => $idUser,
            ]);
            // Simpan transaksi per item (subtotal) agar nilai uang masuk DB
            DB::table('transaksi')->insert([
                'idpesanan' => $pesanan->idpesanan,
                'total' => $subtotal,
                'bayar' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $rowsCreated++;
        }

        if ($rowsCreated === 0) {
            return back()->withErrors(['items' => 'Masukkan jumlah > 0 untuk minimal satu menu.'])->withInput();
        }

        // Catatan: total harga pelanggan (grand total) dihitung di sini.
        // Idealnya disimpan pada tabel Transaksi sebagai total, namun untuk saat ini
        // kita tampilkan pada notifikasi agar owner dapat melihat totalnya.

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil ditambahkan! Total: Rp ' . number_format($grandTotal, 0, ',', '.'));
    }

    /**
     * API untuk mendapatkan pesanan pelanggan
     */
    public function getPesananPelanggan($idPelanggan)
    {
        $pesanan = Pesanan::with(['menu', 'transaksi'])
            ->where('idpelanggan', $idPelanggan)
            ->get()
            ->map(function($p) {
                return [
                    'nama_menu' => $p->menu->nama_menu,
                    'jumlah' => $p->jumlah,
                    'nomor_meja' => $p->meja_nomor ?? 'N/A',
                    'status' => $p->transaksi->bayar > 0 ? 'lunas' : 'belum lunas'
                ];
            });

        return response()->json($pesanan);
    }
}
