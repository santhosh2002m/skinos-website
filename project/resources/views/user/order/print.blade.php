@php
   $creditPayLabels = [
      'days_7' => 'Within 7 Days',
      'days_7_30' => 'Within 7-30 Days',
   ];
@endphp
<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="{{$seo->meta_keys}}">
        <meta name="author" content="GeniusOcean">

        <title>{{$gs->title}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('assets/print/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/print/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('assets/print/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/print/css/style.css')}}">
  <link href="{{asset('assets/print/css/print.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}">
  <style type="text/css">

#color-bar {
  display: inline-block;
  width: 20px;
  height: 20px;
  margin-left: 5px;
  margin-top: 5px;
}

@page { size: auto;  margin: 0mm; }
@page {
  size: A4;
  margin: 0;
}
@media print 
  html, body {
    width: 210mm;
    height: 287mm;
  }

html {

}
::-webkit-scrollbar {
    width: 0px;  /* remove scrollbar space */
    background: transparent;  /* optional: just make scrollbar invisible */
}
  </style>
</head>
<body onload="window.print();">
   <div class="container-fluid">
   <div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <!-- Starting of Dashboard data-table area -->
      <div class="section-padding add-product-1">
         <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="product__header">
                  <div class="row reorder-xs">
                     <div class="col-lg-8 col-md-5 col-sm-5 col-xs-12">
                        <div class="product-header-title">
                           <h2>{{ __('Order#') }} {{$order->order_number}} [{{$order->status}}]</h2>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-10">
                           <div class="dashboard-content">
                              <div class="view-order-page" id="print">
                                 <p class="order-date" style="margin-left: 2%">{{ __('Order Date') }} {{date('d-M-Y',strtotime($order->created_at))}}</p>
                                 @if($order->dp == 1)
                                 <div class="billing-add-area">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <h5>{{ __('Billing Address') }}</h5>
                                          <address>
                                             {{ __('Name:') }} {{$order->customer_name}}<br>
                                             {{ __('Email:') }} {{$order->customer_email}}<br>
                                             {{ __('Phone:') }} {{$order->customer_phone}}<br>
                                             {{ __('Address:') }} {{$order->customer_address}}<br>
                                             {{$order->customer_city}}-{{$order->customer_zip}}
                                          </address>
                                       </div>
                                       <div class="col-md-6">
                                          <h5>{{ __('Payment Information') }}</h5>
                                          <p>{{ __('GST:') }}  {{ \PriceHelper::showOrderCurrencyPrice($order->pay_amount - ($order->pay_amount / (1 + (18 / 100))),$order->currency_sign) }}</p>
                                          <p>{{ __('Paid Amount:') }} {{ \PriceHelper::showOrderCurrencyPrice(($order->pay_amount  * $order->currency_value),$order->currency_sign) }}</p>
                                          @if($order->wallet_price > 0)
                                             <p>{{ __('Amount Paid via Wallet :') }} {{ \PriceHelper::showOrderCurrencyPrice(($order->wallet_price * $order->currency_value),$order->currency_sign) }}</p>
                                          @endif
                                          <p>{{ __('Payment Method:') }} {{$order->method}}</p>
                                          @if($order->method != "Cash On Delivery")
                                          @if($order->method=="Stripe")
                                          {{$order->method}} {{ __('Charge ID:') }} 
                                          <p>{{$order->charge_id}}</p>
                                          @endif
                                          {{$order->method}} {{ __('Transaction ID:') }} 
                                          <p id="ttn">{{$order->txnid}}</p>
                                          @endif
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="invoice__metaInfo">
                                    <div class="col-md-6">
                                       <h5>{{ __('Billing Address') }}</h5>
                                       <address>
                                          {{ __('Name:') }} {{$order->customer_name}}<br>
                                          {{ __('Email:') }} {{$order->customer_email}}<br>
                                          {{ __('Phone:') }} {{$order->customer_phone}}<br>
                                          {{ __('Address:') }} {{$order->customer_address}}<br>
                                          {{$order->customer_city}}-{{$order->customer_zip}}
                                       </address>
                                       <h5>{{ __('Payment Information') }}</h5>
                                       <p>{{ __('GST:') }}  {{ \PriceHelper::showOrderCurrencyPrice($order->pay_amount - ($order->pay_amount / (1 + (18 / 100))),$order->currency_sign) }}</p>
                                       @if ($order->redeem_cb_in_invoice > 0)
                                             <p><span>@lang('Paid Amount :') </span>
                                                {{ \PriceHelper::showOrderCurrencyPrice(($order->pay_amount - ($order->pay_amount * ($order->redeem_cb_in_invoice/100) )) * $order->currency_value, $order->currency_sign) }}
                                             </p>
                                       @else
                                             <p><span>@lang('Paid Amount :') </span>
                                                {{ \PriceHelper::showOrderCurrencyPrice($order->pay_amount * $order->currency_value, $order->currency_sign) }}
                                             </p>
                                       @endif
                                       @if($order->wallet_price > 0)
                                          <p>{{ __('Amount Paid via Wallet :') }} {{ \PriceHelper::showOrderCurrencyPrice(($order->wallet_price * $order->currency_value),$order->currency_sign) }}</p>
                                       @endif
                                       @if ($order->redeem_cb_in_invoice > 0)
                                             <p><span>@lang('CB Redeemed in invoice :') </span>
                                                {{ \PriceHelper::showOrderCurrencyPrice(($order->pay_amount * ($order->redeem_cb_in_invoice/100) ) * $order->currency_value, $order->currency_sign) }}
                                             </p>
                                       @else
                                             <p><span>@lang('CB credited to wallet :') </span>
                                                {{ \PriceHelper::showOrderCurrencyPrice(($order->pay_amount * ($order->cashback_percentage/100) ) * $order->currency_value, $order->currency_sign) }}
                                             </p>
                                       @endif
                                       @if ($order->credit_pay_time && $order->credit_pay_time !== 'advance')
                                          <p>
                                                <span>@lang('Credit Period :')</span>
                                                {{ $creditPayLabels[$order->credit_pay_time] ?? $order->credit_pay_time }}
                                          </p>
                                       @endif
                                       <p>{{ __('Payment Method:') }} {{$order->method}}</p>
                                       @if($order->method != "Cash On Delivery")
                                       @if($order->method=="Stripe")
                                       {{$order->method}} {{ __('Charge ID:') }} 
                                       <p>{{$order->charge_id}}</p>
                                       @endif
                                       {{$order->method}} {{ __('Transaction ID:') }} 
                                       <p id="ttn">{{$order->txnid ?? "NA"}}</p>
                                       @endif
                                    </div>
                                    <div class="col-md-6" style="width: 50%;">
                                       @if ($order->sales_rep_id !== null)
                                          <div class="address-item">
                                             <h5>@lang('Sales Representative')</h5>
                                                   <p>@lang('Ordered by:')</p>
                                                   <p>
                                                      {{ $order->sales_rep_name }}
                                                   </p>
                                                   <p>
                                                      {{ $order->sales_rep_phone }}
                                                   </p>
                                                   <p>
                                                      {{ $order->sales_rep_email }}
                                                   </p>
                                          </div>
                                       @endif
                                       @if($order->shipping == "shipto")
                                       <h5>{{ __('Shipping Address') }}</h5>
                                       <address>
                                          {{ __('Name:') }} {{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}<br>
                                          {{ __('Email:') }} {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}<br>
                                          {{ __('Phone:') }} {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}<br>
                                          {{ __('Address:') }} {{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}<br>
                                          {{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}-{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}
                                       </address>
                                       @else
                                       <!--<h5>{{ __('PickUp Location') }}</h5>
                                       <address>
                                          {{ __('Address:') }} {{$order->pickup_location}}<br>
                                       </address>
                                       -->
                                       @endif
                                       <!--
                                       <h5>{{ __('Shipping Method') }}</h5>
                                       @if($order->shipping == "shipto")
                                       <p>{{ __('Ship To Address') }}</p>
                                       @else
                                       <p>{{ __('Pick Up') }}</p>
                                       @endif
                                       -->
                                    </div>
                                 </div>
                                 @endif
                                 <br>
                                 <br>
                                 <div class="table-responsive">
                                    <table id="example" class="table">
                                       <h4 class="text-center">{{ __('Ordered Products:') }}</h4>
                                       <hr>
                                       <thead>
                                          <tr>
                                             <th width="10%">{{ __('ID#') }}</th>
                                             <th>{{ __('Name') }}</th>
                                             <th width="20%">{{ __('Details') }}</th>
                                             <th width="20%">{{ __('Price') }}</th>
                                             <th width="10%">{{ __('Total') }}</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       @php
                                          $groupedCartItems = collect($cart['items'])->groupBy(function ($product) {
                                             return $product['mix_match_batch'] ?? 'no_batch';
                                          });
                                       @endphp

                                       @foreach ($groupedCartItems as $batchKey => $group)
                                          @if ($batchKey === 'no_batch')
                                             @foreach ($group as $product)
                                                   <tr class="tbody-product">
                                                      <td><b><span class="td-title">{{ $product['item']['id'] }}</span></b></td>

                                                      <td class="td-product-name">
                                                         <div class="td-title td-product-namee">
                                                               <input type="hidden" value="{{ $product['license'] }}">
                                                               @php $user = $product['item']['user_id'] != 0 ? App\Models\User::find($product['item']['user_id']) : null; @endphp
                                                               <b>
                                                                  <p>
                                                                     {{ mb_strlen($product['item']['name'], 'UTF-8') > 50
                                                                           ? mb_substr($product['item']['name'], 0, 50, 'UTF-8') . '...'
                                                                           : $product['item']['name'] }}
                                                                  </p>
                                                               </b>

                                                               @if ($product['item']['type'] != 'Physical' && $order->payment_status == 'Completed')
                                                                  @if ($product['item']['file'] != null)
                                                                     <a class="title-hover-color"
                                                                        href="{{ route('user-order-download', ['slug' => $order->order_number, 'id' => $product['item']['id']]) }}">
                                                                           <i class="fa fa-download"></i> {{ __('Download') }}
                                                                     </a>
                                                                  @elseif($product['item']['link'])
                                                                     <a class="title-hover-color" target="_blank"
                                                                        href="{{ $product['item']['link'] }}">
                                                                           <i class="fa fa-download"></i> {{ __('Download') }}
                                                                     </a>
                                                                  @endif

                                                                  @if ($product['license'] != '')
                                                                     <a href="javascript:;" data-toggle="modal" data-target="#licence"
                                                                        class="btn btn-sm btn-info product-btn" id="license">
                                                                           <i class="fa fa-eye"></i> {{ __('View License') }}
                                                                     </a>
                                                                  @endif
                                                               @endif
                                                         </div>

                                                         {{--<span class="license-key">License key: ...</span>--}}
                                                      </td>

                                                      <td>
                                                         <p><b><span>@lang('Quantity:')</span></b> {{ $product['qty'] }}</p>
                                                      </td>

                                                      <td>
                                                         <b>
                                                               <span class="td-title">
                                                                  {{ \PriceHelper::showCurrencyPrice($product['item_price'] * $order->currency_value) }}
                                                               </span>
                                                         </b>
                                                      </td>

                                                      <td>
                                                         <b>
                                                               <span class="td-title">
                                                                  @if(auth()->user()->preferred_type === 'scheme_based_profile' && !empty($product['scheme']['discount_percentage']))
                                                                     {{ \PriceHelper::showCurrencyPrice(
                                                                           (($product['item_price'] * $product['qty']) -
                                                                           ($product['item_price'] * $product['qty']) * ($product['scheme']['discount_percentage'] / 100)) * $order->currency_value
                                                                     ) }}
                                                                  @else
                                                                     {{ \PriceHelper::showCurrencyPrice(
                                                                           ($product['item_price'] * $product['qty']) * $order->currency_value
                                                                     ) }}
                                                                  @endif
                                                               </span>
                                                         </b>
                                                      </td>
                                                   </tr>
                                             @endforeach

                                          @else
                                             @php
                                                   $first = $group[0];
                                                   $bundleName = $first['scheme']['name'] ?? 'Mix Bundle';
                                                   $totalQty = collect($group)->sum('qty');
                                                   $totalItemPrice = collect($group)->sum(fn($p) => $p['item_price']);
                                                   $totalPrice = collect($group)->sum(function ($p) {
                                                      if (auth()->user()->preferred_type === 'scheme_based_profile' && !empty($p['scheme']['discount_percentage'])) {
                                                         return ($p['item_price'] * $p['qty']) - (($p['item_price'] * $p['qty']) * ($p['scheme']['discount_percentage'] / 100));
                                                      } else {
                                                         return $p['item_price'] * $p['qty'];
                                                      }
                                                   });
                                             @endphp
                                             <tr class="tbody-product bundle-group-row">
                                                   <td><b><span class="td-title">Mix and Match</span></b></td>

                                                   <td class="td-product-name">
                                                      <div class="td-title td-product-namee">
                                                         <span>Scheme: <b>{{ $bundleName }}</b></span>
                                                         <ul style="margin: 5px 0;padding-left: 0;">
                                                               @foreach ($group as $product)
                                                                  <li style="display: flex; gap: 0.3rem">
                                                                     <p>
                                                                           {{ mb_strlen($product['item']['name'], 'UTF-8') > 20
                                                                              ? mb_substr($product['item']['name'], 0, 20, 'UTF-8') . '...'
                                                                              : $product['item']['name'] }}
                                                                     </p>
                                                                     -
                                                                     <p>({{ $product['scheme']['name_of_the_box'] }})</p>
                                                                  </li>
                                                               @endforeach
                                                         </ul>
                                                      </div>
                                                   </td>

                                                   <td>
                                                         <p><b><span>@lang('Quantity:')</span></b> {{ $totalQty }}</p>
                                                   </td>

                                                   <td>
                                                      <b>
                                                         <span class="td-title">
                                                               {{ \PriceHelper::showCurrencyPrice($totalItemPrice * $order->currency_value) }}
                                                         </span>
                                                      </b>
                                                   </td>

                                                   <td>
                                                      <b>
                                                         <span class="td-title">
                                                               {{ \PriceHelper::showCurrencyPrice($totalPrice * $order->currency_value) }}
                                                         </span>
                                                      </b>
                                                   </td>
                                             </tr>
                                          @endif
                                       @endforeach

                                       </tbody>
                                       <tfoot>
                                          <tr>
                                             <td colspan="5" style="text-align: right; padding-top: 20px;">
                                                <div style="display: inline-block; text-align: right;">
                                                   <p><strong>@lang('GST') (18%):</strong> {{ App\Models\Product::convertPrice($cart['totalPrice'] - ($cart['totalPrice'] / (1 + (18 / 100)))) }}</p>
                                                   <p><strong>@lang('Final Price'):</strong> {{ $cart ? App\Models\Product::convertPrice($cart['totalPrice']) : '0.00' }}</p>
                                                </div>
                                             </td>
                                          </tr>
                                       </tfoot>

                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Ending of Dashboard data-table area -->
   </div>
   <!-- ./wrapper -->
   <!-- ./wrapper -->
   <script type="text/javascript">
      (function($) {
      "use strict";
      
      setTimeout(function () {
          window.close();
        }, 500);
      
      })(jQuery);
      
   </script>
</body>
</html>
