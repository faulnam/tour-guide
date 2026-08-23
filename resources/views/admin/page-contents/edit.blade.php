@extends('layouts.admin')

@section('title', 'Page Copywriting Editor')
@section('page_title', 'Page Content & Copywriting')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <div class="bg-neutral-900 border border-neutral-800 p-4">
        <h2 class="text-xs uppercase tracking-widest font-bold text-white">Dynamic Copywriting Editor</h2>
        <p class="text-[11px] text-neutral-400">All headline texts, paragraphs, mission statements, and quotes are dynamically editable here with zero hardcoded values.</p>
    </div>

    <form action="{{ route('admin.page-contents.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        @foreach($contents as $page => $items)
            <div class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6">
                
                <div class="border-b border-neutral-800 pb-3 flex items-center justify-between">
                    <h3 class="text-xs uppercase tracking-widest2 font-bold text-accent">
                        Page: {{ strtoupper($page) }}
                    </h3>
                    <span class="text-[10px] uppercase tracking-wider text-neutral-500 font-mono">{{ $items->count() }} text blocks</span>
                </div>

                <div class="space-y-6">
                    @foreach($items as $item)
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="content_{{ $item->key }}" class="text-[11px] uppercase tracking-wider font-semibold text-neutral-300">
                                    {{ $item->label ?: ucwords(str_replace('_', ' ', $item->section)) }}
                                </label>
                                <span class="font-mono text-neutral-500 text-[10px]">{{ $item->key }}</span>
                            </div>

                            @if(str_contains($item->key, '_p') || str_contains($item->key, 'description') || str_contains($item->key, 'quote') || strlen($item->value ?? '') > 120)
                                <textarea id="content_{{ $item->key }}" 
                                          name="contents[{{ $item->key }}]" 
                                          rows="3" 
                                          class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-2.5 focus:outline-none focus:border-white transition-colors leading-relaxed">{{ old("contents.{$item->key}", $item->value) }}</textarea>
                            @else
                                <input type="text" 
                                       id="content_{{ $item->key }}" 
                                       name="contents[{{ $item->key }}]" 
                                       value="{{ old("contents.{$item->key}", $item->value) }}" 
                                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
                            @endif
                        </div>
                    @endforeach
                </div>

            </div>
        @endforeach

        <div class="sticky bottom-6 z-20 flex justify-end">
            <button type="submit" class="px-8 py-3.5 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold shadow-2xl transition-colors">
                Save All Page Contents &rarr;
            </button>
        </div>

    </form>
</div>
@endsection
