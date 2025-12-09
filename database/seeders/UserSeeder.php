<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 212121212121212121,
            'nama' => 'Gundam',
            'username' => 'trosa',
            'password' => 'trosa',
            'role' => 'admin',
            'status_aktif' => 'aktif',
        ]);
    }
}