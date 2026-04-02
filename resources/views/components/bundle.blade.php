<section class="py-12 md:py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-10">
            @php
                $bundles = App\Models\Bundle::where('is_active', true)->limit(4)->get();
            @endphp

            @foreach($bundles as $bundle)
            <div class="group bg-gradient-to-br from-amber-50 via-pink-50 to-orange-50 rounded-md md:rounded-md p-4 md:p-8 relative overflow-hidden transition-all duration-500 transform hover:-translate-y-1 md:hover:-translate-y-2 border border-amber-100/50">
                <div class="relative z-10">
                    <h3 class="text-xl md:text-2xl lg:text-3xl xl:text-4xl font-semibold text-gray-900 mb-4 md:mb-6 leading-tight line-clamp-2 min-h-0 md:h-24 flex items-center">{{ $bundle->name }}</h3>
                </div>
                
                <!-- Mobile Layout: Stacked -->
                <div class="block md:hidden">
                    <div class="relative mb-4">
                        <img src="{{ $bundle->image }}" 
                             alt="{{ $bundle->name }}" 
                             class="w-full h-48 md:h-72 object-cover rounded-md md:rounded-md group-hover:scale-105 transition-transform duration-500"> 
                        @if($bundle->badge)
                            <div class="absolute -top-2 -right-2 {{ $bundle->badge_color === 'purple' ? 'bg-purple-500' : ($bundle->badge_color === 'green' ? 'bg-green-500' : ($bundle->badge_color === 'red' ? 'bg-red-500' : 'bg-pink-500')) }} text-white text-xs px-2 py-1 rounded-full font-medium">{{ $bundle->badge }}</div>
                        @endif
                    </div>
                    
                    <div class="space-y-3">
                        <span class="text-xs font-semibold text-pink-600 tracking-wider uppercase">{{ $bundle->category }}</span>
                        
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="w-3 h-3 md:w-4 md:h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                            <span class="text-xs md:text-sm text-gray-600">({{ $bundle->review_count }} reviews)</span>
                        </div>
                        
                        <h2 class="font-bold text-2xl md:text-4xl text-pink-600">{{ $bundle->formatted_price }}</h2>
                        
                        <!-- Add to Cart Button -->
                        <button onclick="addBundleToCart({{ $bundle->id }})" class="w-full md:w-auto mt-4 bg-pink-600 text-white px-4 md:px-6 py-3 rounded-md font-semibold hover:bg-pink-700 transition-all duration-300 transform hover:scale-105 flex items-center justify-center space-x-2 shadow-lg">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span>Add Bundle to Cart</span>
                        </button>
                    </div>
                </div>
                
                <!-- Desktop Layout: Side by Side -->
                <div class="hidden md:flex items-center">
                    <div class="relative">
                            <img src="{{ $bundle->image }}" 
                                 alt="{{ $bundle->name }}" 
                             class="h-72 aspect-square object-cover rounded-md group-hover:scale-105 transition-transform duration-500"> 
                            @if($bundle->badge)
                                <div class="absolute -top-2 -right-2 {{ $bundle->badge_color === 'purple' ? 'bg-purple-500' : ($bundle->badge_color === 'green' ? 'bg-green-500' : ($bundle->badge_color === 'red' ? 'bg-red-500' : 'bg-pink-500')) }} text-white text-xs px-2 py-1 rounded-full font-medium">{{ $bundle->badge }}</div>
                            @endif
                    </div>
                    <div class="flex flex-col justify-center space-y-3 ml-6">
                            <span class="text-xs font-semibold text-pink-600 tracking-wider uppercase">{{ $bundle->category }}</span>
                        <p class="text-gray-800 font-semibold text-xl w-full">
                                {{ $bundle->name }}
                        </p>
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-600">({{ $bundle->review_count }} reviews)</span>
                            </div>
                            <h2 class="font-bold text-4xl text-pink-600">{{ $bundle->formatted_price }}</h2>
                            
                            <!-- Add to Cart Button -->
                            <button onclick="addBundleToCart({{ $bundle->id }})" class="mt-4 bg-pink-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-pink-700 transition-all duration-300 transform hover:scale-105 flex items-center space-x-2 shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span>Add Bundle to Cart</span>
                            </button>
                    </div>
                </div>
                
                <div class="absolute top-0 right-0 w-20 h-20 md:w-40 md:h-40 bg-gradient-to-br from-pink-200 to-amber-200 opacity-30 rounded-full -mr-10 -mt-10 md:-mr-20 md:-mt-20 blur-xl"></div>
                <div class="absolute bottom-3 right-3 md:bottom-6 md:right-6 flex space-x-1 md:space-x-2">
                    <div class="w-2 h-6 md:w-3 md:h-8 bg-pink-400 rounded-full animate-pulse"></div>
                    <div class="w-2 h-8 md:w-3 md:h-10 bg-amber-400 rounded-full animate-pulse" style="animation-delay: 0.5s;"></div>
                    <div class="w-2 h-4 md:w-3 md:h-6 bg-orange-400 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section> 