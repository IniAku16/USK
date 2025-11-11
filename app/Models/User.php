<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'iduser';

    protected $fillable = [
        'nama_user',
        'role',
        'username',
        'password',
    ];

    protected $hidden = ['password'];

    public function pesanan(){
        return $this->hasMany(Pesanan::class, 'iduser');
    }
}
