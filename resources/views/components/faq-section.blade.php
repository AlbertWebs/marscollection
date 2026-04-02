<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">FREQUENTLY ASKED QUESTIONS</h2>
        </div>
        
        <div class="max-w-3xl mx-auto" x-data="{ 
            activeTab: 1,
            toggleTab(tab) {
                this.activeTab = this.activeTab === tab ? null : tab;
            }
        }">
            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-md mb-4 overflow-hidden">
                <button @click="toggleTab(1)" 
                        class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900">How can I track my order?</h3>
                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" 
                         :class="{ 'rotate-180': activeTab === 1 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="activeTab === 1" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="px-6 pb-4">
                    <p class="text-gray-600 leading-relaxed">
                        You'll receive an email confirmation with your order details once your order is placed. 
                        For order status updates, please contact our customer service team directly. We'll keep you 
                        informed about your order's progress via email and phone.
                    </p>
                </div>
            </div>
            
            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-md mb-4 overflow-hidden">
                <button @click="toggleTab(2)" 
                        class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900">What is your return policy?</h3>
                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" 
                         :class="{ 'rotate-180': activeTab === 2 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="activeTab === 2" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="px-6 pb-4">
                    <p class="text-gray-600 leading-relaxed">
                        We accept returns within 30 days for unused and unopened products in their original packaging. 
                        Contact our customer service team to initiate a return. Please note that opened personal care items 
                        cannot be returned for hygiene reasons.
                    </p>
                </div>
            </div>
            
            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-md mb-4 overflow-hidden">
                <button @click="toggleTab(3)" 
                        class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900">Where do you ship?</h3>
                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" 
                         :class="{ 'rotate-180': activeTab === 3 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="activeTab === 3" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="px-6 pb-4">
                    <p class="text-gray-600 leading-relaxed">
                        We currently ship within Kenya to major cities including Nairobi, Mombasa, Kisumu, Nakuru, 
                        Eldoret, and Thika. Standard shipping takes 3-5 business days, while express shipping 
                        (1-2 days) is available for most locations. International shipping is not available at this time.
                    </p>
                </div>
            </div>
            
            <!-- FAQ Item 4 -->
            <div class="bg-white rounded-md mb-4 overflow-hidden">
                <button @click="toggleTab(4)" 
                        class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900">How do I book an appointment?</h3>
                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" 
                         :class="{ 'rotate-180': activeTab === 4 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="activeTab === 4" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="px-6 pb-4">
                    <p class="text-gray-600 leading-relaxed">
                        You can book an appointment through our website by visiting the "Book Appointment" page. 
                        Choose your preferred service, date, and time slot. You'll receive a confirmation email 
                        once your appointment is confirmed. You can also call us directly to schedule an appointment.
                    </p>
                </div>
            </div>
            
            <!-- FAQ Item 5 -->
            <div class="bg-white rounded-md mb-4 overflow-hidden">
                <button @click="toggleTab(5)" 
                        class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900">How do I choose the right products?</h3>
                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" 
                         :class="{ 'rotate-180': activeTab === 5 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="activeTab === 5" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="px-6 pb-4">
                    <p class="text-gray-600 leading-relaxed">
                        Browse our product categories and read customer reviews to help you make informed decisions. 
                        You can also contact our customer service team for personalized recommendations based on your 
                        needs. We recommend starting with our best-selling products and reading product descriptions 
                        carefully to understand what each item offers.
                    </p>
                </div>
            </div>
            
            <!-- FAQ Item 6 -->
            <div class="bg-white rounded-md mb-4 overflow-hidden">
                <button @click="toggleTab(6)" 
                        class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 transition-colors">
                    <h3 class="text-lg font-semibold text-gray-900">What payment methods do you accept?</h3>
                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-200" 
                         :class="{ 'rotate-180': activeTab === 6 }"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="activeTab === 6" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="px-6 pb-4">
                    <p class="text-gray-600 leading-relaxed">
                        We accept cash on delivery for all orders. This allows you to pay when you receive your 
                        order, ensuring a secure and convenient shopping experience. Payment is collected by our 
                        delivery team upon successful delivery of your items.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section> 