@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('page_title', 'Dashboard Overview')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header -->
    <div class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Welcome back, {{ auth()->user()->name }}!
            </h2>
            <p class="text-xs text-neutral-400 mt-1">
                Here is a summary of your website contents, portfolio submissions, and customer inquiries.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.projects.create') }}" class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-[11px] uppercase tracking-wider font-semibold transition-colors">
                + New Project
            </a>
            <a href="{{ route('admin.settings.edit') }}" class="px-4 py-2.5 border border-neutral-700 text-neutral-300 hover:text-white hover:border-neutral-500 text-[11px] uppercase tracking-wider transition-colors">
                Edit Settings
            </a>
        </div>
    </div>

    <!-- 8 Analytical Counter Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
        
        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Projects</div>
            <div class="text-3xl font-bold text-white">{{ $stats['projects'] }}</div>
            <a href="{{ route('admin.projects.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Manage Projects &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Services</div>
            <div class="text-3xl font-bold text-white">{{ $stats['services'] }}</div>
            <a href="{{ route('admin.services.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Manage Hierarchy &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Clients</div>
            <div class="text-3xl font-bold text-white">{{ $stats['clients'] }}</div>
            <a href="{{ route('admin.clients.index') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Manage Logos &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Awards</div>
            <div class="text-3xl font-bold text-white">{{ $stats['awards'] }}</div>
            <a href="{{ url('/admin/awards') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">View Awards &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Blog Posts</div>
            <div class="text-3xl font-bold text-white">{{ $stats['posts'] }}</div>
            <a href="{{ url('/admin/blog-posts') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Manage Articles &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Job Vacancies</div>
            <div class="text-3xl font-bold text-white">{{ $stats['vacancies'] }}</div>
            <a href="{{ url('/admin/job-vacancies') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Manage Careers &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Unread Messages</div>
            <div class="text-3xl font-bold {{ $stats['unread_messages'] > 0 ? 'text-accent' : 'text-white' }}">
                {{ $stats['unread_messages'] }}
            </div>
            <a href="{{ url('/admin/messages') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">Open Inbox &rarr;</a>
        </div>

        <div class="bg-neutral-900 border border-neutral-800 p-5 space-y-2">
            <div class="text-xs uppercase tracking-widest text-neutral-500 font-semibold">Subscribers</div>
            <div class="text-3xl font-bold text-white">{{ $stats['subscribers'] }}</div>
            <a href="{{ url('/admin/subscribers') }}" class="text-[10px] text-accent hover:underline uppercase tracking-wider inline-block">View Subscribers &rarr;</a>
        </div>

    </div>

    <!-- Recent Data Tables (2 Columns) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Projects -->
        <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white">Recent Projects</h3>
                <a href="{{ route('admin.projects.index') }}" class="text-[10px] text-neutral-400 hover:text-white uppercase tracking-wider">View All</a>
            </div>

            <div class="space-y-3">
                @forelse($recentProjects as $p)
                    <div class="flex items-center justify-between p-3 bg-neutral-950/60 border border-neutral-800/80 text-xs">
                        <div class="flex items-center gap-3 truncate">
                            <div class="w-10 h-10 bg-neutral-800 overflow-hidden shrink-0">
                                @if($p->cover_image)
                                    <img src="{{ str_starts_with($p->cover_image, 'http') ? $p->cover_image : asset('storage/' . $p->cover_image) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="truncate">
                                <div class="font-semibold text-white truncate">{{ $p->title }}</div>
                                <div class="text-[10px] text-neutral-400">{{ $p->service ? $p->service->title : 'Uncategorized' }}</div>
                            </div>
                        </div>
                        <a href="{{ route('admin.projects.edit', $p) }}" class="text-neutral-400 hover:text-white text-[11px] font-semibold pl-3">Edit &rarr;</a>
                    </div>
                @empty
                    <div class="text-center py-6 text-neutral-500 text-xs">No projects available.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Contact Inquiries -->
        <div class="bg-neutral-900 border border-neutral-800 p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-neutral-800 pb-3">
                <h3 class="text-xs uppercase tracking-widest font-bold text-white">Recent Contact Inquiries</h3>
                <a href="{{ url('/admin/messages') }}" class="text-[10px] text-neutral-400 hover:text-white uppercase tracking-wider">View Inbox</a>
            </div>

            <div class="space-y-3">
                @forelse($recentMessages as $msg)
                    <div class="p-3 bg-neutral-950/60 border border-neutral-800/80 text-xs space-y-1">
                        <div class="flex items-center justify-between">
                            <div class="font-semibold text-white">{{ $msg->name }}</div>
                            <div class="text-[10px] text-neutral-500">{{ $msg->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="text-[11px] text-neutral-400 truncate">{{ $msg->email }} {{ $msg->company ? '&bull; ' . $msg->company : '' }}</div>
                        <p class="text-[11px] text-neutral-300 line-clamp-1 italic">{{ $msg->message }}</p>
                    </div>
                @empty
                    <div class="text-center py-6 text-neutral-500 text-xs">No contact inquiries yet.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
