@php
    $rawPhone = \App\Models\Setting::get('contact_phone_primary', '0726243706');
    $cleanPhone = preg_replace('/\D/', '', $rawPhone);
    if (str_starts_with($cleanPhone, '0')) $cleanPhone = '254' . substr($cleanPhone, 1);
@endphp

<!-- WhatsApp Floating Button & Modal -->
<div id="whatsapp-floating-container" style="position: fixed; bottom: 24px; left: 24px; z-index: 99999; display: flex; flex-direction: column; align-items: flex-start;">
    <!-- WhatsApp Chat Popup Dialog -->
    <div id="whatsapp-chat-popup" 
         class="hidden mb-3 w-[calc(100vw-2rem)] sm:w-84 max-w-sm rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 origin-bottom-left"
         style="background-color: #ffffff; border: 1px solid #e5e7eb; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);">
        
        <!-- Header -->
        <div style="background-color: #059669; color: #ffffff;" class="p-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div style="background-color: rgba(255, 255, 255, 0.2);" class="w-10 h-10 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 fill-current text-white" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.301-.15-1.781-.878-2.057-.978-.277-.1-.478-.15-.68.15-.201.3-.777.978-.953 1.179-.175.2-.351.225-.652.075-.301-.15-1.272-.469-2.423-1.496-.895-.798-1.5-1.784-1.675-2.085-.176-.301-.019-.464.132-.614.136-.135.301-.351.452-.527.15-.175.201-.3.301-.501.1-.2.05-.376-.025-.526-.075-.15-.68-1.639-.932-2.247-.246-.593-.497-.513-.68-.522-.176-.009-.377-.01-.578-.01-.201 0-.527.075-.803.376s-1.054 1.03-1.054 2.512c0 1.482 1.079 2.914 1.23 3.115.15.2 2.124 3.243 5.145 4.547.719.311 1.28.497 1.718.637.722.23 1.379.197 1.898.12.578-.087 1.781-.728 2.032-1.432.251-.704.251-1.307.176-1.432-.075-.126-.276-.201-.577-.351zm-5.467 7.618a9.947 9.947 0 0 1-5.074-1.391l-.364-.216-3.771.989 1.006-3.677-.237-.377A9.948 9.948 0 0 1 2.05 12c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10zm0-22C5.373 0 0 5.373 0 12c0 2.116.554 4.103 1.523 5.836L0 24l6.326-1.66A11.95 11.95 0 0 0 12.005 24C18.627 24 24 18.627 24 12S18.627 0 12.005 0z"/>
                        </svg>
                    </div>
                    <span style="background-color: #34d399; border-color: #059669;" class="absolute bottom-0 right-0 w-2.5 h-2.5 border-2 rounded-full"></span>
                </div>
                <div>
                    <h3 class="font-semibold text-sm leading-tight text-white">Mars Collection Support</h3>
                    <p class="text-[11px] text-emerald-100">Typically replies instantly</p>
                </div>
            </div>
            <button type="button" 
                    onclick="toggleWhatsAppChat()" 
                    class="text-emerald-100 hover:text-white p-1 rounded-full transition-colors cursor-pointer"
                    aria-label="Close WhatsApp chat">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Chat Body -->
        <div style="background-color: #f0fdf4;" class="p-4 space-y-3">
            <div style="background-color: #ffffff; border: 1px solid #f3f4f6;" class="p-3 rounded-2xl rounded-tl-sm shadow-xs max-w-[85%] text-xs text-gray-700 leading-relaxed">
                Hello! Welcome to Mars Collection. How can we help you find the right pair today?
            </div>
        </div>

        <!-- Input Area -->
        <form onsubmit="handleWhatsAppSend(event)" style="background-color: #ffffff; border-top: 1px solid #f3f4f6;" class="p-3">
            <div class="relative">
                <textarea id="whatsapp-message-input" 
                          rows="2" 
                          placeholder="Type your message here..." 
                          required
                          class="w-full text-xs text-gray-800 bg-gray-50 border border-gray-200 rounded-xl p-2.5 pr-10 focus:outline-none focus:bg-white resize-none transition-all"></textarea>
                <button type="submit" 
                        style="background-color: #059669; color: #ffffff;"
                        class="absolute bottom-2.5 right-2 w-7 h-7 hover:opacity-90 rounded-lg flex items-center justify-center transition-transform hover:scale-105 active:scale-95 shadow-xs cursor-pointer"
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
            style="background-color: #10b981; color: #ffffff; width: 56px; height: 56px; border-radius: 9999px; box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.4), 0 4px 6px -4px rgba(16, 185, 129, 0.3);"
            class="group relative flex items-center justify-center transform hover:scale-105 active:scale-95 transition-all duration-300 cursor-pointer"
            aria-label="Open WhatsApp Chat Inquiry">
        
        <!-- WhatsApp Icon (Default) -->
        <svg id="wa-icon-chat" class="w-7 h-7 fill-current relative z-10" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.301-.15-1.781-.878-2.057-.978-.277-.1-.478-.15-.68.15-.201.3-.777.978-.953 1.179-.175.2-.351.225-.652.075-.301-.15-1.272-.469-2.423-1.496-.895-.798-1.5-1.784-1.675-2.085-.176-.301-.019-.464.132-.614.136-.135.301-.351.452-.527.15-.175.201-.3.301-.501.1-.2.05-.376-.025-.526-.075-.15-.68-1.639-.932-2.247-.246-.593-.497-.513-.68-.522-.176-.009-.377-.01-.578-.01-.201 0-.527.075-.803.376s-1.054 1.03-1.054 2.512c0 1.482 1.079 2.914 1.23 3.115.15.2 2.124 3.243 5.145 4.547.719.311 1.28.497 1.718.637.722.23 1.379.197 1.898.12.578-.087 1.781-.728 2.032-1.432.251-.704.251-1.307.176-1.432-.075-.126-.276-.201-.577-.351zm-5.467 7.618a9.947 9.947 0 0 1-5.074-1.391l-.364-.216-3.771.989 1.006-3.677-.237-.377A9.948 9.948 0 0 1 2.05 12c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10zm0-22C5.373 0 0 5.373 0 12c0 2.116.554 4.103 1.523 5.836L0 24l6.326-1.66A11.95 11.95 0 0 0 12.005 24C18.627 24 24 18.627 24 12S18.627 0 12.005 0z"/>
        </svg>

        <!-- Close Icon (When open) -->
        <svg id="wa-icon-close" class="hidden w-6 h-6 text-white relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
        </svg>

        <!-- Tooltip Label for Desktop -->
        <span style="background-color: #111827; color: #ffffff;" class="hidden sm:inline-block absolute right-16 top-1/2 -translate-y-1/2 text-xs font-medium py-1.5 px-3 rounded-lg shadow-md whitespace-nowrap opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity duration-200">
            Chat with us
        </span>
    </button>
</div>
<button id="back-to-top-btn" type="button" onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        style="position: fixed; right: 24px; bottom: 24px; z-index: 99999;"
        class="hidden md:flex items-center justify-center w-12 h-12 rounded-full bg-gray-900 text-white shadow-lg hover:bg-amber-600 transition-colors"
        aria-label="Back to top" title="Back to top">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7M12 8v12"/>
    </svg>
</button>

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
