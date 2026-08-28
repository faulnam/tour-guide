<!-- BENGKEL AI Consultant Floating Widget (Clean Minimalist Luxury Styling) -->
<div x-data="bengkelChatbot()" x-init="init()" class="fixed bottom-6 right-6 z-40">
    
    <!-- Minimalist Teaser Prompt (Auto appears when unopened) -->
    <div x-show="showTeaser && !isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-3"
         x-cloak
         class="absolute bottom-16 right-0 mb-2 w-72 bg-white text-black border border-neutral-200 p-4 shadow-xl text-xs space-y-2">
        <div class="flex items-start justify-between">
            <div class="flex items-center space-x-2">
                <span class="w-1.5 h-1.5 bg-black inline-block"></span>
                <span class="eyebrow text-[10px] text-black font-bold">BENGKEL AI Consultant</span>
            </div>
            <button @click="dismissTeaser()" class="text-neutral-400 hover:text-black text-sm">&times;</button>
        </div>
        <p class="text-neutral-600 text-[11px] leading-relaxed">
            Ingin konsultasi seputar spesifikasi ECU remap, dyno tuning, custom build, atau estimasi biaya?
        </p>
        <button @click="openChat()" class="text-[10px] uppercase tracking-widest font-semibold text-black hover:text-accent underline block pt-1">
            Mulai Konsultasi &rarr;
        </button>
    </div>

    <!-- Floating Toggle Button -->
    <button @click="toggleChat()" 
            type="button"
            class="group w-14 h-14 bg-black text-white hover:bg-neutral-900 border border-black flex items-center justify-center shadow-2xl transition-all duration-300 focus:outline-none"
            aria-label="Toggle AI Consultation Chat">
        <div class="relative w-6 h-6 flex items-center justify-center">
            <!-- Chat Icon -->
            <svg x-show="!isOpen" class="w-5 h-5 transition-transform group-hover:scale-105" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <!-- Close (X) Icon -->
            <svg x-show="isOpen" x-cloak class="w-5 h-5 transition-transform rotate-0 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
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
         class="absolute bottom-16 right-0 mb-3 w-[92vw] sm:w-[410px] h-[580px] md:h-[85vh] max-h-[640px] bg-white text-black border border-neutral-200 shadow-2xl flex flex-col z-50 overflow-hidden font-sans">
        
        <!-- Window Header -->
        <div class="px-5 py-4 border-b border-neutral-200 bg-white flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-black text-white flex items-center justify-center text-xs font-bold font-sans">
                    B
                </div>
                <div>
                    <h3 class="text-xs uppercase tracking-widest font-bold text-black">BENGKEL AI Consultant</h3>
                    <div class="flex items-center space-x-1.5 text-[10px] text-neutral-500 mt-0.5">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full inline-block"></span>
                        <span>Performance &amp; Tuning Expert</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <button @click="confirmClearChat()" 
                        type="button" 
                        class="p-1.5 text-neutral-400 hover:text-black transition-colors text-[11px] uppercase tracking-wider" 
                        title="Hapus Percakapan">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </button>
                <button @click="isOpen = false" 
                        type="button" 
                        class="p-1.5 text-neutral-400 hover:text-black transition-colors"
                        aria-label="Tutup Chat">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <!-- Chat Body Messages Scroll Area -->
        <div x-ref="chatContainer" class="flex-1 p-5 overflow-y-auto space-y-4 bg-neutral-bg/60 text-xs">
            
            <!-- Default Welcome Card -->
            <div class="p-4 bg-white border border-neutral-200 space-y-2">
                <div class="eyebrow text-[9px] text-accent font-semibold">Selamat Datang di BENGKEL Modifikasi</div>
                <p class="text-neutral-700 text-xs leading-relaxed">
                    Halo! Saya asisten AI spesialis modifikasi performa motor dan mobil. Silakan ajukan pertanyaan seputar ECU Remap, Dyno tuning, custom build, atau booking servis.
                </p>
            </div>

            <!-- Suggestion Quick Prompts -->
            <div class="space-y-1.5 pt-1">
                <div class="eyebrow text-[9px] text-neutral-400 uppercase">Topik Populer:</div>
                <div class="flex flex-wrap gap-1.5">
                    <template x-for="(sug, idx) in suggestions" :key="idx">
                        <button @click="sendPredefined(sug.prompt)" 
                                type="button" 
                                class="text-left px-2.5 py-1.5 bg-white hover:bg-black hover:text-white text-neutral-700 border border-neutral-200 text-[10px] tracking-wide transition-all">
                            <span x-text="sug.label"></span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Messages Stream -->
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div class="max-w-[85%] space-y-1" :class="msg.role === 'user' ? 'items-end' : 'items-start'">
                        
                        <div class="p-3.5 text-xs leading-relaxed" 
                             :class="msg.role === 'user' 
                                 ? 'bg-black text-white' 
                                 : 'bg-white text-neutral-800 border border-neutral-200 shadow-sm'">
                            <div class="bengkel-chat-body" x-html="renderMarkdown(msg.text)"></div>
                        </div>

                        <!-- Timestamp & Copy Helper for Model -->
                        <div class="flex items-center space-x-2 px-1 text-[9px] text-neutral-400" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
                            <span x-text="msg.time"></span>
                            <template x-if="msg.role === 'model'">
                                <button @click="copyText(msg.text, $event)" class="hover:text-black uppercase tracking-widest text-[8px]">
                                    Salin
                                </button>
                            </template>
                        </div>

                    </div>
                </div>
            </template>

            <!-- Thinking Status Animation Indicator -->
            <div x-show="isThinking" x-cloak class="flex items-center space-x-2 p-3 bg-white border border-neutral-200 w-fit text-neutral-600 text-xs shadow-sm">
                <svg class="animate-spin w-3.5 h-3.5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span class="text-[11px]" x-text="thinkingStatus"></span>
            </div>

            <!-- Error Banner -->
            <div x-show="errorMessage" x-cloak class="p-3 bg-red-50 border border-red-200 text-red-700 text-xs">
                <span x-text="errorMessage"></span>
            </div>

        </div>

        <!-- Chat Input Footer -->
        <div class="p-3 border-t border-neutral-200 bg-white">
            <form @submit.prevent="sendMessage()" class="flex items-center space-x-2">
                <input type="text" 
                       x-model="userInput" 
                       :disabled="isThinking"
                       placeholder="Tulis pertanyaan seputar modifikasi..." 
                       class="flex-1 bg-neutral-bg border border-neutral-300 text-black text-xs px-3.5 py-2.5 focus:outline-none focus:border-black transition-colors disabled:bg-neutral-100 placeholder:text-neutral-400">
                <button type="submit" 
                        :disabled="!userInput.trim() || isThinking" 
                        class="px-4 py-2.5 bg-black text-white hover:bg-neutral-800 disabled:opacity-30 disabled:cursor-not-allowed text-xs uppercase tracking-widest font-semibold transition-colors flex items-center space-x-1">
                    <span>Kirim</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.bengkel-chat-body p { margin-bottom: 0.5rem; }
