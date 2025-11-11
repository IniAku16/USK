<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'idpelanggan';

    protected $fillable = [
        'nama_pelanggan',
        'jenis_kelamin',
        'no_hp',
        'alamat',
    ];

    public function pesanan(){
        return $this->hasMany(Pesanan::class, 'idpelanggan');
    }
}
