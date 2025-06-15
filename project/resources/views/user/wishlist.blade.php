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
        font-size: 62.5%;
        font-family: "DM Sans", sans-serif;
    }

    body {
        line-height: 1.6;
    }

    /* Universal Responsive Values */
    :root {
        --section-padding: 4rem;
        --heading-1: 7rem;
        --heading-2: 4.8rem;
        --body-text: 1.8rem;
        --primary-color: #001F3F;
        --accent-color: #800080;
        --text-muted: #727272;
        --background-light: #f6f6f6;
    }

    @media (max-width: 1200px) {
        :root {
            --heading-1: 6rem;
            --heading-2: 4rem;
        }
    }

    @media (max-width: 992px) {
        :root {
            --heading-1: 5rem;
            --heading-2: 3.5rem;
            --section-padding: 3rem;
        }
    }

    @media (max-width: 768px) {
        :root {
            --heading-1: 4rem;
            --heading-2: 3rem;
            --body-text: 1.6rem;
            --section-padding: 2rem;
        }
    }

    @media (max-width: 480px) {
        :root {
            --heading-1: 3.2rem;
            --heading-2: 2.5rem;
            --body-text: 1.4rem;
            --section-padding: 1.5rem;
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
        gap: 2rem;
        padding: var(--section-padding);
        padding-bottom: 0 !important;
    }

    .content-box {
        text-align: center;
        padding: 2rem;
    }

    .content-box h3 {
        font-family: "Dancing Script", cursive;
        font-size: var(--heading-2);
        margin-bottom: 1rem;
        color: var(--accent-color);
    }

    .content-box h1 {
        font-size: var(--heading-1);
        font-weight: 400;
        line-height: 1.2;
        margin-bottom: 2rem;
        color: var(--primary-color);
    }

    .content-box p {
        font-size: var(--body-text);
        line-height: 1.6;
        color: var(--text-muted);
        max-width: 80%;
        margin: 0 auto 3rem;
    }

    .image-box img {
        width: 100%;
        height: auto;
        max-width: 600px;
        margin: 0 auto;
        display: block;
    }

    .feature-container {
        background-color: #bec6ce;
        font-size: 1.7rem;
        display: flex;
        justify-content: space-between;
        padding-block: 2rem;
        padding-inline: 3.6rem;
    }

    .feature-container li {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .feature-container li ion-icon {
        color: var(--accent-color);
        font-size: 2rem;
    }

    @media (min-width: 768px) {
        .content-container {
            grid-template-columns: 55% 45%;
            padding: 4rem;
        }

        .content-box {
            text-align: left;
            padding: 3rem;
        }

        .content-box p {
            margin-left: 0;
        }

        .feature-container {
            justify-content: space-between;
            padding: 2rem 4rem;
        }
    }

    /* Brand Section */
    .brand-custom h3 {
        font-size: var(--heading-2);
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 3rem;
    }

    .brand-logo {
        display: flex;
        flex-wrap: wrap;
        gap: 15rem;
        justify-content: center;
        padding: 3rem 0;
    }

    .brand-logo img {
        max-height: 80px;
        width: auto;
        transition: transform 0.3s ease;
    }

    .brand-logo img:hover {
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .brand-custom h3 {
            font-size: 3rem;
        }

        .brand-logo {
            gap: 2rem;
            padding: 2rem 0;
        }

        .brand-logo img {
            max-height: 60px;
        }
    }

    /* Category Section */
    .category-container {
        padding: var(--section-padding);
        text-align: center;
    }

    .category-container h3 {
        font-size: var(--heading-2);
        color: var(--primary-color);
        margin-bottom: 4rem;
    }

    .category--image-box {
        text-align: center;
        margin: 2rem 0;
    }

    .image {
        width: 18rem;
        height: 18rem;
        margin: 0 auto 2rem;
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
            width: 15rem;
            height: 15rem;
        }
    }

    /* Product Card Styles */
    .single-product {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .single-product:hover {
        transform: translateY(-8px);
    }

    .img-wrapper {
        position: relative;
        padding: 1.5rem;
    }

    .product-img {
        width: 100%;
        height: 300px;
        object-fit: contain;
        border-radius: 8px;
    }

    .product-badge {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        background: var(--accent-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 1.25rem;
        font-weight: 700;
        z-index: 1;
    }

    .product-actions {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        display: flex;
        gap: 0.5rem;
        z-index: 2;
    }

    .action-btn {
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
        width: 24px;
        height: 24px;
    }

    .action-btn svg path {
        stroke: var(--primary-color);
        fill: none;
        transition: all 0.3s ease;
    }

    .action-btn.danger {
        background: #dc3545;
    }

    .action-btn.danger i {
        color: white;
        font-size: 1.25rem;
    }

    .add-to-cart {
        position: absolute;
        bottom: 1.5rem;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 3rem);
        opacity: 0;
        margin-left: 5px;
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
        padding: 0.75rem 1.5rem;
        border-radius: 6px;
        text-align: center;
        font-size: 1.25rem;
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
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .product-name {
        flex: 1;
        color: var(--primary-color);
        font-size: 1.5rem;
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
        font-size: 1.75rem;
    }

    .original-price {
        display: block;
        color: #6c757d;
        font-size: 1.25rem;
    }

    @media (max-width: 768px) {
        .product-img {
            height: 220px;
        }

        .product-name {
            font-size: 1.25rem;
        }

        .current-price {
            font-size: 1.5rem;
        }

        .original-price {
            font-size: 1rem;
        }

        .add-cart {
            font-size: 1rem;
            padding: 0.5rem 1rem;
        }

        .product-badge {
            font-size: 1rem;
            padding: 0.4rem 0.8rem;
        }

        .action-btn {
            width: 36px;
            height: 36px;
        }

        .action-btn svg {
            width: 20px;
            height: 20px;
        }
    }

    /* Product Sections */
    .product-cards-slider {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 3rem;
        padding: var(--section-padding);
    }

    /* Explore Products Section */
    .explore-tab-navbar {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .explore-tab-navbar .nav-item {
        margin: 0;
    }

    .explore-tab-navbar .nav-link {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--primary-color);
        background: #EDEDED;
        border: 1px solid #DFDFDF;
        border-radius: 11px;
        padding: 1rem 2rem;
        transition: all 0.3s ease;
    }

    .explore-tab-navbar .nav-link:hover,
    .explore-tab-navbar .nav-link.active {
        background: var(--accent-color);
        color: #fff;
        border-color: var(--accent-color);
    }

    .tab-content .tab-pane {
        padding: 1rem 0;
    }

    /* Button Styles */
    .custom-btn {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        justify-content: center;
        margin: 2rem 0;
    }

    .button-43 {
        display: block;
        background-image: linear-gradient(-180deg, var(--accent-color) 0%, var(--accent-color) 100%);
        border-radius: 9px;
        box-sizing: border-box;
        color: #FFFFFF;
        font-size: 16px;
        justify-content: center;
        padding: 1rem 1.75rem;
        text-decoration: none;
        border: 0;
        cursor: pointer;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        margin: 0 auto;
        margin-top: 2rem;
        transition: all 0.3s ease-in;
    }

    .button-43:hover {
        background-image: linear-gradient(-180deg, #6A0DAD 0%, #6A0DAD 100%);
    }

    @media (min-width: 768px) {
        .button-43 {
            padding: 1rem 2rem;
        }
    }

    /* Feature Container Media Queries */
    @media (max-width: 992px) {
        .feature-container {
            flex-wrap: wrap;
            gap: 1.5rem;
            padding-inline: 2rem;
        }

        .feature-container li {
            flex: 1 1 45%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .feature-container {
            font-size: 1.5rem;
            padding-inline: 1.5rem;
        }

        .feature-container li ion-icon {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 480px) {
        .feature-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 1rem;
            padding-inline: 1rem;
        }

        .feature-container li {
            flex: 1 1 100%;
            width: 100%;
            justify-content: center;
        }

        .feature-container li ion-icon {
            font-size: 1.6rem;
        }
    }
</style>

@section('content')
{{-- <section class="gs-breadcrumb-section bg-class"
    data-background="{{ $gs->breadcrumb_banner ? asset('assets/images/' . $gs->breadcrumb_banner) : asset('assets/images/noimage.png') }}">
    <div class="container">
        <div class="row justify-content-center content-wrapper">
            <div class="col-12">
                <h2 class="breadcrumb-title">@lang('Wishlist')</h2>
                <ul class="bread-menu">
                    <li><a href="{{ route('front.index') }}">@lang('Home')</a></li>
                    <li><a href="javascript:;">@lang('Wishlist')</a></li>
                </ul>
            </div>
        </div>
    </div>
</section> --}}
<div class="gs-blog-wrapper">
    <div class="container">
        <div class="row flex-column-reverse flex-lg-row">
            <div class="col-12 col-lg-12 col-xl-12 gs-main-blog-wrapper">
                <div class="product-nav-wrapper">
                    <h5>@lang('Total Products Found:') <span id="wishlist-count">{{ $wishlists->count() }}</span></h5>
                </div>
                @if($wishlists->count() > 0)
                <div class="row gy-4 mt-20">
                    @foreach ($wishlists as $product)
                    @include('includes.frontend.home_product', [
                        'class' => 'col-sm-6 col-md-6 col-lg-4 col-xl-3',
                        'wishlist' => true,
                    ])
                    @endforeach
                </div>
                {{ $wishlists->links('includes.frontend.pagination') }}
                @else
                <div class="product-nav-wrapper d-flex justify-content-center" style="margin: 2rem 0">
                    <h5>@lang('No Product Found')</h5>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Wishlist Remove (for wishlist page)
    document.querySelectorAll('.removewishlist').forEach(button => {
        // Remove any existing event listeners to prevent conflicts
        button.removeEventListener('click', handleRemoveWishlist);
        button.addEventListener('click', handleRemoveWishlist);

        function handleRemoveWishlist(e) {
            e.preventDefault();
            const url = this.getAttribute('data-href');
            // Target the grid column containing the product card
            const productCard = this.closest('.col-sm-6');
            const wishlistCountElement = document.querySelector('#wishlist-count');

            if (!url) {
                alert('Wishlist action unavailable');
                return;
            }

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
                    // Remove the product card from the DOM
                    if (productCard) {
                        productCard.remove();
                    }
                    // Update wishlist count
                    if (wishlistCountElement) {
                        wishlistCountElement.textContent = data.count || Math.max(parseInt(wishlistCountElement.textContent) - 1, 0);
                    }
                    // If no products remain, show "No Product Found"
                    if (document.querySelectorAll('.single-product').length === 0) {
                        const wrapper = document.querySelector('.gs-main-blog-wrapper');
                        wrapper.innerHTML = `
                            <div class="product-nav-wrapper d-flex justify-content-center mt-4" style="margin: 3rem 0">
                                <h5>@lang('No Product Found')</h5>
                            </div>
                        `;
                    }
                    // Optional: Show success message
                    // alert('Product removed from wishlist successfully!');
                    toastr.success(data.message || 'Successfully Removed From Wishlist.');
                } else {
                    toastr.success(data.message || 'Error removing from wishlist');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('An error occurred while removing from wishlist: ' + error.message);
            });
        }
    });
});
</script>
@endsection