<header class="header header-2 header-intro-clearance">
<style>
    @media screen and (min-width: 768px) {
        .desktop-logo {
            width: 24% !important;
        }
    }
    .activate{
        color: #64c474 !important;
    }

/* ===== HEADER SEARCH PANEL ===== */

.header-search-panel {
    display: none;
    background: #f6f6ec;
    padding: 30px 60px;
    border-top: 1px solid #ddd;
}

.header-search-panel.active {
    display: block;
}

/* Input row */
.search-input-wrapper {
    display: flex;
    align-items: center;
    gap: 15px;
    font-size: 20px;
}

.search-input-wrapper input {
    flex: 1;
    border: none;
    background: transparent;
    font-size: 22px;
    outline: none;
}

.search-input-wrapper button {
    font-size: 28px;
    background: none;
    border: none;
    cursor: pointer;
}

/* Layout */
.search-results {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 40px;
    margin-top: 30px;
}

/* Product grid */
.search-product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* Product card (same feel as listing) */
.search-product-card {
    background: #fff;
    border-radius: 14px;
    padding: 10px;
    text-align: center;
}

.search-product-card img {
    width: 100%;
    border-radius: 10px;
}

/* Mobile */
@media (max-width: 991px) {
    .search-results {
        grid-template-columns: 1fr;
    }

    .search-product-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}


</style>
    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>
                <a href="{{url('/')}}" class="logo">
                    <img src="{{asset('images/WhatsApp Image 2025-07-22 at 19.56.01.jpeg')}}" alt="Molla Logo"
                        width="105" height="25" class="desktop-logo">
                </a>
            </div>
            <div class="header-center">
                <div
                    class="header-search header-search-extended header-search-visible header-search-no-radius d-none d-lg-block">
                    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                    <form action="{{ route('shop') }}" method="get" autocomplete="off">
                        <div class="header-search-wrapper search-wrapper-wide position-relative">
                            <label for="q" class="sr-only">Search</label>
                            <input type="search" class="form-control" name="q" id="product-searchss" placeholder="Search product ..."
                                value="{{ request('q') }}" required>
                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>

                            <ul id="search-results" class="list-group position-absolute w-100 mt-1" style="z-index: 1000; display: none;"></ul>
                        </div>
                    </form>
                </div>
            </div>
            <div class="header-right">
                <!-- SEARCH ICON (RIGHT SIDE) -->
<a href="javascript:void(0)" id="open-search">
    <i class="icon-search"></i>
