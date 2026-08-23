<?php

namespace App\Http\Controllers;

use App\Models\Award;
use Illuminate\View\View;

class AwardController extends Controller
{
    /**
     * Display awards and publications list with pagination.
     */
    public function index(): View
    {
        $awards = Award::active()
            ->ordered()
            ->paginate(6);

        return view('awards.index', compact('awards'));
    }

    /**
     * Display single award / publication detail.
     */
    public function show(string $slug): View
    {
        $award = Award::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $prevAward = Award::active()
            ->where('id', '<', $award->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextAward = Award::active()
            ->where('id', '>', $award->id)
            ->orderBy('id', 'asc')
            ->first();

        $otherAwards = Award::active()
            ->where('id', '!=', $award->id)
            ->ordered()
            ->take(3)
            ->get();

        return view('awards.show', compact('award', 'prevAward', 'nextAward', 'otherAwards'));
    }
}
