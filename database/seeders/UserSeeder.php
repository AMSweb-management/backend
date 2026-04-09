<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Apotek',
            'email' => 'admin@apotek.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Pegawai Apotek',
            'email' => 'pegawai@apotek.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
