<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display blog articles index with optional category filtering.
     */
    public function index(Request $request): View
    {
        $query = BlogPost::published()->with('category');
        $currentCategory = null;

        if ($categorySlug = $request->get('category')) {
            $currentCategory = BlogCategory::where('slug', $categorySlug)->first();
            if ($currentCategory) {
                $query->where('blog_category_id', $currentCategory->id);
            }
        }

        $posts = $query->paginate(6)->withQueryString();

        $categories = BlogCategory::withCount(['posts' => function ($q) {
            $q->where('is_published', true);
        }])->get();

        return view('blog.index', compact('posts', 'categories', 'currentCategory'));
    }

    /**
     * Display a single blog article detail page.
     */
    public function show(string $slug): View
    {
        $post = BlogPost::where('slug', $slug)
            ->published()
            ->with('category')
            ->firstOrFail();

        // Prev and Next Articles
        $prevPost = BlogPost::published()
            ->where('published_at', '<', $post->published_at ?? $post->created_at)
            ->latest('published_at')
            ->first();

        $nextPost = BlogPost::published()
            ->where('published_at', '>', $post->published_at ?? $post->created_at)
            ->oldest('published_at')
            ->first();

        // Recent posts for sidebar
        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        $categories = BlogCategory::withCount(['posts' => function ($q) {
            $q->where('is_published', true);
        }])->get();

        return view('blog.show', compact('post', 'prevPost', 'nextPost', 'recentPosts', 'categories'));
    }
}
