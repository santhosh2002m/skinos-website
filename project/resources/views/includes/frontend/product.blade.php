<div class="{{ isset($class) ? $class : 'col-md-6 col-lg-4 col-xl-3' }} mt-1">
    <div class="single-product  border p-3 rounded bg-white">
        <div class="img-wrapper">
            @if (Auth::check())
                @if (isset($wishlist))
                    <a href="javascript:;" class="removewishlist"
                        data-href="{{ route('user-wishlist-remove', App\Models\Wishlist::where('user_id', '=', $user->id)->where('product_id', '=', $product->id)->first()->id) }}">
                        <div class="add-to-wishlist-btn bg-danger">
                            <i class="fas fa-trash text-white"></i>
                        </div>
                    </a>
                @else
                    <a href="javascript:;" class="wishlist" data-href="{{ route('user-wishlist-add', $product->id) }}">
                        <div class="add-to-wishlist-btn {{ wishlistCheck($product->id) ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z"
                                    stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </a>
                @endif
            @else
                <a href="{{ route('user.login') }}">
                    <div class="add-to-wishlist-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z"
                                stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </a>
            @endif

            <a href="{{ route('front.product', $product->slug) }}">
                <img class="product-img"
                    src="{{ $product->photo ? asset('assets/images/products/' . $product->photo) : asset('assets/images/noimage.png') }}"
                    alt="product img">
            </a>
        </div>

        <div class="product-info">
            <a href="{{ route('front.product', $product->slug) }}" class="product-name"
                style="color: black; font-family: 'Open Sans', sans-serif;">
                {{ $product->showName() }}
            </a>
            <div class="product-pricing">
                @if (Auth::check())
                    <span style="font-size: 0.8rem">({!! $product->showPrice() !!} / Unit )</span>
                    <span class="current-price" id="{{ 'current-price-' . $product->id }}"
                        data-unit-price="{{ $product->price }}"
                        style="color: black; font-weight: 700; font-size: 1rem;">
                        {!! $product->showPrice() !!}
                    </span>
                    <p class="org-price" id="{{ 'total-price-' . $product->id }}">
                        <del>
                            <span class="price-sign"></span>
                            <span class="individual-price"></span>
                        </del>
                        <span class="off_percentage"></span>
                    </p>
                @else
                    <span style="color: black;">₹ XXXX</span>
                @endif
            </div>
        </div>
        <div class="product-counter" data-product-id="{{ $product->id }}">
            @if (Auth::check())
                <div class="custom-wrapper my-2">
                    <div class="custom-row">
                        <div class="custom-col">
                            <div class="custom-counter-container">
                                <button style="color: #001F3F;font-size:13px"
                                    class="custom-btn-decrease custom-btn-light" type="button"
                                    data-product-id="{{ $product->id }}">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input style="color: #001F3F" type="number" name="counter_value" value="1"
                                    class="custom-input counter_value_{{ $product->id }}" min="1" />
                                <button style="color: #001F3F;font-size:13px"
                                    class="custom-btn-increase custom-btn-light" type="button"
                                    data-product-id="{{ $product->id }}">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>


        @if (Auth::check())
            <div class="button-flex">
                <!-- Buy Now Button -->
                @if (Auth::check())
                    @if ($product->product_type == 'affiliate')
                        <button class="subscribe-buttonnn colors"
                            onclick="window.location.href='{{ $product->affiliate_link }}'">
                            @lang('Buy Now')
                        </button>
                    @else
                        @if ($product->emptyStock())
                            <button class="subscribe-buttonnn colors" disabled>
                                {{ __('Out of Stock') }}
                            </button>
                        @else
                            <a href="{{ route('front.cart') }}">
                                <button class="subscribe-buttonnn colors">
                                    @lang('Buy Now')
                                </button>
                            </a>
                        @endif
                    @endif
                    <!-- Add to Cart Button -->
                    @if ($product->product_type == 'affiliate')
                        <button class="subscribe-buttonnn"
                            onclick="window.location.href='{{ $product->affiliate_link }}'">
                            @lang('Add To Cart')
                        </button>
                    @else
                        @if ($product->emptyStock())
                            <button class="subscribe-buttonnn" disabled>
                                {{ __('Out of Stock') }}
                            </button>
                        @else
                            {{-- @if ($product->type != 'Listing')
                                <button
                                    class="subscribe-buttonnn {{ $product->cross_products ? 'view_cross_product' : 'add_cart_click' }}"
                                    data-href="{{ route('product.cart.add', $product->id) }}"
                                    data-cross-href="{{ route('front.show.cross.product', $product->id) }}"
                                    data-product-id="{{ $product->id }}"
                                    {{ $product->cross_products ? 'data-bs-toggle="modal" data-bs-target="#exampleModal"' : '' }}>
                                    @lang('Add To Cart')
                                </button>
                            @else --}}
                            <button class="subscribe-buttonnn add_cart_click"
                                data-href="{{ route('product.cart.add', $product->id) }}"
                                data-product-id="{{ $product->id }}" 
                                data-product-quantity="1"
                                data-discount-slab=""
                                >
                                @lang('Add To Cart')
                            </button>
                            {{-- @endif --}}
                        @endif
                    @endif
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Add these dependencies in the head section -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<style>
    button:focus,
    input:focus {
        outline: none;
        box-shadow: none;
    }

    .colors {
        background-color: #001F3F !important;
    }

    .subscribe-buttonnn {
        background-color: #6B00FF;
        /* Kept as per your existing style */
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 16px;
        font-family: Inter, sans-serif;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .subscribe-buttonnn:hover {
        background-color: #8C32FF;
        /* Kept as per your existing style */
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
    }

    .subscribe-buttonnn:active {
        transform: scale(0.95);
        background-color: #5C00E6;
        /* Kept as per your existing style */
    }

    .button-flex {
        display: flex;
        justify-content: space-between;
        padding: 0 1rem;
    }

    .custom-counter-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-counter-container input button {
        border: 4px solid #001F3F;
    }

    .custom-counter-container .custom-input {
        text-align: center;
        padding: 6px 10px;
        border: 1px solid #d4d4d4;
        max-width: 100%;
        -moz-appearance: textfield;
    }

    .custom-counter-container .custom-input::-webkit-outer-spin-button,
    .custom-counter-container .custom-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .custom-counter-container .custom-btn-decrease,
    .custom-counter-container .custom-btn-increase {
        border: 1px solid #d4d4d4;
        padding: 10px 13px;
        font-size: 10px;
        height: 38px;
        width: 38px;
        transition: 0.3s;
        background: #f8f9fa;
        cursor: pointer;
    }

    .custom-counter-container .custom-btn-increase {
        margin-left: -1px;
        border-radius: 0 4px 4px 0;
    }

    .custom-counter-container .custom-btn-decrease {
        margin-right: -1px;
        border-radius: 4px 0 0 4px;
    }

    .custom-btn-decrease:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f8f9fa;
    }

    .product-info {
        padding: 0.5rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .product-name {
        flex: 1;
        color: var(--primary-color);
        font-size: 1rem;
        font-weight: 600;
        line-height: 1.4;
        margin: 0;
        text-decoration: none;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-pricing {
        text-align: right;
    }

    .current-price {
        display: block;
        color: var(--accent-color);
        /* Purple */
        font-weight: 700;
        font-size: 1.75rem;
    }

    .single-product:hover .product-name {
        color: #800080 !important;
        /* Purple color */
        transition: color 0.3s ease;
        /* Smooth transition */
    }

    /* Styling for price-display to target showPrice() output */
    .price-display {
        font-family: 'Open Sans', sans-serif;
        color: black;
    }
</style>