</a>


                
        <!-- Account -->
        <div class="account {{ request()->is('account*') ? 'active' : '' }}">
            <a href="{{ url('account') }}" title="My account"  class="account {{ request()->is('account*') ? 'activate' : '' }}">
                <div class="icon">
                    <i class="icon-user"></i>
                </div>
                <p>Account</p>
            </a>
        </div>

        <!-- Wishlist -->
        <div class="wishlist d-none d-md-block {{ request()->is('wishlist*') ? 'active' : '' }}" style="padding-top: 3.8rem;">
            <a href="{{ url('wishlist') }}" title="Wishlist" class="{{ request()->is('wishlist*') ? 'activate' : '' }}">
                <div class="icon">
                    <i class="icon-heart-o"></i>
                    <span class="wishlist-count badge">{{ \App\Helpers\CartHelper::getWishlistCount() }}</span>
                </div>
                <p>Wishlist</p>
            </a>
        </div>

        <!-- Cart -->
        <div class="dropdown cart-dropdown d-none d-md-block {{ request()->is('cart*') || request()->is('checkout*') ? 'active' : '' }}" style="padding-top: 3.8rem;">
            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false" data-display="static" class="{{ request()->is('cart*') ? 'activate' : '' }}">
                <div class="icon">
                    <i class="icon-shopping-cart {{ request()->is('cart*') ? 'activate' : '' }}"></i>
                    <span class="cart-count">{{ \App\Helpers\CartHelper::getCartCount() }}</span>
                </div>
                <p>Cart</p>
            </a>

            @php
                $cartItems = \App\Helpers\CartHelper::getCart();
                $total = 0;
            @endphp

            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-cart-products">
                    @if(!empty($cartItems))
                        @foreach($cartItems as $item)
                            @php
                                $price = $item['product']->discounted_price;
                                $total += $price * $item['quantity'];
                            @endphp
                            <div class="product">
                                <div class="product-cart-details">
                                    <h4 class="product-title">
                                        <a href="{{ url('product/' . $item['product']->slug) }}">
                                            {{ $item['name'] ?? $item['product']->name }}
                                        </a>
                                    </h4>
                                    <span class="cart-product-info">
                                        <span class="cart-product-qty">{{ $item['quantity'] }}</span>
                                        x ₹{{ number_format($price, 2) }}
                                    </span>
                                </div>
                                <figure class="product-image-container">
                                    <a href="{{ url('shop-product-detail/' . $item['product']->id) }}" class="product-image">
                                        <img src="{{ asset('storage/' . $item['product']->featured_image) }}"
                                            alt="product" style="width: 60px; height: auto;">
                                    </a>
                                </figure>

                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove" title="Remove Product">
                                        <i class="icon-close"></i>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center">Your cart is empty.</p>
                    @endif
                </div>

                @if(!empty($cartItems))
                    <div class="dropdown-cart-total">
                        <span>Total</span>
                        <span class="cart-total-price">₹{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="dropdown-cart-action">
                        <a href="{{ url('cart') }}" class="btn btn-primary">View Cart</a>
                        <a href="{{ url('checkout') }}" class="btn btn-outline-primary-2">
                            <span>Checkout</span><i class="icon-long-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        </div>
    

        </div>
        <!-- EXPANDABLE SEARCH PANEL -->
<!-- EXPANDABLE SEARCH PANEL -->
<div id="header-search-panel" class="header-search-panel">

    <!-- Search Input -->
    <div class="search-input-wrapper">
        <i class="icon-search"></i>
        <input
            type="search"
            id="product-search"
            placeholder="Search for..."
            autocomplete="off"
        />
        <button id="close-search">&times;</button>
    </div>

    <!-- Results -->
    <div class="search-results">

        <!-- Suggestions -->
        <div class="search-suggestions" style="display:none">
            <h6>SUGGESTIONS</h6>
            <ul id="search-suggestions"></ul>
        </div>

        <!-- Products -->
        <div class="search-products" style="display:none">
            <h6>PRODUCTS</h6>
            <div id="search-products" class="search-product-grid"></div>
        </div>

        <!-- Empty State -->
        <p id="search-empty" style="display:none;margin-top:20px;">
            No product found
        </p>

    </div>
</div>


    </div>
    <div class="header-bottom sticky-header">
        <div class="container">
            <div class="header-left">
                <div class="dropdown category-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" data-display="static" title="Browse Categories"
                        style="font-size: 20px !important;">
                        Browse Categories
                    </a>
                    <div class="dropdown-menu">
                        <nav class="side-nav">
                            <ul class="menu-vertical sf-arrows">
                                <li class="item-lead"><a href="{{url('category/tshirts')}}">Tshirts</a></li>
                                    @php
                                    $getCaregories = \App\Helpers\CartHelper::getCaregories();
                                    @endphp
                                @foreach($getCaregories as $categories)
                                <li><a href="{{url('category/'.$categories->slug)}}">{{$categories->name}}</a></li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="header-center">
               <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container {{ request()->is('/') ? 'active' : '' }}">
                            <a href="{{ url('/') }}" style="font-size: 20px !important;">Home</a>
                        </li>
                        <li class="{{ request()->is('shop*') ? 'active' : '' }}">
                            <a href="{{ url('shop') }}" style="font-size: 20px !important;">Shop</a>
                        </li>
                        <li class="{{ request()->is('about') || request()->is('contact_us') || request()->is('faq') ? 'active' : '' }}">
                            <a href="#" class="sf-with-ul" style="font-size: 20px !important;">Pages</a>
                            <ul>
                                <li>
                                    <a href="{{ url('about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a>
                                </li>
                                <li>
                                    <a href="{{ url('contact_us') }}" class="{{ request()->is('contact_us') ? 'active' : '' }}">Contact</a>
                                </li>
                                <li>
                                    <a href="{{ url('faq') }}" class="{{ request()->is('faq') ? 'active' : '' }}">FAQs</a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{ request()->is('blogs*') ? 'active' : '' }}">
                            <a href="{{ url('blogs') }}" style="font-size: 20px !important;">Blog</a>
                        </li>
                    </ul>
                </nav>

            </div>

            <div class="header-right" style="font-size: 20px !important;">
                <i class="la la-lightbulb-o"></i>
                <p>Clearance<span class="highlight">&nbsp;Up to 30% Off</span></p>
            </div>
        </div>
    </div>
