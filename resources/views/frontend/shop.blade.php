@extends('frontend.partials.app')
@section('content')

<style>

        .ll-card {
        position: relative;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #ececec;
        transition: .35s;
        height: 100%;
        width: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 5px 18px rgba(0, 0, 0, .06);
    }

    .ll-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, .12);
    }

    /* IMAGE */

    .ll-image {
        position: relative;
        /* padding:12px; */
        background: #fff;
    }

    .ll-image a {
        display: block;
    }

    .ll-image img {

        width: 100%;
        aspect-ratio: 1/1;

        object-fit: cover;

        border-radius: 18px;

        background: #f4f4f4;

        transition: .4s;
    }

    .ll-card:hover .ll-image img {

        transform: scale(1.05);

    }

    /* Badge */

    .ll-badge {

        position: absolute;

        left: 20px;

        top: 20px;

        z-index: 5;

        background: #ff6b35;

        color: #fff;

        padding: 6px 12px;

        border-radius: 20px;

        font-size: 11px;

        font-weight: 700;

        letter-spacing: .3px;
    }

    .ll-badge.green {

        background: #2fb344;

    }

    /* Wishlist */

    .ll-wishlist {

        position: absolute;

        right: 20px;

        top: 20px;

        width: 38px;

        height: 38px;

        border: none;

        border-radius: 50%;

        background: rgba(0, 0, 0, .75);

        color: #fff;

        display: flex;

        align-items: center;

        justify-content: center;

        z-index: 10;

        transition: .3s;

        cursor: pointer;
    }

    .ll-wishlist:hover {

        background: #111;

    }

    .ll-wishlist.active {

        background: #ff4d6d;

    }

    /* BODY */

    .ll-body {

        padding: 15px 18px 18px;

        display: flex;

        flex-direction: column;

        flex: 1;
    }

    /* TITLE */

    .ll-body h3 {

        margin: 0;

        font-size: 15px;

        font-weight: 550;

        line-height: 1.45;

        height: 46px;

        overflow: hidden;
    }

    .ll-body h3 a {

        color: #222;

        text-decoration: none;
    }

    .ll-body h3 a:hover {

        color: #2fb344;
    }

    /* Rating */

    .ll-rating {


        display: flex;

        align-items: center;

        gap: 5px;

        font-size: 14px;
    }

    .ll-rating i {

        color: #ff9800;
    }

    .ll-rating span {

        color: #ff9800;

        font-weight: 600;
    }

    .ll-rating small {

        color: #999;
    }

    /* Price */

    .ll-price {

        display: flex;

        align-items: center;

        flex-wrap: wrap;

        gap: 8px;

    }

    .ll-price .sale {

        font-size: 23px;

        font-weight: 600;

        color: #111;
    }

    .ll-price .old {

        font-size: 15px;

        color: #999;

        text-decoration: line-through;
    }

    /* Footer */

    .ll-footer {

        margin-top: auto;

        display: flex;

        justify-content: space-between;

        align-items: center;

    }

    .delivery {

        color: #38b000;

        font-size: 14px;

        display: flex;

        align-items: center;

        gap: 6px;
    }

    .delivery i {

        font-size: 15px;
    }

    /* Cart */

    .cart {

        width: 46px;

        height: 46px;

        border-radius: 14px;

        background: #4CAF50;

        color: #fff;

        display: flex;

        align-items: center;

        justify-content: center;

        font-size: 18px;

        transition: .3s;

        text-decoration: none;
    }

    .cart:hover {

        background: #222;

        color: #fff;
    }

    /* Mobile */

    @media(max-width:991px) {

        .ll-card {

            border-radius: 18px;

        }

        .ll-image {

            padding: 10px;

        }

        .ll-body {

            padding: 14px;

        }

        .ll-body h3 {

            font-size: 14px;

            height: 40px;

        }

        .ll-price .sale {

            font-size: 24px;

        }

        .delivery {

            font-size: 12px;

        }

        .cart {

            width: 40px;

            height: 40px;

            font-size: 15px;

        }

        .ll-badge {

            font-size: 10px;

            padding: 5px 10px;

            left: 15px;

            top: 15px;

        }

        .ll-wishlist {

            width: 34px;

            height: 34px;

            top: 15px;

            right: 15px;

        }

    }

    .btn-product.btn-cart {
        border: none !important;
        outline: none;
        background-color: transparent;
        /* Optional if you want no background */
        box-shadow: none;
        /* Optional if you want to remove any shadow */
    }

    .toolbox {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: nowrap;
    }

    .toolbox-left,
    .toolbox-right {
        display: flex;
        align-items: center;
    }

    /* Mobile fix */
    @media (max-width: 768px) {
        .toolbox {
            flex-direction: row;
            gap: 8px;
        }

        .toolbox-left,
        .toolbox-right {
            width: auto;
        }

        .toolbox-sort label {
            display: none;
            /* optional: hide label to save space */
        }

        #sortby {
            min-width: 120px;
        }
    }

    /*=========================
CATEGORY PILLS
=========================*/

    .ll-category-section {

        padding: 20px 0;

        background: #fff;

    }

    .ll-category-scroll {

        display: flex;

        align-items: center;

        gap: 14px;

        overflow-x: auto;

        overflow-y: hidden;

        scrollbar-width: none;

        -webkit-overflow-scrolling: touch;

        padding-bottom: 8px;

    }

    .ll-category-scroll::-webkit-scrollbar {

        display: none;

    }

    .ll-category-pill {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        white-space: nowrap;

        height: 48px;

        padding: 0 24px;

        border-radius: 40px;

        background: #fff;

        border: 1px solid #ececec;

        color: #222;

        font-size: 15px;

        font-weight: 600;

        text-decoration: none;

        transition: .3s;

        box-shadow: 0 5px 20px rgba(0, 0, 0, .05);

    }

    .ll-category-pill:hover {

        color: #22C55E;

        transform: translateY(-2px);

        text-decoration: none;

    }

    .ll-category-pill.active {

        background: #22C55E;

        color: #fff;

        border-color: #22C55E;

    }

    .ll-category-more {

        min-width: 60px;

        height: 48px;

        padding: 0 18px;

        border: none;

        border-radius: 40px;

        background: #fff;

        box-shadow: 0 5px 20px rgba(0, 0, 0, .06);

        font-weight: 600;

        cursor: pointer;

        transition: .3s;

    }

    .ll-category-more:hover {

        background: #22C55E;

        color: #fff;

    }

    /*=========================
TABLET
=========================*/

    @media(max-width:991px) {

        .ll-category-pill {

            padding: 0 20px;

            height: 46px;

            font-size: 14px;

        }

    }

    /*=========================
MOBILE
=========================*/

    @media(max-width:767px) {

        .ll-category-section {

            padding: 0px 0;

        }

        .ll-category-scroll {

            gap: 10px;

        }

        .ll-category-pill {

            height: 44px;

            padding: 0 18px;

            font-size: 14px;

        }

        .ll-category-more {

            width: 44px;

            height: 44px;

            padding: 0;

            border-radius: 14px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 18px;

        }

        .ll-category-more i {

            margin: 0 !important;

        }

        .ll-category-more {

            font-size: 0;

        }

        .ll-category-more i {

            font-size: 18px;

        }

    }

