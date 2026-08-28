<div x-data="{
    open: false,
    messages: [
        { role: 'model', text: 'Halo! Saya **Apex AI Assistant**, pakar modifikasi dan performa motor & mobil di Apex Garage. Ada yang bisa saya bantu terkait dyno tuning, custom build, estimasi biaya, atau jadwal booking?' }
    ],
    userInput: '',
    isLoading: false,
    suggestions: [
        'Estimasi Remap ECU Mobil/Motor',
        'Konsep Motor Custom Cafe Racer',
        'Paket Widebody & Cat Oven Spies Hecker',
        'Cara Booking & Pembayaran DP'
    ],
    sendMessage(textToSend = null) {
        const text = textToSend || this.userInput.trim();
        if (!text || this.isLoading) return;

        this.messages.push({ role: 'user', text: text });
        if (!textToSend) this.userInput = '';
        this.isLoading = true;
        this.scrollToBottom();

        fetch('{{ route('chatbot.send') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                message: text,
                history: this.messages.slice(-8)
            })
        })
        .then(res => res.json())
        .then(data => {
            this.isLoading = false;
            if (data.success) {
                this.messages.push({ role: 'model', text: data.reply });
            } else {
                this.messages.push({ role: 'model', text: data.message || 'Maaf, terjadi kendala saat memproses jawaban.' });
            }
            this.scrollToBottom();
        })
        .catch(err => {
            this.isLoading = false;
            this.messages.push({ role: 'model', text: 'Terjadi kesalahan jaringan. Silakan coba kembali.' });
            this.scrollToBottom();
        });
    },
    scrollToBottom() {
        this.$nextTick(() => {
            const container = this.$refs.chatContainer;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    }
}" class="fixed bottom-6 left-6 z-50">

    <!-- Floating Chat Trigger Button -->
    <button @click="open = !open" 
            class="w-14 h-14 rounded-full bg-gradient-to-tr from-red-600 to-red-500 text-white shadow-2xl flex items-center justify-center hover:scale-105 active:scale-95 transition-all glow-red border-2 border-red-400/50 group relative">
        <i class="fa-solid fa-robot text-xl transition-transform duration-300" :class="open ? 'rotate-90 scale-0' : 'scale-100'"></i>
        <i class="fa-solid fa-xmark text-xl absolute transition-transform duration-300" :class="open ? 'scale-100' : 'scale-0'"></i>
        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-neutral-900 animate-ping"></span>
        <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-emerald-500 rounded-full border-2 border-neutral-900"></span>
    </button>

    <!-- Chat Modal Window -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-6 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-6 scale-95"
         x-cloak
         class="absolute bottom-16 left-0 w-80 sm:w-96 bg-[#111116] border border-neutral-800 rounded-2xl shadow-2xl overflow-hidden flex flex-col h-[520px] max-h-[85vh]">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-neutral-900 via-[#181822] to-red-950/60 p-4 border-b border-neutral-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-red-600/20 border border-red-500/40 text-red-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-gauge-high text-sm"></i>
                </div>
                <div>
                    <div class="font-racing font-bold text-xs tracking-wider text-white">APEX AI CONSULTANT</div>
                    <div class="text-[10px] text-emerald-400 flex items-center gap-1.5 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Online • Mod & Tuning Expert</span>
                    </div>
                </div>
            </div>
            <button @click="open = false" class="text-neutral-400 hover:text-white text-sm p-1">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Chat Messages Container -->
        <div x-ref="chatContainer" class="flex-1 p-4 overflow-y-auto space-y-3 text-xs">
            <template x-for="(msg, index) in messages" :key="index">
                <div class="flex flex-col" :class="msg.role === 'user' ? 'items-end' : 'items-start'">
                    <div class="max-w-[85%] rounded-2xl px-3.5 py-2.5 leading-relaxed"
                         :class="msg.role === 'user' 
                             ? 'bg-red-600 text-white rounded-br-none shadow-md' 
                             : 'bg-neutral-900 border border-neutral-800 text-neutral-200 rounded-bl-none'">
                        <div class="whitespace-pre-line" x-html="msg.text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')"></div>
                    </div>
                    <span class="text-[9px] text-neutral-500 mt-1 px-1" x-text="msg.role === 'user' ? 'Anda' : 'Apex AI'"></span>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div x-show="isLoading" class="flex items-center gap-2 text-neutral-400 text-[11px] p-2 bg-neutral-900/60 rounded-xl border border-neutral-800 w-fit">
                <i class="fa-solid fa-gear fa-spin text-red-500"></i>
                <span>Menganalisis spesifikasi...</span>
            </div>
        </div>

        <!-- Quick Question Chips -->
        <div class="px-3 py-2 bg-neutral-900/80 border-t border-neutral-800 overflow-x-auto flex gap-1.5 scrollbar-none text-[10px]">
            <template x-for="(chip, i) in suggestions" :key="i">
                <button type="button" @click="sendMessage(chip)" 
                        class="whitespace-nowrap bg-[#181822] hover:bg-red-600 hover:text-white text-neutral-300 px-2.5 py-1 rounded-full border border-neutral-700 transition-colors">
                    <span x-text="chip"></span>
                </button>
            </template>
        </div>

        <!-- Input Box -->
        <form @submit.prevent="sendMessage()" class="p-3 bg-[#0d0d12] border-t border-neutral-800 flex items-center gap-2">
            <input type="text" x-model="userInput" placeholder="Tanya remap, biaya, modif motor/mobil..."
                   class="flex-1 bg-neutral-900 border border-neutral-700 rounded-xl px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:ring-1 focus:ring-red-500">
            <button type="submit" :disabled="!userInput.trim() || isLoading"
                    class="p-2.5 bg-red-600 disabled:opacity-50 hover:bg-red-500 text-white rounded-xl transition-all">
                <i class="fa-solid fa-paper-plane text-xs"></i>
            </button>
        </form>

    </div>

</div>
