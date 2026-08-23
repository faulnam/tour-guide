<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Client;
use App\Models\HeroSlide;
use App\Models\Project;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Display the About Us page.
     */
    public function index(): View
    {
        $heroSlides = HeroSlide::forPage('about')->get();

        $highlightProjects = Project::published()
            ->with('service')
            ->orderBy('order')
            ->take(4)
            ->get();

        $awards = Award::active()
            ->ordered()
            ->take(8)
            ->get();

        $clients = Client::active()
            ->ordered()
            ->get();

        return view('about.index', compact(
            'heroSlides',
            'highlightProjects',
            'awards',
            'clients'
        ));
    }
}
