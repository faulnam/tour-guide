@extends('layouts.admin')

@section('title', 'Manage Services Hierarchy')
@section('page_title', 'Services (2-Level Hierarchy)')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex items-center justify-between bg-neutral-900 border border-neutral-800 p-4">
        <div>
            <h2 class="text-xs uppercase tracking-widest font-bold text-white">Hierarchical Category Structure</h2>
            <p class="text-[11px] text-neutral-400">Manage 2-level service categories for the navigation menu &amp; project tagging.</p>
        </div>
        <a href="{{ route('admin.services.create') }}" class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-bold uppercase tracking-wider transition-colors">
            + New Service
        </a>
    </div>

    <!-- Services Tree List -->
    <div class="bg-neutral-900 border border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-neutral-300">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider text-[10px] border-b border-neutral-800">
                    <tr>
                        <th class="py-3.5 px-4">Service Category Name</th>
                        <th class="py-3.5 px-4">Slug (URL)</th>
                        <th class="py-3.5 px-4 text-center">Order</th>
                        <th class="py-3.5 px-4 text-center">Projects</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($services as $parent)
                        <!-- Parent Row -->
                        <tr class="bg-neutral-950/40 hover:bg-neutral-800/40 transition-colors font-semibold">
                            <td class="py-3.5 px-4 text-white flex items-center gap-2">
                                <span class="w-2 h-2 bg-accent inline-block"></span>
                                <span class="text-sm font-bold">{{ $parent->title }}</span>
                                <span class="text-[9px] uppercase tracking-wider bg-neutral-800 text-neutral-400 px-1.5 py-0.5 rounded-none font-normal">Parent</span>
                            </td>
                            <td class="py-3.5 px-4 text-neutral-400 font-mono text-[11px]">
                                /services/{{ $parent->slug }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-normal">
                                {{ $parent->order }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-normal">
                                <span class="bg-neutral-800 text-neutral-300 text-[10px] px-2 py-0.5 font-bold">{{ $parent->projects_count }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($parent->is_active)
                                    <span class="inline-block bg-emerald-950 text-emerald-400 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider border border-emerald-800">Active</span>
                                @else
                                    <span class="inline-block bg-neutral-800 text-neutral-500 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">Inactive</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2 font-normal">
                                <a href="{{ url('/services/' . $parent->slug) }}" target="_blank" class="text-neutral-400 hover:text-white underline text-[11px]">View</a>
                                <a href="{{ route('admin.services.edit', $parent) }}" class="text-neutral-300 hover:text-white font-semibold underline text-[11px]">Edit</a>
                                
                                <form action="{{ route('admin.services.destroy', $parent) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this category and its subcategories?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Sub-Services (Children Rows) -->
                        @foreach($parent->children as $child)
                            <tr class="hover:bg-neutral-800/30 transition-colors">
                                <td class="py-3 px-4 pl-10 text-neutral-200 flex items-center gap-2">
                                    <span class="text-neutral-600 font-mono">└─</span>
                                    <span>{{ $child->title }}</span>
                                </td>
                                <td class="py-3 px-4 text-neutral-500 font-mono text-[11px]">
                                    /services/{{ $parent->slug }}/{{ $child->slug }}
                                </td>
                                <td class="py-3 px-4 text-center text-neutral-400">
                                    {{ $child->order }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="bg-neutral-800 text-neutral-400 text-[10px] px-2 py-0.5">{{ $child->projects_count }}</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($child->is_active)
                                        <span class="inline-block bg-emerald-950 text-emerald-400 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider border border-emerald-800">Active</span>
                                    @else
                                        <span class="inline-block bg-neutral-800 text-neutral-500 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right space-x-2">
                                    <a href="{{ url('/services/' . $parent->slug . '/' . $child->slug) }}" target="_blank" class="text-neutral-400 hover:text-white underline text-[11px]">View</a>
                                    <a href="{{ route('admin.services.edit', $child) }}" class="text-neutral-300 hover:text-white font-semibold underline text-[11px]">Edit</a>
                                    
                                    <form action="{{ route('admin.services.destroy', $child) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this sub-service?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline ml-2">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-neutral-500 text-xs">
                                No service categories registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
