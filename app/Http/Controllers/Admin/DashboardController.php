<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\BlogPost;
use App\Models\Client;
use App\Models\ContactMessage;
use App\Models\JobVacancy;
use App\Models\NewsletterSubscriber;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard with summary counters and recent items.
     */
    public function index(): View
    {
        $stats = [
            'projects' => Project::count(),
            'services' => Service::count(),
            'clients' => Client::count(),
            'awards' => Award::count(),
            'posts' => BlogPost::count(),
            'vacancies' => JobVacancy::count(),
            'unread_messages' => ContactMessage::unread()->count(),
            'subscribers' => NewsletterSubscriber::count(),
        ];

        $recentProjects = Project::with('service')->latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();
        $recentSubscribers = NewsletterSubscriber::latest('subscribed_at')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProjects', 'recentMessages', 'recentSubscribers'));
    }
}
