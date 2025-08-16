<header class="header header-2 header-intro-clearance">
<style>
    @media screen and (min-width: 768px) {
        .desktop-logo {
            width: 24% !important;
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
            </div><!-- End .header-left -->

            <div class="header-center">
                <div
                    class="header-search header-search-extended header-search-visible header-search-no-radius d-none d-lg-block">
                    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                    <form action="{{ route('shop') }}" method="get" autocomplete="off">
                        <div class="header-search-wrapper search-wrapper-wide position-relative">
                            <label for="q" class="sr-only">Search</label>
                            <input type="search" class="form-control" name="q" id="product-search" placeholder="Search product ..."
                                value="{{ request('q') }}" required>
                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>

                            <ul id="search-results" class="list-group position-absolute w-100 mt-1" style="z-index: 1000; display: none;"></ul>
                        </div>
                    </form>
                </div><!-- End .header-search -->
            </div>

            <div class="header-right">
                <div class="account">
                    <a href="{{url('account')}}" title="My account">
                        <div class="icon">
                            <i class="icon-user"></i>
                        </div>
                        <p>Account</p>
                    </a>
                </div><!-- End .compare-dropdown -->

                <div class="wishlist">
                    <a href="{{url('wishlist')}}" title="Wishlist">
                        <div class="icon">
                            <i class="icon-heart-o"></i>
                            <span class="wishlist-count badge">3</span>
                        </div>
                        <p>Wishlist</p>
                    </a>
                </div><!-- End .compare-dropdown -->

                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" data-display="static">
                        <div class="icon">
                            <i class="icon-shopping-cart"></i>
                            <span class="cart-count">{{ \App\Helpers\CartHelper::getCartCount() }}</span>
                        </div>
                        <p>Cart</p>
                    </a>
                    @php
                    $cartItems = \App\Helpers\CartHelper::getCart();
                    @endphp
                    <div class="dropdown-menu dropdown-menu-right">
                        @php
                        $total = 0;
                        @endphp

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
                                </div><!-- End .product-cart-details -->

                                <figure class="product-image-container">
                                    <a href="{{ url('product/' . $item['product']->slug) }}" class="product-image">
                                        <img src="{{ asset('storage/' . $item['product']->featured_image) }}"
                                            alt="product" style="width: 60px; height: auto;">
                                    </a>
                                </figure>

                                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-remove" title="Remove Product">
                                        <i class="icon-close"></i>
                                    </button>
                                </form>
                            </div><!-- End .product -->
                            @endforeach
                            @else
                            <p class="text-center">Your cart is empty.</p>
                            @endif
                        </div><!-- End .dropdown-cart-products -->

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
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .cart-dropdown -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->

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
                                <li class="item-lead"><a href="{{ route('shop', ['filter' => 'clothing']) }}">Clothes</a></li>
                                <li class="item-lead"><a href="{{url('category/tshirts')}}">Tshirts</a></li>

                                    @php
                                    $getCaregories = \App\Helpers\CartHelper::getCaregories();
                                    @endphp
                                @foreach($getCaregories as $categories)
                                <li><a href="{{url('category/'.$categories->slug)}}">{{$categories->name}}</a></li>
                                @endforeach
                            </ul><!-- End .menu-vertical -->
                        </nav><!-- End .side-nav -->
                    </div><!-- End .dropdown-menu -->
                </div><!-- End .category-dropdown -->
            </div><!-- End .header-left -->

            <div class="header-center">
                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container active">
                            <a href="{{url('/')}}" style="font-size: 20px !important;">Home</a>
                        </li>
                        <li>
                            <a href="{{url('shop')}}" style="font-size: 20px !important;">Shop</a>

                        </li>
                        <li>
                            <a href="#" class="sf-with-ul" style="font-size: 20px !important;">Pages</a>

                            <ul>
                                <li>
                                    <a href="{{url('about')}}" class="sf-with-ul">About</a>
                                </li>
                                <li>
                                    <a href="{{url('contact_us')}}" class="sf-with-ul">Contact</a>
                                </li>
                                <li><a href="{{url('login')}}">Login</a></li>
                                <li><a href="{{url('faq')}}">FAQs</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{url('blogs')}}" style="font-size: 20px !important;">Blog</a>
                        </li>
                    </ul><!-- End .menu -->
                </nav><!-- End .main-nav -->
            </div><!-- End .header-center -->

            <div class="header-right" style="font-size: 20px !important;">
                <i class="la la-lightbulb-o"></i>
                <p>Clearance<span class="highlight">&nbsp;Up to 30% Off</span></p>
            </div>
        </div><!-- End .container -->
    </div><!-- End .header-bottom -->
</header><!-- End .header -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('product-search');
    const resultList = document.getElementById('search-results');

    input.addEventListener('input', function () {
        const query = input.value;

        if (query.length < 3) {
            resultList.style.display = 'none';
            resultList.innerHTML = '';
            return;
        }

        fetch(`/search-suggestions?q=${query}`)
            .then(response => response.json())
            .then(data => {
                resultList.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(product => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item', 'list-group-item-action');
                        li.textContent = product.name;
                        li.style.cursor = 'pointer';
                        li.onclick = () => {
                            window.location.href = `/shop-product-detail/${product.id}`; // Or use ID
                        };
                        resultList.appendChild(li);
                    });
                    resultList.style.display = 'block';
                } else {
                    resultList.style.display = 'none';
                }
            });
    });

    document.addEventListener('click', function (e) {
        if (!input.contains(e.target) && !resultList.contains(e.target)) {
            resultList.style.display = 'none';
        }
    });
});

</script>