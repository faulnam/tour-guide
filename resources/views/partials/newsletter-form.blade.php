<div class="bg-neutral-900 text-white p-8 md:p-12 space-y-6">
    <div class="space-y-2">
        <div class="eyebrow-light">Stay Informed</div>
        <h3 class="text-xl md:text-2xl font-bold tracking-tight uppercase font-sans">Subscribe to Our Newsletter</h3>
        <p class="text-neutral-400 text-xs leading-relaxed">
            Dapatkan wawasan teknis seputar modifikasi mobil &amp; motor, dyno tuning, dan update jadwal workshop BENGKEL.
        </p>
    </div>

    <form action="{{ url('/newsletter/subscribe') }}" method="POST" class="space-y-4">
        @csrf
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="email" 
                   name="email" 
                   required 
                   placeholder="Masukkan alamat email Anda" 
                   class="flex-1 bg-black border border-neutral-800 text-white text-xs px-4 py-3.5 focus:outline-none focus:border-white transition-colors placeholder:text-neutral-600">
            <button type="submit" 
                    class="bg-white text-black hover:bg-neutral-200 text-xs uppercase tracking-widest2 px-8 py-3.5 font-semibold transition-colors">
                Subscribe
            </button>
        </div>
    </form>
</div>
