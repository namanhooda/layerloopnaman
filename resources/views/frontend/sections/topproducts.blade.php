<style>
    /*=============================
    LayerLoop Product Card
  ==============================*/

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

</style>

<div class="container">
    <div class="heading heading-center mb-3">
        <h2 class="title">Top Selling Products</h2><!-- End .title -->

        <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">

            <!-- <li class="nav-item">
                    <a class="nav-link" id="top-fur-link" data-toggle="tab" href="#top-fur-tab" role="tab"
                        aria-controls="top-fur-tab" aria-selected="false">Furniture</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="top-decor-link" data-toggle="tab" href="#top-decor-tab" role="tab"
                        aria-controls="top-decor-tab" aria-selected="false">Decoration</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="top-light-link" data-toggle="tab" href="#top-light-tab" role="tab"
                        aria-controls="top-light-tab" aria-selected="false">Lighting</a>
                </li> -->
        </ul>
    </div><!-- End .heading -->

    <div class="tab-content">
        <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
            <div class="products">
                <div class="row g-4">

                    @foreach($sale as $product)

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
        </div><!-- .End .tab-pane -->
        <div class="tab-pane p-0 fade" id="top-fur-tab" role="tabpanel" aria-labelledby="top-fur-link">
            <div class="products">
                <div class="row justify-content-center">
                    <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                        <div class="product product-11 text-center">
                            <figure class="product-media">
                                <span class="product-label label-circle label-sale">Sale</span>
                                <a href="#">
                                    <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-9-1.jpg')}}"
                                        alt="Product image" class="product-image">
                                    <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-9-2.jpg')}}"
                                        alt="Product image" class="product-image-hover">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                            wishlist</span></a>
                                </div><!-- End .product-action-vertical -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#" class="prodcatlink">Furniture</a>
                                </div>
                                <h3 class="product-title"><a href="#">Garden Armchair</a></h3>
                                <!-- End .product-title -->
                                <div class="product-price">
                                    <span class="new-price">$94,00</span>
                                    <span class="old-price">Was $94,00</span>
                                </div><!-- End .product-price -->
                            </div><!-- End .product-body -->
                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                            </div><!-- End .product-action -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

                    <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                        <div class="product product-11 text-center">
                            <figure class="product-media">
                                <span class="product-label label-circle label-new">New</span>
                                <a href="#">
                                    <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-12-1.jpg')}}"
                                        alt="Product image" class="product-image">
                                    <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-12-2.jpg')}}"
                                        alt="Product image" class="product-image-hover">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                            wishlist</span></a>
                                </div><!-- End .product-action-vertical -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#" class="prodcatlink">Furniture</a>
                                </div>
                                <h3 class="product-title"><a href="#">2-Seater</a></h3>
                                <!-- End .product-title -->
                                <div class="product-price">
                                    $3.107,00
                                </div><!-- End .product-price -->
                            </div><!-- End .product-body -->
                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                            </div><!-- End .product-action -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->

                    <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                        <div class="product product-11 text-center">
                            <figure class="product-media">
                                <a href="#">
                                    <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-13-1.jpg')}}"
                                        alt="Product image" class="product-image">
                                    <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-13-2.jpg')}}"
                                        alt="Product image" class="product-image-hover">
                                </a>

                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                            wishlist</span></a>
                                </div><!-- End .product-action-vertical -->
                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#" class="prodcatlink">Furniture</a>
                                </div>
                                <h3 class="product-title"><a href="#">Wingback Chair</a></h3>
                                <!-- End .product-title -->
                                <div class="product-price">
                                    $2.486,00
                                </div><!-- End .product-price -->
                            </div><!-- End .product-body -->
                            <div class="product-action">
                                <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                            </div><!-- End .product-action -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .products -->
        </div><!-- .End .tab-pane -->
        
    </div><!-- End .tab-content -->
</div><!-- End .container -->
