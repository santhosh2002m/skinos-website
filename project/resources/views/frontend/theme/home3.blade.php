@extends('layouts.front')

<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz@0,9..40;1,9..40&family=Dancing+Script:wght@400..700&display=swap');

    /* Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        font-size: 56.25%;
        font-family: "DM Sans", sans-serif;
    }

    body {
        line-height: 1.6;
    }

    /* Universal Responsive Values */
    :root {
        --section-padding: 3.5rem;
        --heading-1: 6rem;
        --heading-2: 4rem;
        --body-text: 1.6rem;
        --primary-color: #001F3F;
        --accent-color: #800080;
        --text-muted: #727272;
        --background-light: #f6f6f6;
    }

    @media (max-width: 1200px) {
        :root {
            --heading-1: 5rem;
            --heading-2: 3.5rem;
        }
    }

    @media (max-width: 992px) {
        :root {
            --heading-1: 4.5rem;
            --heading-2: 3rem;
            --section-padding: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        :root {
            --heading-1: 3.5rem;
            --heading-2: 2.5rem;
            --body-text: 1.4rem;
            --section-padding: 1.8rem;
        }
    }

    @media (max-width: 480px) {
        :root {
            --heading-1: 2.8rem;
            --heading-2: 2rem;
            --body-text: 1.2rem;
            --section-padding: 1.2rem;
        }
    }

    /* Category Hover Effects */
    .category--image-box a {
        display: block;
        transition: all 0.3s ease;
    }

    .image {
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .image img {
        transition: all 0.3s ease;
    }

    .category--image-box:hover .image {
        transform: translateY(-5px);
    }

    .category--image-box:hover .image img {
        transform: scale(1.05);
    }

    .category-p {
        transition: all 0.3s ease;
        color: var(--primary-color);
        font-size: var(--body-text);
        font-weight: 500;
    }

    .category--image-box:hover .category-p {
        color: var(--accent-color);
    }

    /* Hero Section */
    .main-container {
        background: linear-gradient(to bottom, #ffffff 10%, var(--primary-color) 100%);
        border-radius: 1.8rem;
        margin: 0 auto;
        overflow: hidden;
    }

    .content-container {
        align-items: center;
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.8rem;
        padding: var(--section-padding);
        padding-bottom: 0 !important;
    }

    .content-box {
        text-align: center;
        padding: 1.8rem;
    }

    .content-box h3 {
        font-family: "Dancing Script", cursive;
        font-size: 3.5rem;
        margin-bottom: 0.8rem;
        color: var(--accent-color);
    }

    .content-box h1 {
        font-size: var(--heading-1);
        font-weight: 400;
        line-height: 1.2;
        margin-bottom: 1.8rem;
        color: var(--primary-color);
    }

    .content-box p {
        font-size: var(--body-text);
        line-height: 1.6;
        color: var(--text-muted);
        max-width: 80%;
        margin: 0 auto 2.5rem;
    }

    .image-box img {
        width: 100%;
        height: auto;
        max-width: 550px;
        margin: 0 auto;
        display: block;
    }

    .feature-container {
        background-color: #bec6ce;
        font-size: 1.5rem;
        display: flex;
        justify-content: space-between;
        padding-block: 1.8rem;
        padding-inline: 3.2rem;
    }

    .feature-container li {
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }

    .feature-container li ion-icon {
        color: var(--accent-color);
        font-size: 1.8rem;
    }

    @media (min-width: 768px) {
        .content-container {
            grid-template-columns: 55% 45%;
            padding: 3.5rem;
        }

        .content-box {
            text-align: left;
            padding: 2.5rem;
        }

        .content-box p {
            margin-left: 0;
        }

        .feature-container {
            justify-content: space-between;
            padding: 1.8rem 3.5rem;
        }
    }

    /* Brand Section */
    .brand-custom h3 {
        font-size: var(--heading-2);
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .brand-logo {
        display: flex;
        flex-wrap: wrap;
        gap: 12rem;
        justify-content: center;
        padding: 2.5rem 0;
    }

    .brand-logo img {
        max-height: 70px;
        width: auto;
        transition: transform 0.3s ease;
    }

    .brand-logo img:hover {
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .brand-custom h3 {
            font-size: 2.5rem;
        }

        .brand-logo {
            gap: 1.8rem;
            padding: 1.8rem 0;
        }

        .brand-logo img {
            max-height: 50px;
        }
    }

    /* Category Section */
    .category-container {
        padding: 0 35px;
        text-align: center;
    }

    .category-container h3 {
        font-family: "Proxima Nova", "DM Sans", sans-serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 3.5rem;
    }

    .category--image-box {
        text-align: center;
        margin: 1.8rem 0;
    }

    .image {
        width: 16rem;
        height: 16rem;
        margin: 0 auto 1.8rem;
        border-radius: 50%;
        overflow: hidden;
    }

    .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .image {
            width: 13rem;
            height: 13rem;
        }
    }

    /* Product Card Styles */
    .single-product {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .single-product:hover {
        transform: translateY(-7px);
    }

    .img-wrapper {
        position: relative;
        padding: 1.3rem;
    }

    .product-img {
        width: 100%;
        height: 280px;
        object-fit: contain;
        border-radius: 7px;
    }

    .product-badge {
        position: absolute;
        top: 1.3rem;
        left: 1.3rem;
        background: var(--accent-color);
        color: white;
        padding: 0.4rem 0.9rem;
        border-radius: 5px;
        font-size: 1.1rem;
        font-weight: 700;
        z-index: 1;
    }

    .product-actions {
        position: absolute;
        bottom: 2rem;
        right: 1.7rem;
        display: flex;
        gap: 0.4rem;
        z-index: 2;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        background: var(--accent-color);
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
        width: 22px;
        height: 22px;
    }

    .action-btn svg path {
        stroke: var(--primary-color);
        fill: none;
        transition: all 0.3s ease;
    }

    .action-btn:hover svg path,
    .action-btn svg:hover path {
        stroke: #ffffff;
        fill: none;
    }

    .action-btn.danger {
        background: #dc3545;
    }

    .action-btn.danger i {
        color: white;
        font-size: 1.1rem;
    }

    .add-to-cart {
        position: absolute;
        bottom: 1.3rem;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 2.6rem);
        display: flex;
        justify-content: center;
        opacity: 0;
        margin-left: 4px;
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
        padding: 0.7rem 1.3rem;
        border-radius: 5px;
        text-align: center;
        font-size: 1.1rem;
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
        padding: 1.3rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.9rem;
    }

    .product-name {
        flex: 1;
        color: var(--primary-color);
        font-size: 1.3rem;
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
        font-weight: 700;
        font-size: 1.5rem;
    }

    .original-price {
        display: block;
        color: #6c757d;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .product-img {
            height: 200px;
        }

        .product-name {
            font-size: 1.1rem;
        }

        .current-price {
            font-size: 1.3rem;
        }

        .original-price {
            font-size: 0.9rem;
        }

        .add-cart {
            font-size: 0.9rem;
            padding: 0.4rem 0.9rem;
        }

        .product-badge {
            font-size: 0.9rem;
            padding: 0.3rem 0.7rem;
        }

        .action-btn {
            width: 32px;
            height: 32px;
        }

        .action-btn svg {
            width: 18px;
            height: 18px;
        }
    }

    /* Product Sections */
    .product-cards-slider {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 2.5rem;
        padding: 0 35px;
        position: relative;
    }

    .product-cards-slider .slick-track {
        padding-bottom: 20px;
    }

    /* Slider Arrow Styles */
    .slick-prev, .slick-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: var(--accent-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .slick-prev:hover, .slick-next:hover {
        background: #6A0DAD;
    }

    .slick-prev {
        left: -50px;
    }

    .slick-next {
        right: -50px;
    }

    .slick-prev ion-icon, .slick-next ion-icon {
        font-size: 20px;
        color: #fff;
    }

    @media (max-width: 992px) {
        .slick-prev {
            left: -30px;
        }

        .slick-next {
            right: -30px;
        }
    }

    @media (max-width: 768px) {
        .slick-prev {
            left: -20px;
        }

        .slick-next {
            right: -20px;
        }

        .slick-prev, .slick-next {
            width: 35px;
            height: 35px;
        }

        .slick-prev ion-icon, .slick-next ion-icon {
            font-size: 18px;
        }
    }

    @media (max-width: 480px) {
        .slick-prev {
            left: 0px;
        }

        .slick-next {
            right: 0px;
        }

        .slick-prev, .slick-next {
            width: 30px;
            height: 30px;
        }

        .slick-prev ion-icon, .slick-next ion-icon {
            font-size: 16px;
        }
    }

    /* Explore Products Section */
    .explore-products .gs-title-box h2.title {
        font-family: "Proxima Nova", "DM Sans", sans-serif;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 2.5rem;
    }

    .simple {
        font-family: "Proxima Nova", "DM Sans", sans-serif;
        font-size: var(--heading-2);
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 2.5rem;
        text-align: center !important
    }

    .explore-tab-navbar {
        display: flex;
        justify-content: center;
        gap: 0.9rem;
        margin-bottom: 2.5rem;
    }

    .explore-tab-navbar .nav-item {
        margin: 0;
    }

    .explore-tab-navbar .nav-link {
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--primary-color);
        background: #EDEDED;
        border: 1px solid #DFDFDF;
        border-radius: 10px;
        padding: 0.9rem 1.8rem;
        transition: all 0.3s ease;
    }

    .explore-tab-navbar .nav-link:hover,
    .explore-tab-navbar .nav-link.active {
        background: var(--accent-color);
        color: #fff;
        border-color: var(--accent-color);
    }

    .tab-content .tab-pane {
        padding: 0.9rem 0;
    }

    /* Button Styles */
    .custom-btn {
        display: flex;
        flex-wrap: wrap;
        gap: 1.3rem;
        justify-content: center;
        margin: 1.8rem 0;
    }

    .button-43 {
        display: block;
        background-image: linear-gradient(-180deg, var(--accent-color) 0%, var(--accent-color) 100%);
        border-radius: 8px;
        box-sizing: border-box;
        color: #FFFFFF;
        font-size: 14px;
        justify-content: center;
        padding: 0.9rem 1.5rem;
        text-decoration: none;
        border: 0;
        cursor: pointer;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        margin: 0 auto;
        margin-top: 1.8rem;
        transition: all 0.3s ease;
    }

    .button-43:hover {
        background-image: linear-gradient(-180deg, #6A0DAD 0%, #6A0DAD 100%);
    }

    @media (min-width: 768px) {
        .button-43 {
            padding: 0.9rem 1.8rem;
        }
    }

    /* Partner Section */
    .pr-partners-section {
        padding: 18px 0;
    }

    .pr-main-title {
        font-size: var(--heading-2);
        color: var(--primary-color);
        margin-bottom: 13px;
        font-weight: 700;
        text-align: center;
    }

    .pr-description {
        font-size: 14px;
        color: #6c757d;
        line-height: 1.6;
        max-width: 650px;
        margin: 0 auto;
        text-align: center;
        margin-bottom: 3.5rem;
    }

    .pr-slider-container {
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    .pr-slider-track {
        display: flex;
        animation: pr-scroll-animation 25s linear infinite;
        width: max-content;
    }

    .pr-slide-item {
        flex: 0 0 auto;
        padding: 0 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .pr-partner-logo img {
        max-width: 160px;
        height: auto;
        filter: grayscale(100%);
        transition: all 0.3s ease;
    }

    .pr-partner-logo:hover img {
        filter: grayscale(0);
        transform: scale(1.05);
    }

    @keyframes pr-scroll-animation {
        0% { transform: translateX(0%); }
        100% { transform: translateX(-50%); }
    }

    @media (max-width: 768px) {
        .pr-slide-item { padding: 0 13px; }
        .pr-partner-logo img { max-width: 100px; }
        .pr-main-title { font-size: 2rem; }
        .pr-description { font-size: 1rem; }
    }

    .pr-slider-container:hover .pr-slider-track {
        animation-play-state: paused;
    }

    /* USP Section */

    .unique-usp-section{
        margin: 2rem 0;
    }

    .custom-usp-container {
        margin: 0 auto;
        padding: 5rem 1rem;
        background-color: var(--primary-color);
    }

    .usp-content-grid {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 2rem;
        align-items: center;
        padding-left: 2.5rem;
    }

    .usp-text-block .usp-main-heading {
        font-size: 3.6rem;
        font-weight: 700;
        margin-bottom: 3rem;
        /* color: #FFFFFF; */
    }

    .usp-point-item {
        margin-bottom: 4rem;
    }

    .usp-point-title {
        font-size: 2.4rem;
        font-weight: 600;
        margin-bottom: 1rem;
        /* color: #ffffff; */
    }

    .usp-point-desc {
        line-height: 1.7;
        /* color: #fff; */
        margin: 0;
        font-size: 1.8rem;
    }

    .usp-main-visual {
        /* width: 90%; */
        /* border-radius: 50%; */
        border-radius: 15px;
        height: auto;
        max-height: 500px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    @media (max-width: 768px) {
        .usp-main-visual {
            width: 80%;
        }
    }

    /* Feature Container Media Queries */
    @media (max-width: 992px) {
        .feature-container {
            flex-wrap: wrap;
            gap: 1.3rem;
            padding-inline: 1.8rem;
        }

        .feature-container li {
            flex: 1 1 45%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .feature-container {
            font-size: 1.3rem;
            padding-inline: 1.3rem;
        }

        .feature-container li ion-icon {
            font-size: 1.6rem;
        }
    }

    @media (max-width: 480px) {
        .feature-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 0.9rem;
            padding-inline: 0.9rem;
        }

        .feature-container li {
            flex: 1 1 100%;
            width: 100%;
            justify-content: center;
        }

        .feature-container li ion-icon {
            font-size: 1.4rem;
        }
    }

    .price-details {
        font-family: 'Poppins', sans-serif;
        color: black;
    }

    .product-name {
        font-family: 'Poppins', sans-serif;
        color: black;
    }

    .action-btn, .add-cart {
        transition: background-color 0.3s ease;
    }

    .action-btn:hover, .add-cart:hover {
        /* background-color: #6A0DAD; */
    }

    .banner {
        height: 60%;
    }

    .gs-cate-section {
        margin: 25px !important;
    }
</style>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap');

    @font-face {
        font-family: 'Proxima Nova';
        src: url('/path/to/proximanova-regular.woff2') format('woff2'),
             url('/path/to/proximanova-regular.woff') format('woff');
        font-weight: 400;
        font-style: normal;
    }

    @font-face {
        font-family: 'Proxima Nova';
        src: url('/path/to/proximanova-bold.woff2') format('woff2'),
             url('/path/to/proximanova-bold.woff') format('woff');
        font-weight: 700;
        font-style: normal;
    }

    :root {
        --accent-color: #800080;
    }

    .hero-shop-now-btn:hover {
        background-color: #6A0DAD;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3) !important;
    }
</style>

<style>
    .category-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 18px;
    }
    .category--image-box {
        flex: 0 1 calc(20% - 18px);
        text-align: center;
    }
    .category--image-box .image img {
        width: 100%;
        /* height: auto; */
    }
    .category-p {
        margin-top: 9px;
        font-size: 14px;
    }
    .gs-hero-section{
        height: 400px;
    }
    @media (max-width: 1200px) {
        .gs-hero-section{
            height: 220px;
        }
    }
    @media (max-width: 768px) {
        .gs-hero-section{
            height: 110px
        }
        .slick-dots {
            display: none !important;
        }
        .usp-section {
            /* background: #f0f0f0; */
            background: #ffffff !important;
        }
    }
    .usp-section {
        /* background: #f0f0f0; */
        background: #ffffff;
        background: linear-gradient(90deg, rgba(255, 255, 255, 1) 30%, rgb(255, 230, 234) 80%, rgba(255, 208, 192, 0.81) 100%);
    }
    .usp-point-item:not(:last-child) {
        margin-bottom: 1.5rem;
    }

    .main-heading{
        font-size: 3.5rem !important;
    }

</style>

@section('content')

    <section class="hero-slider-wrapper">
        @foreach ($sliders as $slider)
            <div class="gs-hero-section image-fluid"
                style="background-image: url('{{ asset('assets/images/sliders/' . $slider->photo) }}');
                        background-size: contain;
                        background-position: bottom;
                        background-repeat: no-repeat;
                        display: flex;
                        font-family: 'Proxima Nova', 'DM Sans', sans-serif;">
            </div>
        @endforeach
    </section>

    <!-- Categories Section Start -->
    <div class="gs-cate-section container mx-auto" style="padding-top: 0">
        <div class="">
            <div class="category-container">
                <h3 class="main-heading">Shop by Concern</h3>
                <div class="category-grid">
                    @php
                        $tags = DB::table('tags')->where('status', 1)->take(5)->get();
                    @endphp
                    @foreach ($tags as $tag)
                        <div class="category--image-box">
                            <a href="{{ route('front.category', ['tag' => $tag->slug]) }}">
                                <div class="image">
                                    <img src="{{ asset('assets/images/categories/' . $tag->image) }}"
                                         alt="{{ $tag->name }}"/>
                                </div>
                                <p class="category-p">{{ $tag->name }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Categories Section End -->

    <!-- Explore Products Section Start -->
    <section class="explore-products">
        <div class="container">
            <div class="row mb-32 justify-content-center">
                <div class="col-12">
                    <div class="gs-title-box text-center">
                        <h2 class="title main-heading">@lang('Explore Our Products')</h2>
                    </div>

                    <!-- Tab Navigation -->
                    <ul class="nav explore-tab-navbar" id="myTab" role="tablist">
                        <!-- Trending First -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="ex-product-2" data-bs-toggle="tab"
                                data-bs-target="#ex-product-2-pane" type="button" role="tab"
                                aria-controls="ex-product-2-pane" aria-selected="true">
                                @lang('TRENDING')
                            </button>
                        </li>
                        <!-- New Arrival Second -->
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ex-product-1" data-bs-toggle="tab"
                                data-bs-target="#ex-product-1-pane" type="button" role="tab"
                                aria-controls="ex-product-1-pane" aria-selected="false">
                                @lang('NEW ARRIVAL')
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="myTabContent">
                <!-- Trending Products -->
                <div class="tab-pane fade show active" id="ex-product-2-pane"
                     role="tabpanel" aria-labelledby="ex-product-2" tabindex="0">
                    <div class="product-cards-slider">
                        @forelse ($trending_products as $product)
                            <div class="product-card-wrapper">
                                @include('includes.frontend.home_product')
                            </div>
                        @empty
                            <div class="text-center w-100">
                                <p class="text-muted">@lang('No Trending Products Found')</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- New Arrival Products -->
                <div class="tab-pane fade" id="ex-product-1-pane"
                     role="tabpanel" aria-labelledby="ex-product-1" tabindex="0">
                    <div class="product-cards-slider">
                        @forelse ($latest_products as $product)
                            <div class="product-card-wrapper">
                                @include('includes.frontend.home_product')
                            </div>
                        @empty
                            <div class="text-center w-100">
                                <p class="text-muted">@lang('No New Arrivals Found')</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Explore Products Section End -->

    <!-- Why Choose Us Section Start -->
    <section class="container-fluid p-5 my-3 usp-section">
        <div class="row align-items-center">
            <!-- Text Content -->
            <div class="usp-text-block col-12 col-md-8 mb-4 mb-md-0 px-5 text-center text-md-start">
                <h1 class="usp-main-heading main-heading">Why Choose Us?</h1>

                <div class="usp-point-item mb-4">
                    <h2 class="usp-point-title">Expert Medical Board</h2>
                    <p class="usp-point-desc">
                        Consultant dermatologists ensure clinically precise, safe, and effective products backed by rigorous research.
                    </p>
                </div>

                <div class="usp-point-item mb-4">
                    <h2 class="usp-point-title">Strategic R&D Partnership</h2>
                    <p class="usp-point-desc">
                        Collaboration with Rowan Bioceuticals UAE for advanced R&D and cutting-edge manufacturing technologies.
                    </p>
                </div>

                <div class="usp-point-item mb-4">
                    <h2 class="usp-point-title">Global Ingredient Sourcing</h2>
                    <p class="usp-point-desc">
                        Premium ingredients from top suppliers (USA, Japan, Korea, Thailand, Germany, France), including first-in-India components, for superior efficacy.
                    </p>
                </div>
                <div class="usp-point-item mb-4">
                    <h2 class="usp-point-title">FDA-GMP-ISO-CE-Approved Facility</h2>
                    <p class="usp-point-desc">
                        Products manufactured in a state-of-the-art Delhi facility meeting global quality and safety standards.
                    </p>
                </div>
                <div class="usp-point-item mb-4">
                    <h2 class="usp-point-title">Optimized for Indian Skin</h2>
                    <p class="usp-point-desc">
                        Medical-grade formulations tailored for Indian skin’s unique needs, addressing higher melanin and environmental sensitivities.
                    </p>
                </div>
            </div>

            <!-- Visual Image -->
            <div class="col-12 col-md-4 text-center d-flex justify-content-center">
                <img src="{{ asset('assets/svg/girl.jpg') }}" alt="Illustration of Skinosis advantages" class="img-fluid usp-main-visual" />
            </div>
        </div>
    </section>
    <!-- Why Choose Us Section End -->

    <!-- Partners Section Start -->
    <section class="pr-partners-section">
        <div class="container">
            <div class="pr-title-container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-12">
                        <div class="pr-header-box">
                            <h2 class="simple main-heading">@lang('Our Partners')</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pr-partners-container">
                <div class="pr-slider-container">
                    <div class="pr-slider-track">
                        @forelse (DB::table('partners')->get() as $data)
                            <div class="pr-slide-item">
                                <a href="javascript:;">
                                    <div class="pr-partner-logo">
                                        <img src="{{ asset('assets/images/partner/' . $data->photo) }}" alt="partner" />
                                    </div>
                                </a>
                            </div>
                        @empty
                            <p>No partners available.</p>
                        @endforelse
                        @forelse (DB::table('partners')->get() as $data)
                            <div class="pr-slide-item">
                                <a href="javascript:;">
                                    <div class="pr-partner-logo">
                                        <img src="{{ asset('assets/images/partner/' . $data->photo) }}" alt="partner" />
                                    </div>
                                </a>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Partners Section End -->

    <script>
        $(document).ready(function() {
            $('.product-cards-slider').each(function(index) {
                // console.log('Initializing slider #' + index, this);
                $(this).slick({
                    infinite: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: false,
                    autoplay: false,
                    prevArrow: '<button type="button" class="slick-prev"><ion-icon name="arrow-back-outline"></ion-icon></button>',
                    nextArrow: '<button type="button" class="slick-next"><ion-icon name="arrow-forward-outline"></ion-icon></button>',
                    responsive: [
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 3
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1
                            }
                        }
                    ]
                }).on('init', function(event, slick) {
                    // console.log('Slider #' + index + ' initialized', slick);
                }).on('reInit', function(event, slick) {
                    // console.log('Slider #' + index + ' reinitialized', slick);
                });
            });

            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                $('.product-cards-slider').slick('refresh');
                console.log('Tab switched to: ' + $(e.target).attr('id'));
            });

            document.querySelectorAll('.wishlist').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const toggleState = this.getAttribute('data-toggle');
                    const url = toggleState === 'add' ? this.getAttribute('data-href-add') : this.getAttribute('data-href-remove');
                    const method = toggleState === 'add' ? 'POST' : 'DELETE';
                    const actionBtn = this.querySelector('.action-btn');

                    if (!url) {
                        alert('Wishlist action unavailable');
                        return;
                    }

                    fetch(url, {
                        method: method,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`HTTP ${response.status}: ${text || 'Network response was not ok'}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success || data[0] === 1) {
                            actionBtn.classList.toggle('active');
                            if (toggleState === 'add') {
                                const wishlistId = data.wishlist_id || (data[0] === 1 ? 'temp-' + Date.now() : null);
                                if (!wishlistId) {
                                    throw new Error('Wishlist ID not returned from server');
                                }
                                this.setAttribute('data-toggle', 'remove');
                                this.setAttribute('data-href-remove', '{{ route("user-wishlist-remove", ":id") }}'.replace(':id', wishlistId));
                                toastr.success(data.message || 'Added to wishlist');
                                const countElement = document.querySelector('#wishlist-count');
                                if (countElement) {
                                    countElement.textContent = data.count || data[1] || parseInt(countElement.textContent) + 1;
                                }
                            } else {
                                this.setAttribute('data-toggle', 'add');
                                this.setAttribute('data-href-remove', '');
                                toastr.success(data.message || 'Removed from wishlist');
                                const countElement = document.querySelector('#wishlist-count');
                                if (countElement) {
                                    countElement.textContent = data.count || Math.max(parseInt(countElement.textContent) - 1, 0);
                                }
                            }
                        } else {
                            toastr.error(data.message || (toggleState === 'add' ? 'Error adding to wishlist' : 'Error removing from wishlist'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        toastr.error('An error occurred while updating wishlist: ' + error.message);
                    });
                });
            });

            document.querySelectorAll('.removewishlist').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.getAttribute('data-href');

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`HTTP ${response.status}: ${text || 'Network response was not ok'}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success || data[0] === 1) {
                            location.reload();
                        } else {
                            alert(data.message || 'Error removing from wishlist');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while removing from wishlist: ' + error.message);
                    });
                });
            });

            document.querySelectorAll('.compare_product').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = this.getAttribute('data-href');
                    const actionBtn = this.querySelector('.action-btn');

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error(`HTTP ${response.status}: ${text}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            actionBtn.classList.toggle('active');
                        } else {
                            alert(data.message || 'Error adding to compare');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while adding to compare: ' + error.message);
                    });
                });
            });

            document.querySelectorAll('.button-43').forEach(button => {
                button.addEventListener('click', () => {
                    window.location.href = "{{ url('/category') }}";
                });
            });
        });
        $(document).ready(function(){
            $('.hero-slider-wrapper').slick({
                dots: true,
                arrows: false,
                infinite: true,
                speed: 500,
                autoplay: false,
                autoplaySpeed: 4000,
                slidesToShow: 1,
                slidesToScroll: 1,
            });
        });
    </script>
@endsection