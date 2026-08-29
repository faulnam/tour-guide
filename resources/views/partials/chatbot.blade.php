<!-- Nusantara Tour Guide AI Travel Consultant Floating Widget -->
<div x-data="tourGuideChatbot()" x-init="init()" class="fixed bottom-6 right-6 z-40">
    
    <!-- Minimalist Teaser Prompt (Auto appears when unopened) -->
    <div x-show="showTeaser && !isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-3"
         x-cloak
         class="absolute bottom-16 right-0 mb-2 w-72 bg-white text-[#1A2E26] rounded-2xl border border-gray-100 p-4 shadow-elevated text-xs space-y-2">
        <div class="flex items-start justify-between">
            <div class="flex items-center space-x-2">
                <span class="w-2 h-2 bg-emerald-500 rounded-full inline-block"></span>
                <span class="eyebrow text-[10px] text-primary font-bold">Nusantara AI Travel Guide</span>
            </div>
            <button @click="dismissTeaser()" class="text-gray-400 hover:text-gray-700 text-sm">&times;</button>
        </div>
        <p class="text-gray-600 text-[11px] leading-relaxed">
            Butuh rekomendasi itinerary wisata Indonesia, estimasi biaya tur, atau tips persiapan liburan?
        </p>
        <button @click="openChat()" class="text-[10px] uppercase tracking-wider font-bold text-accent-dark hover:text-primary flex items-center gap-1 pt-1">
            <span>Tanya Pemandu AI</span>
            <i class="fa-solid fa-arrow-right text-[9px]"></i>
        </button>
    </div>

    <!-- Floating Toggle Button -->
    <button @click="toggleChat()" 
            type="button"
            class="group w-12 h-12 bg-primary text-white hover:bg-secondary rounded-xl flex items-center justify-center shadow-elevated hover:shadow-glow transition-all duration-300 focus:outline-none"
            aria-label="Toggle AI Travel Consultation Chat">
        <div class="relative w-5 h-5 flex items-center justify-center">
            <!-- Chat Icon -->
            <i x-show="!isOpen" class="fa-solid fa-compass text-lg text-accent transition-transform group-hover:rotate-45"></i>
            <!-- Close (X) Icon -->
            <i x-show="isOpen" x-cloak class="fa-solid fa-xmark text-lg text-white transition-transform group-hover:rotate-90"></i>
        </div>
    </button>

    <!-- Main Chat Window Modal -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         x-cloak
         class="absolute bottom-16 right-0 mb-3 w-[92vw] sm:w-[410px] bg-white text-[#1A2E26] rounded-2xl border border-gray-100 shadow-2xl flex flex-col z-50 overflow-hidden font-sans"
         style="height: min(580px, calc(100vh - 120px)); max-height: calc(100vh - 120px);">
        
        <!-- Window Header -->
        <div class="px-5 py-4 border-b border-gray-100 bg-primary text-white flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-accent text-primary-dark flex items-center justify-center text-xs font-bold font-sans shadow-sm">
                    <i class="fa-solid fa-compass"></i>
                </div>
                <div>
                    <h3 class="text-xs uppercase tracking-wider font-bold text-white">Nusantara AI Travel Guide</h3>
                    <div class="flex items-center space-x-1.5 text-[10px] text-accent mt-0.5">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full inline-block"></span>
                        <span>Konsultan Wisata Seluruh Indonesia</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button @click="confirmClearChat()" 
                        type="button" 
                        class="p-1.5 text-gray-300 hover:text-white transition-colors text-xs" 
                        title="Hapus Percakapan">
                    <i class="fa-regular fa-trash-can"></i>
                </button>
                <button @click="isOpen = false" 
                        type="button" 
                        class="p-1.5 text-gray-300 hover:text-white transition-colors"
                        aria-label="Tutup Chat">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        </div>

        <!-- Chat Body Messages Scroll Area -->
        <div x-ref="chatContainer" class="flex-1 p-5 overflow-y-auto space-y-4 bg-[#F8FAF9] text-xs">
            
            <!-- Default Welcome Card -->
            <div class="p-4 bg-white rounded-xl border border-gray-100 shadow-soft space-y-2">
                <div class="eyebrow text-[9px] text-sage font-bold uppercase tracking-wider">Selamat Datang di Nusantara Tour Guide</div>
                <p class="text-gray-700 text-xs leading-relaxed">
                    Halo! Saya asisten AI konsultan perjalanan Indonesia. Tanyakan seputar rekomendasi destinasi Raja Ampat, Labuan Bajo, Bromo, Bali, tips persiapan, atau booking pemandu berlisensi resmi HPI!
                </p>
            </div>

            <!-- Suggestion Quick Prompts -->
            <div x-show="messages.length === 0 && suggestions.length > 0" class="space-y-2">
                <div class="text-[10px] uppercase tracking-wider font-bold text-gray-500">Pilihan Topik Populer:</div>
                <div class="flex flex-col gap-1.5">
                    <template x-for="(sug, index) in suggestions" :key="index">
                        <button @click="sendPredefined(sug.prompt)" 
                                type="button"
                                class="text-left px-3.5 py-2.5 bg-white hover:bg-sage-light hover:border-sage border border-gray-200 text-gray-800 rounded-lg text-xs font-medium transition-all shadow-sm">
                            <span x-text="sug.label"></span> &rarr;
                        </button>
                    </template>
                </div>
            </div>

            <!-- Message List -->
            <template x-for="(msg, i) in messages" :key="i">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.role === 'user' 
                                    ? 'bg-primary text-white rounded-2xl rounded-tr-none px-4 py-3 max-w-[85%] shadow-sm' 
                                    : 'bg-white text-gray-800 border border-gray-100 rounded-2xl rounded-tl-none px-4 py-3 max-w-[90%] shadow-soft leading-relaxed'">
                        <div class="text-xs space-y-1.5 break-words" x-html="renderMarkdown(msg.text)"></div>
                        <div class="text-[9px] mt-1 text-right" 
                             :class="msg.role === 'user' ? 'text-gray-300' : 'text-gray-400'" 
                             x-text="msg.time"></div>
                    </div>
                </div>
            </template>

            <!-- Loading Bubble -->
            <div x-show="isLoading" class="flex justify-start">
                <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-none px-4 py-3 shadow-soft flex items-center space-x-1.5 text-xs text-gray-500">
                    <span class="w-1.5 h-1.5 bg-accent rounded-full animate-bounce"></span>
                    <span class="w-1.5 h-1.5 bg-accent rounded-full animate-bounce [animation-delay:0.2s]"></span>
                    <span class="w-1.5 h-1.5 bg-accent rounded-full animate-bounce [animation-delay:0.4s]"></span>
                    <span class="ml-1 text-[11px]">Pemandu AI sedang merangkum...</span>
                </div>
            </div>

        </div>

        <!-- Window Footer / Input Form -->
        <div class="p-3 border-t border-gray-100 bg-white">
            <form @submit.prevent="sendMessage()" class="flex items-center space-x-2">
                <input type="text" 
                       x-model="inputMessage" 
                       x-ref="messageInput"
                       :disabled="isLoading"
                       placeholder="Tanyakan destinasi, rute, atau tips wisata..." 
                       class="flex-1 bg-gray-50 border border-gray-200 text-xs px-3.5 py-2.5 rounded-xl focus:outline-none focus:border-primary transition-colors disabled:opacity-50 text-gray-800">
                <button type="submit" 
                        :disabled="isLoading || !inputMessage.trim()"
                        class="px-4 py-2.5 bg-primary text-white hover:bg-secondary rounded-xl font-bold transition-all disabled:opacity-40 shadow-sm flex items-center justify-center">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                </button>
            </form>
            <div class="mt-1.5 text-center">
                <span class="text-[9px] text-gray-400">Didukung Google Gemini &bull; Wisata Resmi Indonesia</span>
            </div>
        </div>

    </div>

</div>

<script>
function tourGuideChatbot() {
    return {
        isOpen: false,
        showTeaser: false,
        isLoading: false,
        inputMessage: '',
        messages: [],
        suggestions: [
            { label: 'Itinerary Raja Ampat 4D3N', prompt: 'Berapa estimasi biaya dan rekomendasi itinerary 4D3N ke Wayag & Misool Raja Ampat beserta pemandu?' },
            { label: 'Sailing Komodo & Labuan Bajo', prompt: 'Kapan musim terbaik untuk liveaboard ke Pulau Padar, Pink Beach, dan snorkeling bersama Manta Ray?' },
            { label: 'Paket Sunrise Bromo & Ijen Blue Fire', prompt: 'Apa saja persiapan dan perlengkapan mendaki untuk tur sunrise Bromo dan Kawah Ijen?' },
            { label: 'Pemandu Budaya Bali & Toraja', prompt: 'Bagaimana etika berkunjung dan rute wisata warisan budaya spiritual di Bali dan Tana Toraja?' }
        ],

        init() {
            const saved = localStorage.getItem('nusantara_tour_chat_history');
            if (saved) {
                try {
                    this.messages = JSON.parse(saved);
                } catch (e) {
                    this.messages = [];
                }
            }

            const teaserDismissed = sessionStorage.getItem('nusantara_chat_teaser_dismissed');
            if (!teaserDismissed && this.messages.length === 0) {
                setTimeout(() => {
                    this.showTeaser = true;
                }, 4000);
            }
        },

        dismissTeaser() {
            this.showTeaser = false;
            sessionStorage.setItem('nusantara_chat_teaser_dismissed', '1');
        },

        openChat() {
            this.isOpen = true;
            this.showTeaser = false;
            this.$nextTick(() => {
                this.scrollToBottom();
                this.$refs.messageInput?.focus();
            });
        },

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.showTeaser = false;
                this.$nextTick(() => {
                    this.scrollToBottom();
                    this.$refs.messageInput?.focus();
                });
            }
        },

        sendPredefined(promptText) {
            this.inputMessage = promptText;
            this.sendMessage();
        },

        async sendMessage() {
            const text = this.inputMessage.trim();
            if (!text || this.isLoading) return;

            const now = new Date();
            const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');

            this.messages.push({
                role: 'user',
                text: text,
                time: timeString
            });

            this.inputMessage = '';
            this.isLoading = true;
            this.saveHistory();
            this.$nextTick(() => this.scrollToBottom());

            try {
                const historyPayload = this.messages.slice(-10).map(m => ({
                    role: m.role === 'user' ? 'user' : 'model',
                    text: m.text
                }));

                const response = await fetch('{{ route("chatbot.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        message: text,
                        history: historyPayload
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.messages.push({
                        role: 'assistant',
                        text: data.reply,
                        time: new Date().getHours().toString().padStart(2, '0') + ':' + new Date().getMinutes().toString().padStart(2, '0')
                    });
                } else {
                    this.messages.push({
                        role: 'assistant',
                        text: data.message || 'Mohon maaf, terjadi kendala teknis pada layanan pemandu AI. Silakan hubungi admin kami via WhatsApp.',
                        time: new Date().getHours().toString().padStart(2, '0') + ':' + new Date().getMinutes().toString().padStart(2, '0')
                    });
                }
            } catch (err) {
                this.messages.push({
                    role: 'assistant',
                    text: 'Tidak dapat terhubung ke server pemandu wisata. Silakan periksa koneksi internet Anda.',
                    time: new Date().getHours().toString().padStart(2, '0') + ':' + new Date().getMinutes().toString().padStart(2, '0')
                });
            } finally {
                this.isLoading = false;
                this.saveHistory();
                this.$nextTick(() => this.scrollToBottom());
            }
        },

        confirmClearChat() {
            if (confirm('Apakah Anda ingin menghapus seluruh riwayat konsultasi ini?')) {
                this.messages = [];
                localStorage.removeItem('nusantara_tour_chat_history');
            }
        },

        saveHistory() {
            localStorage.setItem('nusantara_tour_chat_history', JSON.stringify(this.messages.slice(-20)));
        },

        scrollToBottom() {
            if (this.$refs.chatContainer) {
                this.$refs.chatContainer.scrollTop = this.$refs.chatContainer.scrollHeight;
            }
        },

        renderMarkdown(rawText) {
            if (!rawText) return '';
            let escaped = rawText
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');

            // Bold **text**
            escaped = escaped.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            // Bullet points
            escaped = escaped.replace(/^\s*[\-\*]\s+(.*)$/gm, '<li class="ml-3 list-disc">$1</li>');
            // Numbered list
            escaped = escaped.replace(/^\s*(\d+)\.\s+(.*)$/gm, '<li class="ml-3 list-decimal">$2</li>');
            // Paragraph breaks
            escaped = escaped.replace(/\n\n/g, '<div class="h-2"></div>');
            escaped = escaped.replace(/\n/g, '<br>');

            return escaped;
        }
    }
}
</script>
