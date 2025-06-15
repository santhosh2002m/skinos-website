<style>
    .mix-match-bundle,
    .individual-product
    {
        font-family: 'Segoe UI', sans-serif;
        background-color: #1a1a1a;
        color: #f1f1f1;
    }

    .mix-match-bundle .bundle-name {
        font-weight: 500;
        font-size: 1rem;
        margin-bottom: 8px;
        text-align: left;
    }

    .mix-match-bundle .bundle-item-list {
        text-align: left;
        list-style: none;
        padding-left: 0;
        margin: 0;
    }

    .mix-match-bundle .bundle-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .mix-match-bundle .image-container {
        flex-shrink: 0;
        margin-right: 12px;
        padding-left: 1rem;
    }

    .mix-match-bundle .image-container img,
    .individual-product .cart-product img
    {
        width: 80px;
        border-radius: 50%;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.4);
        transition: transform 0.2s ease, fill 0.2s ease;
    }
    .mix-match-bundle .image-container img:hover,
    .individual-product .cart-product img:hover
    {
        transform: scale(1.1);
    }

    .mix-match-bundle .text-container .item-name {
        font-weight: 500;
        margin: 0;
    }

    .mix-match-bundle .text-container .item-name a {
        color: #000000 !important;
        text-decoration: none;
    }

    .mix-match-bundle .text-container .item-name a:hover {
        text-decoration: underline;
    }

    .mix-match-bundle .text-container .item-qty {
        font-size: 1rem;
        color: #2b2b2b;
        margin: 2px 0 0;
    }

    .mix-match-bundle .bundle-display-name,
    .individual-product .cart-quantity input
    {
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
        font-weight: 400;
        font-size: 1.2rem !important;
    }

    .mix-match-bundle .bundle-price span,
    .individual-product .cart-price span
    {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .mix-match-bundle .bundle-price del,
    .individual-product del 
    {
        color: #999;
        font-size: 1.1rem;
    }

    .mix-match-bundle .cart-remove-btn svg,
    .individual-product .cart-remove-btn:hover svg 
    {
        cursor: pointer;
        transition: transform 0.2s ease, fill 0.2s ease;
    }
    
    .cart-remove-btn:hover svg {
        transform: scale(1.25);
        stroke: #ff4d4f;
    }
    .individual-product .cart-product {
        display: flex;
        justify-content: start;
        padding-left: 1rem;
    }
</style>
<div class="container gs-cart-container">
    <div class="row gs-cart-row">


        @if (Session::has('cart'))

            @php
                $discount = 0;
                $groupedProducts = collect($products)->groupBy(function ($product) {
                    return $product['mix_match_batch'] ?? 'no_batch';
                });
            @endphp
            @foreach ($products as $product)
            @php
                if ($product['discount'] != 0) {
                    $total_itemprice = $product['item_price'] * $product['qty'];
                    $tdiscount = ($total_itemprice * $product['discount']) / 100;
                    $discount += $tdiscount;
                }
            @endphp
            @endforeach



            <div class="col-lg-8">
                <div class="cart-table table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="">
                                <th scope="col" style="text-align: left;">@lang('Product Name')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Scheme')</th>
                                <th scope="col">@lang('Subtotal')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="t_body">
                            @foreach ($groupedProducts as $batchKey => $items)
                                @if ($batchKey === 'no_batch')
                                    @foreach ($items as $product)
                                    @php
                                        $total_itemprice = $product['item_price'] * $product['qty'];
                                    @endphp
                                    <tr class="individual-product">
                                        <td class="cart-product-area">
                                            <div class="cart-product">
                                                <img src="{{ $product['item']['photo'] ? asset('assets/images/products/' . $product['item']['photo']) : asset('assets/images/noimage.png') }}"
                                                    alt="">
                                                <div class="cart-product-info">
                                                    <a class="cart-title d-inline-block"
                                                        href="{{ route('front.product', $product['item']['slug']) }}">{{ mb_strlen($product['item']['name'], 'UTF-8') > 35
                                                            ? mb_substr($product['item']['name'], 0, 35, 'UTF-8') . '...'
                                                            : $product['item']['name'] }}</a>

                                                    <div class="d-flex align-items-center gap-2">
                                                        @if (!empty($product['color']))
                                                            @lang('Color') : <p
                                                                class="cart-color d-inline-block rounded-2"
                                                                style="border: 10px solid #{{ $product['color'] == '' ? 'white' : $product['color'] }};">
                                                            </p>
                                                        @endif
                                                        @if (!empty($product['size']))
                                                            @lang('Size') : <p class="d-inline-block">
                                                                {{ $product['size'] }}
                                                            </p>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </td>
                                        <td class="cart-price">
                                            {{ App\Models\Product::convertPrice($product['item_price']) }}</td>

                                        @if ($product['item']['type'] == 'Physical')
                                            <td>
                                                <div class="cart-quantity">
                                                    {{-- <button class="cart-quantity-btn quantity-down">-</button> --}}
                                                    <input type="text"
                                                        id="qty{{ $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']) }}"
                                                        value="{{ $product['scheme']['name'] }}" class="borderless" style="width: 80px" readonly>
                                                    {{-- <input type="hidden" class="prodid"
                                                        value="{{ $product['item']['id'] }}">
                                                    <input type="hidden" class="itemid"
                                                        value="{{ $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']) }}"> --}}
                                                    {{-- <input type="hidden" class="size_qty"
                                                        value="{{ $product['size_qty'] }}"> --}}
                                                    {{-- <input type="hidden" class="size_price"
                                                        value="{{ $product['size_price'] }}"> --}}
                                                    {{-- <input type="hidden" class="minimum_qty"
                                                        value="{{ $product['item']['minimum_qty'] == null ? '0' : $product['item']['minimum_qty'] }}"> --}}

                                                    {{-- <button class="cart-quantity-btn quantity-up">+</button> --}}
                                                </div>
                                            </td>
                                        @else
                                            <td class="product-quantity">
                                                1
                                            </td>
                                        @endif


                                        @if ($product['size_qty'])
                                            <input type="hidden"
                                                id="stock{{ $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']) }}"
                                                value="{{ $product['size_qty'] }}">
                                        @elseif($product['item']['type'] != 'Physical')
                                            <input type="hidden"
                                                id="stock{{ $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']) }}"
                                                value="1">
                                        @else
                                            <input type="hidden"
                                                id="stock{{ $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']) }}"
                                                value="{{ $product['stock'] }}">
                                        @endif



                                        <td class="cart-price"
                                            id="prc{{ $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']) }}">
                                            <span class="div">
                                                {{ App\Models\Product::convertPrice($product['price']) }}
                                                <del>{{ App\Models\Product::convertPrice($total_itemprice) }}</del>
                                            </span>
                                            {{-- @if ($product['discount'] != 0)
                                                <strong>{{ $product['discount'] }}% {{ __('off') }}</strong>
                                            @endif --}}
                                        </td>
                                        <td>
                                            <a class="cart-remove-btn"
                                                data-class="cremove{{ $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']) }}"
                                                href="{{ route('product.cart.remove', [
                                                    $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']),
                                                    'batch_id' => $product['mix_match_batch'] ?? ''
                                                ]) }}"
                                                >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M9 3H15M3 6H21M19 6L18.2987 16.5193C18.1935 18.0975 18.1409 18.8867 17.8 19.485C17.4999 20.0118 17.0472 20.4353 16.5017 20.6997C15.882 21 15.0911 21 13.5093 21H10.4907C8.90891 21 8.11803 21 7.49834 20.6997C6.95276 20.4353 6.50009 20.0118 6.19998 19.485C5.85911 18.8867 5.8065 18.0975 5.70129 16.5193L5 6M10 10.5V15.5M14 10.5V15.5"
                                                        stroke="#1F0300" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    {{-- Mix & Match Bundle --}}
                                    @php
                                        $first = $items[0];
                                        $bundleName = "Mix and Match Bundle (" .$first['scheme']['name']. ")" ?? 'Mix Bundle';
                                        $bundleDisplayName = $first['scheme']['name'] ?? 'Mix Bundle';
                                        // $totalQty = collect($items)->sum('qty');
                                        $totalBundlePrice = collect($items)->sum(fn($p) => $p['price']);
                                        $totalItemPrice = collect($items)->sum(fn($p) => $p['item_price'] * $p['qty']);
                                        // $totalDiscount = $totalItemPrice - $totalPrice;
                                    @endphp

                                    <tr class="mix-match-bundle">
                                        <td colspan="2">
                                            <p class="bundle-name">{{ $bundleName }}</p>
                                            <ul class="bundle-item-list">
                                                @foreach ($items as $item)
                                                    <li class="bundle-item">
                                                        <div class="image-container">
                                                            <img src="{{ $item['item']['photo'] ? asset('assets/images/products/' . $item['item']['photo']) : asset('assets/images/noimage.png') }}" alt="">
                                                        </div>
                                                        <div class="text-container">
                                                            <p class="item-name">
                                                                <a class="cart-title"
                                                                    href="{{ route('front.product', $item['item']['slug']) }}">{{ mb_strlen($item['item']['name'], 'UTF-8') > 35
                                                                        ? mb_substr($item['item']['name'], 0, 35, 'UTF-8') . '...'
                                                                        : $item['item']['name'] }}</a>
                                                            </p>
                                                            <p class="item-qty">
                                                                Price : <strong>{{App\Models\Product::convertPrice($item['item_price'])}}</strong>/ Unit
                                                            </p>
                                                            <p class="item-qty">
                                                                Quantity : {{ $item['scheme']['name_of_the_box'] }} ({{$item['qty']}})
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="bundle-display-name">{{ $bundleDisplayName }}</td>
                                        <td class="bundle-price">
                                            <span>
                                                {{ App\Models\Product::convertPrice($totalBundlePrice) }}
                                                <del>{{ App\Models\Product::convertPrice($totalItemPrice) }}</del>
                                            </span>
                                        </td>
                                        <td>
                                            <a class="cart-remove-btn"
                                            href="{{ route('product.cart.remove', [
                                                $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']),
                                                'batch_id' => $batchKey ?? ''
                                            ]) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M9 3H15M3 6H21M19 6L18.2987 16.5193C18.1935 18.0975 18.1409 18.8867 17.8 19.485C17.4999 20.0118 17.0472 20.4353 16.5017 20.6997C15.882 21 15.0911 21 13.5093 21H10.4907C8.90891 21 8.11803 21 7.49834 20.6997C6.95276 20.4353 6.50009 20.0118 6.19998 19.485C5.85911 18.8867 5.8065 18.0975 5.70129 16.5193L5 6M10 10.5V15.5M14 10.5V15.5"
                                                        stroke="#1F0300" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h4 class="cart-summary-title">@lang('Shopping Cart')</h4>
                    <div class="cart-summary-content">
                        <div class="cart-summary-item d-flex justify-content-between">
                            <p class="cart-summary-subtitle">
                                @lang('MRP') 
                                 (Incl. GST)
                                {{-- ({{ count(Session::get('cart')->items) }}
                                @lang('Items')) --}}
                            </p>
                            <p class="cart-summary-price">
                                {{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice + $discount) : '0.00' }}
                            </p>
                        </div>
                        <div class="cart-summary-item d-flex justify-content-between">
                            <p class="cart-summary-subtitle">@lang('Discount')</p>
                            <p class="cart-summary-price"> - {{ App\Models\Product::convertPrice($discount) }}</p>
                        </div>
                        <div class="cart-summary-item d-flex justify-content-between">
                            <p class="cart-summary-subtitle">@lang('Value (Excl. GST)')</p>
                            <p class="cart-summary-price">{{ App\Models\Product::convertPrice($totalPrice / (1 + (18 / 100))) }}</p>
                        </div>
                        <div class="cart-summary-item d-flex justify-content-between">
                            <p class="cart-summary-subtitle">@lang('GST')</p>
                            <p class="cart-summary-price">+ {{ App\Models\Product::convertPrice($totalPrice - ($totalPrice / (1 + (18 / 100))) ) }}</p>
                        </div>
                        <div class="cart-summary-item d-flex justify-content-between">
                            <p class="cart-summary-subtitle">@lang('Total Amount Payable')</p>
                            <p class="cart-summary-price total-cart-price" style="color: black">
                                {{ Session::has('cart') ? App\Models\Product::convertPrice($mainTotal) : '0.00' }}
                            </p>
                        </div>
                        <div class="cart-summary-btn">
                            <a href="{{ route('front.checkout') }}" class="template-btn w-100">@lang('Proceed to Buy')</a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                <div class="card border py-4">
                    <div class="card-body">
                        <h4 class="text-center">{{ __('Cart is Empty!! Add some products in your Cart') }}</h4>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
