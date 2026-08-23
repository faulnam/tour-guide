<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Parent: Interior Design
        $interiorDesign = Service::updateOrCreate(
            ['slug' => 'interior-design'],
            [
                'parent_id' => null,
                'title' => 'Interior Design',
                'excerpt' => 'Full-scope interior design solutions tailored for commercial, hospitality, and residential environments.',
                'description' => 'We create bespoke interior design environments that blend functional efficiency with striking aesthetic character.',
                'icon' => 'cube-transparent',
                'order' => 1,
                'is_active' => true,
            ]
        );

        // Sub-services under Interior Design
        $subServices = [
            [
                'title' => 'Work Space',
                'slug' => 'work-space',
                'excerpt' => 'Modern office and corporate workspace interiors engineered for productivity and brand identity.',
                'description' => 'From collaborative open areas to executive boardrooms, we create workspace environments that empower teams and inspire innovation.',
                'order' => 1,
            ],
            [
                'title' => 'Public Space',
                'slug' => 'public-space',
                'excerpt' => 'Captivating public and community gathering spaces crafted for seamless circulation and social interaction.',
                'description' => 'Dynamic public architectural spaces designed to accommodate human scale, accessibility, and monumental character.',
                'order' => 2,
            ],
            [
                'title' => 'Hospitality',
                'slug' => 'hospitality',
                'excerpt' => 'Boutique hotel, resort, and guest experience interiors blending comfort, luxury, and warmth.',
                'description' => 'Immersive hospitality destinations that elevate guest satisfaction through thoughtful ambiance and timeless craft.',
                'order' => 3,
            ],
            [
                'title' => 'Show Unit and Residence',
                'slug' => 'show-unit-and-residence',
                'excerpt' => 'Luxury residential interiors and property show units that showcase premium lifestyle aspiration.',
                'description' => 'Private homes and property marketing show units meticulously crafted down to every bespoke detail and finish.',
                'order' => 4,
            ],
            [
                'title' => 'Commercial & Retail',
                'slug' => 'commercial-retail',
                'excerpt' => 'Engaging retail flagship stores and commercial brand environments engineered to drive footfall.',
                'description' => 'Retail spatial design that reinforces brand equity and creates unforgettable sensory consumer journeys.',
                'order' => 5,
            ],
            [
                'title' => 'Restaurant & Bar',
                'slug' => 'restaurant-bar',
                'excerpt' => 'Iconic dining, cafe, lounge, and bar interiors setting atmosphere and culinary theater.',
                'description' => 'F&B concept spaces engineered with strategic lighting, acoustic balance, and striking signature elements.',
                'order' => 6,
            ],
        ];

        foreach ($subServices as $sub) {
            Service::updateOrCreate(
                ['slug' => $sub['slug']],
                [
                    'parent_id' => $interiorDesign->id,
                    'title' => $sub['title'],
                    'excerpt' => $sub['excerpt'],
                    'description' => $sub['description'],
                    'order' => $sub['order'],
                    'is_active' => true,
                ]
            );
        }

        // 2. Parent: Interior Styling
        Service::updateOrCreate(
            ['slug' => 'interior-styling'],
            [
                'parent_id' => null,
                'title' => 'Interior Styling',
                'excerpt' => 'Curated curation of decorative accessories, art pieces, lighting, and custom textures.',
                'description' => 'Our interior styling team curates objects, artwork, soft furnishings, and botanical accents to give spaces their defining personality.',
                'icon' => 'sparkles',
                'order' => 2,
                'is_active' => true,
            ]
        );

        // 3. Parent: 3D Visualization
        Service::updateOrCreate(
            ['slug' => '3d-visualization'],
            [
                'parent_id' => null,
                'title' => '3D Visualization',
                'excerpt' => 'Photorealistic architectural rendering and spatial digital twins for pre-construction visualization.',
                'description' => 'High-end photorealistic 3D visualization, cinematic lighting simulations, and material studies that bring blueprints to life.',
                'icon' => 'eye',
                'order' => 3,
                'is_active' => true,
            ]
        );
    }
}
