<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobVacancyRequest;
use App\Models\JobVacancy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JobVacancyController extends Controller
{
    public function index(Request $request): View
    {
        $query = JobVacancy::query();

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $vacancies = $query->latest('posted_at')->paginate(10)->withQueryString();

        return view('admin.job-vacancies.index', compact('vacancies'));
    }

    public function create(): View
    {
        return view('admin.job-vacancies.create');
    }

    public function store(JobVacancyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $slug = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (JobVacancy::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }
        $data['slug'] = $slug;
        $data['is_active'] = $request->boolean('is_active', true);
        $data['posted_at'] = $data['posted_at'] ?? now();

        JobVacancy::create($data);

        return redirect()->route('admin.job-vacancies.index')->with('success', 'Job vacancy posted successfully!');
    }

    public function edit(JobVacancy $jobVacancy): View
    {
        return view('admin.job-vacancies.edit', compact('jobVacancy'));
    }

    public function update(JobVacancyRequest $request, JobVacancy $jobVacancy): RedirectResponse
    {
        $data = $request->validated();

        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            $data['slug'] = Str::slug($data['title']);
        }

        $data['is_active'] = $request->boolean('is_active', true);

        $jobVacancy->update($data);

        return redirect()->route('admin.job-vacancies.index')->with('success', 'Job vacancy updated successfully!');
    }

    public function destroy(JobVacancy $jobVacancy): RedirectResponse
    {
        $jobVacancy->delete();

        return redirect()->route('admin.job-vacancies.index')->with('success', 'Job vacancy deleted successfully!');
    }
}
