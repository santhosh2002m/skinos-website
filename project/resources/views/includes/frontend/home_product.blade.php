<div class="{{ isset($class) ? $class : '' }}">
    <div class="single-product">
        <div class="img-wrapper position-relative">
            <!-- Product Image -->
            <a href="{{ route('front.product', $product->slug) }}">
                <img class="product-img" src="{{ $product->photo ? asset('assets/images/products/' . $product->photo) : asset('assets/images/noimage.png') }}" alt="{{ $product->name ?? 'Product' }}">
            </a>

            <!-- Product Actions (Wishlist and Compare) -->
            <div class="product-actions">
                @auth
                    @if (isset($wishlist) && $wishlist)
                        <a href="javascript:;" class="removewishlist" data-href="{{ route('user-wishlist-remove', $product->wishlist_id) }}">
                            <div class="action-btn danger" style="background-color: #ff0019; transition: background-color 0.3s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                    <path d="M3 6h18" />
                                    <path d="M8 6v-2a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2" />
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                    <path d="M10 11v6" />
                                    <path d="M14 11v6" />
                                </svg>
                            </div>
                        </a>
                    @else
                        <a href="javascript:;" class="wishlist"
                           data-href-add="{{ route('user-wishlist-add', $product->id) }}"
                           data-href-remove="{{ ($wishlistItem = \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->first()) ? route('user-wishlist-remove', $wishlistItem->id) : '' }}"
                           data-toggle="{{ $wishlistItem ? 'remove' : 'add' }}">
                            <div class="action-btn {{ $wishlistItem ? 'active' : '' }}" style="transition: background-color 0.3s ease;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </a>
                    @endif
                @else
                    <a href="{{ route('user.login') }}">
                        <div class="action-btn" style="background-color: #ffffff; transition: background-color 0.3s ease;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </a>
                @endauth
            </div>

            <!-- Add to Cart/View Button -->
            <div class="add-to-cart">
                @if ($product->product_type == 'affiliate')
                    <a href="{{ $product->affiliate_link ?? '#' }}" class="add_to_cart_button">
                        <div class="add-cart" style="background-color: #800080; color: white; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#6A0DAD'" onmouseout="this.style.backgroundColor='#800080'">
                            @lang('View')
                        </div>
                    </a>
                @else
                    @if (method_exists($product, 'emptyStock') && $product->emptyStock())
                        <div class="add-cart disabled" style="background-color: #ccc; color: black; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#b0b0b0'" onmouseout="this.style.backgroundColor='#ccc'">
                            @lang('Out of Stock')
                        </div>
                    @else
                        @if ($product->type != 'Listing')
                            <a href="{{ route('front.product', $product->slug) }}" class="add_to_cart_button">
                                <div class="add-cart" style="background-color: #800080; color: white; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#6A0DAD'" onmouseout="this.style.backgroundColor='#800080'">
                                    @lang('View')
                                </div>
                            </a>
                        @endif
                    @endif
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="product-info">
            <a href="{{ route('front.product', $product->slug) }}" class="product-name" style="color: black; font-family: 'Poppins', sans-serif; font-size: 1.3rem;">
                {{ method_exists($product, 'showName') ? $product->showName() : ($product->name ?? 'N/A') }}
            </a>
            <div class="product-pricing">
                @auth
                    <div class="price-details">
                        {!! method_exists($product, 'showPrice') ? $product->showPrice() : "" !!}
                    </div>
                @else
                    <span style="color: black;">₹ XXXX</span>
                @endauth
            </div>
        </div>
    </div>
</div>