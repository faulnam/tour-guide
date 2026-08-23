<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display all services categories index.
     */
    public function index(): View
    {
        $services = Service::parents()
            ->active()
            ->ordered()
            ->with(['children' => function ($q) {
                $q->active()->ordered();
            }])
            ->get();

        $featuredProjects = Project::published()
            ->featured()
            ->with('service')
            ->take(6)
            ->get();

        return view('services.index', compact('services', 'featuredProjects'));
    }

    /**
     * Display a parent service category and its sub-services + projects.
     */
    public function show(string $parentSlug): View
    {
        $service = Service::parents()
            ->where('slug', $parentSlug)
            ->active()
            ->with(['children' => function ($q) {
                $q->active()->ordered();
            }])
            ->firstOrFail();

        // Get IDs of this parent service and all its children
        $serviceIds = $service->children->pluck('id')->push($service->id);

        $projects = Project::published()
            ->whereIn('service_id', $serviceIds)
            ->with('service')
            ->ordered()
            ->paginate(9);

        return view('services.show', compact('service', 'projects'));
    }

    /**
     * Display a specific sub-service category with filtered projects.
     */
    public function showChild(string $parentSlug, string $childSlug): View
    {
        $parent = Service::parents()
            ->where('slug', $parentSlug)
            ->active()
            ->firstOrFail();

        $child = Service::where('parent_id', $parent->id)
            ->where('slug', $childSlug)
            ->active()
            ->firstOrFail();

        $projects = Project::published()
            ->where('service_id', $child->id)
            ->with('service')
            ->ordered()
            ->paginate(9);

        // Get sibling sub-services for easy tab navigation
        $siblings = Service::where('parent_id', $parent->id)
            ->active()
            ->ordered()
            ->get();

        return view('services.child', compact('parent', 'child', 'projects', 'siblings'));
    }
}
