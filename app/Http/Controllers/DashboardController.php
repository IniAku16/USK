<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Pesanan;

class DashboardController extends Controller
{
    private function commonStats(): array
    {
        $today = now()->toDateString();

        $totalMenu = Menu::count();
        $totalPelanggan = Pelanggan::count();
        $totalPesananHariIni = DB::table('pesanan')->whereDate('created_at', $today)->count();
        $totalTransaksiHariIni = DB::table('transaksi')->whereDate('created_at', $today)->count();
        $omzetHariIni = (int) DB::table('transaksi')->whereDate('created_at', $today)->sum('bayar');
        $belumLunas = DB::table('transaksi')->where('bayar', 0)->count();

        // Meja status (tersedia/terisi) berdasarkan pesanan aktif (transaksi belum lunas)
        $meja = Cache::get('data_meja', []);
        $mejaTerisi = 0;
        $mejaTersedia = 0;
        foreach ($meja as $m) {
            $aktif = Pesanan::where('id_meja', $m['id'])
                ->whereHas('transaksi', function($q) { $q->where('bayar', 0); })
                ->exists();
            if ($aktif) { $mejaTerisi++; } else { $mejaTersedia++; }
        }

        // Analytics 7 hari terakhir
        $days = collect(range(6, 0))->map(function($i) {
            $date = now()->subDays($i);
            return [
                'key' => $date->toDateString(),
                'label' => $date->format('D'),
            ];
        });

        $omzet7 = [];
        $pesanan7 = [];
        $labels7 = [];
        foreach ($days as $d) {
            $labels7[] = $d['label'];
            $omzet7[] = (int) DB::table('transaksi')->whereDate('created_at', $d['key'])->sum('bayar');
            $pesanan7[] = (int) DB::table('pesanan')->whereDate('created_at', $d['key'])->count();
        }

        // Notifikasi ringkas
        // Sold out menu disimpan di session (bukan kolom DB)
        $soldOutCount = count(session('soldout_menus', []));
        $newCustomerToday = Pelanggan::whereDate('created_at', $today)->count();

        $notifications = [
            [
                'type' => 'warning',
                'text' => $soldOutCount . ' menu berstatus SOLD OUT',
            ],
            [
                'type' => 'danger',
                'text' => $belumLunas . ' transaksi belum dibayar',
            ],
            [
                'type' => 'info',
                'text' => $mejaTerisi . ' meja terisi, ' . $mejaTersedia . ' tersedia',
            ],
            [
                'type' => 'success',
                'text' => $newCustomerToday . ' pelanggan baru hari ini',
            ],
        ];

        // Calendar/timeline: aktivitas terbaru (5 transaksi terakhir)
        $recentActivities = DB::table('transaksi as t')
            ->join('pesanan as p', 'p.idpesanan', '=', 't.idpesanan')
            ->join('pelanggan as pl', 'pl.idpelanggan', '=', 'p.idpelanggan')
            ->select('t.created_at', 'pl.nama_pelanggan', 'p.id_meja', 't.total', 't.bayar')
            ->orderByDesc('t.created_at')
            ->limit(5)
            ->get();

        return [
            'totalMenu' => $totalMenu,
            'totalPelanggan' => $totalPelanggan,
            'totalPesananHariIni' => $totalPesananHariIni,
            'totalTransaksiHariIni' => $totalTransaksiHariIni,
            'omzetHariIni' => $omzetHariIni,
            'belumLunas' => $belumLunas,
            'mejaTerisi' => $mejaTerisi,
            'mejaTersedia' => $mejaTersedia,
            'labels7' => $labels7,
            'omzet7' => $omzet7,
            'pesanan7' => $pesanan7,
            'notifications' => $notifications,
            'recentActivities' => $recentActivities,
        ];
    }

