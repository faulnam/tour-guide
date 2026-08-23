@extends('layouts.admin')

@section('title', 'Edit Job Vacancy: ' . $jobVacancy->title)
@section('page_title', 'Edit Job Vacancy')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.job-vacancies.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Careers</span>
        </a>
    </div>

    <form action="{{ route('admin.job-vacancies.update', $jobVacancy) }}" method="POST" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Position Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $jobVacancy->title) }}" 
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
                       value="{{ old('slug', $jobVacancy->slug) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>
        </div>

        <div>
            <label for="email_subject" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Application Email Subject Line
            </label>
            <input type="text" 
                   id="email_subject" 
                   name="email_subject" 
                   value="{{ old('email_subject', $jobVacancy->email_subject) }}" 
                   class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
        </div>

        <div>
            <label for="responsibilities" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Key Responsibilities (Write each item on a new line or HTML)
            </label>
            <textarea id="responsibilities" 
                      name="responsibilities" 
                      rows="5" 
                      class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors font-mono">{{ old('responsibilities', $jobVacancy->responsibilities) }}</textarea>
        </div>

        <div>
            <label for="requirements" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Requirements &amp; Qualifications (Write each item on a new line or HTML)
            </label>
            <textarea id="requirements" 
                      name="requirements" 
                      rows="5" 
                      class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors font-mono">{{ old('requirements', $jobVacancy->requirements) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
            <div>
                <label for="posted_at" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Date Posted
                </label>
                <input type="date" 
                       id="posted_at" 
                       name="posted_at" 
                       value="{{ old('posted_at', $jobVacancy->posted_at ? $jobVacancy->posted_at->format('Y-m-d') : '') }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Status
                </label>
                <label class="flex items-center gap-2 pt-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $jobVacancy->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded-none accent-black bg-neutral-950 border-neutral-800">
                    <span class="text-xs text-white">Active (Accepting applications)</span>
                </label>
            </div>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.job-vacancies.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Update Position &rarr;
            </button>
        </div>

    </form>
</div>
@endsection
