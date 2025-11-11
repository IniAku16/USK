<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama_user' => 'Admin',
            'role' => 'administrator',
            'username' => 'admin',
            'password' => Hash::make('admin1'),
        ]);

        User::create([
            'nama_user' => 'Waiter',
            'role' => 'waiter',
            'username' => 'waiter',
            'password' => Hash::make('waiter1'),
        ]);

        User::create([
            'nama_user' => 'Kasir',
            'role' => 'kasir',
            'username' => 'kasir',
            'password' => Hash::make('kasir1'),
        ]);

        User::create([
            'nama_user' => 'Owner',
            'role' => 'owner',
            'username' => 'owner',
            'password' => Hash::make('owner1'),
        ]);
    }
}
