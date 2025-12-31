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
            'id' => 1234567890,
            'nama' => 'Ida Bagus Adimas Aridiningrat',
            'username' => 'admin123',
            'password' => 'admin123',
            'role' => 'admin',
            'status_aktif' => 'aktif',
        ]);
    }
}