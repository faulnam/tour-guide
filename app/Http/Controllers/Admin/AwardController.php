<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AwardRequest;
use App\Models\Award;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AwardController extends Controller
{
    public function index(Request $request): View
    {
        $query = Award::query();

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $awards = $query->orderBy('order')->latest('published_date')->paginate(10)->withQueryString();

        return view('admin.awards.index', compact('awards'));
    }

    public function create(): View
    {
        return view('admin.awards.create');
    }

    public function store(AwardRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $slug = !empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (Award::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('awards', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['order'] = $request->input('order', 0) ?? 0;

        Award::create($data);

        return redirect()->route('admin.awards.index')->with('success', 'Award added successfully!');
    }

    public function edit(Award $award): View
    {
        return view('admin.awards.edit', compact('award'));
    }

    public function update(AwardRequest $request, Award $award): RedirectResponse
    {
        $data = $request->validated();

        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        } else {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('image')) {
            if ($award->image && !str_starts_with($award->image, 'http') && Storage::disk('public')->exists($award->image)) {
                Storage::disk('public')->delete($award->image);
            }
            $data['image'] = $request->file('image')->store('awards', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['order'] = $request->input('order', 0) ?? 0;

        $award->update($data);

        return redirect()->route('admin.awards.index')->with('success', 'Award updated successfully!');
    }

    public function destroy(Award $award): RedirectResponse
    {
        if ($award->image && !str_starts_with($award->image, 'http') && Storage::disk('public')->exists($award->image)) {
            Storage::disk('public')->delete($award->image);
        }

        $award->delete();

        return redirect()->route('admin.awards.index')->with('success', 'Award removed successfully!');
    }
}
