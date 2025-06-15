<li>
    <a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i
            class="fas fa-hand-holding-usd"></i>{{ __('Orders') }}</a>
    <ul class="collapse list-unstyled" id="order" data-parent="#accordion">
        <li>
            <a href="{{ route('admin-orders-all') }}"> {{ __('All Orders') }}</a>
        </li>
        <li>
            <a href="{{ route('admin-orders-all') }}?status=pending"> {{ __('Pending Orders') }}</a>
        </li>
        <li>
            <a href="{{ route('admin-orders-all') }}?status=processing"> {{ __('Processing Orders') }}</a>
        </li>
        <li>
            <a href="{{ route('admin-orders-all') }}?status=completed"> {{ __('Completed Orders') }}</a>
        </li>
        <li>
            <a href="{{ route('admin-orders-all') }}?status=declined"> {{ __('Declined Orders') }}</a>
        </li>
    </ul>
</li>

<li>
    <a href="#brand" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-hand-holding-usd"></i>{{ __('Manage Brand') }}
    </a>
    <ul class="collapse list-unstyled" id="brand" data-parent="#accordion">
        <li>
            <a href="{{ route('admin-brand-index') }}">{{ __('Brands') }}</a>
        </li>
        <li>
            <a href="{{ route('admin-scheme-index') }}">{{ __('Scheme') }}</a>
        </li>
        <li>
            <a href="{{ route('admin-slabs-index') }}">{{ __('Discount Slabs') }}</a>
        </li>
        <li>
            <a href="{{ route('admin-tag-index') }}">{{ __('Tags') }}</a>
        </li>
        <li>
            <a href="{{ route('admin-cashback-index') }}">{{ __('Cashbacks') }}</a>
        </li>
    </ul>
</li>

<li>
    <a href="#menu1" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-flag"></i>{{ __('Manage Country') }}
    </a>
    <ul class="collapse list-unstyled" id="menu1" data-parent="#accordion">
        <li>
            <a href="{{ route('admin-country-index') }}"><span>{{ __('Country') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-country-tax') }}"><span>{{ __('Manage Gst') }}</span></a>
        </li>
    </ul>
</li>

{{-- <li>
    <a href="#menu5" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i
            class="fas fa-sitemap"></i>{{ __('Manage Categories') }}</a>
    <ul class="collapse list-unstyled
        @if (request()->is('admin/attribute/*/manage') && request()->input('type') == 'category') show @endif"
        id="menu5" data-parent="#accordion">
        <li class="@if (request()->is('admin/attribute/*/manage') && request()->input('type') == 'category') active @endif">
            <a href="{{ route('admin-cat-index') }}"><span>{{ __('Main Category') }}</span></a>
        </li>
    </ul>
</li> --}}

<li>
    <a href="#menu2" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="icofont-cart"></i>{{ __('Products') }}
    </a>
    <ul class="collapse list-unstyled" id="menu2" data-parent="#accordion">
        <li>
            <a  href="{{ route('admin-prod-create','physical') }}"><span>{{ __('Add New Product') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-prod-index') }}"><span>{{ __('All Products') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-prod-deactive') }}"><span>{{ __('Deactivated Product') }}</span></a>
        </li>
        {{-- <li> --}}
            {{-- <a href="{{ route('admin-prod-catalog-index') }}"><span>{{ __('Product Catalogs') }}</span></a> --}}
        {{-- </li> --}}
        {{-- <li> --}}
            {{-- <a href="{{ route('admin-gs-prod-settings') }}"><span>{{ __('Product Settings') }}</span></a> --}}
        {{-- </li> --}}
    </ul>
</li>

{{-- <li>
    <a href="{{ route('admin-prod-import') }}"><i class="fas fa-upload"></i>{{ __('Bulk Product Upload') }}</a>
</li> --}}

{{-- <li>
    <a href="{{ route('admin-coupon-index') }}" class="wave-effect"><i
            class="fas fa-percentage"></i>{{ __('Set Coupons') }}</a>
</li> --}}

<li>
    <a href="#menu3" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="icofont-user"></i>{{ __('Customers') }}
    </a>
    <ul class="collapse list-unstyled" id="menu3" data-parent="#accordion">
        <li>
            <a href="{{ route('admin-user-index') }}"><span>{{ __('Customers List') }}</span></a>
        </li>
        {{-- <li>
            <a href="{{ route('admin-withdraw-index') }}"><span>{{ __('Withdraws') }}</span></a>
        </li> --}}
        <li>
            <a href="{{ route('admin-user-image') }}"><span>{{ __('Customer Default Image') }}</span></a>
        </li>
    </ul>
</li>

{{-- <li>
    <a href="#customerDeposit" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="icofont-money"></i>{{ __('Customer Deposits') }}
    </a>
    <ul class="collapse list-unstyled" id="customerDeposit" data-parent="#accordion">
        <li>
            <a href="{{ route('admin-user-deposits', 'all') }}"><span>{{ __('Completed Deposits') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-user-deposits', 'pending') }}"><span>{{ __('Pending Deposits') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-trans-index') }}"><span>{{ __('Transactions') }}</span></a>
        </li>
    </ul>
</li> --}}

