@php
    $brands = \App\Models\Brand::whereNotNull('logo')->where('logo', '!=', '')->get();
@endphp

@if($brands->isNotEmpty())
<section class="py-10 border-y border-gray-100 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-xs uppercase tracking-widest text-gray-400 font-medium mb-8">Brands We Carry</p>
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-14">
            @foreach($brands as $brand)
                <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" title="{{ $brand->name }}">
                        <img src="{{ str_starts_with($brand->logo, 'http') ? $brand->logo : Storage::disk('s3')->url($brand->logo) }}"
                             alt="{{ $brand->name }}"
                             class="h-8 w-auto object-contain grayscale hover:grayscale-0 opacity-60 hover:opacity-100 transition-all duration-200">
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif
