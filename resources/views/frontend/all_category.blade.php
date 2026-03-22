@extends('frontend.layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <section class="pt-4 mb-4">
        <div class="container text-center">
            <div class="row">
                <div class="col-lg-6 text-center text-lg-left">
                    <h1 class="fw-700 fs-20 fs-md-24 text-dark">
                        {{ translate('All Categories') }}
                    </h1>
                </div>
                <div class="col-lg-6">
                    <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                        <li class="breadcrumb-item has-transition opacity-60 hov-opacity-100">
                            <a class="text-reset" href="{{ route('home') }}">{{ translate('Home') }}</a>
                        </li>
                        <li class="text-dark fw-600 breadcrumb-item">
                            "{{ translate('All Categories') }}"
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- All Categories - Full Width Image Grid -->
    <section class="mb-0 pb-0" style="background: #000;">
        <div class="container-fluid p-0">
            <div class="row g-0">
                @foreach ($categories as $key => $category)
                    <div class="col-lg-4 col-md-6 col-sm-6 p-0">
                        <a href="{{ route('products.category', $category->slug) }}" class="category-image-card" style="display: block; position: relative; overflow: hidden; height: 600px; text-decoration: none;">
                            <!-- Category Image -->
                            <img src="{{ uploaded_asset($category->banner) }}" alt="{{ $category->getTranslation('name') }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;">
                            
                            <!-- Overlay -->
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 40px; background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);">
                                <h2 style="font-family: 'Montserrat', sans-serif; font-size: 48px; font-weight: 900; text-transform: uppercase; letter-spacing: 4px; color: #fff; margin: 0; text-shadow: 3px 3px 6px rgba(0,0,0,0.7);">
                                    {{ $category->getTranslation('name') }}
                                </h2>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        
        <style>
            .category-image-card:hover img {
                transform: scale(1.08);
            }
            .category-image-card:hover {
                box-shadow: inset 0 0 100px rgba(0,0,0,0.3);
            }
            
            @media (max-width: 992px) {
                .category-image-card {
                    height: 500px !important;
                }
                .category-image-card h2 {
                    font-size: 40px !important;
                }
            }
            
            @media (max-width: 768px) {
                .category-image-card {
                    height: 450px !important;
                }
                .category-image-card h2 {
                    font-size: 32px !important;
                    letter-spacing: 3px !important;
                }
            }
            
            @media (max-width: 576px) {
                .category-image-card {
                    height: 400px !important;
                }
                .category-image-card h2 {
                    font-size: 28px !important;
                    letter-spacing: 2px !important;
                    padding: 30px !important;
                }
            }
        </style>
    </section>
@endsection

@section('script')
    <script>
        $('.show-hide-cetegoty').on('click', function() {
            var el = $(this).siblings('ul');
            if (el.hasClass('less')) {
                el.removeClass('less');
                $(this).html('{{ translate('Less') }} <i class="las la-angle-up"></i>');
            } else {
                el.addClass('less');
                $(this).html('{{ translate('More') }} <i class="las la-angle-down"></i>');
            }
        });
    </script>
@endsection
