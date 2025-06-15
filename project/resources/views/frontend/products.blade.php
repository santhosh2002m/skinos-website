@extends('layouts.front')

@section('content')
    <!-- product wrapper start -->
    <div class="gs-blog-wrapper">
        <div class="container">
            <div class="row flex-column-reverse flex-lg-row">
                <div class="col-12 col-lg-4 col-xl-3 mt-40 mt-lg-0">
                    <div class="uvx-cart-summary-container" style="display: {{Auth::user() ? "block" : "none"}};">
                        <div class="uvx-cart-header">
                            <h3>Shopping Cart</h3>
                            <p id="discount-warning">
                            </p>
                        </div>
                        <div class="uvx-cart-totals">
                            <p>Total MRP: <strong id="totalMRP">Loading..</strong></p>
                            <p>Total Discount: <strong id="totalDiscount">Loading..</strong></p>
                            <p>Total Payable: <strong id="totalPayable">Loading..</strong></p>
                        </div>
                        <div id="product-heading" class="uvx-cart-items">
                            <h6>Products :</h6>
                        </div>
                        <div id="cart-items-container" class="uvx-cart-items">
                            <!-- Placeholder Item -->
                            <div class="uvx-cart-item">
                                <div class="uvx-image-wrapper">
                                    <div class="uvx-skeleton img"></div>
                                </div>
                            </div>
                            <div class="uvx-cart-item">
                                <div class="uvx-image-wrapper">
                                    <div class="uvx-skeleton img"></div>
                                </div>
                            </div>
                            <div class="uvx-cart-item">
                                <div class="uvx-image-wrapper">
                                    <div class="uvx-skeleton img"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uvx-category-container  border p-3 my-4 rounded bg-white">
                        <!-- Shop By Brands Section -->
                        <div class="uvx-category-item">
                            <div class="uvx-category-header">
                                <span>Shop by Brands</span>
                                <span class="uvx-caret-icon">▾</span>
                            </div>
                            <div class="uvx-category-content">
                                <div class="uvx-radio-group">
                                    @forelse ($brands as $brand)
                                        <div class="brand-logo-item">
                                            <label class="uvx-radio-item" for="{{ 'brand-' . $brand->slug }}">
                                                <input type="radio" name="brand" id="{{ 'brand-' . $brand->slug }}"
                                                    value="{{ $brand->slug }}"
                                                    {{ request()->input('brand') == $brand->slug ? 'checked' : '' }}>
                                                <span class="uvx-radio-custom"></span>
                                                <a href="#" class="brand-link" data-slug="{{ $brand->slug }}">
                                                    <img class="logo-img"
                                                        src="{{ asset('assets/images/brands/' . $brand->image) }}"
                                                        alt="{{ $brand->name }}">
                                                </a>
                                            </label>
                                        </div>
                                    @empty
                                        <p>No brands available.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Shop By Tags Section -->

                        <div class="uvx-category-item">
                            <div class="uvx-category-header">
                                <span>Shop by Tags</span>
                                <span class="uvx-caret-icon">▾</span>
                            </div>
                            <div class="uvx-category-content">
                                <div class="uvx-checkbox-group">
                                    @php
                                        $tags = DB::table('tags')->where('status', 1)->select('name', 'slug')->get();
                                    @endphp

                                    @foreach ($tags as $tag)
                                        <label class="uvx-checkbox-item" for="{{ 'tag-' . $tag->slug }}">
                                            <input type="checkbox" name="tags[]" id="{{ 'tag-' . $tag->slug }}"
                                                value="{{ $tag->name }}"
                                                {{ in_array($tag->name, (array) request()->input('tags', [])) ? 'checked' : '' }}>
                                            <span style="border-radius: 100%" class="uvx-checkbox-custom"></span>
                                            <span>{{ $tag->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Price Range -->
                        @if (Auth::check())
                            <div class="uvx-category-item">
                                <div class="uvx-category-header">
                                    <span>Price Range</span>
                                    <span class="uvx-caret-icon">▾</span>
                                </div>
                                <div class="uvx-category-content">
                                    <div class="uvx-radio-group">
                                        <label class="uvx-radio-item">
                                            <input type="radio" name="price_range" data-min="0" data-max="1000"
                                                {{ request('min') == 0 && request('max') == 1000 ? 'checked' : '' }}>
                                            <span class="uvx-radio-custom"></span>
                                            <div class="pricing-flex">
                                                <span>Under</span> <span>₹1000</span>
                                            </div>
                                        </label>

                                        <label class="uvx-radio-item">
                                            <input type="radio" name="price_range" data-min="1000" data-max="2000"
                                                {{ request('min') == 1000 && request('max') == 2000 ? 'checked' : '' }}>
                                            <span class="uvx-radio-custom"></span>
                                            <div class="pricing-flex">
                                                <span>₹1000</span> <span>-</span> <span>₹2000</span>
                                            </div>
                                        </label>

                                        <label class="uvx-radio-item">
                                            <input type="radio" name="price_range" data-min="2000" data-max=""
                                                {{ request('min') == 2000 && request('max') == null ? 'checked' : '' }}>
                                            <span class="uvx-radio-custom"></span>
                                            <div class="pricing-flex">
                                                <span>Above</span> <span>₹2000</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($attributes))
                            @foreach ($attributes as $attr)
                                <div class="uvx-category-item">
                                    <div class="uvx-category-header">
                                        <span>{{ $attr->name }}</span>
                                        <span class="uvx-caret-icon">▾</span>
                                    </div>
                                    <div class="uvx-category-content">
                                        <div class="uvx-checkbox-group">
                                            @foreach ($attr->attribute_options as $option)
                                                <label class="uvx-checkbox-item">
                                                    <input type="checkbox" name="{{ $attr->input_name }}[]"
                                                        value="{{ $option->name }}"
                                                        {{ isset($_GET[$attr->input_name]) && in_array($option->name, (array) $_GET[$attr->input_name]) ? 'checked' : '' }}>
                                                    <span class="uvx-checkbox-custom"></span>
                                                    <span>{{ $option->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <div class="">
                            <button style="width: 100%" class="subscribe-buttonnn" id="applyFilters">Apply Filter</button>
                        </div>

                        <div class="">
                            <button href="{{ route('front.category') }}"
                                style="width: 100%; margin-top: 0.5rem; background-color:#800080"
                                class="subscribe-buttonnn">Clear Filter</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 col-xl-9 gs-main-blog-wrapper">
                    @php
                        if (request()->input('view_check') == null || request()->input('view_check') == 'grid-view') {
                            $view = 'grid-view';
                        } else {
                            $view = 'list-view';
                        }
                    @endphp

                    <!-- product nav wrapper -->
                    <div class="product-nav-wrapper px-3 py-2 rounded">
                        <h5>@lang('Total Products Found:') {{ $prods->count() }}</h5>
                        <div class="filter-wrapper">
                            <div class="sort-wrapper">
                                <h6>@lang('Sort by:')</h6>
                                <select id="sortby" name="sort">
                                    <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>
                                        {{ __('Latest Product') }}</option>
                                    <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>
                                        {{ __('Oldest Product') }}</option>
                                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                        {{ __('Lowest Price') }}</option>
                                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                        {{ __('Highest Price') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    @if ($prods->count() == 0)
                        <div class="product-nav-wrapper d-flex justify-content-center">
                            <h5>@lang('No Product Found')</h5>
                        </div>
                    @else
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade {{ $view == 'list-view' ? 'show active' : '' }}"
                                id="layout-list-pane" role="tabpanel" tabindex="0">
                                <div class="row gy-4 gy-lg-5">
                                    @foreach ($prods as $product)
                                        @include('includes.frontend.list_view_product')
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade {{ $view == 'grid-view' ? 'show active' : '' }}"
                                id="layout-grid-pane" role="tabpanel" tabindex="0">
                                <div class="row gy-4 gy-lg-5 mt-1">
                                    @foreach ($prods as $product)
                                        @php
                                            $preferredType = Auth::check() ? Auth::user()->preferred_type : null;
                                        @endphp
                                        @if ($preferredType === 'scheme_based_profile')
                                            @include('includes.frontend.product_scheme', [
                                                'class' => 'col-sm-6 col-md-6 col-xl-4',
                                                'product' => $product,
                                                'scheme_entries' =>
                                                    optional($product->brand->scheme)->scheme_entries ?? [],
                                            ])
                                        @elseif ($preferredType === 'net_discount_profile')
                                            @include('includes.frontend.product_discount', [
                                                'class' => 'col-sm-6 col-md-6 col-xl-4',
                                                'product' => $product,
                                                'discountSlab' => $discountSlab,
                                                'scheme_entries' =>
                                                    optional($product->brand->scheme)->scheme_entries ?? [],
                                            ])
                                        @else
                                            @include('includes.frontend.product', [
                                                'class' => 'col-sm-6 col-md-6 col-xl-4',
                                                'product' => $product,
                                                'scheme_entries' =>
                                                    optional($product->brand->scheme)->scheme_entries ?? [],
                                            ])
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{ $prods->links('includes.frontend.pagination') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if (Auth::check() && Auth::user()->preferred_type === 'net_discount_profile')
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
    <!-- product wrapper end -->

    <input type="hidden" id="update_min_price" value="">
    <input type="hidden" id="update_max_price" value="">
@endsection

{{-- @section('script') --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const baseUrl = '{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}';

            // Collapsible Sections
            document.querySelectorAll('.uvx-category-header').forEach(header => {
                header.addEventListener('click', function(e) {
                    const parent = this.parentElement;
                    const isActive = parent.classList.contains('uvx-active');
                    parent.classList.toggle('uvx-active', !isActive);
                    document.querySelectorAll('.uvx-category-item').forEach(item => {
                        if (item !== parent) item.classList.remove('uvx-active');
                    });
                });
            });

            // Prevent input clicks from toggling sections
            document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
                input.addEventListener('click', e => e.stopPropagation());
            });

            // Brand Radio Button Handling
            document.querySelectorAll('input[name="brand"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    applyFilter({
                        brand: this.value
                    });
                });
            });

            // Brand Image Click Handling
            document.querySelectorAll('.brand-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const slug = this.dataset.slug;
                    const radio = document.querySelector(`input[name="brand"][value="${slug}"]`);
                    if (radio) {
                        radio.checked = true;
                        applyFilter({
                            brand: slug
                        });
                    }
                });
            });

            // Shop By Brands - Immediate filter on checkbox change
            document.querySelectorAll('input[name="brands[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const brands = Array.from(document.querySelectorAll('input[name="brands[]"]:checked')).map(cb => cb.value);
                    applyFilter({
                        'brands[]': brands
                    });
                });
            });

            // Apply Filter Button - For tags and price range only
            document.getElementById('applyFilters').addEventListener('click', function() {
                const params = {};

                // Tags
                const tags = Array.from(document.querySelectorAll('input[name="tags[]"]:checked')).map(checkbox => checkbox.value);
                if (tags.length > 0) params['tags[]'] = tags;

                // Price Range
                const priceRange = document.querySelector('input[name="price_range"]:checked');
                if (priceRange) {
                    params['min'] = priceRange.dataset.min;
                    params['max'] = priceRange.dataset.max;
                }

                applyFilter(params);
            });

            // Clear Filter Button
            document.querySelector('.subscribe-buttonnn[href="{{ route('front.category') }}"]').addEventListener('click', function(e) {
                e.preventDefault();
                window.location.href = baseUrl;
            });

            // Sort By - Immediate filter on change
            document.getElementById('sortby').addEventListener('change', function() {
                applyFilter({
                    sort: this.value
                });
            });

            // Update pagination links
            document.querySelectorAll('ul.pagination li a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    const page = url.searchParams.get('page') || '1';
                    const currentParams = new URLSearchParams(window.location.search);
                    currentParams.set('page', page);
                    window.location.href = `${baseUrl}?${currentParams.toString()}`;
                });
            });

            // Master applyFilter function
            function applyFilter(newParams) {
                const currentParams = new URLSearchParams(window.location.search);
                const params = new URLSearchParams();

                // Preserve existing parameters except overridden ones
                for (let [key, value] of currentParams.entries()) {
                    // Skip brand or brands[] if newParams contains brand filter
                    if (newParams['brand'] && (key === 'brand' || key === 'brands[]')) continue;
                    if (newParams['brands[]'] && (key === 'brand' || key === 'brands[]')) continue;

                    // Skip tags and price range if filtering new
                    if (newParams['tags[]'] && key === 'tags[]') continue;
                    if ((newParams['min'] || newParams['max']) && (key === 'min' || key === 'max')) continue;

                    // Skip sort if overridden
                    if (newParams['sort'] && key === 'sort') continue;

                    // Skip page param (always reset to 1 on new filter)
                    if (key === 'page') continue;

                    params.append(key, value);
                }

                // Add new parameters
                for (let key in newParams) {
                    if (Array.isArray(newParams[key])) {
                        newParams[key].forEach(value => params.append(key, value));
                    } else {
                        params.set(key, newParams[key]);
                    }
                }

                // Preserve view_check
                const viewCheck = '{{ request()->input('view_check', 'grid-view') }}';
                if (!newParams['view_check']) params.set('view_check', viewCheck);

                window.location.href = `${baseUrl}?${params.toString()}`;
            }
        });
    </script>
    <script>
        function postCartJson(data = {}) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            return fetch('{{ route('front.cart.json') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(data),
            })
            .then(response => {
                if (!response.ok) throw new Error('Request failed: ' + response.status);
                return response.json();
            });
        };
        function handleCartJson(response) {
            const data = response;
            document.getElementById('totalMRP').textContent = `₹${(data.total_price + data.total_discount).toLocaleString()}`;
            document.getElementById('totalDiscount').textContent = `₹${data.total_discount.toLocaleString()}`;
            document.getElementById('totalPayable').textContent = `₹${data.total_price.toLocaleString()}`;
            const container = document.getElementById('cart-items-container');
            container.innerHTML = '';
            const products = data.products;
            document.getElementById('product-heading').style.display = products > 0 ? 'block' : 'none';
            
            Object.keys(products).forEach(key => {
                const product = products[key];
                const item = product.item;
                const scheme = product.scheme;

                const itemHTML = `
                    <div class="uvx-cart-item">
                        <div class="uvx-image-wrapper" title="${item.name}">
                            <a href="/item/${item.slug}">
                                <img src="/assets/images/products/${item.photo}" alt="${item.name}" class="uvx-product-img">
                            </a>
                            <span class="uvx-qty-badge">Qty: ${product.qty}</span>
                        </div>
                    </div>
                `;

                container.insertAdjacentHTML('beforeend', itemHTML);
            });

            if (data.user_type  == 'net_discount_profile') {
                renderDiscountSlabMessage(data.main_total, data.discount_slab || []);
            }
        }
        document.addEventListener('DOMContentLoaded', function () {
            postCartJson().then(handleCartJson).catch(console.error);
        });
        function renderDiscountSlabMessage(cartTotal, discountSlabs) {
            const messageContainer = document.getElementById('discount-warning');
            if (!messageContainer) return;
            if (cartTotal < 1) {
                messageContainer.innerHTML = `Add Products to your cart!`;
                return;
            }
            let nextSlab = null;
            let currentSlab = null;
            discountSlabs.sort((a, b) => a.min_value - b.min_value);
            for (const slab of discountSlabs) {
                const min = slab.min_value;
                const max = slab.max_value;
                if (cartTotal < min) {
                    nextSlab = slab;
                    break;
                }
                if (cartTotal >= min && (max === null || cartTotal <= max)) {
                    currentSlab = slab;
                }
            }
            if (nextSlab) {
                const moreToSpend = nextSlab.min_value - cartTotal;
                const discountPercentageRaw = parseFloat(nextSlab.discount_percentage);
                const discountPercentage = Number.isInteger(discountPercentageRaw)
                    ? discountPercentageRaw.toString()
                    : discountPercentageRaw.toFixed(2).replace(/\.00$/, '');

                const formattedAmount = Number.isInteger(moreToSpend)
                    ? moreToSpend.toLocaleString()
                    : moreToSpend.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                messageContainer.innerHTML = `Avail <strong>${discountPercentage}%</strong> by adding items worth <strong>₹${formattedAmount}</strong> more to your cart!`;
            } else if (currentSlab) {
                const discountPercentageRaw = parseFloat(currentSlab.discount_percentage);
                const discountPercentage = Number.isInteger(discountPercentageRaw)
                    ? discountPercentageRaw.toString()
                    : discountPercentageRaw.toFixed(2).replace(/\.00$/, '');
                messageContainer.innerHTML = `You've unlocked a <strong>${discountPercentage}%</strong> discount!`;
            } else {
                messageContainer.innerHTML = `Add items to your cart to unlock discounts!`;
            }
        }
    </script>
{{-- @endsection --}}
{{-- @section('css') --}}
    <style>
        .footer-container {
            width: 100rem !important;
        }

        .product-pricing .individual-price {
            font-size: 1rem;
        }

        .pricing-flex span {
            display: inline-block;
        }

        .pricing-flex {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
        }

        .brand-logo-item {
            margin: 15px 0;
            /* Increased margin for better spacing with larger logos */
            display: flex;
            align-items: center;
        }

        .uvx-checkbox-item {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .logo-img {
            width: 120px;
            /* Increased from 80px to make logos larger */
            height: auto;
            margin-left: 15px;
            /* Slightly increased margin for better spacing */
            transition: transform 0.3s ease;
        }

        .logo-img:hover {
            transform: scale(1.1);
            /* Slightly increased scale for more noticeable hover effect */
        }

        .uvx-checkbox-custom {
            flex-shrink: 0;
            width: 22px;
            /* Slightly larger checkbox to match larger logos */
            height: 22px;
            /* Matching height */
        }

        .uvx-checkbox-custom::after {
            left: 6px;
            /* Adjusted position for larger checkbox */
            top: 2px;
            /* Adjusted position for larger checkbox */
            width: 6px;
            /* Slightly larger checkmark */
            height: 12px;
            /* Slightly larger checkmark */
        }

        .uvx-category-container {
            font-family: 'Arial', sans-serif;
            max-width: 320px;
            /* Slightly increased to accommodate larger logos */
            margin: auto;
            padding: 20px;
        }

        .uvx-filter-heading {
            color: #333;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .uvx-category-item {
            border-bottom: 1px solid #eee;
        }

        .uvx-category-header {
            padding: 12px 0;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .uvx-category-header:hover {
            background-color: #f9f9f9;
        }

        .uvx-caret-icon {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 14px;
            color: #666;
        }

        .uvx-category-content {
            max-height: 0;
            overflow: hidden;
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding-left: 15px;
        }

        .uvx-category-item.uvx-active .uvx-caret-icon {
            transform: rotate(180deg);
        }

        .uvx-category-item.uvx-active .uvx-category-content {
            max-height: 600px;
            /* Increased to accommodate larger logos */
            opacity: 1;
            padding: 15px 0 20px 15px;
            /* Adjusted padding */
        }

        .uvx-radio-group,
        .uvx-checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 1rem;
        }

        .uvx-radio-item,
        .uvx-checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: opacity 0.3s ease;
            opacity: 0;
            transform: translateY(-5px);
        }

        .uvx-category-item.uvx-active .uvx-radio-item,
        .uvx-category-item.uvx-active .uvx-checkbox-item {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.3s ease 0.2s;
        }

        .uvx-radio-custom {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 2px solid #FFA500;
            border-radius: 50%;
            position: relative;
            transition: all 0.2s ease;
        }

        .uvx-radio-custom::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: #FFA500;
            border-radius: 50%;
            opacity: 0;
        }

        input[type="radio"]:checked+.uvx-radio-custom::after {
            opacity: 1;
        }

        .uvx-checkbox-custom {
            display: inline-block;
            border: 2px solid #FFA500;
            border-radius: 100%;
            position: relative;
            transition: all 0.2s ease;
        }

        input[type="checkbox"]:checked+.uvx-checkbox-custom {
            background: #FFA500;
            border-color: #FFA500;
        }

        input[type="checkbox"]:checked+.uvx-checkbox-custom::after {
            opacity: 1;
        }

        input[type="radio"],
        input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }


        .uvx-category-container .subscribe-buttonnn {
            display: inline-block;
            padding: 12px 24px;
            /* Adjusted for wider buttons as per image */
            background-color: #B266FF;
            /* Light purple for Apply Filter */
            color: white;
            border: none;
            border-radius: 25px;
            /* Rounded edges to match image */
            /* font-size: 16px; */
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Subtle shadow for depth */
        }

        .uvx-category-container .subscribe-buttonnn:hover {
            background-color: #A64DFF;
            /* Slightly darker purple on hover */
        }

        .uvx-category-container .subscribe-buttonnn[href] {
            background-color: #800080;
            /* Darker purple for Clear Filter */
            margin-top: 0.5rem;
            /* Maintain spacing as per original */
        }

        .uvx-category-container .subscribe-buttonnn[href]:hover {
            background-color: #6A0DAD;
            /* Even darker purple on hover */
        }

        #sortby {
            display: block;
            width: 60%;
            max-width: 250px;
            padding: 10px 40px 10px 15px;
            font-size: 16px;
            color: #333;
            background-color: #fff;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20fill%3D%22%23444%22%20height%3D%2220%22%20viewBox%3D%220%200%2024%2024%22%20width%3D%2220%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Cpath%20d%3D%22M7%2010l5%205%205-5z%22/%3E%3Cpath%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        #sortby:hover {
            border-color: #aaa;
        }

        #sortby:focus {
            border-color: #5b9bd5;
            outline: none;
            box-shadow: 0 0 0 2px rgba(91, 155, 213, 0.3);
        }
    </style>
    <style>
        /* Cart Summary */
        .uvx-cart-summary-container {
            background: #ffffff;
            color: #000000;
            border-radius: 12px;
            padding: 1.2rem 1rem;
            font-family: Arial, sans-serif;
            max-width: 700px;
            margin: auto;
        }

        .uvx-cart-summary-container .uvx-cart-header h3 {
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .uvx-cart-summary-container .uvx-cart-items{
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }


        
        .uvx-cart-summary-container .uvx-cart-items h6{
            padding: 1.2rem 0rem;
        }

        .uvx-cart-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            /* margin-bottom: 1.5rem; */
            /* padding: 1rem; */
            /* border: 1px solid #444; */
            border-radius: 10px;
            background-color: #fcfcfc;
            position: relative;
        }

        .uvx-image-wrapper {
            position: relative;
            width: 80px;
            height: 80px;
            flex-shrink: 0;
        }

        .uvx-product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #333;
        }

        .uvx-qty-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #800080;
            color: white;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 50px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .uvx-product-details {
            color: #fff;
            font-size: 0.9rem;
        }

        .uvx-product-details h4 {
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }

        .uvx-discount-text {
            color: #00e676;
            font-weight: 600;
        }

        .uvx-scheme-info {
            font-size: 0.85rem;
            color: #bbb;
        }

        .uvx-cart-summary-container .uvx-cart-item {
            display: flex;
            gap: 1rem;
            border-radius: 50%;
        }

        .uvx-cart-summary-container .uvx-product-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 8px;
            background: #333;
            border-radius: 50%;
            overflow: hidden;
        }

        .uvx-cart-summary-container .uvx-product-details h4 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .uvx-cart-summary-container .uvx-product-details p {
            margin: 4px 0;
            font-size: 0.95rem;
        }

        .uvx-cart-summary-container .uvx-discount-text {
            color: #f39c12;
            font-weight: bold;
        }

        .uvx-cart-summary-container .uvx-scheme-info {
            color: #7ed6df;
            font-size: 0.85rem;
        }

        .uvx-cart-summary-container .uvx-cart-totals {
            margin-top: 1rem;
            /* border-bottom: 1px solid #444; */
            padding-bottom: 16px;
            /* text-align: left; */
        }

        .uvx-cart-summary-container .uvx-cart-totals strong {
            display: inline-block;
            float: right;
            /* text-align: right; */
        }

        .uvx-cart-totals p {
            font-size: 1.1rem;
            margin: 6px 0;
        }

        .uvx-skeleton {
            background-color: #5c5c5c;
            border-radius: 4px;
            animation: pulse 1.5s infinite;
        }

        .uvx-skeleton.text {
            height: 16px;
            width: 100px;
            margin: 5px 0;
        }

        .uvx-skeleton.img {
            width: 80px;
            height: 80px;
            border-radius: 8px;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.4; }
            100% { opacity: 1; }
        }

    </style>
{{-- @endsection --}}
