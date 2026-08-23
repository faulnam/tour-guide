<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a single project portfolio detail page.
     */
    public function show(string $slug): View
    {
        $project = Project::where('slug', $slug)
            ->published()
            ->with(['service.parent', 'images'])
            ->firstOrFail();

        // Previous and Next Projects for navigation
        $prevProject = Project::published()
            ->where('id', '<', $project->id)
            ->orderBy('id', 'desc')
            ->first() ?? Project::published()->orderBy('id', 'desc')->first();

        $nextProject = Project::published()
            ->where('id', '>', $project->id)
            ->orderBy('id', 'asc')
            ->first() ?? Project::published()->orderBy('id', 'asc')->first();

        // Selected Awards for sidebar
        $awards = Award::active()
            ->ordered()
            ->take(3)
            ->get();

        // Related projects from same service or other projects
        $relatedProjects = Project::published()
            ->where('id', '!=', $project->id)
            ->where(function ($query) use ($project) {
                if ($project->service_id) {
                    $query->where('service_id', $project->service_id);
                }
            })
            ->take(3)
            ->get();

        if ($relatedProjects->count() < 3) {
            $relatedProjects = Project::published()
                ->where('id', '!=', $project->id)
                ->take(3)
                ->get();
        }

        return view('portfolio.show', compact(
            'project',
            'prevProject',
            'nextProject',
            'awards',
            'relatedProjects'
        ));
    }

    /**
     * Display projects filtered by category slug (/portfolio-cat/{slug}).
     */
    public function byCategory(string $slug): View
    {
        $service = Service::where('slug', $slug)
            ->active()
            ->with('children')
            ->firstOrFail();

        // If parent category, include child IDs as well
        $serviceIds = $service->children->pluck('id')->push($service->id);

        $projects = Project::published()
            ->whereIn('service_id', $serviceIds)
            ->with('service')
            ->ordered()
            ->paginate(9);

        $allCategories = Service::active()
            ->ordered()
            ->get();

        return view('portfolio.category', compact('service', 'projects', 'allCategories'));
    }
}