<li>
    <a href="#blog" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-fw fa-newspaper"></i>{{ __('Blog') }}
    </a>
    <ul class="collapse list-unstyled" id="blog" data-parent="#accordion">
        <li>
            <a href="{{ route('admin-cblog-index') }}"><span>{{ __('Categories') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-blog-index') }}"><span>{{ __('Posts') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-gs-blog-settings') }}"><span>{{ __('Blog Settings') }}</span></a>
        </li>
    </ul>
</li>

<li>
    <a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-cogs"></i>{{ __('General Settings') }}</a>
    <ul class="collapse list-unstyled" id="general" data-parent="#accordion">
        <li>
            <a href="{{ route('admin-gs-logo') }}"><span>{{ __('Logo') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-gs-fav') }}"><span>{{ __('Favicon') }}</span></a>
        </li>
        {{-- <li>
            <a href="{{ route('admin-shipping-index') }}"><span>{{ __('Shipping Methods') }}</span></a>
        </li> --}}
        {{-- <li>
            <a href="{{ route('admin-package-index') }}"><span>{{ __('Packagings') }}</span></a>
        </li> --}}
        {{-- <li>
            <a href="{{ route('admin-pick-index') }}"><span>{{ __('Pickup Locations') }}</span></a>
        </li> --}}
        <li>
            <a href="{{ route('admin-gs-contents') }}"><span>{{ __('Website Contents') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-gs-maintenance') }}"><span>{{ __('Website Maintenance') }}</span></a>
        </li>
    </ul>
</li>

<li>
    <a href="#homepage" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-edit"></i>{{ __('Home Page Settings') }}</a>
    <ul class="collapse list-unstyled" id="homepage" data-parent="#accordion">
        <li>
            <a href="{{ route('admin-sl-index') }}"><span>{{ __('Sliders') }}</span></a>
        </li>

        <li>
            <a href="{{ route('admin-arrival-index') }}"><span>{{ __('Home Page Name') }}</span></a>
        </li>
    </ul>
</li>

<li>
    <a href="#menu" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false ">
        <i class="fas fa-file-code"></i>{{ __('Menu Page Settings') }}
    </a>
    <ul class="collapse list-unstyled" id="menu" data-parent="#accordion">
        <li>
            <a href="{{ route('admin-faq-index') }}"><span>{{ __('FAQ Page') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-ps-contact') }}"><span>{{ __('Contact Us Page') }}</span></a>
        </li>
        <li>
            <a href="{{ route('admin-page-index') }}"><span>{{ __('Other Pages') }}</span></a>
        </li>
        {{-- <li>
            <a href="{{ route('admin-ps-menu-links') }}"><span>{{ __('Customize Menu Links') }}</span></a>
        </li> --}}
    </ul>
</li>

<li>
    <a href="#payments" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-file-code"></i>{{ __('Payment Settings') }}</a>
    <ul class="collapse list-unstyled" id="payments" data-parent="#accordion">
        {{-- <li><a href="{{ route('admin-gs-payments') }}"><span>{{ __('Payment Information') }}</span></a></li> --}}
        <li><a href="{{ route('admin-payment-index') }}"><span>{{ __('Payment Gateways') }}</span></a></li>
        {{-- <li><a href="{{ route('admin-currency-index') }}"><span>{{ __('Currencies') }}</span></a></li> --}}
    </ul>
</li>

<li>
    <a href="#socials" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
        <i class="fas fa-paper-plane"></i>{{ __('Social Settings') }}
    </a>
    <ul class="collapse list-unstyled" id="socials" data-parent="#accordion">
        <li><a href="{{ route('admin-sociallink-index') }}"><span>{{ __('Social Links') }}</span></a></li>
        {{-- <li><a href="{{ route('admin-social-facebook') }}"><span>{{ __('Facebook Login') }}</span></a></li> --}}
        {{-- <li><a href="{{ route('admin-social-google') }}"><span>{{ __('Google Login') }}</span></a></li> --}}
    </ul>
</li>

<li>
    <a href="{{ route('admin-staff-index') }}" class="wave-effect"><i
            class="fas fa-user-secret"></i>{{ __('Manage Staffs') }}</a>
</li>

<li>
    <a href="{{ route('admin-role-index') }}" class="wave-effect"><i
            class="fas fa-user-tag"></i>{{ __('Manage Roles') }}</a>
</li>