@extends('layouts.admin')

@section('title', 'Manage Job Vacancies')
@section('page_title', 'Careers & Job Vacancies')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-neutral-900 border border-neutral-800 p-4">
        <form action="{{ route('admin.job-vacancies.index') }}" method="GET" class="flex items-center gap-3 flex-1">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Search job position title..." 
                   class="bg-neutral-950 border border-neutral-800 text-white text-xs px-3.5 py-2 w-full md:w-64 focus:outline-none focus:border-white transition-colors placeholder:text-neutral-500">
            <button type="submit" class="px-4 py-2 bg-neutral-800 text-white hover:bg-neutral-700 text-xs font-semibold uppercase tracking-wider">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.job-vacancies.index') }}" class="text-xs text-neutral-400 hover:text-white underline">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.job-vacancies.create') }}" class="px-4 py-2.5 bg-white text-black hover:bg-neutral-200 text-xs font-bold uppercase tracking-wider transition-colors inline-block text-center">
            + Post New Vacancy
        </a>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-neutral-300">
                <thead class="bg-neutral-950 text-neutral-400 uppercase tracking-wider text-[10px] border-b border-neutral-800">
                    <tr>
                        <th class="py-3.5 px-4">Position Title</th>
                        <th class="py-3.5 px-4">Email Subject</th>
                        <th class="py-3.5 px-4">Posted Date</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @forelse($vacancies as $job)
                        <tr class="hover:bg-neutral-800/50 transition-colors">
                            <td class="py-3 px-4 font-semibold text-white">
                                {{ $job->title }}
                            </td>

                            <td class="py-3 px-4 text-neutral-400 font-mono text-[11px]">
                                {{ $job->email_subject ?: 'Application for ' . $job->title }}
                            </td>

                            <td class="py-3 px-4 text-neutral-400">
                                {{ $job->posted_at ? $job->posted_at->format('M d, Y') : '—' }}
                            </td>

                            <td class="py-3 px-4 text-center">
                                @if($job->is_active)
                                    <span class="inline-block bg-emerald-950 text-emerald-400 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider border border-emerald-800">Open</span>
                                @else
                                    <span class="inline-block bg-neutral-800 text-neutral-500 text-[9px] font-bold px-2 py-0.5 uppercase tracking-wider">Closed</span>
                                @endif
                            </td>

                            <td class="py-3 px-4 text-right space-x-2">
                                <a href="{{ route('admin.job-vacancies.edit', $job) }}" class="text-neutral-300 hover:text-white font-semibold underline text-[11px]">Edit</a>
                                
                                <form action="{{ route('admin.job-vacancies.destroy', $job) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this vacancy?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-[11px] underline ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-neutral-500 text-xs">
                                No job vacancies found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($vacancies->hasPages())
            <div class="p-4 border-t border-neutral-800">
                {{ $vacancies->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
