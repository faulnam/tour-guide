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
        // 1. Super Admin
        User::updateOrCreate(
            ['email' => 'admin@bengkel.com'],
            [
                'name' => 'Apex Master Admin',
                'phone' => '081288889999',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'specialty' => 'Workshop Director & Lead Tuner',
                'avatar' => null,
                'address' => 'Jl. Otomotif Raya No. 88, Jakarta Selatan',
                'is_active' => true,
            ]
        );

        // 2. Karyawan / Mekanik 1 - Kepala Mekanik & Dyno Tuner
        User::updateOrCreate(
            ['email' => 'mekanik@bengkel.com'],
            [
                'name' => 'Budi Santoso (Lead Tuner)',
                'phone' => '081234567890',
                'password' => Hash::make('mekanik123'),
                'role' => 'karyawan',
                'specialty' => 'Dyno Jet Tuning & ECU Remapping',
                'avatar' => null,
                'address' => 'Jakarta Selatan',
                'is_active' => true,
            ]
        );

        // 3. Karyawan / Mekanik 2 - Spesialis Motor Custom
        User::updateOrCreate(
            ['email' => 'indra@bengkel.com'],
            [
                'name' => 'Indra Wijaya (Bike Builder)',
                'phone' => '081399887766',
                'password' => Hash::make('karyawan123'),
                'role' => 'karyawan',
                'specialty' => 'Custom Bike Fabrication & Cafe Racer Builder',
                'avatar' => null,
                'address' => 'Tangerang',
                'is_active' => true,
            ]
        );

        // 4. Karyawan / Mekanik 3 - Spesialis Bodykit & Cat Oven
        User::updateOrCreate(
            ['email' => 'reza@bengkel.com'],
            [
                'name' => 'Reza Pratama (Paint Master)',
                'phone' => '081277665544',
                'password' => Hash::make('karyawan123'),
                'role' => 'karyawan',
                'specialty' => 'Custom Bodywork, Carbon Fiber & Oven Painting',
                'avatar' => null,
                'address' => 'Depok',
                'is_active' => true,
            ]
        );

        // 5. Customer 1
        User::updateOrCreate(
            ['email' => 'customer@gmail.com'],
            [
                'name' => 'Rian Aditya',
                'phone' => '081122334455',
                'password' => Hash::make('customer123'),
                'role' => 'customer',
                'specialty' => null,
                'avatar' => null,
                'address' => 'Pondok Indah, Jakarta Selatan',
                'is_active' => true,
            ]
        );

        // 6. Customer 2
        User::updateOrCreate(
            ['email' => 'bambang@gmail.com'],
            [
                'name' => 'Bambang Sudiro',
                'phone' => '081333445566',
                'password' => Hash::make('customer123'),
                'role' => 'customer',
                'specialty' => null,
                'avatar' => null,
                'address' => 'Kelapa Gading, Jakarta Utara',
                'is_active' => true,
            ]
        );
    }
}
