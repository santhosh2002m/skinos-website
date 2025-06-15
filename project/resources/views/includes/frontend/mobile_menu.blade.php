<!-- Mobile Menu -->
<div class="mobile-menu">
    <div class="mobile-menu-top" style="background: white">
        <img src="{{ asset('assets/images/' . $gs->footer_logo) }}" alt="Logo">
        {{-- <img class="logo" src="{{ asset('assets/svg/logo.png') }}" alt="logo"> --}}
        <svg class="close" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M18 6L6 18M6 6L18 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </div>

    <!-- Navigation Tabs -->
    <nav>
        <div class="nav justify-content-between pt-24" id="nav-tab" role="tablist">
            <button class="flex-grow-1 state-left-btn active active-tab-btn" id="main-menu-tab" data-bs-toggle="tab"
                data-bs-target="#main-menu" type="button" role="tab" aria-controls="main-menu" aria-selected="true">
                @lang('MAIN MENU')
            </button>
            <button class="flex-grow-1 state-right-btn active-tab-btn" id="categories-tab" data-bs-toggle="tab"
                data-bs-target="#categories" type="button" role="tab" aria-controls="categories" aria-selected="false">
                @lang('CATEGORIES')
            </button>
        </div>
    </nav>

    <!-- Main Menu Tab Content -->
    <div class="tab-content" id="nav-tabContent1">
        <div class="tab-pane fade show active table-responsive tb-tb" id="main-menu" role="tabpanel"
            aria-labelledby="main-menu-tab" style="color: white;">
            <div class="mobile-menu-widget">
                <div class="single-product-widget">
                    <div class="product-cat-widget">
                        <ul class="accordion">
                            <!-- Shop by Concern (Dynamic Tags) -->
                            <li class="has-submenu">
                                <a href="{{ route('front.category') }}" data-bs-toggle="collapse" data-bs-target="#shop-by-concern"
                                    aria-controls="shop-by-concern" aria-expanded="false" class="collapsed">
                                    @lang('Shop by Concern')
                                </a>
                                <ul id="shop-by-concern" class="accordion-collapse collapse ms-3">
                                    @php
                                        use Illuminate\Support\Str;
                                        use Illuminate\Support\Facades\DB;

                                        $tags = DB::table('products')
                                            ->whereNotNull('tags')
                                            ->pluck('tags')
                                            ->flatMap(fn($tagString) => array_map('trim', explode(',', $tagString)))
                                            ->map(fn($tag) => Str::lower($tag))
                                            ->unique()
                                            ->mapWithKeys(fn($tag) => [$tag => Str::slug($tag)]);
                                    @endphp

                                    @foreach ($tags as $tagName => $tagSlug)
                                        <li>
                                            <a href="{{ route('front.category', ['tag' => $tagSlug]) }}">{{ $tagName }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                            <!-- Shop by Brand (Dynamic Brands) -->
                            <li class="has-submenu">
                                <a href="{{ route('front.category') }}" data-bs-toggle="collapse" data-bs-target="#shop-by-brand"
                                    aria-controls="shop-by-brand" aria-expanded="false" class="collapsed">
                                    @lang('Shop by Brand')
                                </a>
                                <ul id="shop-by-brand" class="accordion-collapse collapse ms-3">
                                    @php
                                        $brands = DB::table('brands')
                                            ->whereNotNull('name')
                                            ->pluck('name', 'slug')
                                            ->mapWithKeys(function ($name, $slug) {
                                                return [$name => $slug ?: Str::slug($name)];
                                            });
                                    @endphp
                                    @foreach ($brands as $brandName => $brandSlug)
                                        <li>
                                            <a href="{{ route('front.category', ['brand' => $brandSlug]) }}">{{ $brandName }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                            <!-- Find a Provider -->
                            <li><a href="{{ route('front.category') }}">@lang('Find a Provider')</a></li>

                            <!-- Find a Provider -->
                            @if (Auth::guard('web')->check() && Auth::user()->preferred_type === 'scheme_based_profile')
                                <li>
                                    <a class="header-colors" href="{{ route('user-mix_match') }}">
                                        @lang('Mix & Match')
                                    </a>
                                </li>
                            @endif

                            <!-- Discover (with Submenu) -->
                            <li class="has-submenu">
                                <a href="{{ route('front.discover') }}" data-bs-toggle="collapse" data-bs-target="#child_level_1"
                                    aria-controls="child_level_1" aria-expanded="false" class="collapsed">
                                    @lang('Discover')
                                </a>
                                <ul id="child_level_1" class="accordion-collapse collapse ms-3">
                                    @php
                                        $blog_cat = DB::table('blog_categories')->get();
                                    @endphp
                                    @foreach ($blog_cat as $blogcat)
                                        <li>
                                            <a href="{{ url('/blog/category/' . $blogcat->slug) }}">{{ $blogcat->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>

                        <!-- Auth Actions -->
                        <div class="auth-actions-btn gap-4 d-flex flex-column">
                            <a class="template-btn" href="{{ route('front.index') }}">@lang('Go to Homepage')</a>
                            @if (Auth::guard('web')->check() && Auth::guard('web')->user()->is_vendor == 2)
                                <a class="template-btn" href="{{ route('user-wishlists') }}">@lang('Vendor Panel')</a>
                            @elseif (!Auth::guard('web')->check() && !Auth::guard('rider')->check())
                                <a class="template-btn" href="{{ route('user.login') }}">@lang('Wishlist')</a>
                            @endif

                            @if (Auth::guard('rider')->check())
                                <a class="template-btn" href="{{ route('rider-dashboard') }}">@lang('Rider Dashboard')</a>
                            @elseif (!Auth::guard('web')->check() && !Auth::guard('rider')->check())
                                <a class="template-btn" href="{{ url('/admin/login') }}">@lang('SP Login')</a>
                            @endif

                            @if (Auth::guard('web')->check() && Auth::guard('web')->user()->is_vendor != 2)
                                <a class="template-btn" href="{{ route('user-dashboard') }}">@lang('User Dashboard')</a>
                                <a class="template-btn" href="{{ route('user-wishlists') }}">@lang('Whish List')</a>
                                @elseif (!Auth::guard('web')->check() && !Auth::guard('rider')->check())
                                <a class="template-btn" href="{{ route('user.login') }}">@lang('HCP Login')</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Categories Tab Content (Shop by Concern Data) -->
    <div class="tab-content" id="nav-tabContent3">
        <div class="tab-pane fade table-responsive tb-tb" id="categories" role="tabpanel"
            aria-labelledby="categories-tab" style="color: white;">
            <div class="mobile-menu-widget">
                <div class="single-product-widget">
                    <div class="product-cat-widget">
                        <ul class="accordion">
                            @php
                                $tags = DB::table('products')
                                    ->whereNotNull('tags')
                                    ->pluck('tags')
                                    ->flatMap(fn($tagString) => array_map('trim', explode(',', $tagString)))
                                    ->unique()
                                    ->mapWithKeys(fn($tag) => [$tag => Str::slug($tag)]);
                            @endphp
                            @foreach ($tags as $tagName => $tagSlug)
                                <li>
                                    <a href="{{ route('front.category', ['tag' => $tagSlug]) }}">{{ $tagName }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .mobile-menu {
        width: 290px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: -300px;
        background-color: #ffffff;
        z-index: 60;
        transition: all 0.3s ease-in;
        overflow-y: scroll;
    }

    .mobile-menu.active {
        left: 0;
    }

    .mobile-menu-top {
        width: 100%;
        padding: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #001f3f !important; /* Enforced primary color with !important */
    }

    .mobile-menu-top img {
        max-width: 120px;
        height: auto;
    }

    .mobile-menu .close {
        cursor: pointer;
    }

    .mobile-menu .close:hover {
        color: #800b00;
    }

    .mobile-menu nav .nav {
        padding-top: 24px;
        background-color: #f8f7f7;
    }

    .mobile-menu nav .state-left-btn,
    .mobile-menu nav .state-right-btn {
        font-size: 16px;
        font-weight: 500;
        text-transform: uppercase;
        color: #1f0300;
        background-color: transparent;
        border: none;
        padding: 10px;
        transition: all 0.3s ease-in;
    }

    .mobile-menu nav .state-left-btn.active,
    .mobile-menu nav .state-right-btn.active {
        color: #001f3f; /* Primary color for active state */
        background-color: #ffffff;
    }

    .mobile-menu nav .state-left-btn:hover,
    .mobile-menu nav .state-right-btn:hover {
        color: #001f3f; /* Primary color for hover state */
    }

    .mobile-menu .tab-content .tab-pane {
        padding: 24px 12px;
        background-color: #ffffff;
    }

    .mobile-menu .tab-content .tab-pane ul li {
        font-size: 16px;
        font-weight: 400;
        position: relative;
        margin-bottom: 12px;
    }

    .mobile-menu .tab-content .tab-pane ul li a {
        color: #1f0300;
        text-transform: uppercase;
        transition: all 0.3s ease-in;
        position: relative;
        display: block;
        padding: 8px 0;
    }

    .mobile-menu .tab-content .tab-pane ul li a:hover {
        color: #001f3f; /* Primary color for hover state */
    }

    .mobile-menu .tab-content .tab-pane ul li a::after {
        content: "";
        position: absolute;
        width: 0%;
        height: 1px;
        display: block;
        transition: all 0.3s ease-in;
        bottom: 0;
        left: 0;
        background-color: #001f3f; /* Primary color for underline */
    }

    .mobile-menu .tab-content .tab-pane ul li a:hover::after {
        width: 50%;
    }

    .mobile-menu .tab-content .tab-pane ul li .accordion-collapse {
        background-color: #f8f7f7;
        padding-left: 15px;
    }

    .mobile-menu .tab-content .tab-pane ul li .accordion-collapse li a {
        font-size: 14px;
        text-transform: capitalize;
    }

    .mobile-menu .auth-actions-btn .template-btn {
        display: block;
        width: 100%;
        padding: 10px;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
        color: #ffffff;
        background-color: #001f3f; /* Primary color for buttons */
        border-radius: 8px;
        text-transform: uppercase;
        transition: all 0.3s ease-in;
    }

    .mobile-menu .auth-actions-btn .template-btn:hover {
        background-color: #003366; /* Darker shade for hover effect */
    }

    @media (max-width: 1199.97px) {
        .mobile-menu.active {
            left: 0;
        }
    }
</style>