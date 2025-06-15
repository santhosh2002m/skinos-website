<footer class="gs-footer-section {{ $gs->theme == 'theme3' ? 'home-3' : '' }}" style="margin-top: 20px">
    <div class="footer-container">
        <div style="padding: 2rem 0">
            <div class="footer-logo-content">
                <div class="phone">
                    <h5>@lang('Phone')</h5>
                    <h6>{{ $ps->phone ?? 'N/A' }}</h6>
                </div>
                <div class="rnd-logo">
                    <img class="logo" src="{{ asset('assets/images/' . ($gs->logo ?? 'default-logo.png')) }}" alt="logo">
                </div>
                <div class="email-content">
                    <h5>@lang('Email')</h5>
                    <h6>{{ $ps->email ?? 'N/A' }}</h6>
                </div>
            </div>
            <div class="footer-grid">
                <div>
                    <h5>@lang('Contact Us')</h5>
                    <p style="margin-bottom: 1rem;font-size:15px">{{ $ps->street ?? 'RND Laboratories, NO:01, XYZ, ABC Road, Bangalore, Karnataka' }}</p>
                </div>
                <div style="justify-self: center">
                    <h5>@lang('Quick Links')</h5>
                    <ul>
                        @php
                            $quickLinks = DB::table('pages')
                                ->where('footer', '=', 1)
                                ->whereIn('slug', ['about-us', 'contact-us', 'blogs'])
                                ->get();
                        @endphp
                        @foreach ($quickLinks as $page)
                            <li>
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.1046 3.69904C5.96513 3.83422 5.96513 4.0534 6.1046 4.18858L10.1378 8.09766L6.1046 12.0067C5.96513 12.1419 5.96513 12.3611 6.1046 12.4963C6.24408 12.6315 6.47021 12.6315 6.60968 12.4963L10.8954 8.34242C11.0349 8.20724 11.0349 7.98807 10.8954 7.85289L6.60968 3.69904C6.47021 3.56386 6.24408 3.56386 6.1046 3.69904Z" fill="white"/>
                                </svg>
                                @if (strtolower($page->slug) == 'contact-us')
                                    <a href="{{ route('front.vendor', 'contact') }}">{{ $page->title }}</a>
                                @elseif (strtolower($page->slug) == 'blogs')
                                    <a href="{{ route('front.vendor', 'blog') }}">{{ $page->title }}</a>
                                @else
                                    <a href="{{ route('front.vendor', $page->slug) }}">{{ $page->title }}</a>
                                @endif
                            </li>
                        @endforeach
                        <li>
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.1046 3.69904C5.96513 3.83422 5.96513 4.0534 6.1046 4.18858L10.1378 8.09766L6.1046 12.0067C5.96513 12.1419 5.96513 12.3611 6.1046 12.4963C6.24408 12.6315 6.47021 12.6315 6.60968 12.4963L10.8954 8.34242C11.0349 8.20724 11.0349 7.98807 10.8954 7.85289L6.60968 3.69904C6.47021 3.56386 6.24408 3.56386 6.1046 3.69904Z" fill="white"/>
                                </svg>
                            <a href="https://skinosis.in/contact">Contact Us</a>
                        </li>
                        <li>
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.1046 3.69904C5.96513 3.83422 5.96513 4.0534 6.1046 4.18858L10.1378 8.09766L6.1046 12.0067C5.96513 12.1419 5.96513 12.3611 6.1046 12.4963C6.24408 12.6315 6.47021 12.6315 6.60968 12.4963L10.8954 8.34242C11.0349 8.20724 11.0349 7.98807 10.8954 7.85289L6.60968 3.69904C6.47021 3.56386 6.24408 3.56386 6.1046 3.69904Z" fill="white"/>
                                </svg>
                            <a href="https://skinosis.in/blog">Blog</a>
                        </li>
                    </ul>
                </div>
                <div style="justify-self: center">
                    <h5>@lang('Useful Links')</h5>
                    <ul>
                        @php
                            $usefulLinks = DB::table('pages')
                                ->where('footer', '=', 1)
                                ->whereIn('slug', ['privacy-policy', 'terms-and-conditions', 'return-policy', 'faqs'])
                                ->get();
                        @endphp
                        @foreach ($usefulLinks as $page)
                            <li>
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.1046 3.69904C5.96513 3.83422 5.96513 4.0534 6.1046 4.18858L10.1378 8.09766L6.1046 12.0067C5.96513 12.1419 5.96513 12.3611 6.1046 12.4963C6.24408 12.6315 6.47021 12.6315 6.60968 12.4963L10.8954 8.34242C11.0349 8.20724 11.0349 7.98807 10.8954 7.85289L6.60968 3.69904C6.47021 3.56386 6.24408 3.56386 6.1046 3.69904Z" fill="white"/>
                                </svg>
                                @if (strtolower($page->slug) == 'faqs')
                                    <a href="{{ route('front.vendor', $page->slug) }}">{{ $page->title }}</a>
                                @else
                                    <a href="{{ route('front.vendor', $page->slug) }}">{{ $page->title }}</a>
                                @endif
                            </li>
                        @endforeach
                        <li>
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.1046 3.69904C5.96513 3.83422 5.96513 4.0534 6.1046 4.18858L10.1378 8.09766L6.1046 12.0067C5.96513 12.1419 5.96513 12.3611 6.1046 12.4963C6.24408 12.6315 6.47021 12.6315 6.60968 12.4963L10.8954 8.34242C11.0349 8.20724 11.0349 7.98807 10.8954 7.85289L6.60968 3.69904C6.47021 3.56386 6.24408 3.56386 6.1046 3.69904Z" fill="white"/>
                            </svg>
                            <a href="{{ url('/faq') }}">@lang("FAQ's")</a>
                        </li>
                        <li>
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.1046 3.69904C5.96513 3.83422 5.96513 4.0534 6.1046 4.18858L10.1378 8.09766L6.1046 12.0067C5.96513 12.1419 5.96513 12.3611 6.1046 12.4963C6.24408 12.6315 6.47021 12.6315 6.60968 12.4963L10.8954 8.34242C11.0349 8.20724 11.0349 7.98807 10.8954 7.85289L6.60968 3.69904C6.47021 3.56386 6.24408 3.56386 6.1046 3.69904Z" fill="white"/>
                            </svg>
                            <a href="{{ url('/admin/login') }}">@lang('SP Login')</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <div class="followers-section">
                        <h5>@lang('Follow Us')</h5>
                        <div class="social-icons">
                            @php
                                $socialLinks = DB::table('social_links')
                                    ->where('user_id', 0)
                                    ->where('status', 1)
                                    ->get();
                            @endphp
                            @foreach ($socialLinks as $link)
                                <a href="{{ $link->link }}" target="_blank" aria-label="{{ str_replace(['<i class="', '"></i>'], '', $link->icon) }}">
                                    <i class="{{ str_replace(['<i class="', '"></i>'], '', $link->icon) }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Footer Section */
    .gs-footer-section {
        background-color: #001F3F;
        border-radius: 9px 9px 0 0;
    }

    /* Footer Logo Content */
    .footer-logo-content {
        color: #fff;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        justify-content: space-between;
        align-items: center;
        padding: 2rem 1rem;
        border-bottom: 2px solid #fff;
        margin-bottom: 2rem;
    }

    /* Footer Container */
    .footer-container {
        width: 100%;
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Center-aligned Text Classes */
    .phone,
    .rnd-logo,
    .email-content {
        text-align: center;
    }

    .rnd-logo img {
        max-width: 150px;
        height: auto;
        margin: 0 auto;
        filter: brightness(3.5);
    }

    /* Footer Grid */
    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        color: #fff;
        padding: 0 1rem;
    }

    .footer-grid h5 {
        margin-bottom: 1.5rem;
        font-size: 18px;
    }

    .footer-grid ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .footer-grid li {
        font-size: 15px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .footer-grid li:hover {
        transform: translateX(10px);
        color: #FF6B00;
    }

    .footer-grid li a {
        color: #fff;
        text-decoration: none;
        font-size: 15px;
        transition: color 0.3s ease;
    }

    .footer-grid li:hover a {
        color: #aa6dff;
    }

    /* Followers Section */
    .followers-section {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .followers-section h5 {
        margin-bottom: 1.5rem;
    }

    .social-icons {
        display: flex;
        gap: 30px;
    }

    .social-icons a {
        color: #fff;
        font-size: 24px;
        transition: all 0.3s ease;
    }

    .social-icons a:hover {
        color: #aa6dff;
        transform: scale(1.2);
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .footer-logo-content {
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 2rem 0;
        }

        .phone, .email-content {
            order: -1;
        }

        .rnd-logo {
            margin: 1rem 0;
        }

        .footer-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .footer-grid {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .footer-grid li {
            justify-content: center;
        }

        .followers-section {
            align-items: center;
        }

        .social-icons {
            justify-content: center;
        }

        .footer-grid h5 {
            margin-top: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .social-icons {
            gap: 10px;
        }

        .social-icons a {
            font-size: 20px;
        }

        .footer-grid li {
            font-size: 14px;
        }

        .footer-logo-content h6 {
            font-size: 14px;
        }
    }
</style>