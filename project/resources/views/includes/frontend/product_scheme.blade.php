@section('css')
    <style>
        /* Product Card Styles */
        button:focus,
        input:focus {
            outline: none;
            box-shadow: none;
        }

        .subscribe-buttonnn {
            background-color: #001f3f;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-family: Inter, sans-serif;
            font-size: 15px;
            font-weight: 500;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s;
        }



        .subscribe-buttonnn:active {
            transform: scale(0.95);
            background-color: #5C00E6;
        }

        .subscribe-buttonnn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .button-flex {
            display: flex;
            justify-content: space-between;
            padding: 0 6px;
        }

        .price-scheme-select {
            width: 100%;
            padding: 8px 15px;
            border: 1px solid #d4d4d4;
            border-radius: 8px;
            background-color: #6B00FF;
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
            border-color: #8C32FF;
            box-shadow: 0 0 0 2px rgba(107, 0, 255, 0.3);
        }

        .price-scheme-select option {
            background-color: white;
            color: #001F3F;
            font-size: 16px;
        }

        .product-info {
            padding: 0.5rem 0.7rem;
            gap: 1rem;
        }

        .product-pricing-unit {
            display: flex;
            justify-content: space-between;
        }

        .product-name {
            flex: 1;
            color: var(--primary-color);
            font-size: 14px;
            font-weight: 600;
            line-height: 1.4;
            margin: 0;
            text-decoration: none;
        }

        .product-pricing {
            text-align: right;
        }

        .current-price {
            display: block;
            color: var(--accent-color);
            font-weight: 700;
            font-size: 1.75rem;
        }

        .single-product:hover .product-name {
            color: #800080 !important;
            transition: color 0.3s ease;
        }

        .price-display {
            font-family: 'Open Sans', sans-serif;
            color: black;
        }

        .add-to-wishlist-btn {
            position: absolute;
            /* top: 10px;
            right: 10px; */
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

        .add-to-wishlist-btn:hover {
            background: #800080;
            transform: scale(1.1);
        }

        .add-to-wishlist-btn.active {
            background: #800080;
        }

        .add-to-wishlist-btn.active svg path {
            stroke: white;
        }

        .add-to-wishlist-btn svg {
            width: 24px;
            height: 24px;
        }

        .add-to-wishlist-btn svg path {
            stroke: #030712;
            transition: all 0.3s ease;
        }

        /* Sidebar Styles */
        .uvx-category-container {
            font-family: 'Arial', sans-serif;
            max-width: 320px;
            margin: auto;
            padding: 20px;
        }

        .uvx-category-item {
            border-bottom: 1px solid #eee;
        }

        .uvx-category-header {
            padding: 12px 0;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .uvx-category-header:hover {
            background-color: #f9f9f9;
        }

        .uvx-caret-icon {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
            color: #666;
        }

        .uvx-category-content {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding-left: 15px;
        }

        .uvx-category-item.uvx-active .uvx-caret-icon {
            transform: rotate(180deg);
        }

        .uvx-category-item.uvx-active .uvx-category-content {
            max-height: 600px;
            opacity: 1;
            padding: 15px 0 20px 15px;
        }

        .uvx-radio-group,
        .uvx-checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 1rem;
        }

        .uvx-radio-item,
        .uvx-checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .uvx-radio-custom {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid #FFA500;
            border-radius: 50%;
            position: relative;
            transition: all 0.2s ease;
        }

        .uvx-radio-custom::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: #FFA500;
            border-radius: 50%;
            opacity: 0;
        }

        input[type="radio"]:checked+.uvx-radio-custom::after {
            opacity: 1;
        }

        .uvx-checkbox-custom {
            display: inline-block;
            width: 22px;
            height: 22px;
            border: 2px solid #FFA500;
            border-radius: 4px;
            position: relative;
            transition: all 0.2s ease;
        }

        input[type="checkbox"]:checked+.uvx-checkbox-custom {
            background: #FFA500;
            border-color: #FFA500;
        }

        input[type="checkbox"]:checked+.uvx-checkbox-custom::after {
            content: '';
            position: absolute;
            left: 6px;
            top: 2px;
            width: 6px;
            height: 12px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        input[type="radio"],
        input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .brand-logo-item {
            margin: 15px 0;
            display: flex;
            align-items: center;
        }

        .logo-img {
            width: 120px;
            height: auto;
            margin-left: 15px;
            transition: transform 0.3s ease;
        }

        .logo-img:hover {
            transform: scale(1.1);
        }

        .pricing-flex {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        .uvx-category-container .subscribe-buttonnn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #B266FF;
            color: white;
            border: none;
            border-radius: 25px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .uvx-category-container .subscribe-buttonnn:hover {
            background-color: #A64DFF;
        }

        .uvx-category-container .subscribe-buttonnn[href] {
            background-color: #800080;
            margin-top: 0.5rem;
        }

        .uvx-category-container .subscribe-buttonnn[href]:hover {
            background-color: #6A0DAD;
        }
    </style>
@endsection

<div class="{{ isset($class) ? $class : 'col-md-6 col-lg-4 col-xl-3' }} mt-2">
    <div class="single-product {{ 'product-number-' . $product->id }} border p-3 rounded bg-white">
        <div class="img-wrapper">
            <!-- Discount Badge -->
            {{-- @if (Auth::check())
                <span class="product-badge discount-badge" id="{{ 'discount-badge-' . $product->id }}"
                    style="display: none;">-{{ round(0) }}%</span>
            @endif --}}

            <!-- Wishlist Actions -->
            @auth
                @php
                    $wishlistItem = \App\Models\Wishlist::where('user_id', auth()->id())
                        ->where('product_id', $product->id)
                        ->first();
                @endphp
                <a href="javascript:;" class="wishlist" data-href-add="{{ route('user-wishlist-add', $product->id) }}"
                    data-href-remove="{{ $wishlistItem ? route('user-wishlist-remove', $wishlistItem->id) : '' }}"
                    data-toggle="{{ $wishlistItem ? 'remove' : 'add' }}">
                    <div class="add-to-wishlist-btn {{ $wishlistItem ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                            fill="{{ $wishlistItem ? '#800080' : 'none' }}"
                        >
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z"
                                stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </a>
            @else
                <a href="{{ route('user.login') }}">
                    <div class="add-to-wishlist-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z"
                                stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </a>
            @endauth

            <!-- Product Image -->
            <a href="{{ route('front.product', $product->slug) }}">
                <img class="product-img"
                    src="{{ $product->photo ? asset('assets/images/products/' . $product->photo) : asset('assets/images/noimage.png') }}"
                    alt="product img">
            </a>
        </div>

        <!-- Price Scheme Dropdown -->
        @if (Auth::check())
            <div class="custom-wrapper mt-4">
                <select class="price-scheme-select" name="price_scheme">
                    <option value="" selected disabled>Select Price Scheme</option>
                    @if (!empty($scheme_entries))
                        @foreach ($scheme_entries as $entry)
                            <option value="{{ $entry->id }}" data-product="{{ $product->id }}"
                                data-discount="{{ $entry->discount_percentage }}" data-quantity="{{ $entry->total_quantity }}"
                                data-product_price="{{ $product->price }}">
                                {{ $entry->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        @endif

        <!-- Product Info -->
        <div class="product-info">
            <a href="{{ route('front.product', $product->slug) }}" class="product-name"
                style="color: black; font-family: 'Open Sans', sans-serif;">
                {{ $product->showName() }}
            </a>
        </div>
        <div class="product-info">
            <div class="product-pricing">
                @if (Auth::check())
                    <div class="product-pricing-unit">
                        <span>Unit Price</span>
                        <span class="unit-price" style="font-size: 0.8rem">{!! $product->showPrice() !!} / Unit</span>
                    </div>
                    <div class="product-pricing-unit">
                        <span>Price Before Discount</span>
                        <span class="total-price" id="{{ 'total-price-' . $product->id }}"
                            style="color: #6c757d; font-size: 1rem;">
                            <del>-</del>
                        </span>
                    </div>
                    <div class="product-pricing-unit">
                        <span>Price After Discount</span>
                        <span class="current-price" id="{{ 'current-price-' . $product->id }}"
                            style="color: black; font-weight: 700; font-size: 1rem;">
                            -
                        </span>
                    </div>
                @else
                    ₹ XXXX
                @endif
            </div>
        </div>

        <!-- Buttons -->
        <div class="button-flex">
            <!-- Buy Now Button -->
            @if (Auth::check())
                @if ($product->emptyStock())
                    <button class="subscribe-buttonnn colors" disabled>
                        {{ __('Out of Stock') }}
                    </button>
                @else
                    <button class="subscribe-buttonnn add_cart_click" data-href="{{ route('product.cart.add', $product->id) }}"
                        data-product-id="{{ $product->id }}" disabled>
                        @lang('Add To Cart')
                    </button>
                @endif
            @endif
        </div>
    </div>
</div>

@section('script')
    <!-- Dependencies -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Price Scheme Select Logic
            $('.price-scheme-select').on('change', function () {
                const schemeId = $(this).val();
                const selectedDiscount = $(this).find(':selected').data('discount');
                const selectedProduct = $(this).find(':selected').data('product');
                const selectedProductTotalQuantity = $(this).find(':selected').data('quantity');
                const selectedProductPrice = $(this).find(':selected').data('product_price');

                const $button = $(`.subscribe-buttonnn[data-product-id="${selectedProduct}"]`);

                if (selectedDiscount !== undefined && selectedProductTotalQuantity > 0) {
                    const totalPrice = selectedProductPrice * selectedProductTotalQuantity;
                    const discountAmount = (totalPrice * selectedDiscount) / 100;
                    const discountedPrice = totalPrice - discountAmount;

                    $(`#current-price-${selectedProduct}`).css('display', 'block').html(
                        `₹ ${discountedPrice.toFixed(2)}`);
                    $(`#total-price-${selectedProduct}`).css('display', 'block');
                    $(`#total-price-${selectedProduct} del`).text(`₹ ${totalPrice.toFixed(2)}`);
                    $button.prop('disabled', false);
                    $button.attr('data-scheme-id', schemeId);
                } else {
                    $button.prop('disabled', true);
                    $(`#current-price-${selectedProduct}`).css('display', 'none');
                    $(`#total-price-${selectedProduct}`).css('display', 'none');
                }
            });

            // Wishlist Add/Remove
            document.querySelectorAll('.wishlist').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const toggleState = this.getAttribute('data-toggle');
                    const url = toggleState === 'add' ? this.getAttribute('data-href-add') : this
                        .getAttribute('data-href-remove');
                    const method = toggleState === 'add' ? 'POST' : 'DELETE';
                    const actionBtn = this.querySelector('.add-to-wishlist-btn');
                    const svg = actionBtn.querySelector('svg');

                    if (!url) {
                        toastr.success('Wishlist action unavailable');
                        return;
                    }

                    fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                        .then(response => {
                            if (!response.ok) {
                                return response.text().then(text => {
                                    throw new Error(
                                        `HTTP ${response.status}: ${text || 'Network response was not ok'}`
                                    );
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Toggle the state
                                actionBtn.classList.toggle('active');
                                if (toggleState === 'add') {
                                    // Update to filled heart (in wishlist)
                                    svg.setAttribute('fill', '#800080');
                                    this.setAttribute('data-toggle', 'remove');
                                    this.setAttribute('data-href-remove',
                                        '{{ route('user-wishlist-remove', ':id') }}'
                                            .replace(':id', data.wishlist_id));
                                    // Update wishlist count (if counter exists)
                                    const countElement = document.querySelector(
                                        '#wishlist-count');
                                    if (countElement) {
                                        countElement.textContent = data.count || parseInt(
                                            countElement.textContent) + 1;
                                    }
                                    toastr.success(data.message ||
                                        'Successfully Added To The Wishlist.');
                                } else {
                                    // Update to outlined heart (not in wishlist)
                                    svg.setAttribute('fill', 'none');
                                    this.setAttribute('data-toggle', 'add');
                                    this.setAttribute('data-href-remove', '');
                                    // Update wishlist count
                                    const countElement = document.querySelector(
                                        '#wishlist-count');
                                    if (countElement) {
                                        countElement.textContent = data.count || Math.max(
                                            parseInt(countElement.textContent) - 1, 0);
                                    }
                                    toastr.success(data.message ||
                                        'Successfully Removed From Wishlist.');
                                }
                            } else {
                                toastr.success(data.message || (toggleState === 'add' ?
                                    'Error adding to wishlist' :
                                    'Error removing from wishlist'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.error('An error occurred while updating wishlist: ' + error
                                .message);
                        });
                });
            });
        });
    </script>
@endsection