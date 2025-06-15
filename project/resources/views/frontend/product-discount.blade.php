<style>
    /* Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        font-size: 62.5%;
        font-family: "DM Sans", sans-serif;
    }

    body {
        background-color: #ffffff;
        color: #333333;
        line-height: 1.6;
    }

    /* Universal Responsive Values */
    :root {
        --section-padding: 4rem;
        --heading-1: 7rem;
        --heading-2: 4.8rem;
        --body-text: 1.8rem;
        --primary-color: #001F3F;
        --accent-color: #800080;
        --text-muted: #727272;
        --background-light: #f6f6f6;
    }

    @media (max-width: 1200px) {
        :root {
            --heading-1: 6rem;
            --heading-2: 4rem;
        }
    }

    @media (max-width: 992px) {
        :root {
            --heading-1: 5rem;
            --heading-2: 3.5rem;
            --section-padding: 3rem;
        }
    }

    @media (max-width: 768px) {
        :root {
            --heading-1: 4rem;
            --heading-2: 3rem;
            --body-text: 1.6rem;
            --section-padding: 2rem;
        }
    }

    @media (max-width: 480px) {
        :root {
            --heading-1: 3.2rem;
            --heading-2: 2.5rem;
            --body-text: 1.4rem;
            --section-padding: 1.5rem;
        }
    }

    /* Content Box */
    .content-box {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Item Display */
    .item-display {
        display: flex;
        flex-wrap: wrap;
        padding: 20px 0;
        padding-bottom: 0;
        gap: 30px;
    }

    /* Image Gallery */
    .image-gallery {
        flex: 1;
        min-width: 300px; /* Changed from 250px */
        max-width: 600px; /* Changed from 500px */
        position: relative;
    }

    .image-container {
        position: relative;
        width: 100%;
    }

    .primary-image {
        width: 100%;
        max-height: 500px; /* Changed from 400px */
        height: auto;
        display: block;
        object-fit: contain; /* Ensure image scales properly */
    }

    .image-previews {
        display: flex;
        margin-top: 10px;
        gap: 5px;
        justify-content: center;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }

    .preview-image {
        width: 80px; /* Changed from 60px */
        height: 60px; /* Changed from 45px */
        border: 1px solid #ddd;
        cursor: pointer;
        object-fit: cover;
    }

    .preview-image.active {
        border: 2px solid #800080;
    }

    .product-cards-slider .slick-track {
        padding-bottom: 20px;
    }

    .slide-prev,
    .slide-next {
        position: absolute;
        top: 60%;
        z-index: 1;
        transform: translateY(-50%);
        background-color: #ffffff2e;
        border: none;
        border-radius: 60%;
        width: 40px;
        height: 40px;
        font-size: 24px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .slide-prev:hover,
    .slide-next:hover {
        background-color: rgba(255, 255, 255, 1);
    }

    .slide-prev {
        left: 0px;
    }

    .slide-next {
        right: 0px;
    }

    /* Item Details */
    .item-details {
        flex: 1;
        min-width: 300px;
        padding-left: 40px;
    }

    .item-name {
        font-size: 36px; /* Reduced from 32px */
        font-weight: 600;
        margin-bottom: 12px;
        color: #000000;
    }

    .item-cost {
        font-size: 22px; /* Reduced from 26px */
        font-weight: 500;
        margin-bottom: 20px;
    }

    .item-cost .individual-price {
        font-size: 2.5rem;
    }

    .item-cost a {
        width: 100%;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        color: rgb(0, 0, 0);
        font-family: Inter, sans-serif;
        font-size: 1.5rem;
        font-weight: 500;
        cursor: pointer;
    }

    .item-desc {
        font-size: 16px;
        color: #333333;
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .item-size {
        font-size: 16px;
        color: #666666;
        margin-bottom: 20px;
    }

    .suggestion-area {
        margin-bottom: 20px;
    }

    .suggestion-header {
        font-size: 12px; /* Reduced from 14px */
        font-weight: 600;
        margin-bottom: 10px;
        color: #333333;
    }

    .skin-categories {
        display: flex;
        gap: 15px;
    }

    .skin-category {
        display: flex;
        align-items: center;
        font-size: 15px;
    }

    .selected-dot {
        display: inline-block;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #eee;
        margin-right: 5px;
        position: relative;
    }

    .selected-dot::after {
        content: "✓";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 10px;
        color: #555;
    }

    /* Count Section */
    .count-section {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .count-label {
        font-size: 16px;
        font-weight: 500;
    }

    .count-controls {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
    }

    .count-decrement,
    .count-increment {
        min-width: 40px;
        min-height: 40px;
        background: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 50%;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .count-field {
        width: 40px;
        text-align: center;
        border: none;
        font-size: 18px;
        margin: 0 10px;
    }

    .cost-display {
        font-size: 18px;
        font-weight: 500;
        color: #800080;
    }

    .cost-display .individual-price {
        font-size: 2.5rem;
    }

    /* Action Options */
    .action-options {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .add-basket-btn {
        flex: 1;
        padding: 15px;
        background-color: #00223d;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .add-basket-btn:hover {
        background-color: #003866;
        transform: translateY(-2px);
    }

    .buy-now-anchor {
        flex: 1;
    }

    .purchase-btn {
        flex: 1;
        padding: 15px;
        background-color: #800080;
        color: white;
        border: none;
        border-radius: 5px;
        width: 100%;
        cursor: pointer;
        font-weight: 500;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .purchase-btn:hover {
        background-color: #6A0DAD;
        transform: translateY(-2px);
    }

    .favorite-btn {
        width: 46px;
        height: 46px;
        background-color: #800080;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.3s ease;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    .favorite-btn:hover {
        background-color: #6A0DAD;
    }

    /* Expandable Sections */
    .expand-section {
        margin-top: 20px;
    }

    .expand-item {
        border-top: 1px solid #eee;
    }

    .expand-header {
        padding: 15px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        font-weight: 500;
        font-size: 13px; /* Reduced from 15px */
        text-transform: uppercase !important;
    }

    .expand-content {
        padding: 0 0 15px;
        display: none;
        font-size: 16px;
        color: #555;
    }

    /* Research Results */
    .research-results {
        margin-top: 30px;
    }

    .research-part {
        padding: 15px 0;
        background-color: #f9f9f9;
        margin-bottom: 10px;
    }

    .research-title {
        font-size: 16px; /* Reduced from 18px */
        font-weight: 600;
        margin-bottom: 10px;
        padding: 0 15px;
    }

    .research-text {
        padding: 0 15px;
        font-size: 16px;
        color: #555;
    }

    .results-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .result-block {
        padding: 15px;
        background-color: #f9f9f9;
    }

    .result-block h3 {
        font-size: 16px; /* Reduced from 18px */
        font-weight: 600;
        margin-bottom: 10px;
    }

    .result-block p {
        font-size: 16px;
        color: #555;
    }

    /* Breadcrumb */
    .product-breadcrumb {
        list-style: none;
        display: flex;
        padding: 10px 0;
        font-size: 16px;
        color: #666;
    }

    .product-breadcrumb li {
        margin-right: 10px;
    }

    .product-breadcrumb li a {
        text-decoration: none;
        color: #666;
    }

    .product-breadcrumb li a:hover {
        color: #800080;
    }

    /* Single Product Card */
    .single-product {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .single-product:hover {
        transform: translateY(-8px);
    }

    .img-wrapper {
        position: relative;
        padding: 1.5rem;
    }

    .product-img {
        width: 100%;
        height: 250px; /* Reduced from 300px */
        object-fit: contain;
        border-radius: 8px;
    }

    .product-badge {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        background: var(--accent-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 1.25rem;
        font-weight: 700;
        z-index: 1;
    }

    .product-actions {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        display: flex;
        gap: 0.5rem;
        z-index: 2;
    }

    .action-btn {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        background: #800080;
        transform: scale(1.1);
    }

    .action-btn.active {
        background: var(--accent-color);
    }

    .action-btn.active svg path {
        stroke: #fff;
        fill: #fff;
    }

    .action-btn svg {
        width: 24px;
        height: 24px;
    }

    .action-btn svg path {
        stroke: var(--primary-color);
        fill: none;
        transition: all 0.3s ease;
    }

    .action-btn:hover svg path,
    .action-btn svg:hover path {
        stroke: #0d6efd;
        fill: none;
    }

    .action-btn.danger {
        background: #dc3545;
    }

    .action-btn.danger i {
        color: white;
        font-size: 1.25rem;
    }

    .add-to-cart {
        position: absolute;
        bottom: 1.5rem;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 3rem);
        opacity: 0;
        margin-left: 5px;
        transition: opacity 0.3s ease;
    }

    .single-product:hover .add-to-cart {
        opacity: 1;
    }

    .add_to_cart_button {
        display: block;
        text-decoration: none;
    }

    .add-cart {
        background: var(--accent-color);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        text-align: center;
        font-size: 1.25rem;
        font-weight: 600;
        transition: background 0.3s ease;
    }

    .add-cart:hover {
        background: #6A0DAD;
    }

    .add-cart.disabled {
        background: #6c757d;
        cursor: not-allowed;
    }

    .product-info {
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .product-name {
        flex: 1;
        color: var(--primary-color);
        font-size: 1.25rem; /* Reduced from 1.5rem */
        font-weight: 600;
        line-height: 1.4;
        margin: 0;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-pricelabel {
        text-align: right;
    }

    .current-price {
        display: block;
        color: var(--accent-color);
        font-weight: 700;
        font-size: 1.5rem; /* Reduced from 1.75rem */
    }

    .original-price {
        display: block;
        color: #6c757d;
        font-size: 1rem; /* Reduced from 1.25rem */
    }

    /* Price Scheme Select */
    .price-scheme-select {
        width: 100%;
        padding: 8px 15px;
        border: 1px solid #d4d4d4;
        border-radius: 8px;
        background-color: #800080;
        color: white;
        font-family: Inter, sans-serif;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpath d='M6 9l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 18px;
    }

    .price-scheme-select:focus {
        outline: none;
        border-color: #6A0DAD;
        box-shadow: 0 0 0 2px rgba(128, 0, 128, 0.3);
    }

    .price-scheme-select option {
        background-color: white;
        color: #001F3F;
        font-size: 16px;
    }

    /* Product Cards Slider */
    .product-cards-slider {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 3rem;
        padding: var(--section-padding);
    }

    /* Explore Tab Navbar */
    .explore-tab-navbar {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .explore-tab-navbar .nav-item {
        margin: 0;
    }

    .explore-tab-navbar .nav-link {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--primary-color);
        background: #EDEDED;
        border: 1px solid #DFDFDF;
        border-radius: 11px;
        padding: 1rem 2;
    }
    .zoom-container {
        position: relative;
        overflow: hidden;
    }

    .primary-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.1s ease;
        transform-origin: center center;
    }

</style>

@extends('layouts.front')
    @php
        $tags = $productt->tags;

        $query = App\Models\Product::where('id', '!=', $productt->id) // exclude the current product
            ->where('type', $productt->type)
            ->where('product_type', $productt->product_type);

        if (!empty($tags)) {
            $query->where(function ($q) use ($tags) {
                foreach ($tags as $tag) {
                    $q->orWhere('tags', 'LIKE', "%{$tag}%");
                }
            });
        }

        $products = $query->withCount('ratings')
                        ->withAvg('ratings', 'rating')
                        ->take(12)
                        ->get();
    @endphp

@section('content')
    <!-- breadcrumb start -->
    {{-- <section class="gs-breadcrumb-section bg-class" data-background="{{ asset('assets/svg/banner.png') }}">
        <div class="container">
            <div class="row justify-content-center content-wrapper">
                <div class="col-12">
                    <h2 class="breadcrumb-title">@lang('Product')</h2>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- breadcrumb end -->

    <!-- Modal start -->
    <div class="modal fade" id="discountSlabModal" tabindex="-1" aria-labelledby="discountSlabModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Discount Slabs</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($discountSlab->isEmpty())
                        <p>No active discount slabs available.</p>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Min Value</th>
                                    <th>Max Value</th>
                                    <th>Discount (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discountSlab as $slab)
                                    <tr>
                                        <td>{{ $slab->id }}</td>
                                        <td>{{ number_format($slab->min_value) }}</td>
                                        <td>{{ $slab->max_value ? number_format($slab->max_value) : 'Above ' . number_format($slab->min_value) }}</td>
                                        <td>{{ $slab->discount_percentage }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="alert alert-info mt-3">
                            <p class="mb-1"><strong>Note:</strong> The discount slabs shown above are automatically applied during checkout.</p>
                            <p class="mb-0">These discounts apply to the total value of your cart, not individual items.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->

    <!-- single product details content wrapper start -->


    <div class="product-page-wrapper" >
        <div class="content-box">
            <div class="item-display">
                <div class="image-gallery">
                    <div class="image-container zoom-wrapper">
                        <button class="slide-prev">‹</button>
                        <div class="zoom-container">
                            <img src="{{ filter_var($productt->photo, FILTER_VALIDATE_URL) ? $productt->photo : asset('assets/images/products/' . $productt->photo) }}"
                                alt="{{ $productt->name }}" class="primary-image" />
                        </div>
                        <button class="slide-next">›</button>
                    </div>
                    <div class="image-previews">
                        <img src="{{ filter_var($productt->photo, FILTER_VALIDATE_URL) ? $productt->photo : asset('assets/images/products/' . $productt->photo) }}"
                            alt="Main View" class="preview-image" />
                        @foreach ($productt->galleries as $gal)
                            <img src="{{ asset('assets/images/galleries/' . $gal->photo) }}" alt="Gallery View"
                                class="preview-image" />
                        @endforeach
                    </div>
                </div>
                <div class="item-details">
                    <h1 class="item-name">{{ $productt->name }}</h1>
                    <p>{!! $productt->details !!}</p>
                    @if (Auth::check())
                        <div class="item-cost">
                            {!! $productt->showPrice() !!}
                            <a class="" data-bs-toggle="modal" data-bs-target="#discountSlabModal" style="cursor: pointer;">
                                (View Discount Slabs)
                            </a>
                        </div>
                    @else
                        <div class="item-cost"> ₹ XXXX</div>
                    @endif

                    @if (Auth::check())
                        <div class="count-section product-counter">
                            <div class="count-label">Quantity</div>
                            <div class="count-controls">
                                <button class="count-decrement custom-btn-decrease">−</button>
                                <input type="text" value="{{ $productt->minimum_qty ?? 1 }}" class="count-field custom-input" />
                                <button class="count-increment custom-btn-increase">+</button>
                            </div>
                            {{-- <div class="cost-display">{!! $productt->showPrice() !!}</div> --}}
                        </div>
                    @endif

                    @if (Auth::check())
                        <div class="action-options">
                            <button class="add-basket-btn add_cart_click"
                                data-href="{{ route('product.cart.add', $productt->id) }}"
                                data-product-id="{{ $productt->id }}"
                                data-product-quantity="1"
                                >
                                @lang('Add to cart')
                            </button>
                            @if ($productt->emptyStock())
                                <button class="purchase-btn" disabled>
                                    {{ __('Out of Stock') }}
                                </button>
                            {{-- @else
                                <a class="buy-now-anchor" href="{{ route('front.cart') }}">
                                    <button class="purchase-btn" disabled data-product-id="{{ $productt->id }}"
                                        data-scheme-id="{{ $productt->id }}">
                                        @lang('Buy Now')
                                    </button>
                                </a> --}}
                            @endif

                            {{-- <button class="favorite-btn" style="color: black">
                                <svg style="color: #000000" width="24" height="25" viewBox="0 0 24 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.1111 3.5C19.6333 3.5 22 6.8525 22 9.98C22 16.3138 12.1778 21.5 12 21.5C11.8222 21.5 2 16.3138 2 9.98C2 6.8525 4.36667 3.5 7.88889 3.5C9.91111 3.5 11.2333 4.52375 12 5.42375C12.7667 4.52375 14.0889 3.5 16.1111 3.5Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                    </path>
                                </svg>
                            </button> --}}

                            <button class="favorite-btn custom-wishlist"
                            data-href="{{ wishlistCheck($productt->id) ? route('user-wishlist-remove', App\Models\Wishlist::where('user_id', '=', Auth::id())->where('product_id', '=', $productt->id)->first()->id) : route('user-wishlist-add', $productt->id) }}"
                            data-toggle="{{ wishlistCheck($productt->id) ? 'remove' : 'add' }}"
                            data-product-id="{{ $productt->id }}"
                            style="background: white ;width: 46px; height: 46px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;"
                            >
                            <svg class="{{ wishlistCheck($productt->id) ? 'active' : '' }}"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="{{ wishlistCheck($productt->id) ? '#800080' :'none'}}">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z"
                                    stroke="#800080" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        </div>
                    @endif

                    <!-- Unified Expandable Section -->
                    <div class="expand-section">
                        @if ($productt->description)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Product Description') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->description !!}
                                </div>
                            </div>
                        @endif

                        @if ($productt->safety_information)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Safety Information') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->safety_information !!}
                                </div>
                            </div>
                        @endif

                        @if ($productt->clinical_evidences)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Clinical Evidences') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->clinical_evidences !!}
                                </div>
                            </div>
                        @endif

                        @if ($productt->usage_instructions)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Usage Instructions') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->usage_instructions !!}
                                </div>
                            </div>
                        @endif

                        @if ($productt->ingredients)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Key Ingredients') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->ingredients !!}
                                </div>
                            </div>
                        @endif

                        @if ($productt->technology)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Technology') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->technology !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- single product details content wrapper end -->
    {{-- <div class="container">
            <img src="{{ asset('assets/svg/big.png') }}" alt="big-img" style="max-width: 100%; height: auto">
        </div> --}}

    <!-- Related Products slider start -->
    {{-- <div class="gs-product-cards-slider-area wow-replaced" data-wow-delay=".1s">
            <div class="container">
                <h2 class="title text-center">@lang('Related Products')</h2>
                <div class="product-cards-slider">
                    @foreach (App\Models\Product::where('type', $productt->type)->where('product_type', $productt->product_type)->withCount('ratings')->withAvg('ratings', 'rating')->take(12)->get() as $product)
                        @include('includes.frontend.home_product', ['class' => 'not'])
                    @endforeach
                </div>
            </div>
        </div> --}}
    <!-- Related Products slider end -->

    <div class="tab-product-des-wrapper wow-replaced" data-wow-delay=".1s">
        <div class="container">

            <div class="tab-content" id="myTabContent">
                {{-- <div class="tab-pane show active wow-replaced" data-wow-delay=".1s" id="description-tab-pane"
                    role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                    {!! clean($productt->details, ['Attr.EnableID' => true]) !!}
                </div>
                <div class="tab-pane fade" id="buy-return-policy-tab-pane" role="tabpanel"
                    aria-labelledby="buy-return-policy-tab" tabindex="0">
                    {!! clean($productt->policy, ['Attr.EnableID' => true]) !!}
                </div> --}}

                <!-- Reviews tab content start  -->
                <div class="tab-pane fade active show" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab"
                    tabindex="0">
                    <div class="row review-tab-content-wrapper">
                        <div class="col-xxl-8">
                            <div id="comments">
                                <h5 class="woocommerce-Reviews-titleDDD my-3" style="font-size: 36px"> @lang('Ratings & Reviews')</h5>
                                <ul class="all-comments">
                                    @forelse($productt->ratings() as $review)
                                        <li>
                                            <div class="single-comment">
                                                <div class="left-area">
                                                    <img src="{{ $review->user->photo ? asset('assets/images/users/' . $review->user->photo) : asset('assets/images/' . $gs->user_image) }}"
                                                        alt="">
                                                    <p class="name text-lg">
                                                        {{ $review->user->name }}
                                                    </p>
                                                    <div class="reating-area">
                                                        <div class="stars"><span
                                                                id="star-rating">{{ $review->rating }}</span> <i
                                                                class="fas fa-star"></i></div>
                                                        <p class="date">
                                                            {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->review_date)->diffForHumans() }}
                                                        </p>
                                                    </div>

                                                </div>
                                                <div class="right-area">
                                                    <div class="comment-body">
                                                        <p>
                                                            {{ $review->review }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li>
                                            <div class="single-comment">
                                                <div class="left-area">
                                                    <p class="name text-lg">
                                                        @lang('No Review Found')
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>


                            @if (Auth::check())
                                <div id="review_form_wrapper">

                                    <div class="review-area">

                                        <h5 class="title">@lang('Reviews')</h5>
                                        <div class="star-area">
                                            <ul class="star-list">
                                                <li class="stars" data-val="1">
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars" data-val="2">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars" data-val="3">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars" data-val="4">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars active" data-val="5">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>


                                    <div class="write-comment-area">

                                        <form action="{{ route('front.review.submit') }}"
                                            data-href="{{ route('front.reviews', $productt->id) }}"
                                            data-side-href="{{ route('front.side.reviews', $productt->id) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" id="rating" name="rating" value="5">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="product_id" value="{{ $productt->id }}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <textarea name="review" placeholder="{{ __('Write Your Review *') }}" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button class="template-btn" style="height: unset; padding: 1.2rem 1.5rem;"
                                                        type="submit">{{ __('Submit') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <h5 class="text-center">
                                    <a href="{{ route('user.login') }}" class="btn login-btn mr-1">
                                        {{ __('Login') }}
                                    </a>
                                    {{ __('To Review') }}
                                </h5>
                            @endif

                        </div>
                    </div>
                </div>
                <!-- Reviews tab content end -->





                @if ($productt->whole_sell_qty != null && $productt->whole_sell_qty != '')
                    <!-- Wholesell Tab content start  -->
                    <div class="tab-pane fade" id="whole-sell-tab-pane" role="tabpanel" aria-labelledby="whole-sell-tab"
                        tabindex="0">
                        <div class="row sholesell-tab-content-wrapper">
                            <div class="col-12 col-lg-8 col-xl-9 col-xxl-8">
                                <div class="pro-summary ">
                                    <div class="price-summary">
                                        <div class="price-summary-content">
                                            <p class="title text-center text-lg">@lang('Wholesell')</p>
                                            <ul class="price-summary-list">
                                                <li class="regular-price">
                                                    <p class="fw-medium">@lang('Quantity')</p>
                                                    <p class="fw-medium">
                                                        @lang('Discount')
                                                    </p>
                                                </li>

                                                @foreach ($productt->whole_sell_qty as $key => $data1)
                                                    <li class="selling-price">
                                                        <label>{{ $productt->whole_sell_qty[$key] }}+</label> <span><span
                                                                class="woocommerce-Price-amount amount">{{ $productt->whole_sell_discount[$key] }}%
                                                                @lang('Off')
                                                            </span>
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Featured Products Section Start -->
    <section class="" style="padding-top: 0; background-color: #ffffff;">
        <div class="container">
            <div class="mb-30">
                <div class="gs-title-box" style="text-align: center">
                    {{-- <h2 class="title wow-replaced">@lang('Our Featured Products')</h2> --}}
                    <h2  style="margin: 0;font-size: 4rem !important; margin-bottom: 2rem" class="title text-center">@lang('Related Products')</h2>

                </div>
            </div>
            <div style="padding: 0 40px" class="row product-cards-slider gy-4 mt-4 mt-lg-0">
                @if ($products->isNotEmpty())
                    @foreach ($products as $product)
                        @include('includes.frontend.home_product', ['class' => 'not'])
                    @endforeach
                @else
                    <div class="no-products text-center text-muted p-4">
                        <p>No related products found.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Featured Products Section End -->


    <!-- More Products By Seller slider start -->
    @if ($productt->user_id != 0 && $vendor_products->count() > 0)
        <div class="gs-product-cards-slider-section more-products-by-seller wow-replaced" data-wow-delay=".1s">
            <div class="gs-product-cards-slider-area more-products-by-seller">
                <div class="container">
                    <h2 class="title text-center">@lang('More Products By Seller')</h2>
                    <div class="product-cards-slider">
                        @foreach ($vendor_products as $product)
                            @include('includes.frontend.home_product', ['class' => 'not'])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- More Products By Seller slider end -->

    <!-- Product report Modal Start -->
    @if (auth()->check())
        <div class="modal gs-modal fade" id="report-modal" tabindex="-1" aria-hidden="true">
            <form action="{{ route('product.report') }}" method="POST"
                class="modal-dialog assign-rider-modal-dialog modal-dialog-centered">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="product_id" value="{{ $productt->id }}">

                <div class="modal-content assign-rider-modal-content form-group">
                    <div class="modal-header w-100">
                        <h4 class="title">{{ __('REPORT PRODUCT') }}</h4>
                        <button type="button" data-bs-dismiss="modal">
                            <i class="fa-regular fa-circle-xmark gs-modal-close-btn"></i>
                        </button>
                    </div>
                    <!-- modal body start -->
                    <div class="input-label-wrapper w-100">
                        <label>{{ __('Please give the following details') }}</label>
                        <input type="text" name="title" class="form-control mb-3"
                            placeholder="{{ __('Enter Report Title') }}" required="">
                        <textarea name="note" class="form-control border p-3" placeholder="{{ __('Enter Report Note') }}"
                            required=""></textarea>
                    </div>
                    <button class="template-btn" data-bs-dismiss="modal" type="submit">{{ __('SUBMIT') }}</button>
                    <!-- modal body end -->
                </div>
            </form>
        </div>
    @endif
    <!-- Product report Modal End -->

    <!-- Vendor Message Modal -->
    <div class="modal gs-modal fade" id="vendorform" tabindex="-1" aria-modal="true" role="dialog">
        <form action="{{ route('user-send-message') }}" id="emailreply" method="POST"
            class="modal-dialog assign-rider-modal-dialog modal-dialog-centered emailreply">
            {{ csrf_field() }}
            <div class="modal-content assign-rider-modal-content form-group">
                <div class="modal-header w-100">
                    <h4 class="title">@lang('Send Message')</h4>
                    <button type="button" data-bs-dismiss="modal">
                        <i class="fa-regular fa-circle-xmark gs-modal-close-btn"></i>
                    </button>
                </div>
                <div class="input-label-wrapper w-100">
                    <input type="text" class="form-control border px-3 mb-4" id="eml" name="email" readonly
                        placeholder="@lang('Select Rider')" value="{{ auth()->user() ? auth()->user()->email : '' }}">
                    <input type="text" class="form-control border px-3 mb-4" name="subject"
                        placeholder="@lang('Subject')" required="">
                    <textarea class="form-control border px-3 mb-4" name="message" placeholder="{{ __('Your Message') }}"
                        required=""></textarea>
                    <input type="hidden" name="name" value="{{ Auth::user() ? Auth::user()->name : '' }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user() ? Auth::user()->id : '' }}">
                    <input type="hidden" name="vendor_id" value="{{ $productt->user_id }}">
                </div>
                <button class="template-btn" data-bs-dismiss="modal" type="submit">@lang('Send Message')</button>
            </div>
        </form>
    </div>

    <!-- Send Message Modal -->
    <div class="modal gs-modal fade" id="sendMessage" tabindex="-1" aria-modal="true" role="dialog">
        <form action="{{ route('user-send-message') }}" method="POST"
            class="modal-dialog assign-rider-modal-dialog modal-dialog-centered emailreply">
            {{ csrf_field() }}
            <div class="modal-content assign-rider-modal-content form-group">
                <div class="modal-header w-100">
                    <h4 class="title">@lang('Send Message')</h4>
                    <button type="button" data-bs-dismiss="modal">
                        <i class="fa-regular fa-circle-xmark gs-modal-close-btn"></i>
                    </button>
                </div>
                <div class="input-label-wrapper w-100">
                    <input type="text" class="form-control form__control border px-3 mb-4" name="subject"
                        placeholder="@lang('Subject')" required="">
                    <textarea class="form-control form__control border px-3 mb-4" name="message" placeholder="{{ __('Your Message') }}"
                        required=""></textarea>
                </div>
                <button class="template-btn" data-bs-dismiss="modal" type="submit">@lang('Send Message')</button>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/front/js/jquery.elevatezoom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>

    <script type="text/javascript">
        (function($) {
            "use strict";

            $("#single-image-zoom").elevateZoom({
                gallery: 'gallery_09',
                zoomType: "inner",
                cursor: "crossgalleryActiveClass: 'active'",
                imageCrossfade: true,
                loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'
            });

            $("#single-image-zoom").bind("click", function(e) {
                var ez = $('#single-image-zoom').data('elevateZoom');
                $.fancybox(ez.getGalleryList());
                return false;
            });

            $(document).on("submit", "#emailreply", function() {
                var token = $(this).find('input[name=_token]').val();
                var subject = $(this).find('input[name=subject]').val();
                var message = $(this).find('textarea[name=message]').val();
                var email = $(this).find('input[name=email]').val();
                var name = $(this).find('input[name=name]').val();
                var user_id = $(this).find('input[name=user_id]').val();
                $('#eml').prop('disabled', true);
                $('#subj').prop('disabled', true);
                $('#msg').prop('disabled', true);
                $('#emlsub').prop('disabled', true);
                $.ajax({
                    type: 'post',
                    url: "{{ URL::to('/user/user/contact') }}",
                    data: {
                        '_token': token,
                        'subject': subject,
                        'message': message,
                        'email': email,
                        'name': name,
                        'user_id': user_id
                    },
                    success: function(data) {
                        $('#eml').prop('disabled', false);
                        $('#subj').prop('disabled', false);
                        $('#msg').prop('disabled', false);
                        $('#subj').val('');
                        $('#msg').val('');
                        $('#emlsub').prop('disabled', false);
                        if (data == 0)
                            toastr.error("Email Not Found");
                        else
                            toastr.success("Message Sent");
                        $('#vendorform').modal('hide');
                    }
                });
                return false;
            });

            $('.add-to-affilate').on('click', function() {
                var value = $(this).data('href');
                var tempInput = document.createElement("input");
                tempInput.style = "position: absolute; left: -1000px; top: -1000px";
                tempInput.value = value;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                toastr.success('Affiliate Link Copied');
            });

            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });
        })(jQuery);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Single-open accordion functionality
            document.querySelectorAll(".expand-header").forEach((button) => {
                button.addEventListener("click", () => {
                    const content = button.nextElementSibling;
                    const isCurrentlyOpen = content.style.display === "block";

                    document.querySelectorAll(".expand-content").forEach((otherContent) => {
                        otherContent.style.display = "none";
                    });
                    document.querySelectorAll(".expand-header span").forEach((span) => {
                        span.textContent = "▼";
                    });

                    if (!isCurrentlyOpen) {
                        content.style.display = "block";
                        button.querySelector("span").textContent = "▲";
                    }
                });
            });

            // Image slider functionality
            let currentImageIndex = 0;
            const primaryImage = document.querySelector(".primary-image");
            const previewImages = document.querySelectorAll(".preview-image");
            const slidePrev = document.querySelector(".slide-prev");
            const slideNext = document.querySelector(".slide-next");

            function updateImage() {
                primaryImage.src = previewImages[currentImageIndex].src;
                previewImages.forEach((img, index) => {
                    img.classList.toggle("active", index === currentImageIndex);
                });
            }

            slideNext.addEventListener("click", () => {
                currentImageIndex = (currentImageIndex + 1) % previewImages.length;
                updateImage();
            });

            slidePrev.addEventListener("click", () => {
                currentImageIndex = (currentImageIndex - 1 + previewImages.length) % previewImages.length;
                updateImage();
            });

            previewImages.forEach((img, index) => {
                img.addEventListener("click", () => {
                    currentImageIndex = index;
                    updateImage();
                });
            });

            updateImage();

            // Wishlist Handler for .custom-wishlist buttons
            document.querySelectorAll('.custom-wishlist').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const toggleState = this.getAttribute('data-toggle');
                    const url = this.getAttribute('data-href');
                    const productId = this.getAttribute('data-product-id');
                    const method = toggleState === 'add' ? 'POST' : 'DELETE';
                    const svg = this.querySelector('svg');

                    if (!url || !productId) {
                        toastr.error('Wishlist action unavailable');
                        return;
                    }

                    fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        return response.json().then(data => ({
                            status: response.status,
                            data: data
                        }));
                    })
                    .then(({ status, data }) => {
                        if (status === 200 && data.success) {
                            svg.classList.toggle('active');
                            if (toggleState === 'add') {
                                const wishlistId = data.wishlist_id;
                                if (!wishlistId) {
                                    throw new Error('Wishlist ID not returned');
                                }
                                svg.setAttribute('fill', '#800080');
                                this.setAttribute('data-toggle', 'remove');
                                this.setAttribute('data-href', `{{ route('user-wishlist-remove', ':id') }}`.replace(':id', wishlistId));
                                toastr.success(data.message || 'Added to wishlist');
                                const countElement = document.querySelector('#wishlist-count');
                                if (countElement) {
                                    countElement.textContent = data.count || parseInt(countElement.textContent) + 1;
                                }
                            } else {
                                svg.setAttribute('fill', 'white');
                                this.setAttribute('data-toggle', 'add');
                                this.setAttribute('data-href', `{{ route('user-wishlist-add', ':id') }}`.replace(':id', productId));
                                toastr.success(data.message || 'Removed from wishlist');
                                const countElement = document.querySelector('#wishlist-count');
                                if (countElement) {
                                    countElement.textContent = data.count || Math.max(parseInt(countElement.textContent) - 1, 0);
                                }
                            }
                        } else {
                            toastr.error(data.message || (toggleState === 'add' ? 'Product already added to wishlist' : 'Error removing from wishlist'));
                        }
                    })
                    .catch(error => {
                        console.error('Wishlist Error:', error);
                        toastr.error(`An error occurred: ${error.message}`);
                    });
                });
            });
        });

        // Quantity Counter
        $(document).ready(function() {
            const productId = @json($productt->id);

            function updateCounter(input, change) {
                const button = $(`.add-basket-btn[data-product-id="${productId}"]`);
                let currentVal = parseInt(input.val()) || 1;
                const newVal = change === 1 ? currentVal + 1 : Math.max(1, currentVal - 1);
                input.val(newVal);
                button.attr('data-product-quantity', newVal);
                input.siblings('.custom-btn-decrease').prop('disabled', newVal <= 1);
            }

            $(".count-field").on("input", function() {
                const button = $(`.add-basket-btn[data-product-id="${productId}"]`);
                let currentValue = parseInt($(this).val());

                if (isNaN(currentValue) || currentValue < 1) {
                    $(this).val(1);
                    button.attr('data-product-quantity', 1);
                } else {
                    $(this).val(currentValue);
                    button.attr('data-product-quantity', currentValue);
                }
                $(this).siblings('.custom-btn-decrease').prop('disabled', $(this).val() <= 1);
            });

            $(".custom-btn-increase").off('click').on('click', function() {
                updateCounter($(this).siblings(".custom-input"), 1);
            });

            $(".custom-btn-decrease").off('click').on('click', function() {
                updateCounter($(this).siblings(".custom-input"), -1);
            });

            $(".custom-input").each(function() {
                $(this).siblings('.custom-btn-decrease').prop('disabled', $(this).val() <= 1);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const zoomContainer = document.querySelector('.zoom-container');
            const image = zoomContainer.querySelector('.primary-image');

            zoomContainer.addEventListener('mousemove', function (e) {
                const rect = zoomContainer.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;

                image.style.transformOrigin = `${x}% ${y}%`;
                image.style.transform = 'scale(2.5)'; // adjust scale as needed
            });

            zoomContainer.addEventListener('mouseleave', function () {
                image.style.transform = 'scale(1)';
                image.style.transformOrigin = 'center center';
            });
        });
    </script>
@endsection
