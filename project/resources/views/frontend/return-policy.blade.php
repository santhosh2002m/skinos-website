
@extends('layouts.front')

@section('title', $page->title . ' - ' . ($gs->title ?? 'Your Site Name'))

@section('meta')
    <meta name="description" content="{{ $page->meta_description ?? 'Learn about our return policy, including return conditions and refund process.' }}">
    <meta name="keywords" content="{{ $page->meta_tag ?? 'return policy, refunds, returns, customer service' }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url('/return-policy') }}">
@endsection

@section('content')
    <!-- Blog wrapper start -->
    <div class="gs-blog-wrapper wow-replaced" data-wow-delay=".1s">
        <div class="container">
            <div class="row">
                <div class="col-12 gs-main-blog-wrapper">
                    <div class="gs-blog-details-wrapper">
                        <div class="gs-blog-card">
                            <ul class="bread-menu">
                                <li><a href="{{ route('front.index') }}">@lang('Home')</a></li>
                                <li>{{ $page->title }}</li>
                            </ul>
                            <h4 class="fea-title mb-24">
                                {{ $page->title }}
                            </h4>
                            <p class="mb-10">
                                {!! clean($page->details, ['Attr.EnableID' => true]) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog wrapper end -->
@endsection

@section('styles')
    <style>
        .gs-blog-wrapper {
            padding: 1.3rem 0;
        }

        .container {
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .gs-blog-details-wrapper {
            margin-bottom: 30px;
        }

        .bread-menu {
            list-style: none;
            display: flex;
            padding: 10px 0;
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
        }

        .bread-menu li {
            margin-right: 10px;
        }

        .bread-menu li a {
            text-decoration: none;
            color: #666;
        }

        .bread-menu li a:hover {
            color: #800080;
        }

        .fea-title {
            font-size: 26px;
            font-weight: 600;
            color: #001F3F;
        }

        .mb-24 {
            margin-bottom: 24px;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .gs-blog-card p {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        @media (max-width: 768px) {
            .fea-title {
                font-size: 20px;
            }

            .bread-menu {
                flex-wrap: wrap;
                gap: 8px;
            }
        }
    </style>
@endsection