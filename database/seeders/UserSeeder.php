<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@desa.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'kecamatan' => null, // admin bisa akses semua data
            ]
        );

        // Contoh akun Kecamatan
        User::updateOrCreate(
            ['email' => 'jatirejo@desa.com'],
            [
                'name' => 'Petugas Kecamatan Jatirejo',
                'password' => Hash::make('password123'),
                'role' => 'kecamatan',
                'kecamatan' => 'Jatirejo',
            ]
        );

        User::updateOrCreate(
            ['email' => 'mojosari@desa.com'],
            [
                'name' => 'Petugas Kecamatan Mojosari',
                'password' => Hash::make('password123'),
                'role' => 'kecamatan',
                'kecamatan' => 'Mojosari',
            ]
        );
    }
}
