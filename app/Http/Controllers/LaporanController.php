<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Pencarian bebas menggantikan periode
        $search = $request->query('search');
        // Disederhanakan: hilangkan parameter HPP & Opex dari UI (tetap bisa ditambah nanti)

        $q = DB::table('transaksi as t')
            ->join('pesanan as p', 'p.idpesanan', '=', 't.idpesanan')
            ->join('menu as m', 'm.idmenu', '=', 'p.idmenu')
            ->leftJoin('pelanggan as pl', 'pl.idpelanggan', '=', 'p.idpelanggan')
            ->select('t.idtransaksi', 't.total', 't.bayar', 't.created_at', 'p.id_meja', 'p.idpelanggan', 'p.jumlah', 'm.nama_menu', 'm.harga', 'pl.nama_pelanggan');

        if ($search) {
            $q->where(function($w) use ($search) {
                $w->where('pl.nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('m.nama_menu', 'like', "%{$search}%")
                  ->orWhere('p.id_meja', 'like', "%{$search}%")
                  ->orWhere('p.idpelanggan', 'like', "%{$search}%");
            });
        }

        $rows = $q->orderBy('t.created_at', 'desc')->get();

        // Gabungkan per pembeli (pelanggan) per meja dan momen transaksi
        $grouped = $rows->groupBy(function ($r) {
            return $r->id_meja . '_' . $r->idpelanggan . '_' . $r->created_at;
        })->map(function ($g) {
            $first = $g->first();
            return (object) [
                'created_at' => $first->created_at,
                'id_meja' => $first->id_meja,
                'idpelanggan' => $first->idpelanggan,
                'nama_pelanggan' => $first->nama_pelanggan,
                'items' => $g->map(function ($r) {
                    return [
                        'nama_menu' => $r->nama_menu,
                        'harga' => (int)$r->harga,
                        'jumlah' => (int)$r->jumlah,
                        'total' => (int)$r->total,
                        'bayar' => (int)$r->bayar,
                    ];
                })->values(),
                'total_qty' => (int)$g->sum('jumlah'),
                'total_harga' => (int)$g->sum('total'),
                'total_bayar' => (int)$g->sum('bayar'),
            ];
        })->values();

        // Aggregate yang lebih jelas
        $totalTagihan = (int) $rows->sum('total'); // total nilai pesanan (apapun status bayar)
        $omzetDiterima = (int) $rows->where('bayar', '>', 0)->sum('bayar'); // hanya yang sudah dibayar
        $piutang = max(0, $totalTagihan - $omzetDiterima); // sisa yang belum diterima

        $jumlahItem = $rows->count();
        $jumlahLunas = $rows->where('bayar', '>', 0)->count();
        $jumlahBelum = $rows->where('bayar', '=', 0)->count();

        // Menu favorit: berdasarkan akumulasi qty
        $menuFavorit = $rows
            ->groupBy('nama_menu')
            ->map(function ($g) {
                return [
                    'nama_menu' => $g->first()->nama_menu,
                    'qty' => (int) $g->sum('jumlah'),
                    // Omzet (subtotal akru) = sum total harga semua transaksi menu tsb
                    'omzet_subtotal' => (int) $g->sum('total'),
                    // Uang Masuk (hanya yang sudah dibayar)
                    'uang_masuk' => (int) $g->where('bayar', '>', 0)->sum('bayar'),
                ];
            })
            ->sortByDesc('qty')
            ->values();

        return view('fitur.laporan', compact(
            'rows', 'search',
            'totalTagihan', 'omzetDiterima', 'piutang',
            'jumlahItem', 'jumlahLunas', 'jumlahBelum',
            'menuFavorit', 'grouped'
        ));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $from = $request->query('from');
        $to = $request->query('to');
        // Disederhanakan: hilangkan parameter HPP & Opex dari UI export

        $q = DB::table('transaksi as t')
            ->join('pesanan as p', 'p.idpesanan', '=', 't.idpesanan')
            ->join('menu as m', 'm.idmenu', '=', 'p.idmenu')
            ->select('t.created_at', 'p.id_meja', 'p.idpelanggan', 'm.nama_menu', 'p.jumlah', 'm.harga', 't.total', 't.bayar');

        if ($from) { $q->whereDate('t.created_at', '>=', $from); }
        if ($to)   { $q->whereDate('t.created_at', '<=', $to); }

        $rows = $q->orderBy('t.created_at', 'desc')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan.csv"',
        ];

        return response()->stream(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Tanggal', 'Meja', 'Pelanggan', 'Menu', 'Qty', 'Harga', 'Subtotal', 'Bayar']);
            foreach ($rows as $r) {
                fputcsv($out, [
                    $r->created_at,
                    $r->id_meja,
                    $r->idpelanggan,
                    $r->nama_menu,
                    $r->jumlah,
                    $r->harga,
                    $r->total,
                    $r->bayar,
                ]);
            }
            fclose($out);
        }, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        // Ambil data yang sama seperti index
        $from = $request->query('from');
        $to = $request->query('to');
        $hppPercent = (float) ($request->query('hpp_percent', 35));
        $opex = (int) ($request->query('opex', 0));

        $q = DB::table('transaksi as t')
            ->join('pesanan as p', 'p.idpesanan', '=', 't.idpesanan')
            ->join('menu as m', 'm.idmenu', '=', 'p.idmenu')
            ->select('t.idtransaksi', 't.total', 't.bayar', 't.created_at', 'p.id_meja', 'p.idpelanggan', 'p.jumlah', 'm.nama_menu', 'm.harga');

        if ($from) { $q->whereDate('t.created_at', '>=', $from); }
        if ($to)   { $q->whereDate('t.created_at', '<=', $to); }

        $rows = $q->orderBy('t.created_at', 'desc')->get();

        $totalTagihan = (int) $rows->sum('total');
        $omzetDiterima = (int) $rows->where('bayar', '>', 0)->sum('bayar');
        $piutang = max(0, $totalTagihan - $omzetDiterima);
        $jumlahItem = $rows->count();
        $jumlahLunas = $rows->where('bayar', '>', 0)->count();
        $jumlahBelum = $rows->where('bayar', '=', 0)->count();

        $menuFavorit = $rows
            ->groupBy('nama_menu')
            ->map(function ($g) {
                return [
                    'nama_menu' => $g->first()->nama_menu,
                    'qty' => (int) $g->sum('jumlah'),
                    'omzet_diterima' => (int) $g->where('bayar', '>', 0)->sum('bayar'),
                ];
            })
            ->sortByDesc('qty')
            ->values();

        $pdf = Pdf::loadView('fitur.laporan-pdf', compact(
            'rows', 'from', 'to',
            'totalTagihan', 'omzetDiterima', 'piutang',
            'jumlahItem', 'jumlahLunas', 'jumlahBelum',
            'menuFavorit'
        ));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Laporan_Transaksi_'.date('Y-m-d_H-i').'.pdf');
    }
}


