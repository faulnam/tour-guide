@extends('layouts.admin')

@section('title', 'Inbox Messages')
@section('page_title', 'Contact Inquiries & Messages')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-neutral-900 border border-neutral-800 p-4">
        <form action="{{ route('admin.messages.index') }}" method="GET" class="flex flex-wrap items-center gap-3 flex-1">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Search sender name, email, company, or text..." 
                   class="bg-neutral-950 border border-neutral-800 text-white text-xs px-3.5 py-2 w-full md:w-64 focus:outline-none focus:border-white transition-colors placeholder:text-neutral-500">

            <select name="filter" class="bg-neutral-950 border border-neutral-800 text-white text-xs px-3 py-2 focus:outline-none focus:border-white">
                <option value="">All Messages</option>
                <option value="unread" {{ request('filter') === 'unread' ? 'selected' : '' }}>Unread Only ({{ $unreadCount }})</option>
                <option value="read" {{ request('filter') === 'read' ? 'selected' : '' }}>Read Messages</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-neutral-800 text-white hover:bg-neutral-700 text-xs font-semibold uppercase tracking-wider">
                Filter
            </button>

            @if(request()->hasAny(['search', 'filter']))
                <a href="{{ route('admin.messages.index') }}" class="text-xs text-neutral-400 hover:text-white underline">Reset</a>
            @endif
        </form>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-neutral-300">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider text-[10px] border-b border-neutral-800">
                    <tr>
                        <th class="py-3.5 px-4 w-8"></th>
                        <th class="py-3.5 px-4">Sender</th>
                        <th class="py-3.5 px-4">Email &bull; Phone</th>
                        <th class="py-3.5 px-4">Message Snippet</th>
                        <th class="py-3.5 px-4">Received</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-neutral-800/50 transition-colors {{ !$msg->is_read ? 'bg-neutral-800/30 font-semibold' : '' }}">
                            <td class="py-3 px-4">
                                @if(!$msg->is_read)
                                    <span class="w-2 h-2 rounded-full bg-accent inline-block" title="Unread"></span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-white">
                                <a href="{{ route('admin.messages.show', $msg) }}" class="hover:underline">
                                    {{ $msg->name }}
                                </a>
                                @if($msg->company)
                                    <div class="text-[10px] text-neutral-400 font-normal">{{ $msg->company }}</div>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-neutral-400 font-mono text-[11px]">
                                <div><a href="mailto:{{ $msg->email }}" class="hover:text-white">{{ $msg->email }}</a></div>
                                @if($msg->phone)
                                    <div class="text-[10px] text-neutral-500">{{ $msg->phone }}</div>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-neutral-300 max-w-sm truncate">
                                <a href="{{ route('admin.messages.show', $msg) }}" class="hover:text-white">
                                    {{ $msg->message }}
                                </a>
                            </td>

                            <td class="py-3 px-4 text-neutral-400 text-[11px] whitespace-nowrap">
                                {{ $msg->created_at->diffForHumans() }}
                            </td>

                            <td class="py-3 px-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.messages.show', $msg) }}" class="text-neutral-300 hover:text-white font-semibold underline text-[11px]">Read</a>
                                
                                <form action="{{ route('admin.messages.destroy', $msg) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this message permanently?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-neutral-500 text-xs">
                                No contact messages found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-4 border-t border-neutral-800">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
