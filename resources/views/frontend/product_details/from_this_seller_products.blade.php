<div class="py-4 px-4 border bg-white border-light-gray" style="margin: 30px 0;">
    @php
        $shopslug = $detailedProduct->user->shop
            ? $detailedProduct->user->shop->slug
            : 'in-house';
    @endphp
    
    <!-- Section Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4" style="padding-bottom: 20px; border-bottom: 2px solid #000;">
        <h2 style="font-family: 'Montserrat', sans-serif; font-size: 28px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; color: #000; margin: 0;">
            {{ translate('Products from this Seller') }}
        </h2>
        <a href="{{ route('same_seller_products', $shopslug) }}" style="background: #000; color: #fff; padding: 12px 24px; text-decoration: none; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s ease;">
            {{ translate('View All') }} <i class="las la-angle-right"></i>
        </a>
    </div>

    <!-- Products Grid -->
    <div class="row" style="gap: 20px 0;">
        @forelse (get_same_seller_products($detailedProduct->user_id , 6) as $key => $same_seller_product)
        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
            <div style="background: #fff; border: 1px solid #e5e5e5; transition: all 0.3s ease;">
                <!-- Product Image -->
                <a href="{{ route('product', $same_seller_product->slug) }}" style="display: block; position: relative; width: 100%; padding-bottom: 140%; overflow: hidden; background: #fafafa;">
                    <img class="lazyload" 
                        src="{{ static_asset('assets/img/placeholder.jpg') }}" 
                        data-src="{{ uploaded_asset($same_seller_product->thumbnail_img) }}"
                        alt="{{ $same_seller_product->getTranslation('name') }}" 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                </a>
                
                <!-- Product Info -->
                <div style="padding: 15px;">
                    <h3 style="font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #333; margin-bottom: 8px; height: 36px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4;">
                        <a href="{{ route('product', $same_seller_product->slug) }}" style="color: #333; text-decoration: none; transition: color 0.3s ease;">
                            {{ $same_seller_product->getTranslation('name') }}
                        </a>
                    </h3>
                    <div style="font-size: 16px; font-weight: 900; color: #000;">
                        <span>{{ home_discounted_base_price($same_seller_product) }}</span>
                        @if (home_base_price($same_seller_product) != home_discounted_base_price($same_seller_product))
                            <del style="font-size: 13px; font-weight: 400; opacity: 0.6; margin-left: 5px;">{{ home_base_price($same_seller_product) }}</del>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-4">
            <h5 style="font-size: 16px; font-weight: 700; color: #666;">{{ translate('No products from this seller found!') }}</h5>
        </div>
        @endforelse
    </div>
    
    <style>
        .seller-products-section .col-lg-2 > div:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            transform: translateY(-4px);
            border-color: #000 !important;
        }
        .seller-products-section .col-lg-2 > div:hover img {
            transform: scale(1.08);
        }
        .seller-products-section h3 a:hover {
            color: #000 !important;
        }
    </style>
</div>