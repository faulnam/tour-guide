@extends('layouts.admin')

@section('title', 'Edit Blog Category: ' . $blogCategory->title)
@section('page_title', 'Edit Blog Category')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    
    <div>
        <a href="{{ route('admin.blog-categories.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Categories</span>
        </a>
    </div>

    <form action="{{ route('admin.blog-categories.update', $blogCategory) }}" method="POST" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Category Title <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="{{ old('title', $blogCategory->title) }}" 
                   required 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

        <div>
            <label for="slug" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Slug (URL Key)
            </label>
            <input type="text" 
                   id="slug" 
                   name="slug" 
                   value="{{ old('slug', $blogCategory->slug) }}" 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.blog-categories.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Update Category &rarr;
            </button>
        </div>

    </form>
</div>
@endsection
