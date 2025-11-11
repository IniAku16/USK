<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data transaksi yang dikelompokkan per pelanggan dan meja
        $query = DB::table('transaksi as t')
            ->join('pesanan as p', 'p.idpesanan', '=', 't.idpesanan')
            ->join('menu as m', 'm.idmenu', '=', 'p.idmenu')
            ->join('pelanggan as pl', 'pl.idpelanggan', '=', 'p.idpelanggan')
            ->select(
                'p.id_meja',
                'p.idpelanggan', 
                'pl.nama_pelanggan',
                't.created_at',
                'm.nama_menu',
                'p.jumlah',
                't.total',
                't.bayar',
                't.idtransaksi'
            );

        // Filter berdasarkan status pembayaran
        $status = $request->get('status');
        if ($status === 'lunas') {
            $query->where('t.bayar', '>', 0);
        } elseif ($status === 'belum_lunas') {
            $query->where('t.bayar', '=', 0);
        }

        // Pencarian berdasarkan nama pelanggan atau meja
        $search = $request->get('search');
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('pl.nama_pelanggan', 'like', '%' . $search . '%')
                  ->orWhere('p.id_meja', 'like', '%' . $search . '%');
            });
        }

        $transaksiGrouped = $query->orderByDesc('t.created_at')
            ->orderBy('p.id_meja')
            ->orderBy('p.idpelanggan')
            ->get()
            ->groupBy(function ($item) {
                return $item->id_meja . '_' . $item->idpelanggan . '_' . $item->created_at;
            });

        // Hitung total per grup
        $transaksiWithTotal = $transaksiGrouped->map(function ($group) {
            $firstItem = $group->first();
            $totalBayar = $group->sum('bayar');
            $totalHarga = $group->sum('total');
            $kembalian = max(0, $totalBayar - $totalHarga);
            
            return (object) [
                'id_meja' => $firstItem->id_meja,
                'idpelanggan' => $firstItem->idpelanggan,
                'nama_pelanggan' => $firstItem->nama_pelanggan,
                'created_at' => $firstItem->created_at,
                'items' => $group,
                'total_harga' => $totalHarga,
                'total_bayar' => $totalBayar,
                'kembalian' => $kembalian,
                'is_lunas' => $totalBayar >= $totalHarga && $totalBayar > 0
            ];
        });

        // Filter hasil berdasarkan status setelah grouping
        if ($status === 'lunas') {
            $transaksiWithTotal = $transaksiWithTotal->filter(function($group) {
                return $group->is_lunas;
            });
        } elseif ($status === 'belum_lunas') {
            $transaksiWithTotal = $transaksiWithTotal->filter(function($group) {
                return !$group->is_lunas;
            });
        }

        return view('fitur.transaksi', compact('transaksiWithTotal', 'status', 'search'));
    }

    public function pay($id, Request $request)
    {
        $request->validate([
            'bayar' => 'required|integer|min:0',
        ]);

        // Ambil semua transaksi untuk grup yang sama
        $trx = DB::table('transaksi')->where('idtransaksi', $id)->first();
        if (!$trx) {
            return redirect()->route('transaksi.index')->with('error', 'Transaksi tidak ditemukan');
        }

        // Ambil semua transaksi dalam grup yang sama
        $pesanan = DB::table('pesanan')->where('idpesanan', $trx->idpesanan)->first();
        $allTransaksiInGroup = DB::table('transaksi as t')
            ->join('pesanan as p', 'p.idpesanan', '=', 't.idpesanan')
            ->where('p.id_meja', $pesanan->id_meja)
            ->where('p.idpelanggan', $pesanan->idpelanggan)
            ->where('t.created_at', $trx->created_at)
            ->select('t.idtransaksi', 't.total')
            ->get();

        // Hitung total harga grup
        $totalHargaGrup = $allTransaksiInGroup->sum('total');
        $bayarPerItem = $request->bayar / $allTransaksiInGroup->count();

        // Update semua transaksi dalam grup
        foreach ($allTransaksiInGroup as $transaksi) {
            DB::table('transaksi')->where('idtransaksi', $transaksi->idtransaksi)->update([
                'bayar' => $bayarPerItem,
                'updated_at' => now(),
            ]);
        }

        $kembalian = max(0, (int)$request->bayar - (int)$totalHargaGrup);
        return redirect()->route('transaksi.index')->with('success', 'Pembayaran disimpan. Kembalian: Rp ' . number_format($kembalian, 0, ',', '.'));
    }

    public function downloadPdf($id)
    {
        // Ambil data transaksi berdasarkan ID
        $transaksi = DB::table('transaksi as t')
            ->join('pesanan as p', 'p.idpesanan', '=', 't.idpesanan')
            ->join('menu as m', 'm.idmenu', '=', 'p.idmenu')
            ->join('pelanggan as pl', 'pl.idpelanggan', '=', 'p.idpelanggan')
            ->where('t.idtransaksi', $id)
            ->select(
                'p.id_meja',
                'p.idpelanggan', 
                'pl.nama_pelanggan',
                't.created_at',
                'm.nama_menu',
                'p.jumlah',
                't.total',
                't.bayar',
                't.idtransaksi'
            )
            ->first();

        if (!$transaksi) {
            return redirect()->route('transaksi.index')->with('error', 'Transaksi tidak ditemukan');
        }

        // Ambil semua item dalam grup yang sama
        $allItems = DB::table('transaksi as t')
            ->join('pesanan as p', 'p.idpesanan', '=', 't.idpesanan')
            ->join('menu as m', 'm.idmenu', '=', 'p.idmenu')
            ->where('p.id_meja', $transaksi->id_meja)
            ->where('p.idpelanggan', $transaksi->idpelanggan)
            ->where('t.created_at', $transaksi->created_at)
            ->select(
                'm.nama_menu',
                'p.jumlah',
                't.total',
                't.bayar'
            )
            ->get();

        // Hitung total
        $totalHarga = $allItems->sum('total');
        $totalBayar = $allItems->sum('bayar');
        $kembalian = max(0, $totalBayar - $totalHarga);

        $data = [
            'transaksi' => $transaksi,
            'items' => $allItems,
            'total_harga' => $totalHarga,
            'total_bayar' => $totalBayar,
            'kembalian' => $kembalian,
            'is_lunas' => $totalBayar >= $totalHarga && $totalBayar > 0
        ];

        $pdf = Pdf::loadView('fitur.transaksi-pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'Transaksi_' . $transaksi->nama_pelanggan . '_' . date('Y-m-d_H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }
}


