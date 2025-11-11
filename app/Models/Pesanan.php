<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'idpesanan';

    protected $fillable = [
        'idmenu',
        'idpelanggan',
        'jumlah',
        'id_meja',   
        'iduser',
    ];

    // 🔹 Relasi ke Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'idmenu', 'idmenu');
    }

    // 🔹 Relasi ke Pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'idpelanggan', 'idpelanggan');
    }

    // 🔹 Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }

    // 🔹 Relasi ke Transaksi (1 pesanan = 1 transaksi)
    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'idpesanan', 'idpesanan');
    }
}
