<div class="bg-primary text-white p-8 md:p-12 space-y-6 rounded-2xl shadow-elevated border border-sage/30">
    <div class="space-y-2">
        <div class="inline-flex items-center gap-2 text-accent text-xs font-bold uppercase tracking-wider">
            <i class="fa-regular fa-paper-plane"></i>
            <span>Newsletter Pariwisata</span>
        </div>
        <h3 class="text-xl md:text-2xl font-bold tracking-tight uppercase font-sans">Dapatkan Inspirasi Wisata &amp; Promo Trip</h3>
        <p class="text-gray-200 text-xs leading-relaxed">
            Dapatkan rekomendasi itinerary rahasia, info open trip Labuan Bajo &amp; Raja Ampat, serta tips mendaki gunung dari pemandu berlisensi resmi.
        </p>
    </div>

    <form action="{{ url('/newsletter/subscribe') }}" method="POST" class="space-y-4">
        @csrf
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="email" 
                   name="email" 
                   required 
                   placeholder="Masukkan alamat email Anda..." 
                   class="flex-1 bg-white/10 border border-white/20 text-white text-xs px-4 py-3.5 rounded-xl focus:outline-none focus:border-accent transition-colors placeholder:text-gray-400">
            <button type="submit" 
                    class="bg-accent text-primary-dark hover:bg-accent-dark hover:text-white text-xs uppercase tracking-wider px-8 py-3.5 rounded-xl font-bold transition-all shadow-md">
                Berlangganan
            </button>
        </div>
    </form>
</div>
