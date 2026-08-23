<?php

namespace Database\Seeders;

use App\Models\Award;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Client;
use App\Models\HeroSlide;
use App\Models\JobVacancy;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hero Slides
        $heroSlides = [
            [
                'page' => 'home',
                'title' => 'Burger & Lobster - Plaza Indonesia',
                'subtitle' => 'Restaurant & Bar Interior Architecture',
                'button_text' => 'View Project',
                'button_link' => '/portfolio/burger-lobster-plaza-indonesia',
                'image' => 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?q=80&w=1920&auto=format&fit=crop',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'title' => 'Lumière Penthouse Residence',
                'subtitle' => 'Show Unit and Residence',
                'button_text' => 'View Project',
                'button_link' => '/portfolio/lumiere-penthouse-residence',
                'image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?q=80&w=1920&auto=format&fit=crop',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'page' => 'home',
                'title' => 'The Grand Ballroom & Atrium',
                'subtitle' => 'Hospitality & Public Space',
                'button_text' => 'View Project',
                'button_link' => '/portfolio/the-grand-ballroom-atrium',
                'image' => 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=1920&auto=format&fit=crop',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($heroSlides as $slide) {
            HeroSlide::updateOrCreate(
                ['title' => $slide['title'], 'page' => $slide['page']],
                $slide
            );
        }

        // 2. Clients (Top Retail, Commercial & Hospitality Brands)
        $clients = [
            ['name' => 'Plaza Indonesia', 'logo' => null, 'website_url' => 'https://plazaindonesia.com', 'order' => 1],
            ['name' => 'Boga Group', 'logo' => null, 'website_url' => 'https://bogagroup.com', 'order' => 2],
            ['name' => 'Ismaya Group', 'logo' => null, 'website_url' => 'https://ismaya.com', 'order' => 3],
            ['name' => 'Pakuwon Jati', 'logo' => null, 'website_url' => 'https://pakuwonjati.com', 'order' => 4],
            ['name' => 'Grand Hyatt', 'logo' => null, 'website_url' => 'https://hyatt.com', 'order' => 5],
            ['name' => 'Sinar Mas Land', 'logo' => null, 'website_url' => 'https://sinarmasland.com', 'order' => 6],
            ['name' => 'Ciputra Development', 'logo' => null, 'website_url' => 'https://ciputra.com', 'order' => 7],
            ['name' => 'Senayan City', 'logo' => null, 'website_url' => 'https://senayancity.com', 'order' => 8],
        ];

        foreach ($clients as $c) {
            Client::updateOrCreate(['name' => $c['name']], $c);
        }

        // 3. Projects
        $restaurantService = Service::where('slug', 'restaurant-bar')->first() ?? Service::first();
        $workSpaceService = Service::where('slug', 'work-space')->first() ?? Service::first();
        $publicSpaceService = Service::where('slug', 'public-space')->first() ?? Service::first();
        $residenceService = Service::where('slug', 'show-unit-and-residence')->first() ?? Service::first();
        $hospitalityService = Service::where('slug', 'hospitality')->first() ?? Service::first();
        $retailService = Service::where('slug', 'commercial-retail')->first() ?? Service::first();

        $projects = [
            [
                'service_id' => $restaurantService->id,
                'title' => 'Burger & Lobster - Plaza Indonesia',
                'slug' => 'burger-lobster-plaza-indonesia',
                'client' => 'Plaza Indonesia Management',
                'location' => 'Jakarta, Indonesia',
                'size' => '758 m²',
                'year' => '2024',
                'description' => '<p>Burger & Lobster at Plaza Indonesia introduces an opulent yet contemporary dining atmosphere combining industrial brass tones with dark polished timber and sumptuous bespoke banquette seating.</p><p>The lighting scheme is orchestrated to deliver theatrical warmth across dining clusters while accentuating the central cocktail bar.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?q=80&w=1000&auto=format&fit=crop',
                'is_featured' => true,
                'is_recent' => true,
                'order' => 1,
                'status' => 'published',
            ],
            [
                'service_id' => $restaurantService->id,
                'title' => 'Sora Japanese Dining & Sake Lounge',
                'slug' => 'sora-japanese-dining-sake-lounge',
                'client' => 'Boga Group',
                'location' => 'PIK, Jakarta',
                'size' => '420 m²',
                'year' => '2024',
                'description' => '<p>An ethereal Japanese dining experience embracing wabi-sabi aesthetics, minimalist fluted timber partitions, and ambient diffused illumination.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1000&auto=format&fit=crop',
                'is_featured' => false,
                'is_recent' => true,
                'order' => 2,
                'status' => 'published',
            ],
            [
                'service_id' => $restaurantService->id,
                'title' => 'The Heritage Teahouse',
                'slug' => 'the-heritage-teahouse',
                'client' => 'Heritage Hospitality Co.',
                'location' => 'Surabaya, Indonesia',
                'size' => '510 m²',
                'year' => '2023',
                'description' => '<p>A serene fusion of colonial architectural elements with contemporary Asian minimalism and hand-carved stone accents.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1552566626-52f8b828add9?q=80&w=1000&auto=format&fit=crop',
                'is_featured' => false,
                'is_recent' => true,
                'order' => 3,
                'status' => 'published',
            ],
            [
                'service_id' => $workSpaceService->id,
                'title' => 'Apex Fintech Innovation Hub',
                'slug' => 'apex-fintech-innovation-hub',
                'client' => 'Apex Financial Group',
                'location' => 'SCBD, Jakarta',
                'size' => '1,450 m²',
                'year' => '2024',
                'description' => '<p>A cutting-edge corporate headquarters designed to foster hybrid collaboration, agile workstations, and executive board sanctuaries.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1000&auto=format&fit=crop',
                'is_featured' => true,
                'is_recent' => true,
                'order' => 4,
                'status' => 'published',
            ],
            [
                'service_id' => $workSpaceService->id,
                'title' => 'Nexus Creative Studio HQ',
                'slug' => 'nexus-creative-studio-hq',
                'client' => 'Nexus Media',
                'location' => 'South Jakarta',
                'size' => '820 m²',
                'year' => '2023',
                'description' => '<p>An open mezzanine studio incorporating acoustic felt paneling, exposed industrial beams, and flexible modular break-out pods.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1497215728101-856f4ea42174?q=80&w=1000&auto=format&fit=crop',
                'is_featured' => false,
                'is_recent' => true,
                'order' => 5,
                'status' => 'published',
            ],
            [
                'service_id' => $publicSpaceService->id,
                'title' => 'Grand Central Galleria Atrium',
                'slug' => 'grand-central-galleria-atrium',
                'client' => 'Pakuwon Group',
                'location' => 'Surabaya, Indonesia',
                'size' => '2,800 m²',
                'year' => '2024',
                'description' => '<p>A multi-tiered retail atrium centered around soaring sculptural parametric columns and illuminated living skylights.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1541888946425-d0fbb18086f6?q=80&w=1000&auto=format&fit=crop',
                'is_featured' => false,
                'is_recent' => true,
                'order' => 6,
                'status' => 'published',
            ],
            [
                'service_id' => $residenceService->id,
                'title' => 'Lumière Penthouse Residence',
                'slug' => 'lumiere-penthouse-residence',
                'client' => 'Private Client',
                'location' => 'Menteng, Jakarta',
                'size' => '650 m²',
                'year' => '2024',
                'description' => '<p>A prestigious multi-level penthouse offering panoramic skyline vistas, custom Italian marble flooring, and concealed smart automation.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?q=80&w=1000&auto=format&fit=crop',
                'is_featured' => true,
                'is_recent' => true,
                'order' => 7,
                'status' => 'published',
            ],
            [
                'service_id' => $residenceService->id,
                'title' => 'The Opus Luxury Show Villa',
                'slug' => 'the-opus-luxury-show-villa',
                'client' => 'Sinar Mas Land',
                'location' => 'BSD City, Tangerang',
                'size' => '480 m²',
                'year' => '2023',
                'description' => '<p>Modern tropical luxury show unit combining floor-to-ceiling glass pavilions with warm travertine stonework and lush indoor courtyards.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=1000&auto=format&fit=crop',
                'is_featured' => false,
                'is_recent' => true,
                'order' => 8,
                'status' => 'published',
            ],
            [
                'service_id' => $retailService->id,
                'title' => 'Maison Joaillerie Flagship Boutique',
                'slug' => 'maison-joaillerie-flagship-boutique',
                'client' => 'Maison Group',
                'location' => 'Senayan City, Jakarta',
                'size' => '320 m²',
                'year' => '2024',
                'description' => '<p>High-jewelry boutique interior featuring velvet vitrines, champagne bronze fixtures, and private VIP consultation salons.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1000&auto=format&fit=crop',
                'is_featured' => false,
                'is_recent' => true,
                'order' => 9,
                'status' => 'published',
            ],
        ];

        foreach ($projects as $pData) {
            $proj = Project::updateOrCreate(['slug' => $pData['slug']], $pData);

            // Add gallery images
            if ($proj->images()->count() === 0) {
                ProjectImage::create([
                    'project_id' => $proj->id,
                    'image_path' => $pData['cover_image'],
                    'order' => 1,
                ]);
                ProjectImage::create([
                    'project_id' => $proj->id,
                    'image_path' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?q=80&w=1000&auto=format&fit=crop',
                    'order' => 2,
                ]);
                ProjectImage::create([
                    'project_id' => $proj->id,
                    'image_path' => 'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?q=80&w=1000&auto=format&fit=crop',
                    'order' => 3,
                ]);
            }
        }

        // 4. Blog Categories & Posts
        $catDesign = BlogCategory::updateOrCreate(['slug' => 'design-perspective'], ['title' => 'Design Perspective']);
        $catAwards = BlogCategory::updateOrCreate(['slug' => 'awards-recognition'], ['title' => 'Awards & Recognition']);
        $catCaseStudies = BlogCategory::updateOrCreate(['slug' => 'case-studies'], ['title' => 'Case Studies']);

        $blogPosts = [
            [
                'blog_category_id' => $catDesign->id,
                'title' => 'Metrix Interior at IIDA 2025: A Celebration of Design, Culture, and Craft',
                'slug' => 'metrix-interior-at-iida-2025-a-celebration-of-design-culture-and-craft',
                'excerpt' => 'This year Metrix Interior joins IIDA (European Customer Choice) to present our latest spatial reflections on culture and lifestyle.',
                'content' => '<p>This year Metrix Interior joins IIDA (European Customer Choice) to present our latest spatial reflections on culture and lifestyle. Through three curated works showcased globally, Metrix demonstrates a body of work that bridges culture, lifestyle, and innovation.</p><p>We believe interior architecture is more than just aesthetics—it is the living stage where human narratives unfold every day.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Metrix Editorial',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'blog_category_id' => $catAwards->id,
                'title' => 'Metrix at IDA Awards 2024',
                'slug' => 'metrix-at-ida-awards-2024',
                'excerpt' => 'We are thrilled to share that Metrix Interior has once again proven its design excellence by winning prestigious awards.',
                'content' => '<p>We are thrilled to share that Metrix Interior has once again proven its design excellence by receiving accolades at the IDA Design Awards 2024. This win reinforces our reputation as a leader in innovative and inspiring interior design benchmarks in Asia.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Metrix Editorial',
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'blog_category_id' => $catCaseStudies->id,
                'title' => 'Designing for Global Taste: Metrix Interior’s Work for Jolly Bar Gurn Malaysia',
                'slug' => 'designing-for-global-taste-metrix-interiors-work-for-jolly-bar-gurn-malaysia',
                'excerpt' => 'Bringing its design expertise beyond Indonesia, Metrix Interior has crafted an iconic cross-border hospitality sanctuary.',
                'content' => '<p>Bringing its design expertise beyond Indonesia, Metrix Interior has crafted an iconic cross-border hospitality destination. Metrix’s palatial design sensibility combining heritage influence with modern panache in craft dining spaces has won international acclaim.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1000&auto=format&fit=crop',
                'author' => 'Metrix Editorial',
                'is_published' => true,
                'published_at' => now()->subDays(30),
            ],
        ];

        foreach ($blogPosts as $post) {
            BlogPost::updateOrCreate(['slug' => $post['slug']], $post);
        }

        // 5. Awards
        $awards = [
            [
                'title' => 'International Design Awards (IDA) 2024 - Gold Winner',
                'slug' => 'ida-2024-gold-winner',
                'image' => 'https://images.unsplash.com/photo-1579783902614-a3fb3927b675?q=80&w=800&auto=format&fit=crop',
                'description' => 'Honored with Gold in Commercial Interior Hospitality Category for Burger & Lobster Plaza Indonesia.',
                'external_link' => 'https://idesignawards.com',
                'published_date' => '2024-05-10',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Asia Pacific Property Awards 2023-2024 - Best Retail Interior',
                'slug' => 'asia-pacific-property-awards-best-retail-interior',
                'image' => 'https://images.unsplash.com/photo-1534447677768-be436bb09401?q=80&w=800&auto=format&fit=crop',
                'description' => 'Awarded 5-Star Winner for outstanding retail interior architecture and customer journey design.',
                'external_link' => 'https://propertyawards.net',
                'published_date' => '2023-11-20',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'INDE.Awards 2023 - Shortlisted The Social Space',
                'slug' => 'inde-awards-2023-shortlisted-social-space',
                'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=800&auto=format&fit=crop',
                'description' => 'Shortlisted among the region’s top commercial interior design studios for civic and hospitality spaces.',
                'external_link' => 'https://indeawards.com',
                'published_date' => '2023-08-15',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($awards as $aw) {
            Award::updateOrCreate(['slug' => $aw['slug']], $aw);
        }

        // 6. Job Vacancies
        $jobs = [
            [
                'title' => 'Senior Interior Designer (Commercial & Hospitality)',
                'slug' => 'senior-interior-designer',
                'responsibilities' => "Lead spatial concept design and interior schematics for luxury commercial & hospitality projects.\nCoordinate design presentations, mood boards, material selection, and 3D modeling pipelines.\nCollaborate closely with clients, MEP engineers, contractors, and junior design staff.",
                'requirements' => "Bachelor's degree in Interior Architecture / Interior Design from reputable university.\nMinimum 5+ years of relevant project experience in high-end hospitality or commercial spaces.\nProficiency in AutoCAD, SketchUp, Enscape/3dsMax, and Adobe Creative Suite.\nStrong presentation and leadership skills in English and Bahasa Indonesia.",
                'email_subject' => 'Application for Senior Interior Designer - [Your Name]',
                'posted_at' => now()->subDays(10),
                'is_active' => true,
            ],
            [
                'title' => '3D Architectural Visualizer',
                'slug' => '3d-architectural-visualizer',
                'responsibilities' => "Produce high-fidelity photorealistic 3D interior renderings, lighting studies, and architectural visualizations.\nModel bespoke furniture, custom joinery details, and complex parametric surfaces.\nWork alongside design leads to translate sketches and AutoCAD plans into realistic CG visuals.",
                'requirements' => "Strong portfolio showcasing high-end realistic interior rendering and lighting expertise.\nProficiency in 3ds Max + Corona / V-Ray, Corona Renderer, Photoshop, and SketchUp.\nDeep understanding of realistic material shaders, texture mapping, and atmospheric lighting.",
                'email_subject' => 'Application for 3D Architectural Visualizer - [Your Name]',
                'posted_at' => now()->subDays(14),
                'is_active' => true,
            ],
        ];

        foreach ($jobs as $j) {
            JobVacancy::updateOrCreate(['slug' => $j['slug']], $j);
        }

        // 7. Testimonials
        $testimonials = [
            [
                'client_name' => 'Michael Pratama',
                'client_company' => 'Managing Director, Boga Group',
                'message' => 'Metrix transformed our restaurant concept into an iconic architectural landmark in Jakarta. Their spatial intuition, material mastery, and attention to acoustic detail are second to none in Asia.',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'client_name' => 'Elena Wijaya',
                'client_company' => 'VP Property Development, Pakuwon Jati',
                'message' => 'Working with Metrix Interior Architecture on our luxury penthouse collection exceeded every expectation. Their commitment to refined luxury and timeless design sets the gold standard.',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'client_name' => 'David Tan',
                'client_company' => 'Director of Operations, Ismaya Group',
                'message' => 'From initial 3D visualization to flawless fit-out execution, Metrix delivers world-class design integrity. Our guests are consistently awed by the atmosphere.',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=200&auto=format&fit=crop',
                'rating' => 5,
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['client_name' => $t['client_name']], $t);
        }
    }
}
