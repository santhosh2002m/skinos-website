@extends('layouts.admin')

@section('styles')
<style type="text/css">
    .order-table-wrap table#example2 {
        margin: 10px 20px;
    }
</style>
@endsection

@section('content')
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Order Details') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                <ul class="links">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Orders') }}</a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Order Details') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="order-table-wrap">
        @include('alerts.admin.form-both')
        @include('alerts.form-success')
        <div class="row">
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area">
                        <h4 class="title">
                            {{ __('Order Details') }}
                        </h4>
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th width="45%">{{ __('Order ID') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->order_number }}</td>
                                </tr>
                                <tr>
                                    <th width="45%">{{ __('Total Product') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->totalQty }}</td>
                                </tr>
                                @if($order->shipping_title != null && $order->is_shipping == 0)
                                <tr>
                                    <th width="45%">{{ __('Shipping Method') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->shipping_title }}</td>
                                </tr>
                                @endif
                                @if($order->shipping_cost != 0)
                                <tr>
                                    <th width="45%">{{ __('Shipping Cost') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ \PriceHelper::showOrderCurrencyPrice($order->shipping_cost, $order->currency_sign) }}</td>
                                </tr>
                                @endif
                                @if($order->tax != 0)
                                <tr>
                                    <th width="45%">{{ __('GST') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ \PriceHelper::showOrderCurrencyPrice(($order->pay_amount - ($order->pay_amount / (1 + (18 / 100)))), $order->currency_sign) }}</td>
                                </tr>
                                @endif
                                @if($order->packing_title != null && $order->is_shipping == 0)
                                <tr>
                                    <th width="45%">{{ __('Packaging Method') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->packing_title }}</td>
                                </tr>
                                @endif
                                @if($order->packing_cost != 0)
                                <tr>
                                    <th width="45%">{{ __('Packaging Cost') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ \PriceHelper::showOrderCurrencyPrice($order->packing_cost, $order->currency_sign) }}</td>
                                </tr>
                                @endif
                                @if($order->wallet_price != 0)
                                <tr>
                                    <th width="45%">{{ __('Amount Paid via Wallet') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ \PriceHelper::showOrderCurrencyPrice(($order->wallet_price * $order->currency_value), $order->currency_sign) }}</td>
                                </tr>
                                @endif
                                @if($order->redeem_cb_in_invoice > 0)
                                <tr>
                                    <th width="45%">{{ __('CB Redeemed in Invoice') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ \PriceHelper::showOrderCurrencyPrice(($order->pay_amount * ($order->redeem_cb_in_invoice/100) * $order->currency_value), $order->currency_sign) }}</td>
                                </tr>
                                @else
                                <tr>
                                    <th width="45%">{{ __('CB Credited to Wallet') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ \PriceHelper::showOrderCurrencyPrice(($order->pay_amount * ($order->cashback_percentage/100) * $order->currency_value), $order->currency_sign) }}</td>
                                </tr>
                                @endif
                                @if($order->credit_pay_time && $order->credit_pay_time !== 'advance')
                                <tr>
                                    <th width="45%">{{ __('Credit Period') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ isset($creditPayLabels[$order->credit_pay_time]) ? $creditPayLabels[$order->credit_pay_time] : $order->credit_pay_time }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th width="45%">{{ __('Total Cost') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ \PriceHelper::showOrderCurrencyPrice((($order->pay_amount + $order->wallet_price) * $order->currency_value), $order->currency_sign) }}</td>
                                </tr>
                                <tr>
                                    <th width="45%">{{ __('Ordered Date') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ date('d-M-Y H:i:s a', strtotime($order->created_at)) }}</td>
                                </tr>
                                @if($order->sales_rep_id)
                                    <tr>
                                        <th width="45%">{{ __('S.R. ID') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{ $order->sales_rep_id }}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%"> {{ __('S.R. Name') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{ $order->sales_rep_name }}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('S.R. Email') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{ $order->sales_rep_email }}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('S.R. Phone') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{ $order->sales_rep_phone }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th width="45%">{{ __('Payment Method') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->method }}</td>
                                </tr>
                                @if($order->method != "Cash On Delivery" && $order->method != "Wallet")
                                @if($order->method == "Stripe")
                                <tr>
                                    <th width="45%">{{ $order->method }} {{ __('Charge ID') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->charge_id }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th width="45%">{{ $order->method }} {{ __('Transaction ID') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->txnid }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th width="45%">{{ __('Payment Status') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">
                                        @if($order->payment_status == 'Pending')
                                        <span class='badge badge-danger'>{{ __('Unpaid') }}</span>
                                        @else
                                        <span class='badge badge-success'>{{ __('Paid') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @if(!empty($order->order_note))
                                <tr>
                                    <th width="45%">{{ __('Order Note') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->order_note }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="footer-area">
                        <a href="{{ route('admin-order-invoice', $order->id) }}" class="mybtn1"><i class="fas fa-eye"></i> {{ __('View Invoice') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area">
                        <h4 class="title">
                            {{ __('Billing Details') }}
                            <a class="f15" href="javascript:;" data-toggle="modal" data-target="#billing-details-edit"><i class="fas fa-edit"></i>{{ __("Edit") }}</a>
                        </h4>
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th width="45%">{{ __('Name') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->customer_name }}</td>
                                </tr>
                                <tr>
                                    <th width="45%">{{ __('Email') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->customer_email }}</td>
                                </tr>
                                <tr>
                                    <th width="45%">{{ __('Phone') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->customer_phone }}</td>
                                </tr>
                                <tr>
                                    <th width="45%">{{ __('Address') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->customer_address }}</td>
                                </tr>
                                <tr>
                                    <th width="45%">{{ __('Country') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->customer_country }}</td>
                                </tr>
                                @if($order->customer_state != null)
                                <tr>
                                    <th width="45%">{{ __('State') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->customer_state }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th width="45%">{{ __('City') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->customer_city }}</td>
                                </tr>
                                <tr>
                                    <th width="45%">{{ __('Postal Code') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->customer_zip }}</td>
                                </tr>
                                @if($order->coupon_code != null)
                                <tr>
                                    <th width="45%">{{ __('Coupon Code') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->coupon_code }}</td>
                                </tr>
                                @endif
                                @if($order->coupon_discount != null)
                                <tr>
                                    <th width="45%">{{ __('Coupon Discount') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $gs->currency_format == 0 ? $order->currency_sign . $order->coupon_discount : $order->coupon_discount . $order->currency_sign }}</td>
                                </tr>
                                @endif
                                @if($order->affilate_user != null)
                                <tr>
                                    <th width="45%">{{ __('Affilate User') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">
                                        @if(App\Models\User::where('id', $order->affilate_user)->exists())
                                        {{ App\Models\User::where('id', $order->affilate_user)->first()->name }}
                                        @else
                                        {{ __('Deleted') }}
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @if($order->affilate_charge != null)
                                <tr>
                                    <th width="45%">{{ __('Affilate Charge') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ \PriceHelper::showOrderCurrencyPrice(($order->affilate_charge * $order->currency_value), $order->currency_sign) }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if($order->dp == 0)
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area">
                        <h4 class="title">
                            {{ __('Shipping Details') }}
                            <a class="f15" href="javascript:;" data-toggle="modal" data-target="#shipping-details-edit"><i class="fas fa-edit"></i>{{ __("Edit") }}</a>
                        </h4>
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>
                                @if($order->shipping == "pickup")
                                <tr>
                                    <th width="45%"><strong>{{ __('Pickup Location') }}:</strong></th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->pickup_location }}</td>
                                </tr>
                                @else
                                <tr>
                                    <th width="45%"><strong>{{ __('Name') }}:</strong></th>
                                    <td width="10%">:</td>
                                    <td>{{ $order->shipping_name == null ? $order->customer_name : $order->shipping_name }}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('Email') }}:</strong></th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->shipping_email == null ? $order->customer_email : $order->shipping_email }}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('Phone') }}:</strong></th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone }}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('Address') }}:</strong></th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->shipping_address == null ? $order->customer_address : $order->shipping_address }}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('Country') }}:</strong></th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->shipping_country == null ? $order->customer_country : $order->shipping_country }}</td>
                                </tr>
                                <tr>
                                    <th width="45%">{{ __('State') }}</th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->shipping_state == null ? $order->customer_state : $order->shipping_state }}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('City') }}:</strong></th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->shipping_city == null ? $order->customer_city : $order->shipping_city }}</td>
                                </tr>
                                <tr>
                                    <th width="45%"><strong>{{ __('Postal Code') }}:</strong></th>
                                    <td width="10%">:</td>
                                    <td width="45%">{{ $order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @php
            // Define credit pay labels for credit period
            $creditPayLabels = [
                'days_7' => 'Within 7 Days',
                'days_7_30' => 'Within 7-30 Days'
            ];

            // Group cart items by user_id
            $resultArray = [];
            foreach ($cart['items'] as $key => $item) {
                $userId = $item['user_id'];
                if (!isset($resultArray[$userId])) {
                    $resultArray[$userId] = [];
                }
                $resultArray[$userId][$key] = $item;
            }
        @endphp

        <div class="row">
            <div class="col-lg-12 order-details-table">
                @foreach($resultArray as $key1 => $productt)
                @php
                    if($key1 == 0){
                        $vendor = App\Models\Admin::find(1);
                    }else{
                        $vendor = App\Models\User::find($key1);
                    }
                @endphp
                <div class="mr-table">
                    <h4 class="title">
                        <a href="javascript:;" data-toggle="modal" vendor="{{ $key1 }}" vendor-store="{{ $vendor->shop_name }}" class="mybtn1 pl-2 show_add_product" data-target="#add-product"><i class="fas fa-plus"></i>{{ __("Add Product") }}</a> {{ __('Products Ordered By') }} - <strong>{{ $vendor->shop_name }}</strong>
                    </h4>
                    <div class="table-responsive">
                        <table class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __('Product ID#') }}</th>
                                    <th>{{ __('Vendor Status') }}</th>
                                    <th>{{ __('Product Title') }}</th>
                                    <th>{{ __('Details') }}</th>
                                    <th>{{ __('Total Price') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $vendor_total = 0;
                                @endphp
                                @foreach ($productt as $itemKey => $product)
                                @php
                                    $vendor_total += $product['price'];
                                @endphp
                                <tr>
                                    <td><input type="hidden" value="{{ $key1 }}">{{ $product['item']['id'] }}</td>
                                    <td>
                                        @if($product['item']['user_id'] != 0)
                                        @php
                                            $user = App\Models\VendorOrder::where('order_id', '=', $order->id)->where('user_id', '=', $product['item']['user_id'])->first();
                                        @endphp
                                        @if($order->dp == 1 && $order->payment_status == 'Completed')
                                        <span class="badge badge-success">{{ __('Completed') }}</span>
                                        @else
                                        @if($user && $user->status == 'pending')
                                        <span class="badge badge-warning">{{ ucwords($user->status) }}</span>
                                        @elseif($user && $user->status == 'processing')
                                        <span class="badge badge-info">{{ ucwords($user->status) }}</span>
                                        @elseif($user && $user->status == 'on delivery')
                                        <span class="badge badge-primary">{{ ucwords($user->status) }}</span>
                                        @elseif($user && $user->status == 'completed')
                                        <span class="badge badge-success">{{ ucwords($user->status) }}</span>
                                        @elseif($user && $user->status == 'declined')
                                        <span class="badge badge-danger">{{ ucwords($user->status) }}</span>
                                        @endif
                                        @endif
                                        @endif
                                    </td>
                                    <td>
                                        <input type="hidden" value="{{ $product['license'] }}">
                                        @if($product['item']['user_id'] != 0)
                                        @php
                                            $user = App\Models\User::find($product['item']['user_id']);
                                        @endphp
                                        @if(isset($user))
                                        <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{ mb_strlen($product['item']['name'], 'utf-8') > 30 ? mb_substr($product['item']['name'], 0, 30, 'utf-8') . '...' : $product['item']['name'] }}</a>
                                        @else
                                        <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{ mb_strlen($product['item']['name'], 'utf-8') > 30 ? mb_substr($product['item']['name'], 0, 30, 'utf-8') . '...' : $product['item']['name'] }}</a>
                                        @endif
                                        @else
                                        <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{ mb_strlen($product['item']['name'], 'utf-8') > 30 ? mb_substr($product['item']['name'], 0, 30, 'utf-8') . '...' : $product['item']['name'] }}</a>
                                        @endif
                                        @if($product['license'] != '')
                                        <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-info product-btn license" style="padding: 5px 12px;"><i class="fa fa-eye"></i> {{ __('View License') }}</a>
                                        @endif
                                        @if($product['affilate_user'] != 0)
                                        <p>
                                            <strong>{{ __('Referral User') }} :</strong> {{ \App\Models\User::find($product['affilate_user'])->name }}
                                        </p>
                                        @endif
                                    </td>
                                    <td>
                                        @if($product['color'])
                                        <p>
                                            <strong>{{ __('Color') }} :</strong> <span style="width: 20px; height: 20px; display: inline-block; vertical-align: middle; border-radius: 50%; background: #{{ $product['color'] }};"></span>
                                        </p>
                                        @endif
                                        <p>
                                            <strong>{{ __('Price') }} :</strong> {{ \PriceHelper::showCurrencyPrice(($product['item_price'] * $order->currency_value)) }}
                                        </p>
                                        <p>
                                            <strong>{{ __('Qty') }} :</strong> {{ $product['qty'] }} {{ $product['item']['measure'] }}
                                        </p>
                                    </td>
                                    <td>
                                        {{ \PriceHelper::showCurrencyPrice($product['price'] * $order->currency_value) }}
                                    </td>
                                </tr>
                                @endforeach
                                @php
                                    $order_shipping = @json_decode($order->vendor_shipping_id, true);
                                    $order_package = @json_decode($order->vendor_packing_id, true);
                                    $vendor_shipping_id = isset($order_shipping[$key1]) ? $order_shipping[$key1] : null;
                                    $vendor_package_id = isset($order_package[$key1]) ? $order_package[$key1] : null;
                                    $shipping = $vendor_shipping_id ? App\Models\Shipping::findOrFail($vendor_shipping_id) : null;
                                    $package = $vendor_package_id ? App\Models\Package::findOrFail($vendor_package_id) : null;
                                @endphp
                                <tr>
                                    <td colspan="7">
                                        <div class="text-right mx-4">
                                            @if($shipping)
                                            <p>
                                                {{ __('Shipping Method') }} :
                                                <strong>{{ $shipping->title }} | {{ \PriceHelper::showCurrencyPrice($shipping->price * $order->currency_value) }}</strong>
                                            </p>
                                            @endif
                                            @if($package)
                                            <p>
                                                {{ __('Packaging Method') }} :
                                                <strong>{{ $package->title }} | {{ \PriceHelper::showCurrencyPrice($package->price * $order->currency_value) }}</strong>
                                            </p>
                                            @endif
                                            <p>
                                                {{ __('Total Amount') }} :
                                                <strong>{{ \PriceHelper::showCurrencyPrice(($vendor_total + ($shipping ? $shipping->price : 0) + ($package ? $package->price : 0)) * $order->currency_value) }}</strong>
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-12 text-center mt-2">
                <a class="btn sendEmail send" href="javascript:;" data-email="{{ $order->customer_email }}" data-toggle="modal" data-target="#vendorform">
                    <i class="fa fa-send"></i> {{ __('Send Email') }}
                </a>
            </div>
        </div>
    </div>
