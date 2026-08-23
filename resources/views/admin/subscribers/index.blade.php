@extends('layouts.admin')

@section('title', 'Newsletter Subscribers')
@section('page_title', 'Newsletter Subscribers')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-neutral-900 border border-neutral-800 p-4">
        <form action="{{ route('admin.subscribers.index') }}" method="GET" class="flex items-center gap-3 flex-1">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Search subscriber email..." 
                   class="bg-neutral-950 border border-neutral-800 text-white text-xs px-3.5 py-2 w-full md:w-64 focus:outline-none focus:border-white transition-colors placeholder:text-neutral-500">
            <button type="submit" class="px-4 py-2 bg-neutral-800 text-white hover:bg-neutral-700 text-xs font-semibold uppercase tracking-wider">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.subscribers.index') }}" class="text-xs text-neutral-400 hover:text-white underline">Reset</a>
            @endif
        </form>

        <div>
            <a href="{{ route('admin.subscribers.export') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-bold uppercase tracking-wider transition-colors">
                <span>&darr; Export CSV</span>
            </a>
        </div>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-neutral-300">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider text-[10px] border-b border-neutral-800">
                    <tr>
                        <th class="py-3.5 px-4"># ID</th>
                        <th class="py-3.5 px-4">Subscriber Email</th>
                        <th class="py-3.5 px-4">Subscribed At</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($subscribers as $sub)
                        <tr class="hover:bg-neutral-800/50 transition-colors">
                            <td class="py-3 px-4 text-neutral-500 font-mono text-[11px]">
                                #{{ $sub->id }}
                            </td>

                            <td class="py-3 px-4 font-semibold text-white font-mono">
                                {{ $sub->email }}
                            </td>

                            <td class="py-3 px-4 text-neutral-400">
                                {{ $sub->subscribed_at ? $sub->subscribed_at->format('M d, Y H:i') : $sub->created_at->format('M d, Y H:i') }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($sub->is_active)
                                    <span class="inline-block bg-emerald-950 text-emerald-400 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider border border-emerald-800">Active</span>
                                @else
                                    <span class="inline-block bg-neutral-800 text-neutral-500 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">Unsubscribed</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-right">
                                <form action="{{ route('admin.subscribers.destroy', $sub) }}" method="POST" class="inline-block" onsubmit="return confirm('Remove this subscriber?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-neutral-500 text-xs">
                                No newsletter subscribers yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscribers->hasPages())
            <div class="p-4 border-t border-neutral-800">
                {{ $subscribers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