</style>
<main class="main">
    @include('frontend.breadcums.shop', ['pageTitle' => 'Shop'])
    <div class="ll-category-section">

        <div class="container">

            <div class="ll-category-scroll">

                <a href="{{ route('shop') }}" class="ll-category-pill {{ request('filter') == null ? 'active' : '' }}">
                    All Products
                </a>

                <a href="{{ route('shop',['filter'=>'murti']) }}"
                    class="ll-category-pill {{ request('filter') == 'murti' ? 'active' : '' }}">
                    Murti
                </a>

                <a href="{{ route('shop',['filter'=>'lithophane']) }}"
                    class="ll-category-pill {{ request('filter') == 'lithophane' ? 'active' : '' }}">
                    Lithophane
                </a>

                <a href="{{ route('shop',['filter'=>'anime']) }}"
                    class="ll-category-pill {{ request('filter') == 'anime' ? 'active' : '' }}">
                    Anime Figures
                </a>

                <a href="{{ route('shop',['filter'=>'miniatures']) }}"
                    class="ll-category-pill {{ request('filter') == 'miniatures' ? 'active' : '' }}">
                    Miniatures
                </a>

                <a href="{{ route('shop',['filter'=>'lamps']) }}"
                    class="ll-category-pill {{ request('filter') == 'lamps' ? 'active' : '' }}">
                    Lamps & Lights
                </a>

                <a href="{{ route('shop',['filter'=>'wall-art']) }}"
                    class="ll-category-pill {{ request('filter') == 'wall-art' ? 'active' : '' }}">
                    Wall Art
                </a>

                <a href="{{ route('shop',['filter'=>'tshirts']) }}"
                    class="ll-category-pill {{ request('filter') == 'tshirts' ? 'active' : '' }}">
                    T-Shirts
                </a>

                <button class="ll-category-more">
                    More
                    <i class="fas fa-chevron-down ml-2"></i>
                </button>

            </div>

        </div>

    </div>
    <div class="page-content">
        <div class="container">

            <div class="products">
                <div class="row g-4">

                    @foreach($products as $product)

                    @php
                    $price = $product->price ?? $product->discounted_price;
                    $salePrice = $product->discounted_price;

                    $discount = 0;
                    if($price > $salePrice){
                    $discount = round((($price-$salePrice)/$price)*100);
                    }

                    $isInWishlist = \App\Models\Wishlist::where(function ($query) {
                    if(auth()->check()){
                    $query->where('user_id',auth()->id());
                    }else{
                    $query->where('system_id',hash('sha256',request()->userAgent().'|'.request()->ip()));
                    }
                    })
                    ->where('product_id',$product->id)
                    ->exists();
                    @endphp

                    <div class="col-6 col-md-4 col-lg-3">

                        <div class="ll-card">

                            {{-- Image --}}
                            <div class="ll-image">

                                @if($discount>0)
                                <span class="ll-badge">
                                    {{ $discount }}% OFF
                                </span>
                                @else
                                <span class="ll-badge green">
                                    NEW
                                </span>
                                @endif


                                <button
                                    class="ll-wishlist add-to-wishlist {{ $isInWishlist ? 'active wishlist-active' : '' }}"
                                    data-product-id="{{ $product->id }}">

                                    <i class="{{ $isInWishlist ? 'fas' : 'far' }} fa-heart"></i>

                                </button>

                                <a href="{{ url('shop-product-detail/'.$product->slug) }}">

                                    <div class="ll-image-box">

                                        <img src="{{ asset('storage/'.$product->featured_image) }}"
                                            alt="{{ $product->name }}" loading="lazy"
                                            onerror="this.src='{{ asset('assets/images/no-image.png') }}';">

                                    </div>

                                </a>

                            </div>

                            {{-- Body --}}

                            <div class="ll-body">

                                <h3>

                                    <a href="{{ url('shop-product-detail/'.$product->slug) }}">
                                        {{ $product->name }}
                                    </a>

                                </h3>

                                <div class="ll-rating">

                                    <i class="fas fa-star"></i>

                                    <span>4.8</span>

                                    <small>(205)</small>

                                </div>

                                <div class="ll-price">

                                    <span class="sale">

                                        ₹{{ number_format($salePrice,2) }}

                                    </span>

                                    @if($price>$salePrice)

                                    <span class="old">

                                        ₹{{ number_format($price,2) }}

                                    </span>

                                    @endif

                                </div>

                                <div class="ll-footer">

                                    <div class="delivery">

                                        <i class="fas fa-check-circle"></i>

                                        Delivery in 2 Days

                                    </div>

                                    <a href="#" class="cart">

                                        <i class="fas fa-shopping-cart"></i>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                    @endforeach

                </div>
            </div>
            <div class="sidebar-filter-overlay"></div><!-- End .sidebar-filter-overlay -->
            <aside class="sidebar-shop sidebar-filter">
                <div class="sidebar-filter-wrapper">
                    <div class="widget widget-clean">
                        <label><i class="icon-close"></i>Filters</label>
                        <a href="#" class="sidebar-filter-clear">Clean All</a>
                    </div><!-- End .widget -->
                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true"
                                aria-controls="widget-1">
                                Category
                            </a>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-1">
                            <div class="widget-body">
                                <div class="filter-items filter-items-count">
                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-1">
                                            <label class="custom-control-label" for="cat-1">Dresses</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">3</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-2">
                                            <label class="custom-control-label" for="cat-2">T-shirts</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">0</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-3">
                                            <label class="custom-control-label" for="cat-3">Bags</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">4</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-4">
                                            <label class="custom-control-label" for="cat-4">Jackets</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">2</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-5">
                                            <label class="custom-control-label" for="cat-5">Shoes</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">2</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-6">
                                            <label class="custom-control-label" for="cat-6">Jumpers</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">1</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-7">
                                            <label class="custom-control-label" for="cat-7">Jeans</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">1</span>
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="cat-8">
                                            <label class="custom-control-label" for="cat-8">Sportwear</label>
                                        </div><!-- End .custom-checkbox -->
                                        <span class="item-count">0</span>
                                    </div><!-- End .filter-item -->
                                </div><!-- End .filter-items -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse -->
                    </div><!-- End .widget -->

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true"
                                aria-controls="widget-2">
                                Size
                            </a>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-2">
                            <div class="widget-body">
                                <div class="filter-items">
                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="size-1">
                                            <label class="custom-control-label" for="size-1">XS</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="size-2">
                                            <label class="custom-control-label" for="size-2">S</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" checked id="size-3">
                                            <label class="custom-control-label" for="size-3">M</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" checked id="size-4">
                                            <label class="custom-control-label" for="size-4">L</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="size-5">
                                            <label class="custom-control-label" for="size-5">XL</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="size-6">
                                            <label class="custom-control-label" for="size-6">XXL</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->
                                </div><!-- End .filter-items -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse -->
                    </div><!-- End .widget -->

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true"
                                aria-controls="widget-3">
                                Colour
                            </a>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-3">
                            <div class="widget-body">
                                <div class="filter-colors">
                                    <a href="#" style="background: #b87145;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #f0c04a;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #333333;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" class="selected" style="background: #cc3333;"><span
                                            class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #3399cc;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #669933;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #f2719c;"><span class="sr-only">Color Name</span></a>
                                    <a href="#" style="background: #ebebeb;"><span class="sr-only">Color Name</span></a>
                                </div><!-- End .filter-colors -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse -->
                    </div><!-- End .widget -->

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true"
                                aria-controls="widget-4">
                                Brand
                            </a>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-4">
                            <div class="widget-body">
                                <div class="filter-items">
                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-1">
                                            <label class="custom-control-label" for="brand-1">Next</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-2">
                                            <label class="custom-control-label" for="brand-2">River Island</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-3">
                                            <label class="custom-control-label" for="brand-3">Geox</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-4">
                                            <label class="custom-control-label" for="brand-4">New Balance</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-5">
                                            <label class="custom-control-label" for="brand-5">UGG</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-6">
                                            <label class="custom-control-label" for="brand-6">F&F</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                    <div class="filter-item">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="brand-7">
                                            <label class="custom-control-label" for="brand-7">Nike</label>
                                        </div><!-- End .custom-checkbox -->
                                    </div><!-- End .filter-item -->

                                </div><!-- End .filter-items -->
                            </div><!-- End .widget-body -->
                        </div><!-- End .collapse -->
                    </div><!-- End .widget -->

                    <div class="widget widget-collapsible">
                        <h3 class="widget-title">
                            <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true"
                                aria-controls="widget-5">
                                Price
                            </a>
                        </h3><!-- End .widget-title -->

                        <div class="collapse show" id="widget-5">
                            <div class="widget-body">
                                <div class="filter-price">
                                    <div class="filter-price-text">
                                        Price Range:
                                        <span id="filter-price-range"></span>
                                    </div><!-- End .filter-price-text -->

                                    <div id="price-slider"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</main>
@endsection