.bengkel-chat-body p:last-child { margin-bottom: 0; }
.bengkel-chat-body strong { font-weight: 700; color: inherit; }
.bengkel-chat-body ul { list-style-type: disc; margin-left: 1.1rem; margin-bottom: 0.5rem; }
.bengkel-chat-body ol { list-style-type: decimal; margin-left: 1.1rem; margin-bottom: 0.5rem; }
.bengkel-chat-body li { margin-bottom: 0.25rem; }
.bengkel-chat-body a { text-decoration: underline; font-weight: 600; color: inherit; }
</style>

<script>
function bengkelChatbot() {
    return {
        isOpen: false,
        showTeaser: false,
        userInput: '',
        isThinking: false,
        thinkingStatus: 'Sedang menganalisis spesifikasi tuning...',
        thinkingInterval: null,
        errorMessage: '',
        messages: [],
        suggestions: [
            { label: 'Estimasi ECU Remap & Dyno Run', prompt: 'Berapa estimasi biaya dan peningkatan performa untuk remap ECU mobil/motor?' },
            { label: 'Konsep Motor Cafe Racer / Bobber', prompt: 'Bagaimana tahapan dan estimasi waktu build motor custom Cafe Racer di BENGKEL?' },
            { label: 'Paket Cat Oven Spies Hecker', prompt: 'Apa keunggulan dan garansi pengecatan oven Spies Hecker di BENGKEL?' },
            { label: 'Cara Booking Online & Bayar DP', prompt: 'Bagaimana alur booking online servis dan pembayaran DP via Payment Gateway?' }
        ],

        init() {
            const saved = sessionStorage.getItem('bengkel_chat_history');
            if (saved) {
                try { this.messages = JSON.parse(saved); } catch(e) { this.messages = []; }
            }

            setTimeout(() => {
                if (!this.isOpen && this.messages.length === 0) {
                    this.showTeaser = true;
                }
            }, 3500);
        },

        openChat() {
            this.isOpen = true;
            this.showTeaser = false;
            this.scrollToBottom();
        },

        toggleChat() {
            this.isOpen = !this.isOpen;
            if (this.isOpen) {
                this.showTeaser = false;
                this.scrollToBottom();
            }
        },

        dismissTeaser() {
            this.showTeaser = false;
        },

        sendPredefined(prompt) {
            this.userInput = prompt;
            this.sendMessage();
        },

        async sendMessage() {
            const text = this.userInput.trim();
            if (!text || this.isThinking) return;

            this.errorMessage = '';
            const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            this.messages.push({ role: 'user', text: text, time: currentTime });
            this.userInput = '';
            this.saveHistory();
            this.scrollToBottom();

            this.isThinking = true;
            this.startThinkingAnimation();

            try {
                const response = await fetch('{{ route('chatbot.send') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: text })
                });

                const data = await response.json();
                this.stopThinkingAnimation();
                this.isThinking = false;

                if (data.status === 'success' && data.reply) {
                    const replyTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    this.messages.push({
                        role: 'model',
                        text: data.reply,
                        time: replyTime
                    });
                    this.saveHistory();
                    this.scrollToBottom();
                } else {
                    this.errorMessage = data.message || 'Terjadi gangguan saat memproses jawaban. Silakan coba kembali.';
                }
            } catch (err) {
                this.stopThinkingAnimation();
                this.isThinking = false;
                this.errorMessage = 'Gagal terhubung dengan server chatbot. Periksa koneksi Anda.';
            }
        },

        startThinkingAnimation() {
            const statuses = [
                'Sedang membaca parameter mesin & dyno...',
                'Mengkalkulasi rasio performa dan rekomendasi paket...',
                'Menyusun estimasi dan arahan teknis...'
            ];
            let idx = 0;
            this.thinkingStatus = statuses[0];
            this.thinkingInterval = setInterval(() => {
                idx = (idx + 1) % statuses.length;
                this.thinkingStatus = statuses[idx];
            }, 1800);
        },

        stopThinkingAnimation() {
            if (this.thinkingInterval) {
                clearInterval(this.thinkingInterval);
                this.thinkingInterval = null;
            }
        },

        scrollToBottom() {
            this.$nextTick(() => {
                if (this.$refs.chatContainer) {
                    this.$refs.chatContainer.scrollTop = this.$refs.chatContainer.scrollHeight;
                }
            });
        },

        saveHistory() {
            try { sessionStorage.setItem('bengkel_chat_history', JSON.stringify(this.messages)); } catch(e) {}
        },

        confirmClearChat() {
            if (confirm('Hapus riwayat percakapan konsultasi?')) {
                this.messages = [];
                sessionStorage.removeItem('bengkel_chat_history');
            }
        },

        copyText(text, event) {
            navigator.clipboard.writeText(text).then(() => {
                const btn = event.target;
                const orig = btn.innerText;
                btn.innerText = 'Tersalin!';
                setTimeout(() => { btn.innerText = orig; }, 1500);
            });
        },

        renderMarkdown(raw) {
            if (!raw) return '';
            let html = raw
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;");

            // Bold
            html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            // Italic
            html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');
            // Inline code
            html = html.replace(/`(.*?)`/g, '<code class="bg-neutral-100 px-1 py-0.5 font-mono text-[10px]">$1</code>');
            // Links
            html = html.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>');

            // Paragraphs and Lists
            const lines = html.split('\n');
            let inList = false;
            let result = '';

            for (let line of lines) {
                let trimmed = line.trim();
                if (trimmed.startsWith('* ') || trimmed.startsWith('- ')) {
                    if (!inList) { result += '<ul>'; inList = true; }
                    result += '<li>' + trimmed.substring(2) + '</li>';
                } else {
                    if (inList) { result += '</ul>'; inList = false; }
                    if (trimmed.length > 0) {
                        result += '<p>' + trimmed + '</p>';
                    }
                }
            }
            if (inList) result += '</ul>';

            return result;
        }
    };
}
</script>