    public function admin()
    {
        if (session('role') !== 'administrator') {
            return redirect('/login')->with('error', 'Akses ditolak');
        }
        
        $stats = $this->commonStats();
        
        // Data khusus Admin - Manajemen Sistem
        $stats['adminStats'] = [
            'totalUsers' => DB::table('users')->count(),
            'activeUsers' => DB::table('users')->count(), // Semua user dianggap aktif
            'totalMeja' => count(Cache::get('data_meja', [])),
            'menuAktif' => Menu::count(), // Semua menu dianggap aktif
            'menuNonaktif' => 0, // Tidak ada menu nonaktif
        ];
        
        // Aktivitas admin hari ini
        $stats['adminActivities'] = [
            'menuDitambah' => Menu::whereDate('created_at', now()->toDateString())->count(),
            'pelangganBaru' => Pelanggan::whereDate('created_at', now()->toDateString())->count(),
            'mejaDitambah' => 0, // Jika ada fitur tambah meja
        ];
        
        return view('admin.dashboard', $stats);
    }

    public function waiter()
    {
        if (session('role') !== 'waiter') {
            return redirect('/login')->with('error', 'Akses ditolak');
        }
        
        $stats = $this->commonStats();
        $userId = session('id_user');
        
        // Data khusus Waiter - Fokus pada Pesanan
        $stats['waiterStats'] = [
            'pesananSaya' => DB::table('pesanan')->where('iduser', $userId)->whereDate('created_at', now()->toDateString())->count(),
            'pesananPending' => DB::table('pesanan')->whereDate('created_at', now()->toDateString())->count(), // Semua pesanan hari ini
            'pesananSelesai' => DB::table('pesanan')->whereDate('created_at', now()->toDateString())->count(), // Semua pesanan hari ini
            'mejaBertugas' => DB::table('pesanan')->where('iduser', $userId)->distinct('id_meja')->count(),
        ];
        
        // Pesanan yang perlu ditangani waiter
        $stats['waiterTasks'] = DB::table('pesanan as p')
            ->join('pelanggan as pl', 'pl.idpelanggan', '=', 'p.idpelanggan')
            ->join('menu as m', 'm.idmenu', '=', 'p.idmenu')
            ->select('p.idpesanan', 'pl.nama_pelanggan', 'm.nama_menu', 'p.id_meja', 'p.jumlah', 'p.created_at')
            ->whereDate('p.created_at', now()->toDateString())
            ->orderBy('p.created_at', 'asc')
            ->limit(10)
            ->get();
            
        return view('waiter.dashboard', $stats);
    }

    public function kasir()
    {
        if (session('role') !== 'kasir') {
            return redirect('/login')->with('error', 'Akses ditolak');
        }
        
        $stats = $this->commonStats();
        
        // Data khusus Kasir - Fokus pada Transaksi & Pembayaran
        $stats['kasirStats'] = [
            'transaksiLunas' => DB::table('transaksi')->where('bayar', '>', 0)->whereDate('created_at', now()->toDateString())->count(),
            'transaksiBelumLunas' => DB::table('transaksi')->where('bayar', 0)->count(),
            'totalPendapatan' => DB::table('transaksi')->where('bayar', '>', 0)->whereDate('created_at', now()->toDateString())->sum('bayar'),
            'rataRataTransaksi' => DB::table('transaksi')->where('bayar', '>', 0)->whereDate('created_at', now()->toDateString())->avg('bayar'),
        ];
        
        // Transaksi yang perlu ditangani kasir
        $stats['kasirTasks'] = DB::table('transaksi as t')
            ->join('pesanan as p', 'p.idpesanan', '=', 't.idpesanan')
            ->join('pelanggan as pl', 'pl.idpelanggan', '=', 'p.idpelanggan')
            ->select('t.idtransaksi', 'pl.nama_pelanggan', 'p.id_meja', 't.total', 't.bayar', 't.created_at')
            ->where('t.bayar', 0)
            ->orderBy('t.created_at', 'asc')
            ->limit(10)
            ->get();
            
        return view('kasir.dashboard', $stats);
    }

