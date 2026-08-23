<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroSlideRequest;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(Request $request): View
    {
        $query = HeroSlide::query();

        if ($page = $request->get('page_filter')) {
            $query->where('page', $page);
        }

        $slides = $query->orderBy('page')->orderBy('order')->paginate(10)->withQueryString();

        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create(): View
    {
        return view('admin.hero-slides.create');
    }

    public function store(HeroSlideRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hero', 'public');
        } else {
            $data['image'] = '';
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['order'] = $request->input('order', 0) ?? 0;

        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide added successfully!');
    }

    public function edit(HeroSlide $heroSlide): View
    {
        return view('admin.hero-slides.edit', compact('heroSlide'));
    }

    public function update(HeroSlideRequest $request, HeroSlide $heroSlide): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($heroSlide->image && !str_starts_with($heroSlide->image, 'http') && Storage::disk('public')->exists($heroSlide->image)) {
                Storage::disk('public')->delete($heroSlide->image);
            }
            $data['image'] = $request->file('image')->store('hero', 'public');
        }

        $data['is_active'] = $request->boolean('is_active', true);
        $data['order'] = $request->input('order', 0) ?? 0;

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide updated successfully!');
    }

    public function destroy(HeroSlide $heroSlide): RedirectResponse
    {
        if ($heroSlide->image && !str_starts_with($heroSlide->image, 'http') && Storage::disk('public')->exists($heroSlide->image)) {
            Storage::disk('public')->delete($heroSlide->image);
        }

        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide deleted successfully!');
    }
}
