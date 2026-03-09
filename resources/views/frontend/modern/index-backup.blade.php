@extends('frontend.layouts.app')

@section('content')
@php $lang = get_system_language()->code; @endphp

<style>
/* Boohooman Exact Styling */
.modern-hero { margin: 0; padding: 0; width: 100%; }
.modern-hero img { width: 100%; height: 600px; object-fit: cover; display: block; }
.modern-category-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0; margin: 0; padding: 0; }
.modern-category-item { position: relative; height: 700px; overflow: hidden; }
.modern-category-item img { width: 100%; height: 100%; object-fit: contain; background: #f5f5f5; }
.modern-category-name { position: absolute; bottom: 40px; left: 40px; font-size: 36px; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: 3px; text-shadow: 2px 2px 8px rgba(0,0,0,0.5); }
.modern-promo { background: #000; color: #fff; padding: 80px 20px; text-align: center; margin: 60px 0; }
.modern-promo h2 { font-size: 56px; font-weight: 900; letter-spacing: 6px; margin-bottom: 20px; }
.modern-promo p { font-size: 16px; font-weight: 600; letter-spacing: 2px; margin-bottom: 10px; }
.modern-promo-btn { display: inline-block; background: #fff; color: #000; padding: 16px 50px; font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; text-decoration: none; margin-top: 20px; }
.modern-section-title { text-align: center; font-size: 48px; font-weight: 900; text-transform: uppercase; letter-spacing: 4px; margin: 60px 0 40px; }
.modern-product-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 10px; max-width: 1400px; margin: 0 auto; }
.modern-product-item { position: relative; height: 400px; overflow: hidden; }
.modern-product-item img { width: 100%; height: 100%; object-fit: cover; }
.modern-product-price { position: absolute; bottom: 15px; left: 15px; background: #fff; padding: 8px 16px; font-size: 18px; font-weight: 900; color: #000; }
@media (max-width: 992px) {
    .modern-category-grid { grid-template-columns: repeat(2, 1fr); }
    .modern-product-grid { grid-template-columns: repeat(4, 1fr); }
    .modern-category-item { height: 500px; }
    .modern-product-item { height: 300px; }
}
@media (max-width: 576px) {
    .modern-category-grid { grid-template-columns: 1fr; }
    .modern-product-grid { grid-template-columns: repeat(2, 1fr); }
    .modern-category-item { height: 450px; }
    .modern-product-item { height: 250px; }
}
</style>

<!-- Hero Banner -->
@if (get_setting('home_slider_images', null, $lang) != null)
    @php
        $decoded_slider_images = json_decode(get_setting('home_slider_images', null, $lang), true);
        $sliders = get_slider_images($decoded_slider_images);
        $home_slider_links = get_setting('home_slider_links', null, $lang);
    @endphp
    @if(count($sliders) > 0)
        <div class="modern-hero">
            <a href="{{ isset(json_decode($home_slider_links, true)[0]) ? json_decode($home_slider_links, true)[0] : '#' }}">
                <img src="{{ $sliders[0] ? my_asset($sliders[0]->file_name) : static_asset('assets/img/placeholder.jpg') }}" alt="{{ env('APP_NAME') }}">
            </a>
        </div>
    @endif
@endif

<!-- Category Grid -->
@if (isset($featured_categories) && count($featured_categories) > 0)
    <div class="modern-category-grid">
        @foreach ($featured_categories->take(3) as $category)
            @php $category_name = $category->getTranslation('name'); @endphp
            <a href="{{ route('products.category', $category->slug) }}" class="modern-category-item">
                <img src="{{ isset($category->coverImage->file_name) ? my_asset($category->coverImage->file_name) : static_asset('assets/img/placeholder.jpg') }}" alt="{{ $category_name }}">
                <div class="modern-category-name">{{ strtoupper($category_name) }}</div>
            </a>
        @endforeach
    </div>
@endif

<!-- Promo Banner -->
<div class="modern-promo">
    <h2>BRAND LOCKER</h2>
    <p>GET FREE DELIVERY & 10% OFF YOUR FAVOURITES THIS YEAR</p>
    <p style="opacity: 0.8; font-size: 14px;">USE CODE: LOCKER10</p>
    <a href="#" class="modern-promo-btn">ENTER NOW</a>
</div>

<!-- Best Sellers -->
@php
    $best_sellers = filter_products(\App\Models\Product::query())
        ->where('published', 1)
        ->where('approved', 1)
        ->orderBy('num_of_sale', 'desc')
        ->limit(12)
        ->get();
@endphp
@if(count($best_sellers) > 0)
    <div style="padding: 0 20px;">
        <h2 class="modern-section-title">BEST SELLERS</h2>
        <div class="modern-product-grid">
            @foreach($best_sellers as $product)
                <a href="{{ route('product', $product->slug) }}" class="modern-product-item">
                    <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->getTranslation('name') }}">
                    <div class="modern-product-price">{{ format_price(home_base_price($product)) }}</div>
                </a>
            @endforeach
        </div>
    </div>
@endif

<!-- Secondary Category Grid -->
@if (isset($featured_categories) && count($featured_categories) > 3)
    <div class="modern-category-grid" style="margin-top: 60px;">
        @foreach ($featured_categories->slice(3)->take(3) as $category)
            @php $category_name = $category->getTranslation('name'); @endphp
            <a href="{{ route('products.category', $category->slug) }}" class="modern-category-item">
                <img src="{{ isset($category->coverImage->file_name) ? my_asset($category->coverImage->file_name) : static_asset('assets/img/placeholder.jpg') }}" alt="{{ $category_name }}">
                <div class="modern-category-name">{{ strtoupper($category_name) }}</div>
            </a>
        @endforeach
    </div>
@endif

<!-- New Arrivals -->
@php
    $new_arrivals = filter_products(\App\Models\Product::query())
        ->where('published', 1)
        ->where('approved', 1)
        ->orderBy('created_at', 'desc')
        ->limit(12)
        ->get();
@endphp
@if(count($new_arrivals) > 0)
    <div style="padding: 0 20px; margin-bottom: 60px;">
        <h2 class="modern-section-title">NEW ARRIVALS</h2>
        <div class="modern-product-grid">
            @foreach($new_arrivals as $product)
                <a href="{{ route('product', $product->slug) }}" class="modern-product-item">
                    <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->getTranslation('name') }}">
                    <div class="modern-product-price">{{ format_price(home_base_price($product)) }}</div>
                </a>
            @endforeach
        </div>
    </div>
@endif

@endsection
