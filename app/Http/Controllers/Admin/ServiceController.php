<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Display a listing of services in hierarchical structure.
     */
    public function index(): View
    {
        $services = Service::parents()
            ->with(['children' => function ($q) {
                $q->withCount('projects')->ordered();
            }])
            ->withCount('projects')
            ->ordered()
            ->get();

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(): View
    {
        $parentServices = Service::parents()->ordered()->get();

        return view('admin.services.create', compact('parentServices'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(ServiceRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $slug = $data['slug'] ? Str::slug($data['slug']) : Str::slug($data['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (Service::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['order'] = $request->input('order', 0) ?? 0;

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service category created successfully!');
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service): View
    {
        $parentServices = Service::parents()->where('id', '!=', $service->id)->ordered()->get();

        return view('admin.services.edit', compact('service', 'parentServices'));
    }

    /**
     * Update the specified service in storage.
     */
    public function update(ServiceRequest $request, Service $service): RedirectResponse
    {
        $data = $request->validated();

        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('image')) {
            if ($service->image && !str_starts_with($service->image, 'http') && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['order'] = $request->input('order', 0) ?? 0;

        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'Service category updated successfully!');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        if ($service->image && !str_starts_with($service->image, 'http') && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service category deleted successfully!');
    }
}
