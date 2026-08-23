@extends('layouts.admin')

@section('title', 'Blog Categories')
@section('page_title', 'Blog Categories')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between bg-neutral-900 border border-neutral-800 p-4">
        <div>
            <h2 class="text-xs uppercase tracking-widest font-bold text-white">Article Categories</h2>
            <p class="text-[11px] text-neutral-400">Manage categories used to group perspectives, case studies, and insights.</p>
        </div>
        <a href="{{ route('admin.blog-categories.create') }}" class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-bold uppercase tracking-wider transition-colors">
            + New Category
        </a>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-neutral-300">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider text-[10px] border-b border-neutral-800">
                    <tr>
                        <th class="py-3.5 px-4">Category Name</th>
                        <th class="py-3.5 px-4">Slug (URL Key)</th>
                        <th class="py-3.5 px-4 text-center">Published Articles</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-neutral-800/50 transition-colors">
                            <td class="py-3 px-4 font-semibold text-white">
                                {{ $cat->title }}
                            </td>

                            <td class="py-3 px-4 text-neutral-400 font-mono text-[11px]">
                                {{ $cat->slug }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                <span class="bg-neutral-800 text-neutral-300 text-[10px] px-2 py-0.5 font-bold">{{ $cat->posts_count }}</span>
                            </td>

                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.blog-categories.edit', $cat) }}" class="text-neutral-300 hover:text-white font-semibold underline text-[11px]">Edit</a>
                                
                                <form action="{{ route('admin.blog-categories.destroy', $cat) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this blog category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-neutral-500 text-xs">
                                No blog categories registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