    public function owner()
    {
        if (session('role') !== 'owner') {
            return redirect('/login')->with('error', 'Akses ditolak');
        }
        
        $stats = $this->commonStats();
        
        // Data khusus Owner - Overview Bisnis Lengkap
        $stats['ownerStats'] = [
            'totalRevenue' => DB::table('transaksi')->where('bayar', '>', 0)->sum('bayar'),
            'revenueBulanIni' => DB::table('transaksi')->where('bayar', '>', 0)->whereMonth('created_at', now()->month)->sum('bayar'),
            'revenueBulanLalu' => DB::table('transaksi')->where('bayar', '>', 0)->whereMonth('created_at', now()->subMonth()->month)->sum('bayar'),
            'totalTransaksi' => DB::table('transaksi')->where('bayar', '>', 0)->count(),
            'customerRetention' => $this->calculateCustomerRetention(),
            'topMenu' => $this->getTopMenu(),
            'peakHours' => $this->getPeakHours(),
        ];
        
        // Analisis bisnis untuk owner
        $stats['businessInsights'] = [
            'growthRate' => $this->calculateGrowthRate(),
            'averageOrderValue' => DB::table('transaksi')->where('bayar', '>', 0)->avg('total'),
            'busiestDay' => $this->getBusiestDay(),
            'menuPerformance' => $this->getMenuPerformance(),
        ];
        
        return view('owner.dashboard', $stats);
    }
    
    private function calculateCustomerRetention()
    {
        // Hitung pelanggan yang kembali dalam 30 hari terakhir
        $returningCustomers = DB::table('transaksi as t')
            ->join('pesanan as p', 'p.idpesanan', '=', 't.idpesanan')
            ->where('t.bayar', '>', 0)
            ->where('t.created_at', '>=', now()->subDays(30))
            ->distinct('p.idpelanggan')
            ->count();
            
        $totalCustomers = Pelanggan::count();
        
        return $totalCustomers > 0 ? round(($returningCustomers / $totalCustomers) * 100, 1) : 0;
    }
    
    private function getTopMenu()
    {
        return DB::table('pesanan as p')
            ->join('menu as m', 'm.idmenu', '=', 'p.idmenu')
            ->select('m.nama_menu', DB::raw('SUM(p.jumlah) as total_terjual'))
            ->groupBy('m.idmenu', 'm.nama_menu')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();
    }
    
    private function getPeakHours()
    {
        return DB::table('transaksi')
            ->where('bayar', '>', 0)
            ->select(DB::raw('HOUR(created_at) as jam'), DB::raw('COUNT(*) as jumlah_transaksi'))
            ->groupBy('jam')
            ->orderByDesc('jumlah_transaksi')
            ->limit(5)
            ->get();
    }
    
    private function calculateGrowthRate()
    {
        $currentMonth = DB::table('transaksi')->where('bayar', '>', 0)->whereMonth('created_at', now()->month)->sum('bayar');
        $lastMonth = DB::table('transaksi')->where('bayar', '>', 0)->whereMonth('created_at', now()->subMonth()->month)->sum('bayar');
        
        if ($lastMonth > 0) {
            return round((($currentMonth - $lastMonth) / $lastMonth) * 100, 1);
        }
        
        return 0;
    }
    
    private function getBusiestDay()
    {
        return DB::table('transaksi')
            ->where('bayar', '>', 0)
            ->select(DB::raw('DAYNAME(created_at) as hari'), DB::raw('COUNT(*) as jumlah'))
            ->groupBy('hari')
            ->orderByDesc('jumlah')
            ->first();
    }
    
    private function getMenuPerformance()
    {
        return DB::table('pesanan as p')
            ->join('menu as m', 'm.idmenu', '=', 'p.idmenu')
            ->select('m.nama_menu', DB::raw('SUM(p.jumlah * m.harga) as revenue'))
            ->groupBy('m.idmenu', 'm.nama_menu')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();
    }
}


