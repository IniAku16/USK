<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'idtransaksi';

    protected $fillable = [
        'idpesanan',
        'total',
        'bayar',
    ];


    public function pesanan(){
        return $this->belongsTo(Pesanan::class, 'idpesanan');
    }
}
