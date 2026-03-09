@extends('frontend.layouts.app')

@section('content')
@php $lang = get_system_language()->code; @endphp

<style>
/* Boohooman Exact Styling */
body { font-family: 'Montserrat', sans-serif !important; }
.modern-hero { margin: 0; padding: 0; width: 100%; }
.modern-hero img { width: 100%; height: 600px; object-fit: cover; display: block; }
.modern-category-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0 !important; margin: 0; padding: 0; }
.modern-category-item { position: relative; height: 700px; overflow: hidden; display: block; text-decoration: none; border: none !important; }
.modern-category-item img { width: 100%; height: 100%; object-fit: contain; background: #f5f5f5; }
.modern-category-name { position: absolute; bottom: 40px; left: 40px; font-size: 36px; font-weight: 900; color: #fff; text-transform: uppercase; letter-spacing: 3px; text-shadow: 2px 2px 8px rgba(0,0,0,0.5); }
.modern-promo { background: #000; color: #fff; padding: 80px 20px; text-align: center; margin: 0 0 60px 0; }
.modern-promo h2 { font-size: 56px; font-weight: 900; letter-spacing: 6px; margin-bottom: 20px; color: #fff; }
.modern-promo p { font-size: 16px; font-weight: 600; letter-spacing: 2px; margin-bottom: 10px; }
.modern-promo-btn { display: inline-block; background: #fff; color: #000; padding: 16px 50px; font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; text-decoration: none; margin-top: 20px; }
@media (max-width: 992px) {
    .modern-category-grid { grid-template-columns: repeat(2, 1fr); }
    .modern-category-item { height: 500px; }
}
@media (max-width: 576px) {
    .modern-category-grid { grid-template-columns: 1fr; }
    .modern-category-item { height: 450px; }
}
</style>

<!-- Hero Banner -->
@if (get_setting('home_slider_images', null, $lang) != null)
    @php
        $decoded_slider_images = json_decode(get_setting('home_slider_images', null, $lang), true);
        $sliders = get_slider_images($decoded_slider_images);
        $home_slider_links = get_setting('home_slider_links', null, $lang);
    @endphp
    @if(is_array($sliders) && count($sliders) > 0)
        <div class="modern-hero">
            <a href="{{ isset(json_decode($home_slider_links, true)[0]) ? json_decode($home_slider_links, true)[0] : '#' }}">
                <img src="{{ $sliders[0] ? my_asset($sliders[0]->file_name) : static_asset('assets/img/placeholder.jpg') }}" alt="{{ env('APP_NAME') }}">
            </a>
        </div>
    @endif
@endif


<!-- Category Grid with Banner -->
<div class="modern-category-grid">
    @if (isset($featured_categories) && count($featured_categories) > 0)
        @foreach ($featured_categories->take(2) as $category)
            @php $category_name = $category->getTranslation('name'); @endphp
            <a href="{{ route('products.category', $category->slug) }}" class="modern-category-item">
                <img src="{{ isset($category->coverImage->file_name) ? my_asset($category->coverImage->file_name) : static_asset('assets/img/placeholder.jpg') }}" alt="{{ $category_name }}">
                <div class="modern-category-name">{{ strtoupper($category_name) }}</div>
            </a>
        @endforeach
    @endif
    <!-- Banner on Right -->
    <a href="#" class="modern-category-item" style="background: #f5f5f5;">
        <img src="{{ static_asset('assets/img/dbz_prod_f70016d574_BMW_COMP_SITE_BANNER_DESK_1920x270.webp') }}" alt="BMW Banner" style="width: 100%; height: 100%; object-fit: cover; display: block;">
    </a>
</div>

<!-- Promo Banner -->
<div class="modern-promo">
    <h2>BRAND LOCKER</h2>
    <p>GET FREE DELIVERY & 10% OFF YOUR FAVOURITES THIS YEAR</p>
    <p style="opacity: 0.8; font-size: 14px;">USE CODE: LOCKER10</p>
    <a href="#" class="modern-promo-btn">ENTER NOW</a>
</div>

<!-- All Categories Grid -->
@if (isset($featured_categories) && count($featured_categories) > 0)
    <div class="modern-category-grid">
        @foreach ($featured_categories as $category)
            @php $category_name = $category->getTranslation('name'); @endphp
            <a href="{{ route('products.category', $category->slug) }}" class="modern-category-item">
                <img src="{{ isset($category->coverImage->file_name) ? my_asset($category->coverImage->file_name) : static_asset('assets/img/placeholder.jpg') }}" alt="{{ $category_name }}">
                <div class="modern-category-name">{{ strtoupper($category_name) }}</div>
            </a>
        @endforeach
    </div>
@endif


<!-- Full Width Banner - Boohooman Style -->
<section style="background: #fff; margin: 0; padding: 0;">
    <div style="max-width: 1400px; margin: 0 auto; padding: 0 20px;">
        
        <a href="#" style="display: block; width: 100%; overflow: hidden; text-decoration: none;">
            <img src="{{ static_asset('assets/img/dbz_prod_bcb376520c_2601_STUDENT_SERVICE_EXTRA15_ENG_DESKK.webp') }}" alt="Student Service Banner" style="width: 100%; height: auto; display: block; object-fit: contain;">
        </a>
    </div>
</section>

<!-- NEW IN Products Section - Enhanced -->
@php
    $all_products = filter_products(\App\Models\Product::query())
        ->where('published', 1)
        ->where('approved', 1)
        ->orderBy('created_at', 'desc')
        ->limit(30)
        ->get();
@endphp
@if(count($all_products) > 0)
    <section class="new-in-section" style="background: #fff; padding: 80px 20px; margin: 0;">
        <div style="max-width: 1400px; margin: 0 auto;">
            <!-- Title -->
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-family: 'Montserrat', sans-serif; font-size: 56px; font-weight: 900; text-transform: uppercase; letter-spacing: 6px; color: #000; margin: 0;">
                    NEW IN
                </h2>
            </div>
            <!-- Products Carousel -->
            <div class="aiz-carousel new-in-carousel" data-items="5" data-xl-items="5" data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='false'>
                @foreach($all_products as $product)
                    <div class="carousel-box new-in-item">
                        <a href="{{ route('product', $product->slug) }}" style="position: relative; height: 550px; overflow: hidden; display: block; text-decoration: none; background: #f9f9f9; transition: all 0.3s ease;">
                            <img src="{{ uploaded_asset($product->thumbnail_img) }}" alt="{{ $product->getTranslation('name') }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                            <!-- Product Info Overlay -->
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, transparent 100%); padding: 30px 20px 20px;">
                                <!-- Product Name -->
                                <div style="color: #fff; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $product->getTranslation('name') }}
                                </div>
                                <!-- Price Tag -->
                                <div style="background: #fff; padding: 10px 20px; font-size: 18px; font-weight: 900; color: #000; letter-spacing: 1px; display: inline-block; box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                                    @php
                                        $price = home_base_price($product);
                                        echo is_numeric($price) ? format_price($price) : $price;
                                    @endphp
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- GET THE LOOK Section -->
<section style="background: #fff; padding: 80px 20px; margin: 0;">
    <div style="max-width: 1400px; margin: 0 auto;">
        <!-- Title -->
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-family: 'Montserrat', sans-serif; font-size: 56px; font-weight: 900; text-transform: uppercase; letter-spacing: 6px; color: #000; margin: 0;">
                GET THE LOOK
            </h2>
        </div>
        <!-- Category Grid -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 80px;">
            @if (isset($featured_categories) && count($featured_categories) > 0)
                @foreach ($featured_categories->take(4) as $category)
                    @php $category_name = $category->getTranslation('name'); @endphp
                    <a href="{{ route('products.category', $category->slug) }}" style="position: relative; height: 600px; overflow: hidden; display: block; text-decoration: none; transition: transform 0.3s ease;">
                        <img src="{{ isset($category->coverImage->file_name) ? my_asset($category->coverImage->file_name) : static_asset('assets/img/placeholder.jpg') }}" alt="{{ $category_name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; bottom: 30px; left: 30px; right: 30px; text-align: center;">
                            <div style="background: rgba(255,255,255,0.95); padding: 20px; font-size: 24px; font-weight: 900; color: #000; text-transform: uppercase; letter-spacing: 3px;">
                                {{ strtoupper($category_name) }}
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Email Signup Section -->
<section style="background: #000; color: #fff; padding: 80px 20px; margin: 0;">
    <div style="max-width: 800px; margin: 0 auto; text-align: center;">
        <h2 style="font-family: 'Montserrat', sans-serif; font-size: 42px; font-weight: 900; text-transform: uppercase; letter-spacing: 4px; margin-bottom: 20px;">
            LET'S GET TO KNOW EACH OTHER
        </h2>
        <p style="font-size: 16px; font-weight: 400; margin-bottom: 40px; line-height: 1.6;">
            Sign up to receive emails from us, so you never miss out on the good stuff.
        </p>
        <form action="{{ route('subscribers.store') }}" method="POST" style="max-width: 600px; margin: 0 auto;">
            @csrf
            <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                <input type="email" name="email" placeholder="Please enter your email address" required style="flex: 1; padding: 18px 24px; font-size: 16px; border: none; background: #fff; color: #000; font-family: 'Montserrat', sans-serif;">
                <button type="submit" style="padding: 18px 40px; background: #fff; color: #000; border: none; font-size: 16px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; cursor: pointer; font-family: 'Montserrat', sans-serif; transition: background 0.3s ease;">
                    SUBSCRIBE
                </button>
            </div>
            <p style="font-size: 12px; opacity: 0.8; line-height: 1.6; margin-top: 20px;">
                By submitting your details, you agree to receive marketing communications from {{ env('APP_NAME') }} & our family of brands by email. You can unsubscribe at any point. You also consent to the use of your details in accordance with our Privacy Policy.
            </p>
        </form>
    </div>
</section>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $.post('{{ route('home.section.featured') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_featured').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.best_selling') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });
        });
    </script>
@endsection
