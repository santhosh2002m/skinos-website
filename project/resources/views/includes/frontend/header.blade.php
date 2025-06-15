<style>
    .info-right li a {
        font-size: 14px;
    }

    .header-logo-wrapper img.logo {
        /* width: 100% !important; */
        height: auto !important;
        object-fit: contain !important;
        max-width: 180px;
    }

    @media (max-width: 1199px) {

        /* Tablet */
        .header-logo-wrapper {
            max-width: 140px !important;
        }
    }

    @media (max-width: 767px) {

        /* Mobile */
        .header-logo-wrapper {
            max-width: 120px !important;
        }

        .mobile-menu-toggle svg {
            width: 20px !important;
            height: 20px !important;
        }
    }

    @media (max-width: 480px) {

        /* Small Mobile */
        .header-logo-wrapper {
            max-width: 100px !important;
        }
    }

    @media (min-width: 1200px) {
        .mobile-menu-toggle {
            display: none !important;
        }
    }

    .info-right li a {
        font-size: 14px;
    }

    @media (max-width: 1199px) {

        /* Tablet */
        .header-logo-wrapper {
            max-width: 140px !important;
        }
    }

    @media (max-width: 767px) {

        /* Mobile */
        .header-logo-wrapper {
            max-width: 120px !important;
        }

        .mobile-menu-toggle svg {
            width: 20px !important;
            height: 20px !important;
        }
    }

    @media (max-width: 480px) {

        /* Small Mobile */
        .header-logo-wrapper {
            max-width: 100px !important;
        }
    }

    @media (min-width: 1200px) {
        .mobile-menu-toggle {
            display: none !important;
        }
    }

    .header-section {
        position: relative;
        z-index: 10 !important;
        -webkit-box-shadow: 0px 4px 25px 0px rgba(0, 0, 0, 0.06);
        box-shadow: 0px 4px 25px 0px rgba(0, 0, 0, 0.06);
    }

    @media (max-width: 991.97px) {
        .header-section .create-navbar {
            -webkit-box-shadow: none;
            box-shadow: none;
        }
    }

    .info-bar {
        padding-top: 18px;
        padding-bottom: 17px;
        background-color: #001f3f;
        overflow: visible;
    }

    @media (max-width: 767.98px) {
        .info-bar {
            padding-top: 6px;
            padding-bottom: 6px;
        }
    }

    .info-bar .info-row {
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }

    .info-bar a {
        color: #fff;
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
    }

    .info-bar a:hover {
        color: #d9d4d4;
    }

    .info-bar .info-left {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }

    @media (max-width: 767.98px) {
        .info-bar .info-left {
            display: none;
        }
    }

    .info-bar .info-left .wows {
        gap: 32px;
    }

    .info-bar .info-left .wows li {
        font-size: 16px;
        font-weight: 400;
    }

    .info-bar .info-left .wows .info-left-icon {
        padding-bottom: 2px;
    }

    .info-bar .info-right .wows {
        gap: 32px;
    }

    .info-bar .info-right .wows .info-bar-btn {
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
    }

    .info-bar .info-right .wows .info-bar-btn:hover {
        background-color: #1d58db;
    }

    @media (max-width: 1199.97px) {
        .info-bar .info-left .wows li {
            font-size: 14px;
        }

        .info-bar .info-right .wows {
            gap: 16px;
        }

        .info-bar .info-right .wows li {
            font-size: 14px !important;
        }

        .info-bar .info-right .info-bar-btn {
            font-size: 14px;
        }
    }

    @media (max-width: 991.97px) {
        .info-bar .info-right .wows {
            gap: 12px;
        }
    }

    @media (max-width: 767.98px) {
        .info-bar .info-row {
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .info-bar .info-row .info-left .wows {
            gap: 16px;
        }

        .info-bar .info-row .info-left .wows li {
            font-size: 14px;
            font-weight: 500;
        }
    }

    @media (max-width: 619.99px) {
        .info-bar .info-row {
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }
    }

    @media (max-width: 459.99px) {
        .info-bar .info-row .info-left ul {
            display: block;
        }
    }

    .nav-link:focus,
    .nav-link:hover {
        color: #ffffff;
    }

    .dropdown-menu {
        min-width: 100%;
        text-align: center;
        z-index: 9;
        padding: 0;
        border-radius: 0;
    }

    .dropdown-menu>li:last-child {
        border-bottom: 2px solid #5c86e5;
    }

    .dropdown-item {
        color: #333;
        height: 44px;
        padding: 9px 24px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: start;
        border-bottom: 1px solid #e9e6e6;
        font-family: Poppins;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 120%;
    }

    .pages_dropdown {
        padding: 13px 24px;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-toggle {
        color: #ffffff;
        border: none;
        position: relative;
    }

    .dropdown-toggle::after {
        margin-left: 0.255em;
        border-top: 0.4em solid;
        border-right: 0.4em solid transparent;
        border-bottom: 0;
        border-left: 0.4em solid transparent;
        border-radius: 2px;
    }

    .dropdown-toggle-black {
        color: #1f0300;
    }

    .menus__dropdown {
        color: #1f0300 !important;
    }

    .navbar-icon {
        margin-right: 10px;
    }

    .dropdown__item {
        color: black !important;
    }

    .dropdown__item:hover {
        color: #ffffff !important;
        background-color: #5c86e5;
    }

    .dropdown-menu.show {
        left: 4px !important;
        top: 6px !important;
    }

    .pages-dropdown.show {
        -webkit-transform: translate3d(-43px, 30px, 0px) !important;
        transform: translate3d(-43px, 30px, 0px) !important;
    }

    .header-top {
        padding: 32px 0;
        background-color: #ffffff;
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
    }

    .header-top.sticky {
        position: fixed;
        top: 0;
        left: 0;
        padding: 18px 0;
        width: 100%;
        -webkit-box-shadow: 0px 4px 32px 0px rgba(0, 0, 0, 0.09);
        box-shadow: 0px 4px 32px 0px rgba(0, 0, 0, 0.09);
    }

    @media (max-width: 1199.97px) {
        .header-top.sticky {
            padding: 16px 0;
        }
    }

    @media (max-width: 991.97px) {
        .header-top.sticky {
            padding: 10px 0;
        }
    }

    .header-top .create-navbar {
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    .header-top .create-navbar .nav-left {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        gap: 16px;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        height: 42px;
    }

    .header-top .create-navbar .nav-center {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }

    .header-top .create-navbar .nav-center .nav-menus {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        gap: 30px;
    }

    .header-top .create-navbar .nav-center .nav-menus li {
        font-size: 15px;
        font-weight: 400;
        position: relative;
    }

    .header-top .create-navbar .nav-center .nav-menus li .has-submenu-icon {
        display: inline-block;
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
    }

    .header-top .create-navbar .nav-center .nav-menus li .has-submenu-icon svg path {
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
    }

    .header-top .create-navbar .nav-center .nav-menus li a {
        color: #1f0300;
        text-transform: uppercase;
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
    }

    .header-top .create-navbar .nav-center .nav-menus li.has-megamenu {
        position: relative;
        class="header-colors"
        /* Added for positioning context */
    }

    .header-top .create-navbar .nav-center .nav-menus li:hover .submenu,
    .header-top .create-navbar .nav-center .nav-menus li:hover .megamenu {
        opacity: 1;
        visibility: visible;
        top: 150%;
        background-color: #ffffff;
    }

    .header-top .create-navbar .nav-center .nav-menus li.active>a {
        color: #5c86e5;
    }

    .header-top .create-navbar .nav-center .nav-menus li.active>a::after {
        content: "";
        position: absolute;
        height: 1px;
        display: block;
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
        bottom: -5px;
        width: 100%;
        height: 1px;
        background-color: #5c86e5;
    }

    .header-top .create-navbar .nav-center .nav-menus li>a {
        position: relative;
    }

    .header-top .create-navbar .nav-center .nav-menus li>a::after {
        content: "";
        position: absolute;
        width: 0%;
        height: 1px;
        display: block;
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
        bottom: -5px;
    }

    .header-top .create-navbar .nav-center .nav-menus li>a.dropdown-item::after {
        content: initial;
    }

    .header-top .create-navbar .nav-center .nav-menus li:hover>a {
        color: #fff;
    }

    .header-top .create-navbar .nav-center .nav-menus li:hover>a::after {
        width: 100%;
        height: 1px;
        background-color: #5c86e5;
    }

    .header-top .create-navbar .nav-center .nav-menus li:hover>.has-submenu-icon {
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }

    .header-top .create-navbar .nav-center .nav-menus li:hover>.has-submenu-icon svg path {
        fill: #5c86e5;
    }

    .header-top .create-navbar .nav-right {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: end;
        gap: 17px;
    }

    .header-top .create-navbar .nav-right .icon-circle {
        width: 48px;
        height: 48px;
        background-color: #f8f7f7;
        border-radius: 50%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
        position: relative;
    }

    .header-top .create-navbar .nav-right .icon-circle svg path {
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
    }

    .header-top .create-navbar .nav-right .icon-circle:hover {
        background-color: #001f3f;
    }

    .header-top .create-navbar .nav-right .icon-circle:hover svg path {
        stroke: #ffffff;
    }

    @media (max-width: 1199.97px) {
        .header-top {
            padding: 16px 0;
        }

        .header-top .custom-container.container {
            max-width: 100%;
            padding-left: 20px;
            padding-right: 20px;
        }

        .header-top .create-navbar .nav-left img {
            width: 160px;
        }

        .header-top .create-navbar .nav-center {
            display: none;
        }

        .header-top .create-navbar .nav-center .nav-menus {
            gap: 20px;
        }

        .header-top .create-navbar .nav-center .nav-menus li {
            font-size: 14px;
        }

        .header-top .create-navbar .nav-right {
            gap: 10px;
        }

        .header-top .create-navbar .nav-right .icon-circle {
            width: 40px;
            height: 40px;
        }

        .header-top .create-navbar .nav-right .icon-circle svg {
            width: 20px;
            height: 20px;
        }
    }

    @media (max-width: 991.97px) {
        .header-top {
            padding: 10px 0;
        }

        .header-top .create-navbar .nav-left {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .header-top .create-navbar .nav-left img {
            margin-left: 15px;
        }

        .header-top .create-navbar .nav-right {
            gap: 10px;
        }

        .header-top .create-navbar .nav-right .icon-circle {
            width: 40px;
            height: 40px;
        }

        .header-top .create-navbar .nav-right .icon-circle svg {
            width: 20px;
            height: 20px;
        }
    }

    @media (max-width: 459.99px) {
        .header-top {
            padding: 10px 0;
        }

        .header-top .custom-container.container {
            max-width: 100%;
            padding-left: 10px;
            padding-right: 10px;
        }

        .header-top .create-navbar .nav-left {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .header-top .create-navbar .nav-left svg {
            width: 22px;
            height: 22px;
        }

        .header-top .create-navbar .nav-left img {
            margin-left: 0px;
            width: 120px;
        }

        .header-top .create-navbar .nav-center {
            display: none;
        }

        .header-top .create-navbar .nav-right {
            gap: 5px;
        }

        .header-top .create-navbar .nav-right .icon-circle {
            width: 34px;
            height: 34px;
        }

        .header-top .create-navbar .nav-right .icon-circle svg {
            width: 17px;
            height: 17px;
        }
    }

    @media (max-width: 349.99px) {
        .header-top {
            padding: 10px 0;
        }

        .header-top .custom-container.container {
            max-width: 100%;
            padding-left: 5px;
            padding-right: 5px;
        }

        .header-top .create-navbar .nav-left {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .header-top .create-navbar .nav-left svg {
            width: 22px;
            height: 22px;
        }

        .header-top .create-navbar .nav-left img {
            margin-left: -15px;
            width: 110px;
        }

        .header-top .create-navbar .nav-center {
            display: none;
        }

        .header-top .create-navbar .nav-right {
            gap: 4px;
        }

        .header-top .create-navbar .nav-right .icon-circle {
            width: 30px;
            height: 30px;
        }

        .header-top .create-navbar .nav-right .icon-circle svg {
            width: 15px;
            height: 15px;
        }
    }

    .megamenu {
        position: absolute;
        top: 110%;
        left: 50%;
        transform: translateX(-50%);
        z-index: 100;
        padding: 30px;
        background: var(--white-color);
        display: flex;
        justify-content: center;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.25);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
        width: auto;
    }

    .megamenu.cat-megamenu {
        max-width: none;
        justify-content: center;
        padding-top: 25px;
        padding-bottom: 40px;
    }

    .megamenu .single-menu {
        flex-grow: 0;
        width: 250px;
        overflow: hidden;
    }

    .megamenu .row {
        width: auto;
        margin: 0;
    }

    .megamenu .row .col-lg-3 {
        flex: 0 0 250px;
        max-width: 250px;
    }

    .megamenu .single-menu h5 {
        font-size: 20px;
        font-weight: 500;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .megamenu .single-menu ul {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        margin: 0;
        padding: 0;
    }

    .megamenu .single-menu ul li {
        margin: 0;
        padding: 0;
        line-height: 2.1;
        position: relative;
    }

    .megamenu .single-menu ul li::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0px;
        height: 2px;
        background: var(--blue-color);
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
    }

    .megamenu .single-menu ul li a {
        color: var(--text-color);
        text-transform: capitalize !important;
        font-size: 16px;
        font-weight: 400;
    }

    .megamenu .single-menu ul li:hover::after {
        opacity: 1;
        width: 20px;
        visibility: visible;
    }

    .megamenu .single-menu ul li:hover a {
        color: var(--blue-color);
    }

    .megamenu .single-menu .banner-1 {
        display: block;
        background-repeat: no-repeat;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
        overflow: hidden;
        padding: 25px;
        background-size: 100%;
        background-position: center;
        transition: all 0.3s;
        position: relative;
    }

    .megamenu .single-menu .banner-1 .banner-img {
        position: absolute;
        top: 0;
        left: 0;
        background: no-repeat;
        background-size: cover;
        background-position: center;
        overflow: hidden;
        -webkit-transition: all 4s cubic-bezier(0, 0, 0.1, 1);
        -o-transition: all 4s cubic-bezier(0, 0, 0.1, 1);
        transition: all 4s cubic-bezier(0, 0, 0.1, 1);
        -webkit-transition-delay: 0.1s;
        -o-transition-delay: 0.1s;
        transition-delay: 0.1s;
        width: 100%;
        height: 100%;
    }

    .megamenu .single-menu .banner-1:hover .banner-img {
        -webkit-transform: scale(1.1);
        -ms-transform: scale(1.1);
        transform: scale(1.1);
    }

    .megamenu .single-menu .banner-1 .inner-box {
        width: 220px;
        position: relative;
        z-index: 20;
    }

    .megamenu .single-menu .banner-1 .tag-line {
        color: var(--light-red-color);
    }

    .megamenu .single-menu .banner-1 .title {
        color: var(--dark-color);
        font-size: 32px;
        font-weight: 600;
    }

    .megamenu .single-menu .banner-1 .badge-title {
        display: block;
        color: var(--white-color);
    }

    .megamenu .single-menu .banner-1 .tag-line,
    .megamenu .single-menu .banner-1 .badge-title {
        font-weight: 500;
        font-size: 14px;
    }

    .megamenu .single-menu .banner-1 .badge-title {
        text-align: center;
        padding: 5px 8px;
        display: block;
        text-transform: uppercase;
    }

    .megamenu .single-menu .banner-1 .price-wrapper {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    .megamenu .single-menu .banner-1 .price-wrapper .current-price {
        font-weight: 500;
        font-size: 24px;
        color: var(--yellow-color);
        display: inline-block;
        margin-right: 10px;
    }

    .megamenu .single-menu .banner-1 .price-wrapper .old-price {
        font-weight: 500;
        font-size: 16px;
        color: var(--white-color);
    }

    .megamenu .single-menu .banner-1 .btn {
        font-size: 14px;
        padding: 8px 13px;
    }

    .megamenu.cat-megamenu .single-menu .banner-1 .inner-box {
        text-align: center;
        position: relative;
        z-index: 20;
        width: 220px;
        margin: 30px auto auto auto;
    }

    .megamenu.cat-megamenu .single-menu .banner-1 .tag-line {
        color: var(--dark-color);
    }

    .megamenu.cat-megamenu .single-menu .banner-1 .title {
        color: var(--dark-color);
        font-size: 32px;
        font-weight: 600;
    }

    .megamenu.cat-megamenu .single-menu .banner-1 .badge-title {
        display: block;
        color: var(--white-color);
    }

    .megamenu.cat-megamenu .single-menu .banner-1 .tag-line,
    .megamenu.cat-megamenu .single-menu .banner-1 .badge-title {
        font-weight: 500;
        font-size: 14px;
    }

    .megamenu.cat-megamenu .single-menu .banner-1 .badge-title {
        text-align: center;
        padding: 5px 8px;
        display: block;
        text-transform: uppercase;
    }

    .megamenu.cat-megamenu .single-menu .banner-1 .price-wrapper {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    .megamenu.cat-megamenu .single-menu .banner-1 .price-wrapper .current-price {
        font-weight: 500;
        font-size: 24px;
        color: var(--yellow-color);
        display: inline-block;
        margin-right: 10px;
    }

    .megamenu.cat-megamenu .single-menu .banner-1 .price-wrapper .old-price {
        font-weight: 500;
        font-size: 16px;
        color: var(--white-color);
    }

    .megamenu.cat-megamenu .single-menu .banner-1 .btn {
        font-size: 14px;
        padding: 8px 13px;
    }

    .has-megamenu:hover .megamenu {
        opacity: 1;
        visibility: visible;
        top: 80%;
    }

    .has-submenu .dropdown-menu {
        display: block;
        top: 170%;
        opacity: 0;
        visibility: hidden;
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
    }

    .has-submenu .dropdown-menu li:last-child .dropdown-item {
        border-bottom: 1px solid #5c86e5;
    }

    .has-submenu .dropdown-menu li .dropdown-item {
        border-bottom: 1px solid #e9e6e6;
    }

    .search-bar {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 12;
        background-color: #ffffff;
    }

    .search-bar.show {
        display: block;
    }

    .search-bar .search-form {
        margin: 56px 120px;
    }

    .search-bar .search-form .input__group {
        border-radius: 0px 8px 8px 0px;
        position: relative;
    }

    .search-bar .search-form .input-group-prepend,
    .search-bar .search-form .input-group-append {
        position: relative;
    }

    .search-bar .search-form .form__control {
        height: 60px;
        background-color: #f8f7f7;
        border-color: #f8f7f7;
    }

    .search-bar .search-form .form__control:focus {
        color: none;
        background-color: none;
        border-color: #f8f7f7;
        outline: 0;
        -webkit-box-shadow: none;
        box-shadow: none;
    }

    .search-bar .search-form .search-category-dropdown {
        height: 60px;
        border-radius: 0;
        width: 280px;
        background-color: #f8f7f7;
        color: #1f0300;
    }

    .search-bar .search-form .search-category-dropdown:hover {
        color: #5c86e5;
    }

    .search-bar .search-form .search-separator {
        position: absolute;
        left: 0;
        top: 12px;
        background-color: #9a8e8c;
        width: 1px;
        height: 36px;
        z-index: 9;
    }

    .search-bar .search-form .dropdown-menu {
        position: absolute;
        top: calc(100% + 10px);
        left: 60px !important;
        z-index: 1000;
        min-width: 70%;
    }

    .search-bar .search-form .search-icn {
        width: 72px;
        height: 60px;
        border-radius: 0;
        border-radius: 0px 8px 8px 0px;
        background-color: #5c86e5;
        border-color: #5c86e5;
    }

    @media (max-width: 991.97px) {
        .search-bar .search-form {
            margin: 40px 80px;
        }

        .search-bar .search-form .search-category-dropdown {
            width: 160px;
        }
    }

    @media (max-width: 767.98px) {
        .search-bar .search-form {
            margin: 30px 20px;
        }
    }

    @media (max-width: 575.97px) {
        .search-bar .search-form {
            margin: 30px 20px;
        }

        .search-bar .search-form .search-category-dropdown {
            width: 130px;
            height: 50px;
        }

        .search-bar .search-form .form__control {
            height: 50px;
        }

        .search-bar .search-form .search-icn {
            width: 60px;
            height: 50px;
        }

        .search-bar .search-form .search-separator {
            height: 30px;
            top: 10px;
        }
    }

    @media (max-width: 399.97px) {
        .search-bar .search-form {
            margin: 30px 10px;
        }

        .search-bar .search-form .search-category-dropdown {
            font-size: 14px;
            width: 120px;
        }

        .search-bar .search-form .form__control {
            height: 50px;
            font-size: 14px;
        }

        .search-bar .search-form .search-icn {
            width: 60px;
            height: 50px;
        }

        .search-bar .search-form .search-separator {
            height: 30px;
            top: 10px;
        }
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        display: block;
        width: 100%;
        height: 100%;
        z-index: 10;
        background-color: rgba(3, 7, 18, 0.5);
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
        opacity: 0;
        visibility: hidden;
    }

    .overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .icon-circle .cart-count {
        background: #001f3f;
        width: 25px;
        height: 25px;
        display: block;
        position: absolute;
        top: -10px;
        right: -10px;
        border-radius: 50%;
        color: white;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }

    @media (max-width: 575.97px) {
        .icon-circle .cart-count {
            width: 16px;
            height: 16px;
            font-size: 10px;
        }
    }

    .mobile-menu {
        width: 290px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: -300px;
        background-color: #ffffff;
        z-index: 60;
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
        overflow-y: scroll;
    }

    .mobile-menu .mobile-menu-top {
        width: 100%;
        padding: 18px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        background-color: #001f3f;
    }

    .mobile-menu .mobile-menu-top img {
        width: 50%;
        filter: brightness(3.5)
    }

    .mobile-menu .close:hover {
        color: #800b00;
    }

    .mobile-menu .tab-content .tab-pane {
        padding: 24px 12px;
    }

    .mobile-menu .tab-content .tab-pane .product-cat-widget {
        padding-top: 0px;
    }

    .mobile-menu .tab-content .tab-pane ul li {
        font-size: 16px;
        font-weight: 500;
        position: relative;
        margin-bottom: 12px;
    }

    .mobile-menu .tab-content .tab-pane ul li a {
        color: #1f0300;
        text-transform: uppercase;
    }

    .mobile-menu .tab-content .tab-pane .gs-dashboard-user-sidebar-wrapper li {
        margin-bottom: 0;
    }

    .mobile-menu .tab-content .tab-pane .gs-dashboard-user-sidebar-wrapper li svg {
        width: 16px;
        height: 16px;
    }

    .mobile-menu .tab-content .tab-pane .gs-dashboard-user-sidebar-wrapper li a span {
        font-size: 14px;
    }

    .mobile-menu .tab-content .tab-pane .gs-dashboard-user-sidebar-wrapper li.active a,
    .mobile-menu .tab-content .tab-pane .gs-dashboard-user-sidebar-wrapper li:hover a {
        color: #ffffff;
    }

    .mobile-menu .mobile-nav-menu {
        margin-top: 32px;
    }

    .mobile-menu .mobile-nav-menu li {
        display: block;
    }

    .mobile-menu .mobile-nav-menu li+li {
        border-top: 1px solid #5c86e5;
    }

    .mobile-menu .mobile-nav-menu li a {
        display: block;
        color: #9a8e8c;
        padding: 10px 0;
        font-weight: 600;
    }

    .mobile-menu .mobile-nav-menu li a:hover {
        color: #5c86e5;
    }

    .mobile-menu .mobile-nav-menu li.has-submenu {
        position: relative;
    }

    .mobile-menu .mobile-nav-menu li.has-submenu>i {
        position: absolute;
        right: 0;
        top: 6px;
        padding: 8px;
    }

    .mobile-menu .mobile-nav-menu li.has-submenu>i.icon-rotate {
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }

    .mobile-menu .mobile-nav-menu li.has-submenu>.submenu-wrapper {
        padding-left: 15px;
        display: none;
    }

    .mobile-menu .mobile-search input {
        width: 100%;
    }

    .mobile-menu .mobile-search button span {
        padding: 0;
        width: 50px;
        height: 50px;
    }

    @media (max-width: 1199.97px) {
        .mobile-menu.active {
            left: 0;
        }
    }

    .mobile-menu .info-right {
        margin-top: 20px;
        display: none;
    }

    @media (max-width: 619.99px) {
        .mobile-menu .info-right {
            display: block;
        }

        .mobile-menu .info-right ul>li {
            padding-right: 10px;
        }
    }

    .nav.flex-column .collapse-item ul {
        margin-left: 20px;
    }

    .collapse-item ul {
        margin-left: 20px;
    }

    .collapse-item ul li {
        font-weight: 400 !important;
    }

    .collapse-item ul li a {
        font-weight: 400 !important;
    }

    .collapse-icon::before {
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        content: "\f067";
        float: right;
        margin-right: 5px;
    }

    .collapse-icon.collapsed::before {
        content: "\f068";
    }

    .nav-link[aria-expanded="true"] .collapse-icon::before {
        content: "\f068";
        color: #5c86e5;
    }

    .nav-link[aria-expanded="false"] .collapse-icon::before {
        content: "\f067";
        color: #5c86e5;
    }

    .collapse-item.collapse .collapse-icon::before {
        content: "\f068";
        color: #5c86e5;
    }

    .collapse-item ul li:first-child {
        margin-top: 10px;
    }

    .collapse-item ul li a.nav-link:hover {
        color: #5c86e5 !important;
    }

    .collapse-item ul li a.nav-link {
        font-weight: 400;
    }

    .nav__link:hover {
        color: #5c86e5 !important;
    }

    .language-dropdown>.dropdown .dropdown-toggle {
        color: #1f0300;
        font-size: 16px;
        font-weight: 500;
        line-height: 120%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        padding: 0;
        margin: 0;
        background-color: transparent;
        border: none;
    }

    .language-dropdown>.dropdown .dropdown-toggle:hover {
        color: #5c86e5;
    }

    .language-dropdown>.dropdown .dropdown-menu {
        min-width: 100%;
        text-align: center;
        z-index: 9;
        padding: 0;
        border-radius: 0;
        overflow-y: auto;
    }

    .language-dropdown>.dropdown .dropdown-item {
        color: #333;
        height: 44px;
        padding: 9px 24px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: start;
        border-bottom: 1px solid #e9e6e6;
        font-family: Poppins;
        font-size: 18px;
        font-style: normal;
        font-weight: 400;
        line-height: 120%;
    }

    .language-dropdown>.dropdown .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .user-dashboard-sidebar {
        -webkit-transition: all 0.3s ease-in;
        -o-transition: all 0.3s ease-in;
        transition: all 0.3s ease-in;
    }

    @media (max-width: 1199.97px) {
        .user-dashboard-sidebar {
            position: fixed;
            top: 0;
            z-index: 10;
            left: -300px;
            width: 300px;
        }

        .user-dashboard-sidebar.active {
            left: 0;
        }
    }
</style>
<style>
    .svg-style {
        fill: white;
        stroke: white;
    }
</style>
<style>
    /* Header Section (Minimal changes to support dropdown) */
    .header-section {
        position: relative;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    /* Header Top (Minimal styling for context) */
    .header-top {
        background-color: #fff;
        padding: 12px 0;
        font-family: 'Inter', sans-serif;
    }

    .create-navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .nav-center ul.nav-menus {
        display: flex;
        align-items: center;
        gap: 24px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .nav-center ul.nav-menus li {
        font-size: 15px;
        font-weight: 500;
        position: relative;
    }

    .nav-center ul.nav-menus li a {
        color: #1f0300;
        text-decoration: none;
        text-transform: uppercase;
        transition: color 0.3s ease;
    }

    .nav-center ul.nav-menus li:hover a,
    .nav-center ul.nav-menus li.active a {
        color: #6B00FF;
    }

    .has-submenu-icon svg {
        width: 16px;
        height: 16px;
        margin-left: 4px;
        transition: transform 0.3s ease;
    }

    .nav-menus li:hover .has-submenu-icon {
        transform: rotate(180deg);
    }

    /* Updated Megamenu Styling for "Shop by Concern" */
    .megamenu.cat-megamenu {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        padding: 20px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 100;
        border-radius: 8px;
        /* Rounded corners for modern look */
        min-width: 300px;
        /* Wider for better readability */
        max-width: 600px;
        /* Prevent overly wide dropdown */
    }

    .has-megamenu:hover .megamenu.cat-megamenu {
        opacity: 1;
        visibility: visible;
        top: 90%;
    }

    .megamenu.cat-megamenu .single-menu {
        width: 100%;
    }

    .megamenu.cat-megamenu .single-menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        /* Allow items to wrap for better layout */
        gap: 10px;
        /* Space between items */
        justify-content: flex-start;
    }

    .megamenu.cat-megamenu .single-menu ul li {
        flex: 1 1 45%;
        /* Two-column layout for tags */
        margin: 0;
        padding: 10px 15px;
        /* Comfortable padding */
        background: #f8f7f7;
        /* Light background for each item */
        border-radius: 6px;
        /* Subtle rounding */
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .megamenu.cat-megamenu .single-menu ul li a {
        color: #1f0300;
        font-family: 'Inter', sans-serif;
        /* Professional font */
        font-size: 14px;
        /* Balanced size */
        font-weight: 400;
        /* Regular weight for clarity */
        text-decoration: none;
        text-transform: capitalize;
        /* Matches document’s suggestion */
        display: block;
        /* Full clickable area */
    }

    .megamenu.cat-megamenu .single-menu ul li:hover {
        background: #6B00FF;
        /* Purple on hover */
        transform: translateY(-2px);
        /* Subtle lift effect */
    }

    .megamenu.cat-megamenu .single-menu ul li:hover a {
        color: #fff;
        /* White text on hover for contrast */
    }

    /* Nav Right (Minimal for context) */
    .nav-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .nav-right .icon-circle {
        width: 40px;
        height: 40px;
        background: #f8f7f7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s ease;
    }

    .nav-right .icon-circle:hover {
        background: #6B00FF;
    }

    .nav-right .icon-circle:hover svg path {
        stroke: #fff;
    }

    .nav-right .icon-circle svg {
        width: 20px;
        height: 20px;
    }

    .nav-right .cart-count {
        background: #6B00FF;
        color: #fff;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: -8px;
        right: -8px;
        font-size: 12px;
    }

    /* Responsive Adjustments */
    @media (max-width: 1199px) {
        .nav-center {
            display: none;
        }

        .header-logo-wrapper img.logo {
            max-width: 160px;
        }
    }

    @media (max-width: 767px) {
        .header-logo-wrapper img.logo {
            max-width: 140px;
        }

        .header-top {
            padding: 10px 0;
        }
    }
</style>

<style>
    /* General Fixes */
    .svg-style {
        /* fill: none; Corrected to match stroke-only SVGs */
        stroke: white;
    }

    /* Header Section */
    .header-section {
        position: relative;
        z-index: 10 !important;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
    }

    @media (max-width: 991.97px) {
        .header-section .create-navbar {
            box-shadow: none;
        }
    }

    /* Info Bar */
    .info-bar {
        padding: 18px 0 17px;
        background-color: #001f3f;
        color: #fff;
        font-family: 'Inter', sans-serif;
    }

    @media (max-width: 767.98px) {
        .info-bar {
            padding: 6px 0;
        }
    }

    .info-bar .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .info-bar a {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s ease-in;
    }

    .info-bar a:hover {
        color: #d9d4d4;
    }

    .info-bar .info-left ul,
    .info-bar .info-right ul {
        display: flex;
        align-items: center;
        gap: 32px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .info-bar .info-right li svg.separator {
        width: 2px;
        height: 21px;
        stroke: rgba(255, 255, 255, 0.8);
    }

    @media (max-width: 767.98px) {
        .info-bar .info-left {
            display: none;
        }

        .info-bar .info-row {
            justify-content: center;
        }

        .info-bar .info-right ul {
            gap: 16px;
        }
    }

    /* Header Top */
    .header-top {
        background-color: #fff;
        padding: 12px 0;
        font-family: 'Inter', sans-serif;
        transition: all 0.3s ease-in;
    }

    .header-top.sticky {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 10px 0;
        box-shadow: 0 4px 32px rgba(0, 0, 0, 0.09);
    }

    .create-navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .nav-center ul.nav-menus {
        display: flex;
        align-items: center;
        gap: 24px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .nav-center ul.nav-menus li {
        font-size: 15px;
        font-weight: 500;
        position: relative;
    }

    .nav-center ul.nav-menus li a {
        color: #1f0300;
        text-decoration: none;
        text-transform: uppercase;
        transition: color 0.3s ease;
    }

    .nav-center ul.nav-menus li:hover a,
    .nav-center ul.nav-menus li.active a {
        color: #6B00FF;
    }

    .has-submenu-icon svg {
        width: 16px;
        height: 16px;
        margin-left: 4px;
        transition: transform 0.3s ease;
    }

    .nav-menus li:hover .has-submenu-icon {
        transform: rotate(180deg);
    }

    /* Updated Megamenu Styling (Matching Image) */
    .megamenu.cat-megamenu {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        padding: 10px 0;
        /* Reduced padding for card-like layout */
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 100;
        border-radius: 8px;
        min-width: 250px;
        max-width: 300px;
        border: 1px solid #e0e0e0;
        /* Light border for card effect */
    }

    .has-megamenu:hover .megamenu.cat-megamenu {
        opacity: 1;
        visibility: visible;
        top: 90%;
    }

    .megamenu.cat-megamenu .single-menu {
        width: 100%;
    }

    .megamenu.cat-megamenu .single-menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: block;
        /* Single column layout like the image */
    }

    .megamenu.cat-megamenu .single-menu ul li {
        padding: 0.3rem 3rem;
        /* Consistent padding */
        background: #f5f5f5;
        /* Light gray background */
        border-bottom: 1px solid #e0e0e0;
        /* Separator line */
        border-radius: 4px;
        /* Slight rounding */
        margin: 5px 0;
        /* Spacing between items */
        transition: background 0.3s ease, color 0.3s ease;
    }

    .megamenu.cat-megamenu .single-menu ul li:last-child {
        border-bottom: none;
        /* Remove border for last item */
    }

    .megamenu.cat-megamenu .single-menu ul li a {
        color: #333;
        font-family: 'Inter', sans-serif;
        font-size: 16px;
        font-style: italic;
        /* Italic text as requested */
        font-weight: 400;
        text-decoration: none;
        text-transform: capitalize;
        display: block;
    }

    .megamenu.cat-megamenu .single-menu ul li:hover {
        background: #6B00FF;
        /* Purple on hover */
    }

    .megamenu.cat-megamenu .single-menu ul li:hover a {
        color: #fff;
        /* White text on hover for visibility */
    }

    /* Nav Right */
    .nav-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .nav-right .icon-circle {
        width: 40px;
        height: 40px;
        background: #f8f7f7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s ease;
        position: relative;
    }

    .nav-right .icon-circle:hover {
        background: #6B00FF;
    }

    .nav-right .icon-circle:hover svg path {
        stroke: #fff;
    }

    .nav-right .icon-circle svg {
        width: 20px;
        height: 20px;
    }

    .nav-right .cart-count {
        background: #6B00FF;
        color: #fff;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: -8px;
        right: -8px;
        font-size: 12px;
    }

    .header-colors {
        color: #001f3f !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 1199px) {
        .nav-center {
            display: none;
        }
    }

    @media (max-width: 767px) {
        .header-top {
            padding: 10px 0;
        }

        .mobile-menu-toggle svg {
            width: 20px !important;
            height: 20px !important;
        }
    }

    @media (max-width: 480px) {
        .header-logo-wrapper img.logo {
            max-width: 115px;
        }
    }

    @media (min-width: 1200px) {
        .mobile-menu-toggle {
            display: none !important;
        }
    }

    @media (max-width: 767.98px) {
        .info-bar .info-left {
            display: none;
        }

        /* Ensure info-bar is visible on mobile */
        @media (max-width: 767.98px) {
            .info-bar {
                display: block !important;
                /* Override any hiding */
                padding: 6px 0;
            }

            .info-bar .info-row {
                justify-content: flex-end;
                /* Align HCP Login to the right */
            }

            .info-bar .info-right ul {
                gap: 12px;
                /* Reduced gap for mobile */
            }

            .info-bar .info-right li a {
                font-size: 12px;
                /* Smaller font for mobile */
            }

            .info-bar .info-right li svg {
                width: 16px;
                /* Smaller icon for mobile */
                height: 18px;
            }

            .info-bar .info-right .cart-count {
                width: 16px;
                height: 16px;
                font-size: 10px;
            }
        }
    }
</style>

<header class="header-section position-relative z-2 header-stikcy">
    <div class="info-bar d-md-block">
        <div class="container custom-containerr">
            <div class="info-row d-flex">
                <div class="info-left">
                    <ul class="wows align-items-center">
                        <li><a href="tel:+1(234)567-8901">
                                @lang('Contact & Support'): {{ $ps->phone }}</a>
                        </li>
                    </ul>
                </div>
                <div class="info-right">
                    <ul class="wows align-items-center d-none d-md-flex">
                        <!-- Wishlist -->
                        @if (Auth::guard('web')->check())
                            <li class="align-items-center">
                                <a href="{{ route('user-wishlists') }}">
                                    <span class="cart-count" id="wishlist-count">
                                        {{ Auth::guard('web')->user()->wishlistCount() }}
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" class="svg-style">
                                        <path
                                            d="M16.1111 3C19.6333 3 22 6.3525 22 9.48C22 15.8138 12.1778 21 12 21C11.8222 21 2 15.8138 2 9.48C2 6.3525 4.36667 3 7.88889 3C9.91111 3 11.2333 4.02375 12 4.92375C12.7667 4.02375 14.0889 3 16.1111 3Z"
                                            stroke="#1F0300" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </li>
                        @else
                            <li class="align-items-center">
                                <a href="{{ route('user.login') }}">
                                    <span class="cart-count" id="wishlist-count">0</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" class="svg-style">
                                        <path
                                            d="M16.1111 3C19.6333 3 22 6.3525 22 9.48C22 15.8138 12.1778 21 12 21C11.8222 21 2 15.8138 2 9.48C2 6.3525 4.36667 3 7.88889 3C9.91111 3 11.2333 4.02375 12 4.92375C12.7667 4.02375 14.0889 3 16.1111 3Z"
                                            stroke="#1F0300" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </li>
                        @endif
                        <!-- SP Login -->
                        {{-- @if (!Auth::guard('web')->check())
                        <li class="align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="2" height="21" viewBox="0 0 2 21"
                                fill="none">
                                <path d="M1 0.5V20.5" stroke="white" stroke-opacity="0.8" />
                            </svg>
                        </li>
                        <li class="gap-2 align-items-center">
                            <svg width="20" height="22" viewBox="0 0 20 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.99955 13.5C7.35782 13.5 5.00855 14.7755 3.51288 16.755C3.19097 17.181 3.03002 17.394 3.03528 17.6819C3.03935 17.9043 3.17902 18.1849 3.35402 18.3222C3.58054 18.5 3.89444 18.5 4.52224 18.5H15.4769C16.1047 18.5 16.4186 18.5 16.6451 18.3222C16.8201 18.1849 16.9598 17.9043 16.9638 17.6819C16.9691 17.394 16.8081 17.181 16.4862 16.755C14.9906 14.7755 12.6413 13.5 9.99955 13.5Z"
                                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M10 11C12.071 11 13.7501 9.32107 13.7501 7.25C13.7501 5.17893 12.071 3.5 10 3.5C7.92893 3.5 6.25 5.17893 6.25 7.25C6.25 9.32107 7.92893 11 10 11Z"
                                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <a href="{{ url('/admin/login') }}">@lang('SP Login')</a>
                        </li>
                        @endif --}}
                        <!-- Separator -->
                        <li class="align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="2" height="21" viewBox="0 0 2 21"
                                fill="none">
                                <path d="M1 0.5V20.5" stroke="white" stroke-opacity="0.8" />
                            </svg>
                        </li>
                        <!-- HCP Login / My Account -->
                        <li class="gap-2 align-items-center">
                            <svg width="20" height="22" viewBox="0 0 20 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.99955 13.5C7.35782 13.5 5.00855 14.7755 3.51288 16.755C3.19097 17.181 3.03002 17.394 3.03528 17.6819C3.03935 17.9043 3.17902 18.1849 3.35402 18.3222C3.58054 18.5 3.89444 18.5 4.52224 18.5H15.4769C16.1047 18.5 16.4186 18.5 16.6451 18.3222C16.8201 18.1849 16.9598 17.9043 16.9638 17.6819C16.9691 17.394 16.8081 17.181 16.4862 16.755C14.9906 14.7755 12.6413 13.5 9.99955 13.5Z"
                                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path
                                    d="M10 11C12.071 11 13.7501 9.32107 13.7501 7.25C13.7501 5.17893 12.071 3.5 10 3.5C7.92893 3.5 6.25 5.17893 6.25 7.25C6.25 9.32107 7.92893 11 10 11Z"
                                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            @if (Auth::guard('web')->check())
                                <a href="{{ route('user-dashboard') }}">@lang('My Account')</a>
                            @elseif (Auth::guard('rider')->check())
                                <a href="{{ route('rider-dashboard') }}">@lang('Dashboard')</a>
                            @else
                                <a href="{{ route('user.login') }}">@lang('HCP Login')</a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header-top">
        <div class="container custom-containerr">
            <div class="create-navbar d-flex">
                <div class="nav-left">
                    <button type="button" class="header-toggle mobile-menu-toggle d-flex d-xl-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M3 12H21M3 6H21M3 18H15" stroke="#1F0300" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                    <a class="header-logo-wrapper" href="{{ route('front.index') }}">
                        <img class="logo" src="{{ asset('assets/images/' . $gs->logo) }}" alt="logo">
                    </a>
                </div>
                <div class="nav-center">
                    <ul class="d-flex align-items-center nav-menus">
                        <!-- Existing nav-menus content unchanged -->
                        <li class="has-megamenu {{ request()->path() == 'category' ? '' : '' }}">
                            <a class="header-colors" href="{{ route('front.category') }}">
                                @lang('Shop by Concern')
                            </a>
                            <span class="has-submenu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.7098 8.20986C18.6169 8.11613 18.5063 8.04174 18.3844 7.99097C18.2625 7.9402 18.1318 7.91406 17.9998 7.91406C17.8678 7.91406 17.7371 7.9402 17.6152 7.99097C17.4934 8.04174 17.3828 8.11613 17.2898 8.20986L12.7098 12.7899C12.6169 12.8836 12.5063 12.958 12.3844 13.0088C12.2625 13.0595 12.1318 13.0857 11.9998 13.0857C11.8678 13.0857 11.7371 13.0595 11.6152 13.0088C11.4934 12.958 11.3828 12.8836 11.2898 12.7899L6.70982 8.20986C6.61685 8.11613 6.50625 8.04174 6.38439 7.99097C6.26253 7.9402 6.13183 7.91406 5.99982 7.91406C5.8678 7.91406 5.7371 7.9402 5.61524 7.99097C5.49338 8.04174 5.38278 8.11613 5.28982 8.20986C5.10356 8.39722 4.99902 8.65067 4.99902 8.91486C4.99902 9.17905 5.10356 9.4325 5.28982 9.61986L9.87982 14.2099C10.4423 14.7717 11.2048 15.0872 11.9998 15.0872C12.7948 15.0872 13.5573 14.7717 14.1198 14.2099L18.7098 9.61986C18.8961 9.4325 19.0006 9.17905 19.0006 8.91486C19.0006 8.65067 18.8961 8.39722 18.7098 8.20986Z"
                                        fill="#180207" />
                                </svg>
                            </span>
                            <div class="megamenu cat-megamenu">
                                <div class="row w-100">
                                    <div class="col-lg-3">
                                        <div class="single-menu mt-2">
                                            <ul>
                                                @php
                                                    use Illuminate\Support\Facades\DB;
                                                    $tags = DB::table('tags')->where('status', 1)->select('name', 'slug')->get();
                                                @endphp
                                                @foreach ($tags as $tag)
                                                    <li><a
                                                            href="{{ route('front.category', ['tag' => $tag->slug]) }}">{{ $tag->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li>
                        <li class="has-megamenu {{ request()->path() == 'category' ? '' : '' }}">
                            <a class="header-colors" href="{{ route('front.category') }}">
                                @lang('Shop by Brand')
                            </a>
                            <span class="has-submenu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.7098 8.20986C18.6169 8.11613 18.5063 8.04174 18.3844 7.99097C18.2625 7.9402 18.1318 7.91406 17.9998 7.91406C17.8678 7.91406 17.7371 7.9402 17.6152 7.99097C17.4934 8.04174 17.3828 8.11613 17.2898 8.20986L12.7098 12.7899C12.6169 12.8836 12.5063 12.958 12.3844 13.0088C12.2625 13.0595 12.1318 13.0857 11.9998 13.0857C11.8678 13.0857 11.7371 13.0595 11.6152 13.0088C11.4934 12.958 11.3828 12.8836 11.2898 12.7899L6.70982 8.20986C6.61685 8.11613 6.50625 8.04174 6.38439 7.99097C6.26253 7.9402 6.13183 7.91406 5.99982 7.91406C5.8678 7.91406 5.7371 7.9402 5.61524 7.99097C5.49338 8.04174 5.38278 8.11613 5.28982 8.20986C5.10356 8.39722 4.99902 8.65067 4.99902 8.91486C4.99902 9.17905 5.10356 9.4325 5.28982 9.61986L9.87982 14.2099C10.4423 14.7717 11.2048 15.0872 11.9998 15.0872C12.7948 15.0872 13.5573 14.7717 14.1198 14.2099L18.7098 9.61986C18.8961 9.4325 19.0006 9.17905 19.0006 8.91486C19.0006 8.65067 18.8961 8.39722 18.7098 8.20986Z"
                                        fill="#180207" />
                                </svg>
                            </span>
                            <div class="megamenu cat-megamenu">
                                <div class="row w-100">
                                    <div class="col-lg-3">
                                        <div class="single-menu mt-2">
                                            <ul>
                                                @php
                                                    $brands = DB::table('brands')->whereNotNull('name')->pluck('name', 'slug')->mapWithKeys(function ($name, $slug) {
                                                        return [$name => $slug ?: Str::slug($name)];
                                                    });
                                                @endphp
                                                @foreach ($brands as $brandName => $brandSlug)
                                                    <li><a
                                                            href="{{ route('front.category', ['brand' => $brandSlug]) }}">{{ $brandName }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="has-megamenu {{ request()->path() == 'category' ? '' : '' }}">
                            <a class="header-colors" href="{{ route('front.category') }}">
                                @lang('Find a Provider')
                            </a>
                        </li>
                        @if (Auth::guard('web')->check() && Auth::user()->preferred_type === 'scheme_based_profile')
                            <li class="has-megamenu {{ request()->path() == 'category' ? '' : '' }}">
                                <a class="header-colors" href="{{ route('user-mix_match') }}">
                                    @lang('Mix & Match')
                                </a>
                            </li>
                        @endif
                        <li class="has-megamenu {{ request()->path() == 'discover' ? '' : '' }}">
                            <a class="header-colors" href="#">
                                @lang('Discover')
                            </a>
                            <span class="has-submenu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18.7098 8.20986C18.6169 8.11613 18.5063 8.04174 18.3844 7.99097C18.2625 7.9402 18.1318 7.91406 17.9998 7.91406C17.8678 7.91406 17.7371 7.9402 17.6152 7.99097C17.4934 8.04174 17.3828 8.11613 17.2898 8.20986L12.7098 12.7899C12.6169 12.8836 12.5063 12.958 12.3844 13.0088C12.2625 13.0595 12.1318 13.0857 11.9998 13.0857C11.8678 13.0857 11.7371 13.0595 11.6152 13.0088C11.4934 12.958 11.3828 12.8836 11.2898 12.7899L6.70982 8.20986C6.61685 8.11613 6.50625 8.04174 6.38439 7.99097C6.26253 7.9402 6.13183 7.91406 5.99982 7.91406C5.8678 7.91406 5.7371 7.9402 5.61524 7.99097C5.49338 8.04174 5.38278 8.11613 5.28982 8.20986C5.10356 8.39722 4.99902 8.65067 4.99902 8.91486C4.99902 9.17905 5.10356 9.4325 5.28982 9.61986L9.87982 14.2099C10.4423 14.7717 11.2048 15.0872 11.9998 15.0872C12.7948 15.0872 13.5573 14.7717 14.1198 14.2099L18.7098 9.61986C18.8961 9.4325 19.0006 9.17905 19.0006 8.91486C19.0006 8.65067 18.8961 8.39722 18.7098 8.20986Z"
                                        fill="#180207" />
                                </svg>
                            </span>
                            <div class="megamenu cat-megamenu">
                                <div class="row w-100">
                                    <div class="col-lg-3">
                                        <div class="single-menu mt-2">
                                            <ul>
                                                @php
                                                    $blog_cat = DB::table('blog_categories')->get();
                                                @endphp
                                                @foreach ($blog_cat as $blogcat)
                                                    <li><a
                                                            href="{{ url('/blog/category/' . $blogcat->slug) }}">{{ $blogcat->name }}</a>
                                                    </li>
                                                @endforeach
                                                <li>
                                                    <a href="{{ route('front.vendor', ['slug' => 'about-us']) }}">About us</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="nav-right">
                    {{-- <div class="icon-circle">
                        <button id="searchIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                d="M21 21L17.5001 17.5M20 11.5C20 16.1944 16.1944 20 11.5 20C6.80558 20 3 16.1944 3 11.5C3 6.80558 6.80558 3 11.5 3C16.1944 3 20 6.80558 20 11.5Z"
                                stroke="#1F0300" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div> --}}
                    <div class="icon-circle">
                        <a href="{{ route('front.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path
                                d="M3 9.5L12 3L21 9.5V20C21 20.5523 20.5523 21 20 21H15C14.4477 21 14 20.5523 14 20V16C14 15.4477 13.5523 15 13 15H11C10.4477 15 10 15.4477 10 16V20C10 20.5523 9.55228 21 9 21H4C3.44772 21 3 20.5523 3 20V9.5Z"
                                    stroke="#1F0300" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                    @php
                        $products = Session::get('cart')->items ?? [];
                        $grouped = collect($products)->groupBy(fn($p) => $p['mix_match_batch'] ?? 'no_batch');

                        $batchGroups = $grouped->except('no_batch')->count(); // number of batch groups
                        $noBatchCount = count($grouped['no_batch'] ?? []);    // individual items

                        $count = $batchGroups + $noBatchCount;
                    @endphp
                    @if (Auth::check())
                        <div class="icon-circle">
                            <a href="{{ route('front.cart') }}">
                                <span class="cart-count" id="cart-count">
                                    {{ $products ? $count : 0 }}
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M2 2H3.30616C3.55218 2 3.67519 2 3.77418 2.04524C3.86142 2.08511 3.93535 2.14922 3.98715 2.22995C4.04593 2.32154 4.06333 2.44332 4.09812 2.68686L4.57143 6M4.57143 6L5.62332 13.7314C5.75681 14.7125 5.82355 15.2031 6.0581 15.5723C6.26478 15.8977 6.56108 16.1564 6.91135 16.3174C7.30886 16.5 7.80394 16.5 8.79411 16.5H17.352C18.2945 16.5 18.7658 16.5 19.151 16.3304C19.4905 16.1809 19.7818 15.9398 19.9923 15.6342C20.2309 15.2876 20.3191 14.8247 20.4955 13.8988L21.8191 6.94969C21.8812 6.62381 21.9122 6.46087 21.8672 6.3335C21.8278 6.22177 21.7499 6.12768 21.6475 6.06802C21.5308 6 21.365 6 21.0332 6H4.57143ZM10 21C10 21.5523 9.55228 22 9 22C8.44772 22 8 21.5523 8 21C8 20.4477 8.44772 20 9 20C9.55228 20 10 20.4477 10 21ZM18 21C18 21.5523 17.5523 22 17 22C16.4477 22 16 21.5523 16 21C16 20.4477 16.4477 20 17 20C17.5523 20 18 20.4477 18 21Z"
                                        stroke="#1F0300" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>