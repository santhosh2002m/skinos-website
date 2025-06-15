@extends('layouts.front')

@section('content')
    {{-- <sectiozk --}}
    <section class="gs-cart-section load_cart">
        <div class="container gs-cart-container">
            <div class="row gs-cart-row">

                @if ($totalQty > 0)

                    @php
                        $discount = 0;
                    @endphp



                    <div class="col-lg-8">
                        <div class="cart-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="">
                                        <th scope="col">@lang('Product Name')</th>
                                        <th scope="col">@lang('Price')</th>
                                        <th scope="col">@lang('Scheme')</th>
                                        <th scope="col">@lang('Subtotal')</th>
                                    </tr>
                                </thead>
                                <tbody class="t_body">
                                    @foreach ($products as $product)
                                                        @php
                                                            if ($product->discount != 0) {
                                                                $total_itemprice = $product->item_price * $product->qty;
                                                                $tdiscount = ($total_itemprice * $product->discount) / 100;
                                                                $discount += $tdiscount;
                                                            }
                                                        @endphp
                                                        <tr class="">
                                                            <td class="cart-product-area">
                                                                <div class="cart-product d-flex">
                                                                    <img src="{{ $product->item->photo ? asset('assets/images/products/' . $product->item->photo) : asset('assets/images/noimage.png') }}"
                                                                        alt="">
                                                                    <div class="cart-product-info">
                                                                        <a class="cart-title d-inline-block"
                                                                            href="{{ route('front.product', $product->item->slug) }}">{{ mb_strlen($product->item->name, 'UTF-8') > 35
                                        ? mb_substr($product->item->name, 0, 35, 'UTF-8') . '...'
                                        : $product->item->name }}</a>

                                                                        {{-- <div class="d-flex align-items-center gap-2">
                                                                            @if (!empty($product->color))
                                                                                @lang('Color') : <p class="cart-color d-inline-block rounded-2"
                                                                                    style="border: 10px solid #{{ $product->color == '' ? 'white' : $product->color }};">
                                                                                </p>
                                                                            @endif
                                                                            @if (!empty($product->size))
                                                                                @lang('Size') : <p class="d-inline-block">
                                                                                    {{ $product->size }}
                                                                                </p>
                                                                            @endif
                                                                        </div> --}}
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="cart-price">
                                                                {{ App\Models\Product::convertPrice($product->item_price) }}
                                                            </td>

                                                            @if ($product->item->type == 'Physical')
                                                                <td>
                                                                    <div class="cart-quantity">
                                                                        <input type="text"
                                                                            id="qty{{ $product->item->id . str_replace(str_split(' ,'), '', $product->values) }}"
                                                                            value="{{ $product->scheme->name_of_the_box }}" class="borderless" style="width: 80px"
                                                                            readonly>
                                                                    </div>
                                                                </td>
                                                            @else
                                                                <td class="product-quantity">
                                                                    1
                                                                </td>
                                                            @endif

                                                            <td class="cart-price"
                                                                id="prc{{ $product->item->id . str_replace(str_split(' ,'), '', $product->values) }}">
                                                                <span class="div" style="display: flex;flex-direction: column">
                                                                    {{ App\Models\Product::convertPrice($product->price) }}
                                                                    <del>{{ App\Models\Product::convertPrice($total_itemprice) }}</del>
                                                                </span>
                                                            </td>
                                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h4 class="cart-summary-title">@lang('Mix and Match Summary')</h4>
                            <div class="cart-summary-content">
                                <div class="cart-summary-item d-flex justify-content-between">
                                    <p class="cart-summary-subtitle">
                                        @lang('MRP') 
                                        ({{$totalQty}} 
                                        @lang('Items'))
                                    </p>
                                    <p class="cart-summary-price">
                                        {{ $totalQty > 0 ? App\Models\Product::convertPrice($totalPrice + $discount)
                                        : '0.00' }}
                                    </p>
                                </div>
                                <div class="cart-summary-item d-flex justify-content-between">
                                    <p class="cart-summary-subtitle">@lang('Discount')</p>
                                    <p class="cart-summary-price">- {{ App\Models\Product::convertPrice($discount) }}</p>
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
                                        {{ $totalQty > 0 ? App\Models\Product::convertPrice($mainTotal) : '0.00' }}
                                    </p>
                                </div>
                                <div class="cart-summary-btn">
                                    <a href="{{ route('user-mix_match_checkout') }}"
                                        class="template-btn w-100">@lang('Proceed to Checkout')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="card border py-4">
                            <div class="card-body d-flex flex-column">
                                <h4 class="text-center">{{ __('We dont have any current Mix and Match Product History.') }}</h4>
                                <button>
                                    <a href="{{ route('user-mix_match') }}" class="text-center btn btn-success mt-4">
                                        Go back to Mix and Match
                                    </a>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection