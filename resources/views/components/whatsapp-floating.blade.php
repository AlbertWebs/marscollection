@php
    $rawPhone = \App\Models\Setting::get('contact_phone_primary', '254707614446');
    $cleanPhone = preg_replace('/\D/', '', $rawPhone);
@endphp

<!-- WhatsApp Floating Button & Modal -->
<div id="whatsapp-floating-container" class="fixed bottom-6 right-6 z-50 flex flex-col items-end">
    <!-- WhatsApp Chat Popup Dialog -->
    <div id="whatsapp-chat-popup" 
         class="hidden mb-3 w-[calc(100vw-2rem)] sm:w-84 max-w-sm bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-300 origin-bottom-right animate-fadeIn">
        
        <!-- Header -->
        <div class="bg-emerald-600 p-4 text-white flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.97.54 1.891.83 2.796.83h.005c3.181 0 5.767-2.586 5.767-5.766.001-3.181-2.585-5.767-5.767-5.767zm0-2.172c4.379 0 7.938 3.559 7.938 7.938 0 4.379-3.559 7.938-7.938 7.938a7.89 7.89 0 01-3.791-.971l-5.24 1.371 1.395-5.105a7.92 7.92 0 01-1.202-4.233c0-4.379 3.559-7.938 7.938-7.938z"/>
                            <path d="M15.42 14.333c-.198-.099-1.171-.577-1.353-.643-.182-.066-.314-.099-.446.099-.132.198-.512.643-.628.775-.116.132-.231.148-.429.05-.198-.099-.838-.309-1.596-.985-.59-.526-.988-1.176-1.104-1.374-.116-.198-.012-.305.087-.403.089-.089.198-.231.297-.347.099-.116.132-.198.198-.33.066-.132.033-.248-.017-.347-.05-.099-.446-1.074-.611-1.47-.161-.387-.325-.334-.446-.34l-.38-.007c-.132 0-.347.05-.528.248-.182.198-.694.677-.694 1.651 0 .974.71 1.916.81 2.048.099.132 1.396 2.131 3.382 2.986 1.986.855 1.986.57 2.349.537.363-.033 1.171-.479 1.336-.941.165-.462.165-.858.116-.941-.05-.083-.182-.132-.38-.231z"/>
                        </svg>
                    </div>
                    <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 border-2 border-emerald-600 rounded-full"></span>
                </div>
                <div>
                    <h3 class="font-semibold text-sm leading-tight text-white">Zayn's Beauty Support</h3>
                    <p class="text-[11px] text-emerald-100">Typically replies instantly</p>
                </div>
            </div>
            <button type="button" 
                    onclick="toggleWhatsAppChat()" 
                    class="text-emerald-100 hover:text-white p-1 rounded-full hover:bg-emerald-700/50 transition-colors"
                    aria-label="Close WhatsApp chat">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Chat Body -->
        <div class="p-4 bg-emerald-50/40 space-y-3">
            <div class="bg-white p-3 rounded-2xl rounded-tl-sm shadow-xs border border-gray-100 max-w-[85%] text-xs text-gray-700 leading-relaxed">
                👋 Hello! Welcome to Zayn's Beauty. How can we help you with our beauty products or salon bookings today?
            </div>
        </div>

        <!-- Input Area -->
        <form onsubmit="handleWhatsAppSend(event)" class="p-3 bg-white border-t border-gray-100">
            <div class="relative">
                <textarea id="whatsapp-message-input" 
                          rows="2" 
                          placeholder="Type your message here..." 
                          required
                          class="w-full text-xs text-gray-800 bg-gray-50 border border-gray-200 rounded-xl p-2.5 pr-10 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white resize-none transition-all"></textarea>
                <button type="submit" 
                        class="absolute bottom-2.5 right-2 w-7 h-7 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg flex items-center justify-center transition-transform hover:scale-105 active:scale-95 shadow-xs"
                        aria-label="Send WhatsApp message">
                    <svg class="w-3.5 h-3.5 fill-current transform rotate-45 -translate-y-0.5 translate-x-0.5" viewBox="0 0 20 20">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                    </svg>
                </button>
            </div>
            <div class="mt-1.5 flex items-center justify-between text-[10px] text-gray-400">
                <span>Direct chat via WhatsApp</span>
                <span class="flex items-center gap-1 text-emerald-600 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                    Online
                </span>
            </div>
        </form>
    </div>

    <!-- Main Floating Trigger Button -->
    <button id="whatsapp-trigger-btn"
            type="button" 
            onclick="toggleWhatsAppChat()" 
            class="group relative flex items-center justify-center w-14 h-14 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full shadow-lg hover:shadow-emerald-300/50 transform hover:scale-105 active:scale-95 transition-all duration-300"
            aria-label="Open WhatsApp Chat Inquiry">
        
        <!-- Pulse effect ring -->
        <span class="absolute inset-0 rounded-full bg-emerald-400 opacity-40 animate-ping group-hover:opacity-0"></span>

        <!-- WhatsApp Icon (Default) -->
        <svg id="wa-icon-chat" class="w-7 h-7 fill-current relative z-10" viewBox="0 0 24 24">
            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.664-.698c.97.54 1.891.83 2.796.83h.005c3.181 0 5.767-2.586 5.767-5.766.001-3.181-2.585-5.767-5.767-5.767zm0-2.172c4.379 0 7.938 3.559 7.938 7.938 0 4.379-3.559 7.938-7.938 7.938a7.89 7.89 0 01-3.791-.971l-5.24 1.371 1.395-5.105a7.92 7.92 0 01-1.202-4.233c0-4.379 3.559-7.938 7.938-7.938z"/>
            <path d="M15.42 14.333c-.198-.099-1.171-.577-1.353-.643-.182-.066-.314-.099-.446.099-.132.198-.512.643-.628.775-.116.132-.231.148-.429.05-.198-.099-.838-.309-1.596-.985-.59-.526-.988-1.176-1.104-1.374-.116-.198-.012-.305.087-.403.089-.089.198-.231.297-.347.099-.116.132-.198.198-.33.066-.132.033-.248-.017-.347-.05-.099-.446-1.074-.611-1.47-.161-.387-.325-.334-.446-.34l-.38-.007c-.132 0-.347.05-.528.248-.182.198-.694.677-.694 1.651 0 .974.71 1.916.81 2.048.099.132 1.396 2.131 3.382 2.986 1.986.855 1.986.57 2.349.537.363-.033 1.171-.479 1.336-.941.165-.462.165-.858.116-.941-.05-.083-.182-.132-.38-.231z"/>
        </svg>

        <!-- Close Icon (When open) -->
        <svg id="wa-icon-close" class="hidden w-6 h-6 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
        </svg>

        <!-- Tooltip Label for Desktop -->
        <span class="hidden sm:inline-block absolute right-16 top-1/2 -translate-y-1/2 bg-gray-900 text-white text-xs font-medium py-1.5 px-3 rounded-lg shadow-md whitespace-nowrap opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-200">
            Chat with us
        </span>
    </button>
</div>

<script>
    const waCleanPhone = @json($cleanPhone);

    function toggleWhatsAppChat() {
        const popup = document.getElementById('whatsapp-chat-popup');
        const iconChat = document.getElementById('wa-icon-chat');
        const iconClose = document.getElementById('wa-icon-close');
        const input = document.getElementById('whatsapp-message-input');

        const isHidden = popup.classList.contains('hidden');
        if (isHidden) {
            popup.classList.remove('hidden');
            iconChat.classList.add('hidden');
            iconClose.classList.remove('hidden');
            setTimeout(() => {
                input.focus();
            }, 100);
        } else {
            popup.classList.add('hidden');
            iconChat.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }
    }

    function handleWhatsAppSend(e) {
        e.preventDefault();
        const input = document.getElementById('whatsapp-message-input');
        const message = input.value.trim();
        if (!message) return;

        const url = `https://wa.me/${waCleanPhone}?text=${encodeURIComponent(message)}`;
        window.open(url, '_blank', 'noopener,noreferrer');
        
        input.value = '';
        toggleWhatsAppChat();
    }
</script>
