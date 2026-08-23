<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Client;
use App\Models\HeroSlide;
use App\Models\Project;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the Home page.
     */
    public function index(): View
    {
        // 1. Hero Slides
        $heroSlides = HeroSlide::forPage('home')->get();

        // 2. Featured Projects (fallback if no hero slides)
        $featuredProjects = Project::published()
            ->featured()
            ->with('service')
            ->orderBy('order')
            ->take(5)
            ->get();

        // 3. Recent Projects (9 cards in 3x3 grid)
        $recentProjects = Project::published()
            ->recent()
            ->with('service')
            ->orderBy('order')
            ->take(9)
            ->get();

        // If not enough marked recent, fill with published projects
        if ($recentProjects->count() < 9) {
            $recentProjects = Project::published()
                ->with('service')
                ->orderBy('order')
                ->take(9)
                ->get();
        }

        // 4. Latest Insights / Blog Posts (3 cards)
        $latestPosts = BlogPost::published()
            ->with('category')
            ->take(3)
            ->get();

        // 5. Clients list
        $clients = Client::active()
            ->ordered()
            ->get();

        // 6. Testimonials
        $testimonials = Testimonial::active()
            ->ordered()
            ->get();

        return view('home.index', compact(
            'heroSlides',
            'featuredProjects',
            'recentProjects',
            'latestPosts',
            'clients',
            'testimonials'
        ));
    }
}
