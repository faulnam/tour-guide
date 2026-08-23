@extends('layouts.admin')

@section('title', 'Add Testimonial')
@section('page_title', 'Add Testimonial')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <div>
        <a href="{{ route('admin.testimonials.index') }}" class="text-xs text-neutral-400 hover:text-white uppercase tracking-wider flex items-center gap-1">
            <span>&larr; Back to Testimonials</span>
        </a>
    </div>

    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="bg-neutral-900 border border-neutral-800 p-6 md:p-8 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="client_name" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Client Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="client_name" 
                       name="client_name" 
                       value="{{ old('client_name') }}" 
                       required 
                       placeholder="e.g. Michael Gunawan" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label for="client_company" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Position &amp; Company
                </label>
                <input type="text" 
                       id="client_company" 
                       name="client_company" 
                       value="{{ old('client_company') }}" 
                       placeholder="e.g. CEO, PT Hospitality Nusantara" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>
        </div>

        <div>
            <label for="message" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                Testimonial Quote / Review <span class="text-red-500">*</span>
            </label>
            <textarea id="message" 
                      name="message" 
                      rows="4" 
                      required 
                      placeholder="Write the client endorsement quote..." 
                      class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors leading-relaxed">{{ old('message') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="rating" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Star Rating (1 - 5)
                </label>
                <select id="rating" name="rating" class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white">
                    <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>5 Stars (★★★★★)</option>
                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 Stars (★★★★)</option>
                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 Stars (★★★)</option>
                </select>
            </div>

            <div>
                <label for="photo" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Client Photo / Avatar (Optional)
                </label>
                <input type="file" 
                       id="photo" 
                       name="photo" 
                       accept="image/*" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-neutral-300 text-xs px-4 py-3 focus:outline-none focus:border-white file:mr-4 file:py-2 file:px-4 file:border-0 file:text-xs file:font-semibold file:bg-neutral-800 file:text-white hover:file:bg-neutral-700">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
            <div>
                <label for="order" class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Sort Order
                </label>
                <input type="number" 
                       id="order" 
                       name="order" 
                       value="{{ old('order', 0) }}" 
                       class="w-full bg-neutral-950 border border-neutral-800 text-white text-xs px-4 py-3 focus:outline-none focus:border-white transition-colors">
            </div>

            <div>
                <label class="block text-[11px] uppercase tracking-wider font-semibold text-neutral-300 mb-2">
                    Status
                </label>
                <label class="flex items-center gap-2 pt-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="w-4 h-4 rounded-none accent-black bg-neutral-950 border-neutral-800">
                    <span class="text-xs text-white">Active</span>
                </label>
            </div>
        </div>

        <div class="pt-6 border-t border-neutral-800 flex items-center justify-end gap-4">
            <a href="{{ route('admin.testimonials.index') }}" class="px-6 py-3 border border-neutral-700 text-neutral-300 hover:text-white text-xs uppercase tracking-wider">
                Cancel
            </a>
            <button type="submit" class="px-8 py-3 bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 font-bold transition-colors">
                Save Testimonial &rarr;
            </button>
        </div>

    </form>
</div>
@endsection
