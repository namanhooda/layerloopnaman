<style>
    .ll-carousel .item {
        padding: 8px;
    }

    .ll-carousel .owl-stage {
        display: flex;
    }

    .ll-carousel .owl-item {
        display: flex;
    }

    .ll-carousel .ll-card {
        width: 100%;
    }

    .ll-carousel .owl-nav {
        margin-top: 25px;
    }

    .ll-carousel .owl-nav button {
        width: 44px;
        height: 44px;
        border-radius: 50% !important;
        background: #fff !important;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .12);
    }

    .ll-carousel .owl-nav button:hover {
        background: #4CAF50 !important;
        color: #fff !important;
    }

    .ll-carousel .owl-stage-outer {
        padding: 10px 5px 20px;
    }

</style>
<div class="container text-center">



    <div class="heading d-flex justify-content-between align-items-center mb-3">
        <h2 class="title mb-0">Trending Now</h2>

        <a href="{{ url('shop') }}" class="view-all">
            View All <i class="icon-long-arrow-right"></i>
        </a>

    </div>
</div>


<div class="container-fluid">
    <div class="tab-content tab-content-carousel">
        <div class="tab-pane p-0 fade show active" id="products-featured-tab" role="tabpanel"
            aria-labelledby="products-featured-link">
            <div class="owl-carousel ll-carousel" data-toggle="owl" data-owl-options='{
        "nav": false,
        "dots": false,
        "margin":20,
        "loop":false,
        "responsive":{
            "0":{"items":2},
            "480":{"items":2},
            "768":{"items":3},
            "992":{"items":4},
            "1200":{"items":5},
            "1600":{"items":6}
        }
    }'>

                @foreach($featured as $product)

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

                <div class="item">

                    <div class="ll-card">

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

                                <i class="{{ $isInWishlist ? 'fas':'far' }} fa-heart"></i>

                            </button>

                            <a href="{{ url('shop-product-detail/'.$product->slug) }}">

                                <div class="ll-image-box">

                                    <img src="{{ asset('storage/'.$product->featured_image) }}" loading="lazy"
                                        alt="{{ $product->name }}"
                                        onerror="this.src='{{ asset('assets/images/no-image.png') }}';">

                                </div>

                            </a>

                        </div>

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

    </div>
</div>
