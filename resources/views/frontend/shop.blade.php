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

        .shop {
            min-width: 100px !important;
        }

    }

    /*=========================
MOBILE
=========================*/

    @media(max-width:767px) {

        .ll-category-section {

            padding: 0px 0;

        }

        .shop {
            min-width: 100px !important;
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

    .shop {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: #4CAF50;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: .3s;
        text-decoration: none;

    }

</style>

<link rel="stylesheet" href="https://checkout-ui.shiprocket.com/assets/styles/shopify.css">
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

                                    <!-- <div class="delivery">

                                        <i class="fas fa-check-circle"></i>

                                        Delivery in 2 Days

                                    </div> -->
                                    <button type="button" class="shop btn btn-primary buyNow"
                                        data-product-id="{{ $product->id }}">
                                        Buy Now
                                    </button>

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

        </div>
    </div>
</main>

@push('scripts')

<script src="https://checkout-ui.shiprocket.com/assets/js/channels/shopify.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        document.querySelectorAll(".buyNow").forEach(function (button) {

            button.addEventListener("click", async function (event) {

                event.preventDefault();

                const productId = this.dataset.productId;

                console.log("Product:", productId);

                try {

                    const response = await fetch("{{ route('shiprocket.token') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    });

                    const data = await response.json();

                    console.log(data);

                    if (!data.success) {

                        alert("Unable to generate Shiprocket token.");

                        return;
                    }

                    if (typeof HeadlessCheckout === "undefined") {

                        alert("Shiprocket Checkout JS not loaded.");

                        return;
                    }

                    HeadlessCheckout.addToCart(
                        event,
                        data.access_token, {
                            fallbackUrl: "{{ url('/checkout') }}",
                            isInitiatedFromApp: false
                        }
                    );

                } catch (error) {

                    console.error(error);

                    alert("Something went wrong.");

                }

            });

        });

    });

</script>

@endpush
@endsection
