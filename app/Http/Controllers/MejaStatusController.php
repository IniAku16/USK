<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Pesanan;

class MejaStatusController extends Controller
{
    /**
     * Mendapatkan status meja (tersedia/terisi)
     */
    public function getMejaStatus()
    {
        $meja = Cache::get('data_meja', []);
        $mejaStatus = [];
        
        foreach ($meja as $m) {
            // Cek apakah meja memiliki pesanan aktif (belum dibayar)
            $pesananAktif = Pesanan::where('id_meja', $m['id'])
                ->whereHas('transaksi', function($query) {
                    $query->where('bayar', 0);
                })
                ->exists();
            
            $mejaStatus[$m['id']] = [
                'id' => $m['id'],
                'nomor_meja' => $m['nomor_meja'],
                'kapasitas' => $m['kapasitas'],
                'status' => $pesananAktif ? 'terisi' : 'tersedia'
            ];
        }
        
        return response()->json($mejaStatus);
    }
    
    /**
     * Update status meja
     */
    public function updateMejaStatus(Request $request)
    {
        $mejaId = $request->input('meja_id');
        $status = $request->input('status'); // 'tersedia' atau 'terisi'
        
        // Simpan status meja di cache
        $mejaStatus = Cache::get('meja_status', []);
        $mejaStatus[$mejaId] = $status;
        Cache::put('meja_status', $mejaStatus, now()->addHours(24));
        
        return response()->json(['success' => true]);
    }
}