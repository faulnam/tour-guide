@extends('layouts.admin')

@section('title', 'Manage Testimonials')
@section('page_title', 'Client Testimonials')

@section('content')
<div class="space-y-6">
    
    <div class="flex items-center justify-between bg-neutral-900 border border-neutral-800 p-4">
        <div>
            <h2 class="text-xs uppercase tracking-widest font-bold text-white">Client Quotes &amp; Reviews</h2>
            <p class="text-[11px] text-neutral-400">Manage client reviews and ratings displayed across the website.</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-bold uppercase tracking-wider transition-colors">
            + Add Testimonial
        </a>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-neutral-300">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider text-[10px] border-b border-neutral-800">
                    <tr>
                        <th class="py-3.5 px-4">Client</th>
                        <th class="py-3.5 px-4">Testimonial Quote</th>
                        <th class="py-3.5 px-4 text-center">Rating</th>
                        <th class="py-3.5 px-4 text-center">Order</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($testimonials as $t)
                        <tr class="hover:bg-neutral-800/50 transition-colors">
                            <td class="py-3 px-4 font-semibold text-white">
                                <div>{{ $t->client_name }}</div>
                                @if($t->client_company)
                                    <div class="text-[10px] text-neutral-400 font-normal">{{ $t->client_company }}</div>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-neutral-300 max-w-xs truncate italic">
                                "{{ $t->message }}"
                            </td>

                            <td class="py-3 px-4 text-center text-accent">
                                {{ str_repeat('★', $t->rating) }}
                            </td>

                            <td class="py-3 px-4 text-center text-neutral-400">
                                {{ $t->order }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($t->is_active)
                                    <span class="inline-block bg-emerald-950 text-emerald-400 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider border border-emerald-800">Active</span>
                                @else
                                    <span class="inline-block bg-neutral-800 text-neutral-500 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">Inactive</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.testimonials.edit', $t) }}" class="text-neutral-300 hover:text-white font-semibold underline text-[11px]">Edit</a>
                                
                                <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this testimonial?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-neutral-500 text-xs">
                                No testimonials registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($testimonials->hasPages())
            <div class="p-4 border-t border-neutral-800">
                {{ $testimonials->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
