<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Client;
use App\Models\HeroSlide;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the Home page for Apex Garage.
     */
    public function index(): View
    {
        // 1. Hero Slides
        $heroSlides = HeroSlide::where('page', 'home')->where('is_active', true)->orderBy('order')->get();

        // 2. Featured Tuning Projects
        $featuredProjects = Project::published()
            ->featured()
            ->with('service')
            ->orderBy('order')
            ->take(5)
            ->get();

        // 3. Recent Modification Projects (Motor & Mobil)
        $recentProjects = Project::published()
            ->with('service')
            ->orderBy('order')
            ->take(6)
            ->get();

        // 4. Popular Tuning & Service Packages
        $popularServices = Service::active()
            ->orderBy('order')
            ->take(6)
            ->get();

        // 5. Certified Mechanics / Builders Team
        $mechanics = User::where('role', 'karyawan')
            ->where('is_active', true)
            ->take(4)
            ->get();

        // 6. Latest Insights / Blog Posts
        $latestPosts = BlogPost::published()
            ->with('category')
            ->take(3)
            ->get();
        $recentPosts = $latestPosts;

        // 7. Performance Brand Partners
        $clients = Client::active()
            ->ordered()
            ->get();

        // 8. Testimonials
        $testimonials = Testimonial::active()
            ->ordered()
            ->get();

        return view('home.index', compact(
            'heroSlides',
            'featuredProjects',
            'recentProjects',
            'popularServices',
            'mechanics',
            'latestPosts',
            'recentPosts',
            'clients',
            'testimonials'
        ));
    }
}
