<style>
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
        background-color: #ffffff;
        color: #333333;
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
        /* Changed from #FF7229 to purple */
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

    /* Content Box */
    .content-box {
        max-width: 1320px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Item Display */
    .item-display {
        display: flex;
        flex-wrap: wrap;
        padding: 20px 0;
        padding-bottom: 0;
        gap: 30px;
    }

    /* Image Gallery */
    .image-gallery {
        flex: 1;
        min-width: 300px;
        /* Changed from 250px */
        max-width: 600px;
        /* Changed from 500px */
    }

    .image-container {
        position: relative;
        width: 100%;
    }

    .primary-image {
        width: 100%;
        max-height: 500px;
        /* Changed from 400px */
        height: auto;
        display: block;
        object-fit: contain;
        /* Ensure image scales properly */
    }

    .image-previews {
        display: flex;
        margin-top: 10px;
        gap: 5px;
        justify-content: center;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
    }

    .preview-image {
        width: 80px;
        /* Changed from 60px */
        height: 60px;
        /* Changed from 45px */
        border: 1px solid #ddd;
        cursor: pointer;
        object-fit: cover;
    }

    .preview-image.active {
        border: 2px solid #800080;
    }

    .product-cards-slider .slick-track {
        padding-bottom: 20px;
    }

    .slide-prev,
    .slide-next {
        position: absolute;
        top: 60%;
        z-index: 1;
        transform: translateY(-50%);
        background-color: #ffffff2e;
        border: none;
        border-radius: 60%;
        width: 40px;
        height: 40px;
        font-size: 24px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .slide-prev:hover,
    .slide-next:hover {
        background-color: rgba(255, 255, 255, 1);
    }

    .slide-prev {
        left: 0px;
    }

    .slide-next {
        right: 0px;
    }

    /* Item Details */
    .item-details {
        flex: 1;
        min-width: 300px;
        padding-left: 40px;
    }

    .item-name {
        font-size: 36px;
        font-weight: 600;
        margin-bottom: 12px;
        color: #000000;
    }

    .item-cost {
        font-size: 22px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .item-desc {
        font-size: 16px;
        color: #333333;
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .item-size {
        font-size: 16px;
        color: #666666;
        margin-bottom: 20px;
    }

    .suggestion-area {
        margin-bottom: 20px;
    }

    .suggestion-header {
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333333;
    }

    .skin-categories {
        display: flex;
        gap: 15px;
    }

    .skin-category {
        display: flex;
        align-items: center;
        font-size: 15px;
    }

    .selected-dot {
        display: inline-block;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #eee;
        margin-right: 5px;
        position: relative;
    }

    .selected-dot::after {
        content: "✓";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 10px;
        color: #555;
    }

    /* Count Section */
    .count-section {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .count-label {
        font-size: 16px;
        font-weight: 500;
    }

    .count-controls {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
    }

    .count-decrement,
    .count-increment {
        min-width: 40px;
        min-height: 40px;
        background: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 50%;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .count-field {
        width: 40px;
        text-align: center;
        border: none;
        font-size: 18px;
        margin: 0 10px;
    }

    .cost-display {
        font-size: 18px;
        font-weight: 500;
        color: #800080;
    }

    /* Action Options */
    .action-options {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .add-basket-btn {
        flex: 1;
        padding: 15px;
        background-color: #00223d;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .add-basket-btn:hover {
        background-color: #003866;
        transform: translateY(-2px);
    }

    .purchase-btn {
        flex: 1;
        padding: 15px;
        background-color: #800080;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        font-size: 16px;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .purchase-btn:hover {
        background-color: #6A0DAD;
        transform: translateY(-2px);
    }

    .favorite-btn {
        width: 40px;
        height: 46px;
        background: none;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 24px;
    }

    /* Expandable Sections */
    .expand-section {
        margin-top: 20px;
    }

    .expand-item {
        border-top: 1px solid #eee;
    }

    .expand-header {
        padding: 15px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        font-weight: 500;
        font-size: 13px;
        text-transform: uppercase !important;
    }

    .expand-content {
        padding: 0 0 15px;
        display: none;
        font-size: 16px;
        color: #555;
    }

    /* Research Results */
    .research-results {
        margin-top: 30px;
    }

    .research-part {
        padding: 15px 0;
        background-color: #f9f9f9;
        margin-bottom: 10px;
    }

    .research-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
        padding: 0 15px;
    }

    .research-text {
        padding: 0 15px;
        font-size: 16px;
        color: #555;
    }

    .results-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .result-block {
        padding: 15px;
        background-color: #f9f9f9;
    }

    .result-block h3 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .result-block p {
        font-size: 16px;
        color: #555;
    }

    /* Breadcrumb */
    .product-breadcrumb {
        list-style: none;
        display: flex;
        padding: 10px 0;
        font-size: 16px;
        color: #666;
    }

    .product-breadcrumb li {
        margin-right: 10px;
    }

    .product-breadcrumb li a {
        text-decoration: none;
        color: #666;
    }

    .product-breadcrumb li a:hover {
        color: #800080;
    }

    /* Single Product Card */
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
        height: 250px;
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
        background: #800080;
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

    .action-btn.dinteger {
        background: #dc3545;
    }

    .action-btn.dinteger i {
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
        font-size: 1.25rem;
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
        font-size: 1rem;
    }

    /* Price Scheme Select */
    .price-scheme-select {
        width: 100%;
        padding: 8px 15px;
        border: 1px solid #d4d4d4;
        border-radius: 8px;
        background-color: #800080;
        color: white;
        font-family: Inter, sans-serif;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpath d='M6 9l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 18px;
    }

    .price-scheme-select:focus {
        outline: none;
        border-color: #6A0DAD;
        box-shadow: 0 0 0 2px rgba(128, 0, 128, 0.3);
    }

    .price-scheme-select option {
        background-color: white;
        color: #001F3F;
        font-size: 16px;
    }

    /* Product Cards Slider */
    .product-cards-slider {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 3rem;
        padding: 0 40;
    }

    /* Explore Tab Navbar */
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
        padding: 0 0;
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

    /* Partner Section */
    .pr-partners-section {
        padding: var(--section-padding) 0;
    }

    .pr-main-title {
        font-size: var(--heading-2);
        color: var(--primary-color);
        margin-bottom: 15px;
        font-weight: 700;
        text-align: center;
    }

    .pr-description {
        font-size: 16px;
        color: #6c757d;
        line-height: 1.6;
        max-width: 700px;
        margin: 0 auto;
        text-align: center;
        margin-bottom: 4rem;
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
        padding: 0 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .pr-partner-logo img {
        max-width: 180px;
        height: auto;
        filter: grayscale(100%);
        transition: all 0.3s ease;
    }

    .pr-partner-logo:hover img {
        filter: grayscale(0);
        transform: scale(1.05);
    }

    @keyframes pr-scroll-animation {
        0% {
            transform: translateX(0%);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .pr-slider-container:hover .pr-slider-track {
        animation-play-state: paused;
    }

    /* USP Section */
    .unique-usp-section {
        padding: 80px 0;
    }

    .custom-usp-container {
        max-width: 99%;
        margin: 0 auto;
        padding-left: 20px;
        background-color: var(--primary-color);
    }

    .usp-content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        padding-left: 3rem;
    }

    .usp-text-block .usp-main-heading {
        font-size: 36px;
        margin-bottom: 40px;
        color: #FFFFFF;
    }

    .usp-point-item {
        margin-bottom: 70px;
    }

    .usp-point-title {
        font-size: 24px;
        margin-bottom: 15px;
        color: #ffffff;
    }

    .usp-point-desc {
        line-height: 1.6;
        color: #fff;
        margin: 0;
    }

    .usp-main-visual {
        width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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

    .content-box h3 {
        font-family: "Dancing Script", cursive;
        font-size: var(--heading-2);
        margin-bottom: 1rem;
        color: var(--accent-color);
    }

    .content-box p {
        font-size: var(--body-text);
        line-height: 1.6;
        color: var(--text-muted);
        max-width: 100%;
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

    /* Price Display */
    .item-cost .price-sign {
        font-size: 1.8rem;
        font-weight: 700;
        color: black;
        margin-left: 2px;
    }

    .item-cost .individual-price {
        font-size: 3.5rem;
        font-weight: 700;
        color: black;
    }

    /* Container Images */
    .container img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    /* Media Queries */
    @media (max-width: 768px) {
        .item-display {
            flex-direction: column;
            gap: 20px;
        }

        .image-gallery {
            max-width: 100%;
            min-width: 200px;
            padding-right: 0;
        }

        .item-details {
            padding-left: 0;
        }

        .item-name {
            font-size: 20px;
        }

        .item-cost {
            font-size: 18px;
        }

        .action-options {
            flex-direction: column;
        }

        .add-basket-btn,
        .purchase-btn {
            width: 100%;
        }

        .count-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .skin-categories {
            flex-wrap: wrap;
        }

        .image-previews {
            justify-content: flex-start;
            overflow-x: auto;
            padding-bottom: 10px;
        }

        .results-layout {
            grid-template-columns: 1fr;
        }

        .product-breadcrumb {
            flex-wrap: wrap;
            gap: 8px;
        }

        .product-breadcrumb li {
            margin-right: 5px;
        }

        .product-img {
            height: 180px;
        }

        .product-name {
            font-size: 1rem;
        }

        .current-price {
            font-size: 1.25rem;
        }

        .original-price {
            font-size: 0.875rem;
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

        .preview-image {
            width: 50px;
            height: 38px;
        }

        .pr-slide-item {
            padding: 0 15px;
        }

        .pr-partner-logo img {
            max-width: 120px;
        }

        .pr-main-title {
            font-size: 2.5rem;
        }

        .pr-description {
            font-size: 1.1rem;
        }

        .usp-content-grid {
            grid-template-columns: 1fr;
            gap: 40px;
            padding-left: 1rem;
        }

        .usp-text-block .usp-main-heading {
            font-size: 28px;
            margin-bottom: 30px;
        }

        .usp-point-item {
            margin-bottom: 30px;
        }

        .usp-visual-wrapper {
            order: -1;
        }

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

        .image {
            width: 15rem;
            height: 15rem;
        }

        .feature-container {
            font-size: 1.5rem;
            padding-inline: 1.5rem;
        }

        .feature-container li ion-icon {
            font-size: 1.8rem;
        }

        .content-container {
            grid-template-columns: 1fr;
            padding: var(--section-padding);
        }

        .content-box {
            text-align: center;
            padding: 2rem;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .content-box {
            padding: 0 30px;
        }

        .item-name {
            font-size: 24px;
        }

        .item-cost {
            font-size: 20px;
        }

        .image-gallery {
            max-width: 400px;
        }

        .action-options {
            flex-wrap: wrap;
        }

        .add-basket-btn,
        .purchase-btn {
            min-width: calc(50% - 5px);
        }
    }

    @media (min-width: 1025px) {
        .image-container {
            max-width: 500px;
            margin: 0 auto;
        }

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

    @media (max-width: 480px) {
        .item-name {
            font-size: 18px;
        }

        .item-desc {
            font-size: 15px;
        }

        .count-section {
            flex-direction: column;
            align-items: stretch;
        }

        .preview-image {
            width: 40px;
            height: 30px;
        }

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

    @media (hover: none) {

        .count-decrement,
        .count-increment {
            min-width: 50px;
            min-height: 50px;
        }
    }
    .zoom-container {
        position: relative;
        overflow: hidden;
    }

    .primary-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.1s ease;
        transform-origin: center center;
    }
</style>


@extends('layouts.front')
@php
    $tags = $productt->tags;

    $query = App\Models\Product::where('id', '!=', $productt->id) // exclude the current product
        ->where('type', $productt->type)
        ->where('product_type', $productt->product_type);

    if (!empty($tags)) {
        $query->where(function ($q) use ($tags) {
            foreach ($tags as $tag) {
                $q->orWhere('tags', 'LIKE', "%{$tag}%");
            }
        });
    }

    $products = $query->withCount('ratings')
        ->withAvg('ratings', 'rating')
        ->take(12)
        ->get();
@endphp

@section('content')
    <!-- breadcrumb start -->
    {{-- <section class="gs-breadcrumb-section bg-class" data-background="{{ asset('assets/svg/banner.png') }}">
        <div class="container">
            <div class="row justify-content-center content-wrapper">
                <div class="col-12">
                    <h2 class="breadcrumb-title">@lang('Product')</h2>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- breadcrumb end -->

    <!-- single product details content wrapper start -->
    {{-- <div class="single-product-details-content-wrapper" style="padding-bottom: 2rem">
        <div class="container">
            <div class="row gy-4">
                <div class="col-12">
                    <!-- product-breadcrumb -->
                    <ul class="product-breadcrumb">
                        <li><a href="{{ route('front.index') }}">@lang('home')</a></li>
                        <li><a href="{{ route('front.category', $productt->category->slug) }}">{{ $productt->category->name
                                }}</a></li>
                        @if ($productt->subcategory_id)
                        <li><a
                                href="{{ route('front.category', [$productt->category->slug, $productt->subcategory->slug]) }}">{{
                                $productt->subcategory->name }}</a></li>
                        @endif
                        @if ($productt->childcategory_id)
                        <li><a
                                href="{{ route('front.category', [$productt->category->slug, $productt->subcategory->slug, $productt->childcategory->slug]) }}">{{
                                $productt->childcategory->name }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="product-page-wrapper" style="margin-bottom: 3rem">
        <div class="content-box">
            <div class="item-display">
                <div class="image-gallery">
                    <div class="image-container zoom-wrapper">
                        <button class="slide-prev">‹</button>
                        <div class="zoom-container">
                            <img src="{{ filter_var($productt->photo, FILTER_VALIDATE_URL) ? $productt->photo : asset('assets/images/products/' . $productt->photo) }}"
                                alt="{{ $productt->name }}" class="primary-image" />
                        </div>
                        <button class="slide-next">›</button>
                    </div>
                    <div class="image-previews">
                        <img src="{{ filter_var($productt->photo, FILTER_VALIDATE_URL) ? $productt->photo : asset('assets/images/products/' . $productt->photo) }}"
                            alt="Main View" class="preview-image" />
                        @foreach ($productt->galleries as $gal)
                            <img src="{{ asset('assets/images/galleries/' . $gal->photo) }}" alt="Gallery View"
                                class="preview-image" />
                        @endforeach
                    </div>
                </div>
                <div class="item-details">
                    <h1 class="item-name">{{ $productt->name }}</h1>
                    <p>{!! $productt->details !!}</p>
                    @if (Auth::check())
                        <div class="item-cost">{!! $productt->showPrice() !!}</div>
                    @else
                        <div class="item-cost"> ₹ XXXX</div>
                        <p style="font-size: 1.4rem">These products are available in leading dermatologist clinics near you.
                            <br />You can visit <a href="{{route('front.category')}}">Find a Provider</a>
                        </p>
                    @endif

                    @if (Auth::check())
                        @php
                            $scheme_entries = optional($productt->brand->scheme)->scheme_entries ?? [];
                            $preferredType = Auth::check() ? Auth::user()->preferred_type : null;
                        @endphp
                        @if ($preferredType === 'scheme_based_profile')
                            <div class="scheme-container d-flex justify-content-between align-items-center flex-wrap my-5">
                                <div class="custom-wrapper mt-4" style="width: 70%">
                                    <select class="price-scheme-select" name="price_scheme">
                                        <option value="" selected disabled>Select Price Scheme</option>
                                        @if (!empty($scheme_entries))
                                            @foreach ($scheme_entries as $entry)
                                                <option value="{{ $entry->id }}" data-product="{{ $productt->id }}"
                                                    data-discount="{{ $entry->discount_percentage }}"
                                                    data-quantity="{{ $entry->total_quantity }}"
                                                    data-product_price="{{ $productt->price }}">
                                                    {{ $entry->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div>
                                    <div class="cost-display" style="font-size: 2.5rem" id="{{ 'current-price-' . $productt->id }}">
                                        {!! $productt->showPrice() !!}
                                    </div>
                                </div>
                            </div>
                        @elseif ($preferredType === 'net_discount_profile')
                            <div class="count-section">
                                <div class="count-label">Quantity</div>
                                <div class="count-controls">
                                    <button class="count-decrement">−</button>
                                    <input type="text" value="{{ $productt->minimum_qty ?? 1 }}" class="count-field" id="order-qty"
                                        readonly />
                                    <button class="count-increment">+</button>
                                </div>
                                <div class="cost-display">{!! $productt->showPrice() !!}</div>
                            </div>
                        @endif
                    @endif

                    @if (Auth::check())
                        <div class="action-options">
                            <button class="add-basket-btn" id="addtodetailscart">@lang('Add to cart')</button>
                            <button class="purchase-btn" id="addtobycard">@lang('Buy now')</button>
                            <button class="favorite-btn" style="color: black">
                                <svg style="color: #000000" width="24" height="25" viewBox="0 0 24 25" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.1111 3.5C19.6333 3.5 22 6.8525 22 9.98C22 16.3138 12.1778 21.5 12 21.5C11.8222 21.5 2 16.3138 2 9.98C2 6.8525 4.36667 3.5 7.88889 3.5C9.91111 3.5 11.2333 4.52375 12 5.42375C12.7667 4.52375 14.0889 3.5 16.1111 3.5Z"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    </path>
                                </svg>
                            </button>
                            <!-- Hidden Inputs for Add to Cart and Buy Now -->
                            <input type="hidden" id="product_price"
                                value="{{ round($productt->vendorPrice() * $curr->value, 2) }}">
                            <input type="hidden" id="product_id" value="{{ $productt->id }}">
                            <input type="hidden" id="curr_pos" value="{{ $gs->currency_format }}">
                            <input type="hidden" id="curr_sign" value="{{ $curr->sign }}">
                            @if ($productt->type == 'Physical')
                                @if (is_array($productt->size))
                                    <input type="hidden" id="stock" value="{{ $productt->size_qty[0] }}">
                                @else
                                    @if (!$productt->emptyStock())
                                        @if ($productt->stock_check == 1)
                                            <input type="hidden" id="stock" value="{{ $productt->size_price[0] }}">
                                        @else
                                            <input type="hidden" id="stock" value="{{ $productt->stock }}">
                                        @endif
                                    @elseif($productt->type != 'Physical')
                                        <input type="hidden" id="stock" value="0">
                                    @else
                                        <input type="hidden" id="stock" value="">
                                    @endif
                                @endif
                            @endif
                        </div>
                    @endif

                    <!-- Unified Expandable Section -->
                    <div class="expand-section">
                        @if($productt->description)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Product Description') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->description !!}
                                </div>
                            </div>
                        @endif

                        @if($productt->safety_information)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Safety Information') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->safety_information !!}
                                </div>
                            </div>
                        @endif

                        @if($productt->clinical_evidences)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Clinical Evidences') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->clinical_evidences !!}
                                </div>
                            </div>
                        @endif

                        @if($productt->usage_instructions)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Usage Instructions') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->usage_instructions !!}
                                </div>
                            </div>
                        @endif

                        @if($productt->ingredients)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Key Ingredients') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->ingredients !!}
                                </div>
                            </div>
                        @endif

                        @if($productt->technology)
                            <div class="expand-item">
                                <div class="expand-header">
                                    {{ __('Technology') }}
                                    <span>▼</span>
                                </div>
                                <div class="expand-content">
                                    {!! $productt->technology !!}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- single product details content wrapper end -->
    {{-- <div class="container">
        <img src="{{ asset('assets/svg/big.png') }}" alt="big-img" style="max-width: 100%; height: auto">
    </div> --}}

    <!-- Related Products slider start -->
    {{-- <div class="gs-product-cards-slider-area wow-replaced" data-wow-delay=".1s">
        <div class="container">
            <h2 class="title text-center">@lang('Related Products')</h2>
            <div class="product-cards-slider">
                @foreach (App\Models\Product::where('type', $productt->type)->where('product_type',
                $productt->product_type)->withCount('ratings')->withAvg('ratings', 'rating')->take(12)->get() as $product)
                @include('includes.frontend.home_product', ['class' => 'not'])
                @endforeach
            </div>
        </div>
    </div> --}}
    <!-- Related Products slider end -->
    <div class="tab-product-des-wrapper wow-replaced" data-wow-delay=".1s">
        <div class="container">
            {{-- <ul class="nav nav-tabs" id="myTab" role="tablist"> --}}
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                        data-bs-target="#description-tab-pane" type="button" role="tab" aria-controls="description-tab-pane"
                        aria-selected="true">
                        @lang('Description')
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="buy-return-policy-tab" data-bs-toggle="tab"
                        data-bs-target="#buy-return-policy-tab-pane" type="button" role="tab"
                        aria-controls="buy-return-policy-tab-pane" aria-selected="false">
                        @lang('Buy / Return Policy')
                    </button>
                </li> --}}
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane"
                        type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">
                        @lang('Reviews')
                    </button>
                </li> --}}

                {{-- @if ($productt->whole_sell_qty != null && $productt->whole_sell_qty != '')
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="whole-sell-tab" data-bs-toggle="tab" data-bs-target="#whole-sell-tab-pane"
                        type="button" role="tab" aria-controls="whole-sell-tab-pane" aria-selected="false">
                        @lang('Whole sell')
                    </button>
                </li>
                @endif

            </ul> --}}
            <div class="tab-content" id="myTabContent">
                {{-- <div class="tab-pane show active wow-replaced" data-wow-delay=".1s" id="description-tab-pane"
                    role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                    {!! clean($productt->details, ['Attr.EnableID' => true]) !!}
                </div>
                <div class="tab-pane fade" id="buy-return-policy-tab-pane" role="tabpanel"
                    aria-labelledby="buy-return-policy-tab" tabindex="0">
                    {!! clean($productt->policy, ['Attr.EnableID' => true]) !!}
                </div> --}}

                <!-- Reviews tab content start  -->
                <div class="tab-pane fade active show" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab"
                    tabindex="0">
                    <div class="row review-tab-content-wrapper">
                        <div class="col-xxl-8">
                            <div id="comments">
                                <h5 class="woocommerce-Reviews-titleDDD my-3" style="font-size: 36px">
                                    @lang('Ratings & Reviews')
                                </h5>
                                <ul class="all-comments">
                                    @forelse($productt->ratings() as $review)
                                        <li>
                                            <div class="single-comment">
                                                <div class="left-area">
                                                    <img src="{{ $review->user->photo ? asset('assets/images/users/' . $review->user->photo) : asset('assets/images/' . $gs->user_image) }}"
                                                        alt="">
                                                    <p class="name text-lg">
                                                        {{ $review->user->name }}
                                                    </p>
                                                    <div class="reating-area">
                                                        <div class="stars"><span id="star-rating">{{ $review->rating }}</span>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <p class="date">
                                                            {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->review_date)->diffForHumans() }}
                                                        </p>
                                                    </div>

                                                </div>
                                                <div class="right-area">
                                                    <div class="comment-body">
                                                        <p>
                                                            {{ $review->review }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li>
                                            <div class="single-comment">
                                                <div class="left-area">
                                                    <p class="name text-lg">
                                                        @lang('No Review Found')
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>


                            @if (Auth::check())
                                <div id="review_form_wrapper">

                                    <div class="review-area">

                                        <h5 class="title">@lang('Reviews')</h5>
                                        <div class="star-area">
                                            <ul class="star-list">
                                                <li class="stars" data-val="1">
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars" data-val="2">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars" data-val="3">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars" data-val="4">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars active" data-val="5">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>


                                    <div class="write-comment-area">

                                        <form action="{{ route('front.review.submit') }}"
                                            data-href="{{ route('front.reviews', $productt->id) }}"
                                            data-side-href="{{ route('front.side.reviews', $productt->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="rating" name="rating" value="5">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="product_id" value="{{ $productt->id }}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <textarea name="review" placeholder="{{ __('Write Your Review *') }}"
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button class="template-btn" type="submit" style="height: unset; padding: 1.2rem 1.5rem;">{{ __('Submit') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <h5 class="all-comments">
                                    <a href="{{ route('user.login') }}" style="color: rgb(128, 0, 128)" class="
                                                        ">
                                        {{ __('Login') }}
                                    </a>
                                    {{ __('To Review') }}
                                </h5>
                            @endif

                        </div>
                    </div>
                </div>
                <!-- Reviews tab content end -->





                @if ($productt->whole_sell_qty != null && $productt->whole_sell_qty != '')
                    <!-- Wholesell Tab content start  -->
                    <div class="tab-pane fade" id="whole-sell-tab-pane" role="tabpanel" aria-labelledby="whole-sell-tab"
                        tabindex="0">
                        <div class="row sholesell-tab-content-wrapper">
                            <div class="col-12 col-lg-8 col-xl-9 col-xxl-8">
                                <div class="pro-summary ">
                                    <div class="price-summary">
                                        <div class="price-summary-content">
                                            <p class="title text-center text-lg">@lang('Wholesell')</p>
                                            <ul class="price-summary-list">
                                                <li class="regular-price">
                                                    <p class="fw-medium">@lang('Quantity')</p>
                                                    <p class="fw-medium">
                                                        @lang('Discount')
                                                    </p>
                                                </li>

                                                @foreach ($productt->whole_sell_qty as $key => $data1)
                                                    <li class="selling-price">
                                                        <label>{{ $productt->whole_sell_qty[$key] }}+</label> <span><span
                                                                class="woocommerce-Price-amount amount">{{ $productt->whole_sell_discount[$key] }}%
                                                                @lang('Off')
                                                            </span>
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <!-- Featured Products Section Start -->
    <section class="" style="padding-top: 0; background-color: #ffffff;">
        <div class="container">
            <div class="mb-40">
                <div class="gs-title-box" style="text-align: center">
                    {{-- <h2 class="title wow-replaced">@lang('Our Featured Products')</h2> --}}
                    <h2 class="title text-center" style="margin: 0;font-size: 4rem !important">@lang('Related Products')
                    </h2>

                </div>
            </div>
            <div class="row product-cards-slider gy-4 mt-4 mt-lg-0">
                @if ($products->isNotEmpty())
                    @foreach ($products as $product)
                        @include('includes.frontend.home_product', ['class' => 'not'])
                    @endforeach
                @else
                    <div class="no-products text-center text-muted p-4">
                        <p>No related products found.</p>
                    </div>
                @endif
            </div>

        </div>
    </section>
    <!-- Featured Products Section End -->


    <!-- More Products By Seller slider start -->
    @if ($productt->user_id != 0 && $vendor_products->count() > 0)
        <div class="gs-product-cards-slider-section more-products-by-seller wow-replaced" data-wow-delay=".1s">
            <div class="gs-product-cards-slider-area more-products-by-seller">
                <div class="container">
                    <h2 class="title text-center">@lang('More Products By Seller')</h2>
                    <div class="product-cards-slider">
                        @foreach ($vendor_products as $product)
                            @include('includes.frontend.home_product', ['class' => 'not'])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- More Products By Seller slider end -->

    <!-- Product report Modal Start -->
    @if (auth()->check())
        <div class="modal gs-modal fade" id="report-modal" tabindex="-1" aria-hidden="true">
            <form action="{{ route('product.report') }}" method="POST"
                class="modal-dialog assign-rider-modal-dialog modal-dialog-centered">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="product_id" value="{{ $productt->id }}">

                <div class="modal-content assign-rider-modal-content form-group">
                    <div class="modal-header w-100">
                        <h4 class="title">{{ __('REPORT PRODUCT') }}</h4>
                        <button type="button" data-bs-dismiss="modal">
                            <i class="fa-regular fa-circle-xmark gs-modal-close-btn"></i>
                        </button>
                    </div>
                    <!-- modal body start -->
                    <div class="input-label-wrapper w-100">
                        <label>{{ __('Please give the following details') }}</label>
                        <input type="text" name="title" class="form-control mb-3" placeholder="{{ __('Enter Report Title') }}"
                            required="">
                        <textarea name="note" class="form-control border p-3" placeholder="{{ __('Enter Report Note') }}"
                            required=""></textarea>
                    </div>
                    <button class="template-btn" data-bs-dismiss="modal" type="submit">{{ __('SUBMIT') }}</button>
                    <!-- modal body end -->
                </div>
            </form>
        </div>
    @endif
    <!-- Product report Modal End -->

    <!-- Vendor Message Modal -->
    <div class="modal gs-modal fade" id="vendorform" tabindex="-1" aria-modal="true" role="dialog">
        <form action="{{ route('user-send-message') }}" id="emailreply" method="POST"
            class="modal-dialog assign-rider-modal-dialog modal-dialog-centered emailreply">
            {{ csrf_field() }}
            <div class="modal-content assign-rider-modal-content form-group">
                <div class="modal-header w-100">
                    <h4 class="title">@lang('Send Message')</h4>
                    <button type="button" data-bs-dismiss="modal">
                        <i class="fa-regular fa-circle-xmark gs-modal-close-btn"></i>
                    </button>
                </div>
                <div class="input-label-wrapper w-100">
                    <input type="text" class="form-control border px-3 mb-4" id="eml" name="email" readonly
                        placeholder="@lang('Select Rider')" value="{{ auth()->user() ? auth()->user()->email : '' }}">
                    <input type="text" class="form-control border px-3 mb-4" name="subject" placeholder="@lang('Subject')"
                        required="">
                    <textarea class="form-control border px-3 mb-4" name="message" placeholder="{{ __('Your Message') }}"
                        required=""></textarea>
                    <input type="hidden" name="name" value="{{ Auth::user() ? Auth::user()->name : '' }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user() ? Auth::user()->id : '' }}">
                    <input type="hidden" name="vendor_id" value="{{ $productt->user_id }}">
                </div>
                <button class="template-btn" data-bs-dismiss="modal" type="submit">@lang('Send Message')</button>
            </div>
        </form>
    </div>

    <!-- Send Message Modal -->
    <div class="modal gs-modal fade" id="sendMessage" tabindex="-1" aria-modal="true" role="dialog">
        <form action="{{ route('user-send-message') }}" method="POST"
            class="modal-dialog assign-rider-modal-dialog modal-dialog-centered emailreply">
            {{ csrf_field() }}
            <div class="modal-content assign-rider-modal-content form-group">
                <div class="modal-header w-100">
                    <h4 class="title">@lang('Send Message')</h4>
                    <button type="button" data-bs-dismiss="modal">
                        <i class="fa-regular fa-circle-xmark gs-modal-close-btn"></i>
                    </button>
                </div>
                <div class="input-label-wrapper w-100">
                    <input type="text" class="form-control form__control border px-3 mb-4" name="subject"
                        placeholder="@lang('Subject')" required="">
                    <textarea class="form-control form__control border px-3 mb-4" name="message"
                        placeholder="{{ __('Your Message') }}" required=""></textarea>
                </div>
                <button class="template-btn" data-bs-dismiss="modal" type="submit">@lang('Send Message')</button>
            </div>
        </form>
    </div>
@endsection


@section('script')
    <script src="{{ asset('assets/front/js/jquery.elevatezoom.js') }}"></script>

    <script type="text/javascript">
        (function ($) {
            "use strict";

            $("#single-image-zoom").elevateZoom({
                gallery: 'gallery_09',
                zoomType: "inner",
                cursor: "crosshair",
                galleryActiveClass: 'active',
                imageCrossfade: true,
                loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'
            });

            $("#single-image-zoom").bind("click", function (e) {
                var ez = $('#single-image-zoom').data('elevateZoom');
                $.fancybox(ez.getGalleryList());
                return false;
            });

            $(document).on("submit", "#emailreply", function () {
                var token = $(this).find('input[name=_token]').val();
                var subject = $(this).find('input[name=subject]').val();
                var message = $(this).find('textarea[name=message]').val();
                var email = $(this).find('input[name=email]').val();
                var name = $(this).find('input[name=name]').val();
                var user_id = $(this).find('input[name=user_id]').val();
                $('#eml').prop('disabled', true);
                $('#subj').prop('disabled', true);
                $('#msg').prop('disabled', true);
                $('#emlsub').prop('disabled', true);
                $.ajax({
                    type: 'post',
                    url: "{{ URL::to('/user/user/contact') }}",
                    data: {
                        '_token': token,
                        'subject': subject,
                        'message': message,
                        'email': email,
                        'name': name,
                        'user_id': user_id
                    },
                    success: function (data) {
                        $('#eml').prop('disabled', false);
                        $('#subj').prop('disabled', false);
                        $('#msg').prop('disabled', false);
                        $('#subj').val('');
                        $('#msg').val('');
                        $('#emlsub').prop('disabled', false);
                        if (data == 0)
                            toastr.error("Email Not Found");
                        else
                            toastr.success("Message Sent");
                        $('#vendorform').modal('hide');
                    }
                });
                return false;
            });

            $('.add-to-affilate').on('click', function () {
                var value = $(this).data('href');
                var tempInput = document.createElement("input");
                tempInput.style = "position: absolute; left: -1000px; top: -1000px";
                tempInput.value = value;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
                toastr.success('Affiliate Link Copied');
            });
        })(jQuery);
    </script>

    <!-- Include JavaScript -->
    <script>
        // Single-open accordion functionality
        document.querySelectorAll(".expand-header").forEach((button) => {
            button.addEventListener("click", () => {
                const content = button.nextElementSibling;
                const isCurrentlyOpen = content.style.display === "block";

                // Close all other sections
                document.querySelectorAll(".expand-content").forEach((otherContent) => {
                    otherContent.style.display = "none";
                });
                document.querySelectorAll(".expand-header span").forEach((span) => {
                    span.textContent = "▼";
                });

                // Toggle the clicked section
                if (!isCurrentlyOpen) {
                    content.style.display = "block";
                    button.querySelector("span").textContent = "▲";
                }
            });
        });

        // // Quantity controls and cost update
        // const minusBtn = document.querySelector(".count-decrement");
        // const plusBtn = document.querySelector(".count-increment");
        // const quantityInput = document.querySelector("#order-qty");
        // const costDisplay = document.querySelector(".cost-display");

        // let basePriceText = "{{ $productt->price }}".replace(/[^0-9.]/g, '');
        // let basePrice = parseFloat(basePriceText);

        // // Function to update the cost display
        // function updateCostDisplay() {
        //     const quantity = parseInt(quantityInput.value);
        //     const totalCost = basePrice * quantity;
        //     costDisplay.textContent = `₹${totalCost.toFixed(2)}`; // Format with 2 decimal places
        // }

        // // Initial update
        // updateCostDisplay();

        // // Decrease quantity
        // minusBtn.addEventListener("click", () => {
        //     let value = parseInt(quantityInput.value);
        //     if (value > {{ $productt->minimum_qty ?? 1 }}) {
        //         quantityInput.value = value - 1;
        //         updateCostDisplay();
        //     }
        // });

        // // Increase quantity
        // plusBtn.addEventListener("click", () => {
        //     let value = parseInt(quantityInput.value);
        //     quantityInput.value = value + 1;
        //     updateCostDisplay();
        // });

        // Image slider functionality
        let currentImageIndex = 0;
        const primaryImage = document.querySelector(".primary-image");
        const previewImages = document.querySelectorAll(".preview-image");
        const slidePrev = document.querySelector(".slide-prev");
        const slideNext = document.querySelector(".slide-next");

        function updateImage() {
            primaryImage.src = previewImages[currentImageIndex].src;
            previewImages.forEach((img, index) => {
                img.classList.toggle("active", index === currentImageIndex);
            });
        }

        slideNext.addEventListener("click", () => {
            currentImageIndex = (currentImageIndex + 1) % previewImages.length;
            updateImage();
        });

        slidePrev.addEventListener("click", () => {
            currentImageIndex = (currentImageIndex - 1 + previewImages.length) % previewImages.length;
            updateImage();
        });

        previewImages.forEach((img, index) => {
            img.addEventListener("click", () => {
                currentImageIndex = index;
                updateImage();
            });
        });

        // Initialize the slider
        updateImage();
    </script>
    <script>
        $(document).ready(function () {
            const originalPrice = $('.current-price').text();
            const basePriceText = originalPrice.replace(/[^0-9.]/g, ''); // Remove currency symbols
            const basePrice = parseFloat(basePriceText) || 0;
            $('.price-scheme-select').on('change', function () {
                const selectedDiscount = $(this).find(':selected').data('discount');
                const selectedProduct = $(this).find(':selected').data('product');
                const selectedProductTotalQuantity = $(this).find(':selected').data('quantity');
                const selectedProductPrice = $(this).find(':selected').data('product_price');

                if (selectedDiscount !== undefined && selectedProductTotalQuantity > 0) {
                    const totalPrice = selectedProductPrice * selectedProductTotalQuantity;

                    const discountAmount = (totalPrice * selectedDiscount) / 100;
                    const discountedPrice = totalPrice - discountAmount;

                    // $(`#discount-badge-${selectedProduct}`).text(`-${Math.round(selectedDiscount)}%`);
                    $(`#current-price-${selectedProduct}`).text(discountedPrice.toFixed(2));
                }
            });
        });

        // Single-open accordion functionality
        document.querySelectorAll(".expand-header").forEach((button) => {
            button.addEventListener("click", () => {
                const content = button.nextElementSibling;
                // Use getComputedStyle to check the actual displayed state
                const isCurrentlyOpen = window.getComputedStyle(content).display === "block";

                // Close all other sections
                document.querySelectorAll(".expand-content").forEach((otherContent) => {
                    otherContent.style.display = "none";
                });
                document.querySelectorAll(".expand-header span").forEach((span) => {
                    span.textContent = "▼";
                });

                // Toggle the clicked section based on computed display state
                if (!isCurrentlyOpen) {
                    content.style.display = "block";
                    button.querySelector("span").textContent = "▲";
                } else {
                    content.style.display = "none";
                    button.querySelector("span").textContent = "▼";
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const zoomContainer = document.querySelector('.zoom-container');
            const image = zoomContainer.querySelector('.primary-image');

            zoomContainer.addEventListener('mousemove', function (e) {
                const rect = zoomContainer.getBoundingClientRect();
                const x = ((e.clientX - rect.left) / rect.width) * 100;
                const y = ((e.clientY - rect.top) / rect.height) * 100;

                image.style.transformOrigin = `${x}% ${y}%`;
                image.style.transform = 'scale(2.5)'; // adjust scale as needed
            });

            zoomContainer.addEventListener('mouseleave', function () {
                image.style.transform = 'scale(1)';
                image.style.transformOrigin = 'center center';
            });
        });
    </script>
@endsection