</div>

{{-- LICENSE MODAL --}}
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-block text-center">
                <h4 class="modal-title d-inline-block">{{ __('License Key') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">{{ __('The License Key is') }} : <span id="key"></span> <a href="javascript:;" id="license-edit">{{ __('Edit License') }}</a><a href="javascript:;" id="license-cancel" class="showbox">{{ __('Cancel') }}</a></p>
                <form method="POST" action="{{ route('admin-order-license', $order->id) }}" id="edit-license" style="display: none;">
                    {{ csrf_field() }}
                    <input type="hidden" name="license_key" id="license-key" value="">
                    <div class="form-group text-center">
                        <input type="text" name="license" placeholder="{{ __('Enter New License Key') }}" style="width: 40%; border: none;" required>
                        <input type="submit" name="submit" class="btn btn-primary" style="border-radius: 0; padding: 2px; margin-bottom: 2px;">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
{{-- LICENSE MODAL ENDS --}}

{{-- BILLING DETAILS EDIT MODAL --}}
@include('admin.order.partials.billing-details')
{{-- BILLING DETAILS MODAL ENDS --}}

{{-- SHIPPING DETAILS EDIT MODAL --}}
@include('admin.order.partials.shipping-details')
{{-- SHIPPING DETAILS MODAL ENDS --}}

{{-- ADD PRODUCT MODAL --}}
@include('admin.order.partials.add-product')
{{-- ADD PRODUCT MODAL ENDS --}}

{{-- EDIT PRODUCT MODAL --}}
<div class="modal fade" id="edit-product-modal" tabindex="-1" role="dialog" aria-labelledby="edit-product-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="submit-loader">
                <img src="{{ asset('assets/images/' . $gs->admin_loader) }}" alt="">
            </div>
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit Item') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
{{-- EDIT PRODUCT MODAL ENDS --}}

{{-- DELETE PRODUCT MODAL --}}
<div class="modal fade" id="delete-product-modal" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-block text-center">
                <h4 class="modal-title d-inline-block">{{ __('Confirm Delete') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">{{ __('You are about to delete this item from this cart.') }}</p>
                <p class="text-center">{{ __('Do you want to proceed?') }}</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger btn-ok">{{ __('Delete') }}</a>
            </div>
        </div>
    </div>
</div>
{{-- DELETE PRODUCT MODAL ENDS --}}

{{-- MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">{{ __('Send Email') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="contact-form">
                                    <form id="emailreply">
                                        {{ csrf_field() }}
                                        <ul>
                                            <li>
                                                <input type="email" class="input-field eml-val" id="eml" name="to" placeholder="{{ __('Email') }} *" value="" required>
                                            </li>
                                            <li>
                                                <input type="text" class="input-field" id="subj" name="subject" placeholder="{{ __('Subject') }} *" required>
                                            </li>
                                            <li>
                                                <textarea class="input-field textarea" name="message" id="msg" placeholder="{{ __('Your Message') }} *" required></textarea>
                                            </li>
                                        </ul>
                                        <button class="submit-btn" id="emlsub" type="submit">{{ __('Send Email') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- MESSAGE MODAL ENDS --}}

{{-- ORDER MODAL --}}
<div class="modal fade" id="confirm-delete2" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="submit-loader">
                <img src="{{ asset('assets/images/' . $gs->admin_loader) }}" alt="">
            </div>
            <div(terminals class="modal-header d-block text-center">
                <h4 class="modal-title d-inline-block">{{ __('Update Status') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center">{{ __("You are about to update the order's status.") }}</p>
                <p class="text-center">{{ __('Do you want to proceed?') }}</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-success btn-ok order-btn">{{ __('Proceed') }}</a>
            </div>
        </div>
    </div>
</div>
{{-- ORDER MODAL ENDS --}}

@endsection

@section('scripts')
<script type="text/javascript">
    (function($) {
        "use strict";

        $(document).on('click', '.show_add_product', function() {
            let vendor_id = $(this).attr('vendor');
            $('#add_vendor_id').val(vendor_id);
            let message = `You can add only <strong>(${$(this).attr('vendor-store')})</strong> Store Product`;
            $('.show_vendor_message').html(message);
        });

        function disablekey() {
            document.onkeydown = function(e) {
                return false;
            }
        }

        function enablekey() {
            document.onkeydown = function(e) {
                return true;
            }
        }

        $('#example2').dataTable({
            "ordering": false,
            'lengthChange': false,
            'searching': false,
            'ordering': false,
            'info': false,
            'autoWidth': false,
            'responsive': true
        });

        $(document).on('click', '.license', function(e) {
            var id = $(this).parent().find('input[type=hidden]').val();
            var key = $(this).parent().parent().find('input[type=hidden]').val();
            $('#key').html(id);
            $('#license-key').val(key);
        });

        $(document).on('click', '#license-edit', function(e) {
            $(this).hide();
            $('#edit-license').show();
            $('#license-cancel').show();
        });

        $(document).on('click', '#license-cancel', function(e) {
            $(this).hide();
            $('#edit-license').hide();
            $('#license-edit').show();
        });

        @if(Session::has('license'))
        $.notify('{{ Session::get('license') }}', 'success');
        @endif

        $(document).on('click', '.edit-product', function() {
            if (admin_loader == 1) {
                $('.submit-loader').show();
            }
            $('#edit-product-modal .modal-content .modal-body').html('').load($(this).data('href'), function(response, status, xhr) {
                if (status == "success") {
                    if (admin_loader == 1) {
                        $('.submit-loader').hide();
                    }
                }
            });
        });

        $(document).on('submit', '#show-product', function(e) {
            e.preventDefault();
            if (admin_loader == 1) {
                $('.submit-loader').show();
            }
            $('button.addProductSubmit-btn').prop('disabled', true);
            disablekey();
            $.ajax({
                method: "POST",
                url: $(this).prop('action'),
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    if (data[0]) {
                        $('#product-show').html('').load(mainurl + "/admin/order/product-show/" + data[1], function(response, status, xhr) {
                            if (status == "success") {
                                if (admin_loader == 1) {
                                    $('.submit-loader').hide();
                                }
                            }
                        });
                    } else {
                        if (admin_loader == 1) {
                            $('.submit-loader').hide();
                        }
                        $('#product-show').html('<div class="col-lg-12 text-center"><h4>' + data[1] + '.</h4></div>')
                    }
                    $('button.addProductSubmit-btn').prop('disabled', false);
                    enablekey();
                }
            });
        });

        $('#delete-product-modal').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    })(jQuery);
</script>
@endsection