@extends('layouts.front')

@section('content')
    {{-- <section class="gs-breadcrumb-section bg-class"
        data-background="{{ $gs->breadcrumb_banner ? asset('assets/images/' . $gs->breadcrumb_banner) : asset('assets/images/noimage.png') }}">
        <div class="container">
            <div class="row justify-content-center content-wrapper">
                <div class="col-12">
                    <h2 class="breadcrumb-title">@lang('Cart')</h2>
                    <ul class="bread-menu">
                        <li><a href="{{ route('front.index') }}">@lang('Home')</a></li>
                        <li><a href="{{ route('front.cart') }}">@lang('Cart')</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="gs-cart-section load_cart" style="margin-top: 1.8rem">
        @if ($user_type == 'scheme_based_profile')
            @include('frontend.ajax.cart-page-scheme')
        @elseif ($user_type == 'net_discount_profile')
            @include('frontend.ajax.cart-page-discount')
        @else
            @include('frontend.ajax.cart-page')
        @endif
    </section>
@endsection
