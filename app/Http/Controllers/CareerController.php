<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\View\View;

class CareerController extends Controller
{
    /**
     * Display the Career page with dynamic job vacancies.
     */
    public function index(): View
    {
        $vacancies = JobVacancy::active()
            ->latest('posted_at')
            ->get();

        return view('career.index', compact('vacancies'));
    }
}
