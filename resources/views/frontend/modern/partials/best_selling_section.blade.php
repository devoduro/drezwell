@php
    $best_selling_products = get_best_selling_products(20);
@endphp
@if (get_setting('best_selling') == 1 && count($best_selling_products) > 0)
    <section class="best-sellers-section" style="background: #fff; padding: 80px 20px; margin: 0;">
        <div class="container" style="max-width: 1400px; margin: 0 auto;">
            <!-- Title -->
            <div class="text-center" style="margin-bottom: 60px;">
                <h2 style="font-family: 'Montserrat', sans-serif; font-size: 56px; font-weight: 900; text-transform: uppercase; letter-spacing: 6px; color: #000; margin: 0;">
                    {{ translate('BEST SELLERS') }}
                </h2>
            </div>
            <!-- Products Grid -->
            <div class="aiz-carousel best-sellers-grid" data-items="6" data-xl-items="6" data-lg-items="4" data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='false' data-infinite='false'>
                @foreach ($best_selling_products as $key => $product)
                <div class="carousel-box best-seller-item">
                    @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
