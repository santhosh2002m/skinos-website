<style>
    .slab-table-container {
        background-color: #f9f9f9;
        padding: 20px;
        margin: 20px;
        border-radius: 12px;
    }

    .slab-table-container h5 {
        font-weight: 600;
        font-size: 1.2rem;
        color: #333;
        border-bottom: 2px solid #001f3f;
        display: inline-block;
        padding-bottom: 5px;
    }

    .slab-table-container .table {
        background-color: #fff;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
    }

    .slab-table-container .table th {
        background-color: #001f3f;
        color: white;
        text-align: center;
        vertical-align: middle;
    }

    .slab-table-container .table td {
        text-align: center;
        vertical-align: middle;
        color: #333;
        font-weight: 500;
    }

    .slab-table-container .table-bordered th,
    .slab-table-container .table-bordered td {
        border: 1px solid #dee2e6;
    }

    @media (max-width: 767.98px) {
        .slab-table-container h5 {
            font-size: 1rem;
        }

        .slab-table-container .table th,
        .slab-table-container .table td {
            font-size: 0.875rem;
            padding: 0.5rem;
        }
    }

</style>
<div class="container gs-cart-container">
    <div class="slab-table-container">
        <div class="row mb-4">
            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                <h5 class="text-center mb-2">Discount Slabs</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Min Value</th>
                            <th>Max Value</th>
                            <th>Discount (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($discountSlab as $slab)
                        <tr>
                            <td>{{ number_format($slab->min_value) }}</td>
                            <td>{{ $slab->max_value ? number_format($slab->max_value) : 'Above ' . number_format($slab->min_value) }}
                            </td>
                            <td>{{ $slab->discount_percentage }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                <h5 class="text-center mb-2">Cashback Slabs</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Min Value</th>
                            <th>Max Value</th>
                            <th>Advance (%)</th>
                            <th>Pay within 7 Days (%)</th>
                            <th>Pay within 30 Days (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cashbackSlab as $slab)
                            <tr>
                                <td>{{ number_format($slab->min_purchase_value) }}</td>
                                <td>{{ $slab->max_purchase_value ? number_format($slab->max_purchase_value) : 'Above ' . number_format($slab->max_purchase_value) }}</td>
                                <td>{{ $slab->advance_percentage}}</td>
                                <td>{{ $slab->days_7_percentage}}</td>
                                <td>{{ $slab->days_7_30_percentage}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row gs-cart-row ">

        @if (Session::has('cart'))
            @php
                $discountPercent = round(100 - ($totalPrice / ($totalDiscount + $totalPrice)) * 100);
                $cartTotal = ($totalPrice + $totalDiscount) ?? 0;
                $nextSlab = \App\Models\DiscountSlab::where('status', 1)
                    ->where('min_value', '>', $cartTotal)
                    ->orderBy('min_value')
                    ->first();
            @endphp

            <div class="col-lg-8">
                <div class="cart-table table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="">
                                <th scope="col">@lang('Product Name')</th>
                                <th scope="col">@lang('Price')</th>
                                <th scope="col">@lang('Quantity')</th>
                                <th scope="col">@lang('Subtotal')</th>
                                <th scope="col">@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody class="t_body">
                            @foreach ($products as $product)
                                            <tr class="">
                                                <td class="cart-product-area">
                                                    <div class="cart-product d-flex">
                                                        <img src="{{ $product['item']['photo'] ? asset('assets/images/products/' . $product['item']['photo']) : asset('assets/images/noimage.png') }}"
                                                            alt="">
                                                        <div class="cart-product-info">

                                                            <a class="cart-title d-inline-block"
                                                                href="{{ route('front.product', $product['item']['slug']) }}">{{ mb_strlen($product['item']['name'], 'UTF-8') > 35
                                ? mb_substr($product['item']['name'], 0, 35, 'UTF-8') . '...'
                                : $product['item']['name'] }}</a>

                                                            <div class="d-flex align-items-center gap-2">
                                                                @if (!empty($product['color']))
                                                                    @lang('Color') : <p class="cart-color d-inline-block rounded-2"
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
                                                    {{ App\Models\Product::convertPrice($product['item_price']) }}
                                                </td>

                                                @if ($product['item']['type'] == 'Physical')
                                                    <td>
                                                        <div class="cart-quantity">
                                                            <button class="cart-quantity-btn quantity-down">-</button>
                                                            <input type="text"
                                                                id="qty{{ $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']) }}"
                                                                value="{{ $product['qty'] }}" class="borderless" readonly>
                                                            <input type="hidden" class="prodid" value="{{ $product['item']['id'] }}">
                                                            <input type="hidden" class="itemid"
                                                                value="{{ $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']) }}">
                                                            <input type="hidden" class="size_qty" value="{{ $product['size_qty'] }}">
                                                            <input type="hidden" class="size_price" value="{{ $product['size_price'] }}">
                                                            <input type="hidden" class="minimum_qty"
                                                                value="{{ $product['item']['minimum_qty'] == null ? '0' : $product['item']['minimum_qty'] }}">

                                                            <button class="cart-quantity-btn quantity-up">+</button>
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
                                                    {{ App\Models\Product::convertPrice($product['price']) }}
                                                    @if ($product['discount'] != 0)
                                                        <strong>{{ $product['discount'] }}% {{ __('off') }}</strong>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="cart-remove-btn"
                                                        ata-class="cremove{{ $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values']) }}"
                                                        href="{{ route('product.cart.remove', $product['item']['id'] . $product['size'] . $product['color'] . str_replace(str_split(' ,'), '', $product['values'])) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none">
                                                            <path
                                                                d="M9 3H15M3 6H21M19 6L18.2987 16.5193C18.1935 18.0975 18.1409 18.8867 17.8 19.485C17.4999 20.0118 17.0472 20.4353 16.5017 20.6997C15.882 21 15.0911 21 13.5093 21H10.4907C8.90891 21 8.11803 21 7.49834 20.6997C6.95276 20.4353 6.50009 20.0118 6.19998 19.485C5.85911 18.8867 5.8065 18.0975 5.70129 16.5193L5 6M10 10.5V15.5M14 10.5V15.5"
                                                                stroke="#1F0300" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-summary">
                    <h4 class="cart-summary-title">@lang('Shopping Cart')</h4>
                    <div class="cart-summary-content">
                        <p style="color:#561fa1">
                            @if($nextSlab)
                                Avail <strong>{{ $nextSlab->discount_percentage }}%</strong> by adding items worth
                                <strong>₹{{ number_format($nextSlab->min_value - $cartTotal, 2) }}</strong> more to your cart!
                            @else
                                @php
                                    $currentSlab = \App\Models\DiscountSlab::where('status', 1)
                                        ->where('min_value', '<=', $cartTotal)
                                        ->where(function ($q) use ($cartTotal) {
                                            $q->whereNull('max_value')->orWhere('max_value', '>=', $cartTotal);
                                        })
                                        ->orderByDesc('min_value')
                                        ->first();
                                @endphp
                                @if($currentSlab)
                                    You've unlocked a <strong>{{ $currentSlab->discount_percentage }}%</strong> discount!
                                @else
                                    Add items to your cart to unlock discounts!
                                @endif
                            @endif
                        </p>
                        <div class="cart-summary-item d-flex justify-content-between">
                            <p class="cart-summary-subtitle">
                                @lang('MRP') 
                                 (Incl. GST)
                                {{-- ({{ count(Session::get('cart')->items) }}
                                @lang('Items')) --}}
                            </p>
                            <p class="cart-summary-price">
                                {{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice + $totalDiscount) : '0.00' }}
                            </p>
                        </div>
                        <div class="cart-summary-item d-flex justify-content-between">
                            <p class="cart-summary-subtitle">@lang('Discount')</p>
                            @if ($totalDiscount > 0)
                                <div class="d-flex flex-column align-items-end">
                                    <p class="cart-summary-price" style="margin: 0">
                                        - {{ App\Models\Product::convertPrice($totalDiscount) }}
                                        (-{{ $discountPercent }}% Off)
                                    </p>
                                    <p class="" data-bs-toggle="modal" data-bs-target="#discountSlabModal"
                                        style="text-align: end;cursor: pointer;">(View Discount Slabs)
                                    </p>
                                </div>
                            @else
                                <div class="d-flex flex-column align-items-end">
                                    <p class="cart-summary-price">0.00</p>
                                    <p class="" data-bs-toggle="modal" data-bs-target="#discountSlabModal"
                                        style="text-align: end;cursor: pointer;">(View Discount Slabs)
                                    </p>
                                </div>
                            @endif
                        </div>
                        <div class="cart-summary-item d-flex justify-content-between">
                            <p class="cart-summary-subtitle">@lang('Value (Excl. GST)')</p>
                            <p class="cart-summary-price">
                                {{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice / (1 + (18 / 100))) : '0.00' }}
                            </p>
                        </div>
                        <div class="cart-summary-item d-flex justify-content-between">
                            <p class="cart-summary-subtitle">@lang('GST')</p>
                            <p class="cart-summary-price">
                                {{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice - ($totalPrice / (1 + (18 / 100)))) : '0.00' }}
                            </p>
                        </div>
                        <div class="cart-summary-item d-flex justify-content-between">
                            <p class="cart-summary-subtitle">@lang('Total Amount Payable')</p>
                            <p class="cart-summary-price total-cart-price">
                                {{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice) : '0.00' }}
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
@if (Auth::check())
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
                                        <td>{{ $slab->max_value ? number_format($slab->max_value) : 'Above ' . number_format($slab->min_value) }}
                                        </td>
                                        <td>{{ $slab->discount_percentage }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="alert alert-info mt-3">
                            <p class="mb-1"><strong>Note:</strong> The discount slabs shown above are automatically
                                applied during checkout.</p>
                            <p class="mb-0">These discounts apply to the total value of your cart, not individual
                                items.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif