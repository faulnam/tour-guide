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
        | Kredensial akun asli TIDAK DITAMPILKAN di login helper.
        |--------------------------------------------------------------------------
        */

        // Super Admin Asli
        User::updateOrCreate(
            ['email' => 'admin@tourguide.id'],
            [
                'name' => 'Nusantara Master Admin',
                'phone' => '081288889999',
                'password' => Hash::make('qwertyu123'),
                'role' => 'admin',
                'specialty' => 'Tour Operations Director & Chief Expeditioner',
                'avatar' => null,
                'address' => 'Jl. Danau Tamblingan No. 88, Sanur, Denpasar, Bali 80228',
                'is_active' => true,
            ]
        );

        // Karyawan / Tour Guide 1 Asli - Pemandu Budaya & Wisata Bahari Bali & Nusa Penida
        User::updateOrCreate(
            ['email' => 'guide@tourguide.id'],
            [
                'name' => 'I Wayan Arta (Lead Bali Guide)',
                'phone' => '081234567890',
                'password' => Hash::make('qwertyu123'),
                'role' => 'karyawan',
                'specialty' => 'HPI Certified - Bali Heritage, Spiritual & Nusa Penida',
                'avatar' => null,
                'address' => 'Ubud, Gianyar, Bali',
                'is_active' => true,
            ]
        );

        // Karyawan / Tour Guide 2 Asli - Spesialis Gunung & Petualangan Bromo-Ijen
        User::updateOrCreate(
            ['email' => 'putra@tourguide.id'],
            [
                'name' => 'Bagas Pratama (Mountain Trekker)',
                'phone' => '081399887766',
                'password' => Hash::make('qwertyu123'),
                'role' => 'karyawan',
                'specialty' => 'Certified Mountaineer - Bromo Sunrise & Ijen Blue Fire',
                'avatar' => null,
                'address' => 'Malang, Jawa Timur',
                'is_active' => true,
            ]
        );

        // Karyawan / Tour Guide 3 Asli - Spesialis Marine & Liveaboard Komodo & Raja Ampat
        User::updateOrCreate(
            ['email' => 'laode@tourguide.id'],
            [
                'name' => 'La Ode Rizal (Marine & Island Guide)',
                'phone' => '081277665544',
                'password' => Hash::make('qwertyu123'),
                'role' => 'karyawan',
                'specialty' => 'PADI Divemaster & Komodo National Park Naturalist Guide',
                'avatar' => null,
                'address' => 'Labuan Bajo, Nusa Tenggara Timur',
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
        | Akun ini ditampilkan di halaman login portal helper.
        | Setiap perubahan data oleh akun demo akan otomatis dibersihkan dalam 25 menit.
        |--------------------------------------------------------------------------
        */

        // Demo Admin (CMS Portal Admin)
        User::updateOrCreate(
            ['email' => 'demoadmin@tourguide.id'],
            [
                'name' => 'Demo Tour Administrator',
                'phone' => '081299778899',
                'password' => Hash::make('demoadmin123'),
                'role' => 'admin',
                'specialty' => 'Nusantara Tour Operations Supervisor (Demo)',
                'avatar' => null,
                'address' => 'Kawasan Pariwisata Nusa Dua, Bali',
                'is_active' => true,
            ]
        );

        // Demo Karyawan / Tour Guide (Karyawan Portal)
        User::updateOrCreate(
            ['email' => 'demoguide@tourguide.id'],
            [
                'name' => 'Demo Tour Guide (HPI Certified)',
                'phone' => '081299445566',
                'password' => Hash::make('demoguide123'),
                'role' => 'karyawan',
                'specialty' => 'Licensed Indonesian Local Guide & Naturalist (Demo)',
                'avatar' => null,
                'address' => 'Jl. Sunset Road No. 10, Kuta, Bali',
                'is_active' => true,
            ]
        );

        // Demo Customer (Customer Portal)
        User::updateOrCreate(
            ['email' => 'democustomer@tourguide.id'],
            [
                'name' => 'Demo Traveler (Wisatawan)',
                'phone' => '081299112233',
                'password' => Hash::make('democustomer123'),
                'role' => 'customer',
                'specialty' => null,
                'avatar' => null,
                'address' => 'Kebayoran Baru, Jakarta Selatan',
                'is_active' => true,
            ]
        );
    }
}
