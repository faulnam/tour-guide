<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate dynamic XML sitemap for search engines.
     */
    public function index(): Response
    {
        $services = Service::active()->with('children')->get();
        $projects = Project::published()->latest('updated_at')->get();
        $posts = BlogPost::published()->latest('updated_at')->get();
        $awards = Award::active()->latest('updated_at')->get();

        $content = view('sitemap.index', compact('services', 'projects', 'posts', 'awards'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
