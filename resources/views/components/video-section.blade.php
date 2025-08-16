@php
    $videoEnabled = \App\Models\Setting::get('video_enabled', '1');
    $videoTitle = \App\Models\Setting::get('video_title', 'DISCOVER THE SECRETS OF GLOWING SKIN');
    $videoDescription = \App\Models\Setting::get('video_description', 'Learn expert tips and techniques for achieving radiant, healthy skin from our beauty specialists');
    $videoYoutubeId = \App\Models\Setting::get('video_youtube_id', 'BNmXh0p0Py4');
    $videoThumbnail = \App\Models\Setting::get('video_thumbnail', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80');
@endphp

@if($videoEnabled)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $videoTitle }}</h2>
        </div>
        
        <div class="relative max-w-4xl mx-auto" x-data="{ 
            showModal: false,
            openModal() {
                this.showModal = true;
                document.body.style.overflow = 'hidden';
            },
            closeModal() {
                this.showModal = false;
                document.body.style.overflow = 'auto';
            }
        }">
            <div class="relative rounded-2xl overflow-hidden shadow-2xl cursor-pointer" @click="openModal()">
                <img src="{{ $videoThumbnail }}" 
                     alt="Woman applying skincare" 
                     class="w-full h-96 object-cover">
                
                <!-- Play Button Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-70 flex items-center justify-center">
                    <div class="bg-white bg-opacity-90 hover:bg-opacity-100 transition-all duration-300 w-20 h-20 rounded-full flex items-center justify-center shadow-lg transform hover:scale-110">
                        <svg class="w-8 h-8 text-pink-600 ml-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Video description -->
            <div class="mt-8 text-center">
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    {{ $videoDescription }}
                </p>
            </div>
            
            <!-- Modal -->
            <div x-show="showModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4"
                 @click.self="closeModal()">
                
                <!-- Modal Backdrop -->
                <div class="absolute inset-0 bg-black/30 bg-opacity-30"></div>
                
                <!-- Modal Content -->
                <div class="relative max-w-4xl w-full max-h-[90vh] overflow-hidden">
                    <!-- Close Button -->
                    <button @click="closeModal()" 
                            class="absolute top-4 right-4 z-10 text-white hover:text-gray-300 transition-colors bg-black bg-opacity-50 rounded-full p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    
                    <!-- Video Container -->
                    <div class="relative w-full" style="padding-bottom: 56.25%;">
                        <iframe 
                            class="absolute top-0 left-0 w-full h-full"
                            src="https://www.youtube.com/embed/{{ $videoYoutubeId }}?si=wMuVVoVzT1L03IQy"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            >
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif 