@extends('frontend.layouts.app')

@section('content')
@php $lang = get_system_language()->code; @endphp

<style>
/* Modern Homepage Styles */
.modern-hero {
    position: relative;
    width: 100%;
    height: 600px;
    overflow: hidden;
}

.modern-hero img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.modern-hero-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    z-index: 10;
}

.modern-hero-title {
    font-size: 72px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 8px;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
    margin-bottom: 10px;
}

.modern-hero-subtitle {
    font-size: 18px;
    font-weight: 600;
    color: #fff;
    letter-spacing: 2px;
    margin-bottom: 30px;
}

.modern-btn {
    background: #fff;
    color: #000;
    padding: 16px 50px;
    font-size: 14px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
}

.modern-btn:hover {
    background: #000;
    color: #fff;
}

.modern-category-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0;
    margin: 0;
}

.modern-category-item {
    position: relative;
    height: 700px;
    overflow: hidden;
}

.modern-category-item img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #f5f5f5;
}

.modern-category-name {
    position: absolute;
    bottom: 40px;
    left: 40px;
    font-size: 32px;
    font-weight: 900;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 3px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
}

.modern-product-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 10px;
    padding: 40px 0;
}

.modern-product-item {
    position: relative;
    height: 350px;
    overflow: hidden;
}

.modern-product-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.modern-product-price {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: #fff;
    padding: 8px 16px;
    font-size: 18px;
    font-weight: 900;
    color: #000;
}

.modern-promo-banner {
    background: #000;
    color: #fff;
    padding: 80px 20px;
    text-align: center;
    margin: 60px 0;
}

.modern-promo-title {
    font-size: 56px;
    font-weight: 900;
    letter-spacing: 6px;
    margin-bottom: 20px;
}

.modern-promo-text {
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 2px;
    margin-bottom: 30px;
}

@media (max-width: 992px) {
    .modern-category-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .modern-product-grid {
        grid-template-columns: repeat(4, 1fr);
    }
    .modern-category-item {
        height: 500px;
    }
}

@media (max-width: 576px) {
    .modern-category-grid {
        grid-template-columns: 1fr;
    }
    .modern-product-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .modern-hero-title {
        font-size: 42px;
        letter-spacing: 4px;
    }
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
            <img src="{{ $sliders[0] ? my_asset($sliders[0]->file_name) : static_asset('assets/img/placeholder.jpg') }}" 
                 alt="{{ env('APP_NAME') }}">
            <div class="modern-hero-overlay">
                <h1 class="modern-hero-title">NEW ARRIVALS</h1>
                <p class="modern-hero-subtitle">SHOP THE LATEST COLLECTION</p>
                <a href="{{ isset(json_decode($home_slider_links, true)[0]) ? json_decode($home_slider_links, true)[0] : '#' }}" 
                   class="modern-btn">SHOP NOW</a>
            </div>
        </div>
    @endif
@endif

<!-- Featured Categories -->
@if (count($featured_categories) > 0)
    <section style="margin: 0; padding: 0;">
        <div class="modern-category-grid">
            @foreach ($featured_categories->take(3) as $category)
                @php $category_name = $category->getTranslation('name'); @endphp
                <a href="{{ route('products.category', $category->slug) }}" class="modern-category-item">
                    <img src="{{ isset($category->coverImage->file_name) ? my_asset($category->coverImage->file_name) : static_asset('assets/img/placeholder.jpg') }}" 
                         alt="{{ $category_name }}">
                    <div class="modern-category-name">{{ strtoupper($category_name) }}</div>
                </a>
            @endforeach
        </div>
    </section>
@endif

<!-- Promotional Banner -->
<div class="modern-promo-banner">
    <h2 class="modern-promo-title">BRAND LOCKER</h2>
    <p class="modern-promo-text">GET FREE DELIVERY & 10% OFF YOUR FAVOURITES THIS YEAR</p>
    <a href="#" class="modern-btn">ENTER NOW</a>
</div>

<!-- Best Sellers / Featured Products -->
@php
    $newest_products = filter_products(\App\Models\Product::query())
        ->where('published', 1)
        ->where('approved', 1)
        ->orderBy('created_at', 'desc')
        ->limit(12)
        ->get();
@endphp

@if(count($newest_products) > 0)
    <section class="container-fluid" style="padding: 0 20px;">
        <h2 style="text-align: center; font-size: 48px; font-weight: 900; text-transform: uppercase; letter-spacing: 4px; margin: 60px 0 40px;">BEST SELLERS</h2>
        
        <div class="modern-product-grid">
            @foreach($newest_products as $product)
                <a href="{{ route('product', $product->slug) }}" class="modern-product-item">
                    <img src="{{ uploaded_asset($product->thumbnail_img) }}" 
                         alt="{{ $product->getTranslation('name') }}">
                    <div class="modern-product-price">
                        {{ format_price(home_base_price($product)) }}
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endif

<!-- Secondary Categories Grid -->
@if (count($featured_categories) > 3)
    <section style="margin: 60px 0; padding: 0;">
        <div class="modern-category-grid">
            @foreach ($featured_categories->slice(3)->take(3) as $category)
                @php $category_name = $category->getTranslation('name'); @endphp
                <a href="{{ route('products.category', $category->slug) }}" class="modern-category-item">
                    <img src="{{ isset($category->coverImage->file_name) ? my_asset($category->coverImage->file_name) : static_asset('assets/img/placeholder.jpg') }}" 
                         alt="{{ $category_name }}">
                    <div class="modern-category-name">{{ strtoupper($category_name) }}</div>
                </a>
            @endforeach
        </div>
    </section>
@endif

@endsection
