<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. AKUN ASLI (REAL ACCOUNTS)
        | Password untuk SEMUA akun asli: qwertyu123
        | Kredensial akun asli TIDAK DITAMPILKAN di halaman login portal.
        |--------------------------------------------------------------------------
        */

        // Super Admin Asli
        User::updateOrCreate(
            ['email' => 'admin@bengkel.com'],
            [
                'name' => 'BENGKEL Master Admin',
                'phone' => '081288889999',
                'password' => Hash::make('qwertyu123'),
                'role' => 'admin',
                'specialty' => 'Workshop Director & Lead Tuner',
                'avatar' => null,
                'address' => 'Jl. Otomotif Raya No. 88, Jakarta Selatan',
                'is_active' => true,
            ]
        );

        // Karyawan / Mekanik 1 Asli - Kepala Mekanik & Dyno Tuner
        User::updateOrCreate(
            ['email' => 'mekanik@bengkel.com'],
            [
                'name' => 'Budi Santoso (Lead Tuner)',
                'phone' => '081234567890',
                'password' => Hash::make('qwertyu123'),
                'role' => 'karyawan',
                'specialty' => 'Dyno Jet Tuning & ECU Remapping',
                'avatar' => null,
                'address' => 'Jakarta Selatan',
                'is_active' => true,
            ]
        );

        // Karyawan / Mekanik 2 Asli - Spesialis Motor Custom
        User::updateOrCreate(
            ['email' => 'indra@bengkel.com'],
            [
                'name' => 'Indra Wijaya (Bike Builder)',
                'phone' => '081399887766',
                'password' => Hash::make('qwertyu123'),
                'role' => 'karyawan',
                'specialty' => 'Custom Bike Fabrication & Cafe Racer Builder',
                'avatar' => null,
                'address' => 'Tangerang',
                'is_active' => true,
            ]
        );

        // Karyawan / Mekanik 3 Asli - Spesialis Bodykit & Cat Oven
        User::updateOrCreate(
            ['email' => 'reza@bengkel.com'],
            [
                'name' => 'Reza Pratama (Paint Master)',
                'phone' => '081277665544',
                'password' => Hash::make('qwertyu123'),
                'role' => 'karyawan',
                'specialty' => 'Custom Bodywork, Carbon Fiber & Oven Painting',
                'avatar' => null,
                'address' => 'Depok',
                'is_active' => true,
            ]
        );

        // Customer 1 Asli
        User::updateOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Rian Aditya',
                'phone' => '081122334455',
                'password' => Hash::make('qwertyu123'),
                'role' => 'customer',
                'specialty' => null,
                'avatar' => null,
                'address' => 'Pondok Indah, Jakarta Selatan',
                'is_active' => true,
            ]
        );

        // Customer 2 Asli
        User::updateOrCreate(
            ['email' => 'bambang@gmail.com'],
            [
                'name' => 'Bambang Sudiro',
                'phone' => '081333445566',
                'password' => Hash::make('qwertyu123'),
                'role' => 'customer',
                'specialty' => null,
                'avatar' => null,
                'address' => 'Kelapa Gading, Jakarta Utara',
                'is_active' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 2. AKUN DEMO (DEMO ACCOUNTS)
        | Akun ini ditampilkan di halaman login portal.
        | Setiap perubahan data oleh akun demo akan otomatis dibersihkan / di-revert dalam 25 menit.
        |--------------------------------------------------------------------------
        */

        // Demo Admin (CMS Portal Admin)
        User::updateOrCreate(
            ['email' => 'demoadmin@bengkel.com'],
            [
                'name' => 'Demo Administrator',
                'phone' => '081299778899',
                'password' => Hash::make('demoadmin123'),
                'role' => 'admin',
                'specialty' => 'Workshop Management Supervisor (Demo)',
                'avatar' => null,
                'address' => 'Jl. Otomotif Raya Demo No. 88, Jakarta Selatan',
                'is_active' => true,
            ]
        );

        // Demo Karyawan / Mekanik (Karyawan Portal)
        User::updateOrCreate(
            ['email' => 'demomekanik@bengkel.com'],
            [
                'name' => 'Demo Mekanik (Dyno Tuner)',
                'phone' => '081299445566',
                'password' => Hash::make('demomekanik123'),
                'role' => 'karyawan',
                'specialty' => 'Dyno Jet Tuning & ECU Specialist (Demo)',
                'avatar' => null,
                'address' => 'Jl. Workshop Demo No. 2, Jakarta Selatan',
                'is_active' => true,
            ]
        );

        // Demo Customer (Customer Portal)
        User::updateOrCreate(
            ['email' => 'democustomer@bengkel.com'],
            [
                'name' => 'Demo Customer',
                'phone' => '081299112233',
                'password' => Hash::make('democustomer123'),
                'role' => 'customer',
                'specialty' => null,
                'avatar' => null,
                'address' => 'Jl. Demo Customer No. 1, Jakarta Selatan',
                'is_active' => true,
            ]
        );
    }
}
