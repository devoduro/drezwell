<div class="py-4 px-4 border bg-white border-light-gray" style="margin: 30px 0;">
    <!-- Section Header -->
    <div class="mb-4" style="padding-bottom: 20px; border-bottom: 2px solid #000;">
        <h2 style="font-family: 'Montserrat', sans-serif; font-size: 28px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; color: #000; margin: 0;">
            {{ translate('Related Products') }}
        </h2>
    </div>

    <!-- Products Grid -->
    <div class="row" style="gap: 20px 0;">
        @forelse (get_related_products_by_category($detailedProduct->category_id) as $key => $related_product)
        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
            <div style="background: #fff; border: 1px solid #e5e5e5; transition: all 0.3s ease;">
                <!-- Product Image -->
                <a href="{{ route('product', $related_product->slug) }}" style="display: block; position: relative; width: 100%; padding-bottom: 140%; overflow: hidden; background: #fafafa;">
                    <img class="lazyload" 
                        src="{{ static_asset('assets/img/placeholder.jpg') }}" 
                        data-src="{{ uploaded_asset($related_product->thumbnail_img) }}"
                        alt="{{ $related_product->name }}" 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                </a>
                
                <!-- Product Info -->
                <div style="padding: 15px;">
                    <h3 style="font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #333; margin-bottom: 8px; height: 36px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4;">
                        <a href="{{ route('product', $related_product->slug) }}" style="color: #333; text-decoration: none; transition: color 0.3s ease;">
                            {{ $related_product->name }}
                        </a>
                    </h3>
                    <div style="font-size: 16px; font-weight: 900; color: #000;">
                        <span>{{ home_discounted_base_price($related_product) }}</span>
                        @if (home_base_price($related_product) != home_discounted_base_price($related_product))
                            <del style="font-size: 13px; font-weight: 400; opacity: 0.6; margin-left: 5px;">{{ home_base_price($related_product) }}</del>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-4">
            <h5 style="font-size: 16px; font-weight: 700; color: #666;">{{ translate('No related products found!') }}</h5>
            <span>
               <svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#e3e3e3"><path d="M626-533q22.5 0 38.25-15.75T680-587q0-22.5-15.75-38.25T626-641q-22.5 0-38.25 15.75T572-587q0 22.5 15.75 38.25T626-533Zm-292 0q22.5 0 38.25-15.75T388-587q0-22.5-15.75-38.25T334-641q-22.5 0-38.25 15.75T280-587q0 22.5 15.75 38.25T334-533Zm146.17 116Q413-417 358.5-379.5T278-280h53q22-42 62.17-65 40.18-23 87.5-23 47.33 0 86.83 23.5T630-280h52q-25-63-79.83-100-54.82-37-122-37ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 340q142.38 0 241.19-98.81Q820-337.63 820-480q0-142.38-98.81-241.19T480-820q-142.37 0-241.19 98.81Q140-622.38 140-480q0 142.37 98.81 241.19Q337.63-140 480-140Z"/></svg>
            </span>
        </div>
        @endforelse
    </div>
    
    <style>
        .related-products-section .col-lg-2 > div:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            transform: translateY(-4px);
            border-color: #000 !important;
        }
        .related-products-section .col-lg-2 > div:hover img {
            transform: scale(1.08);
        }
        .related-products-section h3 a:hover {
            color: #000 !important;
        }
    </style>
</div>