</header>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const openBtn = document.getElementById("open-search");
    const closeBtn = document.getElementById("close-search");
    const panel = document.getElementById("header-search-panel");

    const input = document.getElementById("product-search");

    const suggestionsWrap = document.querySelector(".search-suggestions");
    const productsWrap = document.querySelector(".search-products");

    const suggestionsBox = document.getElementById("search-suggestions");
    const productsBox = document.getElementById("search-products");
    const emptyBox = document.getElementById("search-empty");

    /* OPEN PANEL */
    openBtn.addEventListener("click", function (e) {
        e.preventDefault();
        panel.classList.add("active");
        input.focus();
    });

    /* CLOSE PANEL */
    closeBtn.addEventListener("click", function () {
        panel.classList.remove("active");
        input.value = "";
        suggestionsBox.innerHTML = "";
        productsBox.innerHTML = "";
        suggestionsWrap.style.display = "none";
        productsWrap.style.display = "none";
        emptyBox.style.display = "none";
    });

    /* ENTER → SHOP PAGE */
    input.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            const q = this.value.trim();
            if (q) {
                window.location.href = `/shop?q=${encodeURIComponent(q)}`;
            }
        }
    });

    /* LIVE SEARCH */
    let timer;
    input.addEventListener("keyup", function () {
        clearTimeout(timer);
        const q = this.value.trim();

        if (q.length < 2) {
            suggestionsWrap.style.display = "none";
            productsWrap.style.display = "none";
            emptyBox.style.display = "none";
            return;
        }

        timer = setTimeout(() => {
            fetch(`/ajax-search?q=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(data => {

                    suggestionsBox.innerHTML = "";
                    productsBox.innerHTML = "";
                    emptyBox.style.display = "none";

                    /* Suggestions */
                    if (data.suggestions.length) {
                        suggestionsWrap.style.display = "block";
                        data.suggestions.forEach(item => {
                            suggestionsBox.innerHTML += `<li>${item}</li>`;
                        });
                    } else {
                        suggestionsWrap.style.display = "none";
                    }

                    /* Products */
                    if (data.products.length) {
                        productsWrap.style.display = "block";

                        data.products.forEach(p => {
                            productsBox.innerHTML += `
                                <div class="">
                                    <div class="product product-11 text-center product-manual">
                                        <figure class="product-media">
                                            <a href="/shop-product-detail/${p.slug}">
                                                <img src="${p.image}" class="product-image product-image-manual">
                                            </a>
                                        </figure>

                                        <div class="product-body">
                                            <h3 class="product-title">
                                                <a href="/shop-product-detail/${p.slug}">
                                                    ${p.name}
                                                </a>
                                            </h3>
                                            <div class="product-price">
                                                ₹ ${p.price}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                    } else if (!data.suggestions.length) {
                        emptyBox.style.display = "block";
                    }
                });
        }, 300);
    });

});
</script>

