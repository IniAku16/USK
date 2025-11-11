<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'idmenu';

    protected $fillable = [
        'nama_menu',
        'jenis',
        'harga',
        'foto',
    ];

    public function pesanan(){
        return $this->hasMany(Pesanan::class, 'idmenu');
    }
}
