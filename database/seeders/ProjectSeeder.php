<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $remapService = Service::where('slug', 'ecu-remap-dyno-tuning')->first();
        $bikeService = Service::where('slug', 'custom-motorcycle-build')->first();
        $bodyService = Service::where('slug', 'widebody-custom-aerokit')->first();
        $paintService = Service::where('slug', 'custom-paint-oven-airbrush')->first();
        $airService = Service::where('slug', 'air-suspension-big-brake-kit')->first();

        // 1. Nissan GT-R R35 Liberty Walk
        Project::updateOrCreate(
            ['slug' => 'nissan-gtr-r35-liberty-walk-twin-turbo'],
            [
                'service_id' => $bodyService?->id,
                'title' => 'Nissan GT-R R35 "Godzilla" LBWK Widebody & Stage 3 Dyno',
                'vehicle_type' => 'mobil',
                'vehicle_model' => 'Nissan GT-R R35 V6 Twin-Turbo',
                'client' => 'Bpk. Steven Kurniawan',
                'location' => 'Jakarta Selatan',
                'year' => '2025',
                'description' => 'Transformasi total Nissan GT-R R35 dengan bodykit original Liberty Walk LB-Silhouette WORKS GT 35GT-RR, pengecatan Midnight Purple IV, dan upgrade mesin Stage 3 Garrett Twin-Turbo dengan hasil Dyno menembus 850 HP.',
                'cover_image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=1200&auto=format&fit=crop',
                'before_image' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=600&auto=format&fit=crop',
                'after_image' => 'https://images.unsplash.com/photo-1617814076367-b759c7d7e738?q=80&w=600&auto=format&fit=crop',
                'dyno_hp_before' => 565,
                'dyno_hp_after' => 852,
                'dyno_torque_before' => 633,
                'dyno_torque_after' => 980,
                'modification_specs' => [
                    'Engine' => 'Garrett GTX3076R Gen II Twin-Turbo, ID1700x Injectors, HKS Downpipe & Full Titanium Exhaust',
                    'ECU & Dyno' => 'Syvecs S8 Standalone ECU Tuned on Dyno Jet 224xLC',
                    'Exterior' => 'Full LBWK Dry Carbon Widebody Kit with Giant Swan-Neck GT Wing',
                    'Suspension & Wheels' => 'Air Lift Performance 3H Management + BBS LM-R 20x11 / 20x12.5 Forged',
                    'Brakes' => 'Brembo Carbon Ceramic 410mm 6-Pot Front, 380mm 4-Pot Rear',
                ],
                'is_featured' => true,
                'is_recent' => true,
                'order' => 1,
                'status' => 'published',
            ]
        );

        // 2. Honda CB750 Cafe Racer "The Phantom"
        Project::updateOrCreate(
            ['slug' => 'honda-cb750-cafe-racer-the-phantom'],
            [
                'service_id' => $bikeService?->id,
                'title' => 'Honda CB750 Four "The Phantom" Neo-Cafe Racer',
                'vehicle_type' => 'motor',
                'vehicle_model' => 'Honda CB750 Four SOHC 1978',
                'client' => 'Bpk. Dimas Prakoso',
                'location' => 'Bandung, Jawa Barat',
                'year' => '2025',
                'description' => 'Membangun ulang legenda motor 4-silinder 1978 menjadi Cafe Racer modern berbobot ringan. Rangka subframe kromoli kustom, tangki monocoque aluminium handmade, suspensi Upside-Down Ohlins, dan knalpot 4-into-1 titanium.',
                'cover_image' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=1200&auto=format&fit=crop',
                'before_image' => 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?q=80&w=600&auto=format&fit=crop',
                'after_image' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=600&auto=format&fit=crop',
                'dyno_hp_before' => 67,
                'dyno_hp_after' => 92,
                'dyno_torque_before' => 60,
                'dyno_torque_after' => 84,
                'modification_specs' => [
                    'Engine' => 'Bore-up 836cc Wiseco Piston Kit, Keihin CR Special 29mm Carbs, Porting Polishing 3-Angle Valve',
                    'Chassis' => 'Custom Chromoly Subframe, Aluminum Monocoque Tank & Tail Cowl',
                    'Suspension' => 'Ohlins FGRT USD Front Fork & Ohlins TTX36 Rear Monoshock',
                    'Exhaust' => 'Handmade 4-into-1 Titanium Pie-Cut Pieced Header & Megaphone Muffler',
                    'Electronics' => 'Motogadget M-Unit Blue with Keyless Bluetooth Ignition & M-Blaze Turn Signals',
                ],
                'is_featured' => true,
                'is_recent' => true,
                'order' => 2,
                'status' => 'published',
            ]
        );

        // 3. Honda Civic Type R FL5 Track Weapon
        Project::updateOrCreate(
            ['slug' => 'honda-civic-type-r-fl5-track-weapon'],
            [
                'service_id' => $remapService?->id,
                'title' => 'Honda Civic Type R FL5 "Track Monster" 450 HP',
                'vehicle_type' => 'mobil',
                'vehicle_model' => 'Honda Civic Type R FL5 2.0L VTEC Turbo',
                'client' => 'Bpk. Aditya Nugraha',
                'location' => 'Surabaya',
                'year' => '2025',
                'description' => 'Optimalisasi mesin K20C1 dengan Hondata FlashPro, MHI Stage 2 Turbocharger Upgrade, Eventuri Carbon Intake, dan Spoon Sports Aero Kit untuk performa lap time sirkuit Mandalika & Sentul.',
                'cover_image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=1200&auto=format&fit=crop',
                'before_image' => 'https://images.unsplash.com/photo-1541348263662-e0c8de4259ba?q=80&w=600&auto=format&fit=crop',
                'after_image' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=600&auto=format&fit=crop',
                'dyno_hp_before' => 315,
                'dyno_hp_after' => 456,
                'dyno_torque_before' => 420,
                'dyno_torque_after' => 590,
                'modification_specs' => [
                    'Engine' => 'MHI Stage 2 Billet Turbocharger, Eventuri Gloss Carbon Intake, CSF Racing Intercooler',
                    'ECU & Dyno' => 'Hondata FlashPro Custom Apex Dyno Map with Dual Fuel (Ron 98 & E30 Mix)',
                    'Suspension' => 'KW Suspension Clubsport 3-Way Adjustable Coilover',
                    'Wheels & Tyres' => 'Volk Racing TE37 Saga S-Plus 18x9.5 ET38 + Yokohama Advan A052',
                    'Aero' => 'Spoon Sports Carbon Front Lip & Voltex Type 7 Carbon Swan Neck Wing',
                ],
                'is_featured' => true,
                'is_recent' => true,
                'order' => 3,
                'status' => 'published',
            ]
        );

        // 4. Kawasaki Ninja ZX-25R 4-Cylinder Screamer
        Project::updateOrCreate(
            ['slug' => 'kawasaki-zx25r-4-cylinder-screamer-racing'],
            [
                'service_id' => $paintService?->id,
                'title' => 'Kawasaki Ninja ZX-25R "Screamer" Full Carbon & Akrapovic',
                'vehicle_type' => 'motor',
                'vehicle_model' => 'Kawasaki Ninja ZX-25R 250cc Inline-4',
                'client' => 'Bpk. Rendy Pratama',
                'location' => 'Jakarta Barat',
                'year' => '2026',
                'description' => 'Pengerjaan Full Dry Carbon Bodywork, Knalpot Full System Akrapovic Racing Titanium, ECU aRacer Super X, Quickshifter Auto-Blipper, dan dyno tuning mencapai 19.000 RPM dengan tenaga 55 WHP.',
                'cover_image' => 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?q=80&w=1200&auto=format&fit=crop',
                'before_image' => 'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?q=80&w=600&auto=format&fit=crop',
                'after_image' => 'https://images.unsplash.com/photo-1568772585407-9361f9bf3a87?q=80&w=600&auto=format&fit=crop',
                'dyno_hp_before' => 42,
                'dyno_hp_after' => 55,
                'dyno_torque_before' => 22,
                'dyno_torque_after' => 31,
                'modification_specs' => [
                    'Engine' => 'Porting CNC 4-Cylinder, Velocity Stack Billet, BMC Racing Air Filter',
                    'ECU' => 'aRacer Super X Standalone + AF2 Wideband Sensor Module',
                    'Exhaust' => 'Akrapovic Evolution Line Full Titanium with Carbon Muffler',
                    'Body' => 'Full Carbon Fiber Body Fairings with Candy Emerald Clear Coat',
                    'Brakes & Wheels' => 'Brembo GP4-RX Caliper + Galespeed Type-GP1S Forged Wheels',
                ],
                'is_featured' => false,
                'is_recent' => true,
                'order' => 4,
                'status' => 'published',
            ]
        );

        // 5. BMW M4 G82 Competition Stance & Air Suspension
        Project::updateOrCreate(
            ['slug' => 'bmw-m4-g82-competition-stance-air-suspension'],
            [
                'service_id' => $airService?->id,
                'title' => 'BMW M4 Competition G82 "Frozen Black" Air Suspension & Vorsteiner Aero',
                'vehicle_type' => 'mobil',
                'vehicle_model' => 'BMW M4 Competition G82 S58 Twin-Turbo',
                'client' => 'Bpk. Calvin Hartono',
                'location' => 'Jakarta Utara',
                'year' => '2026',
                'description' => 'BMW M4 G82 dengan instalasi Air Suspension 4-point AccuAir e-Level+, Velg Brixton Forged 20/21 inch, Vorsteiner Carbon Aero Program, dan cat Frozen Deep Black Satin Paint Finish.',
                'cover_image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1200&auto=format&fit=crop',
                'before_image' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=600&auto=format&fit=crop',
                'after_image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=600&auto=format&fit=crop',
                'dyno_hp_before' => 503,
                'dyno_hp_after' => 680,
                'dyno_torque_before' => 650,
                'dyno_torque_after' => 840,
                'modification_specs' => [
                    'Engine' => 'Bootmod3 Stage 2 Custom Flash, Eventuri S58 Carbon Intakes, Eisenmann Race Exhaust',
                    'Suspension' => 'AccuAir e-Level+ Ultimate Air Management with Enduro CVT Compressor',
                    'Wheels' => 'Brixton Forged CM5-R 3-Piece 20x10 Front / 21x11.5 Rear with Michelin PS4S',
                    'Aero' => 'Vorsteiner VRS Aero Carbon Front Grille, Front Spoiler, Rear Diffuser, Side Blades',
                    'Paint' => 'BMW Individual Frozen Deep Black Paint Coating with Ceramic 9H Protection',
                ],
                'is_featured' => false,
                'is_recent' => true,
                'order' => 5,
                'status' => 'published',
            ]
        );
    }
}
