<style>
.ll-carousel .item{
    padding:6px;
    display:flex;
    height:100%;
}

.ll-carousel .owl-stage{
    display:flex;
}

.ll-carousel .owl-item{
    display:flex;
    height:auto;
}

.ll-card{
    width:100%;
    display:flex;
    flex-direction:column;
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
    transition:.25s;
}

.ll-card:hover{
    transform:translateY(-5px);
}

.ll-image{
    position:relative;
    padding:8px;
}

.ll-image-box{
    width:100%;
    aspect-ratio:1;
    background:#f8f8f8;
    border-radius:14px;
    overflow:hidden;
}

.ll-image-box img{
    width:100%;
    height:100%;
    object-fit:contain;
    padding:10px;
}

.ll-badge{
    position:absolute;
    top:14px;
    left:14px;
    font-size:10px;
    font-weight:600;
    padding:4px 9px;
    border-radius:30px;
    background:#ff5722;
    color:#fff;
}

.ll-badge.green{
    background:#43a047;
}

.ll-wishlist{
    position:absolute;
    top:14px;
    right:14px;
    width:34px;
    height:34px;
    border-radius:50%;
    border:none;
    background:#fff;
    box-shadow:0 2px 8px rgba(0,0,0,.12);
}

.ll-body{
    display:flex;
    flex-direction:column;
    flex:1;
    padding:12px;
}

.ll-body h3{
    font-size:15px;
    line-height:1.4;
    margin:0 0 8px;
    min-height:42px;

    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.ll-body h3 a{
    color:#222;
    text-decoration:none;
}

.ll-rating{
    display:flex;
    align-items:center;
    gap:4px;
    font-size:13px;
    margin-bottom:8px;
}

.ll-rating i{
    color:#ff9800;
}

.ll-price{
    display:flex;
    align-items:center;
    gap:8px;
    margin-bottom:12px;
}

.ll-price .sale{
    font-size:24px;
    font-weight:700;
}

.ll-price .old{
    font-size:14px;
    color:#999;
    text-decoration:line-through;
}

.ll-footer{
    display:flex;
    gap:8px;
    margin-top:auto;
}

.ll-footer .shop{
    flex:1;
    height:42px;
    border:none;
    border-radius:10px;
    background:#4CAF50;
    color:#fff;
    font-weight:600;
}

.ll-footer .cart{
    width:42px;
    height:42px;
    border-radius:10px;
    background:#f5f5f5;
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
    color:#333;
}

.ll-carousel .owl-stage-outer{
    padding:8px 2px 16px;
}

@media(max-width:576px){

    .container-fluid{
        padding-left:6px;
        padding-right:6px;
    }

    .ll-carousel .item{
        padding:4px;
    }

    .ll-image{
        padding:6px;
    }

    .ll-body{
        padding:9px;
    }

    .ll-body h3{
        font-size:13px;
        min-height:36px;
    }

    .ll-rating{
        font-size:11px;
        margin-bottom:6px;
    }

    .ll-price{
        margin-bottom:8px;
    }

    .ll-price .sale{
        font-size:19px;
    }

    .ll-price .old{
        font-size:11px;
    }

    .ll-footer{
        gap:6px;
    }

    .ll-footer .shop{
        height:36px;
        font-size:12px;
    }

    .ll-footer .cart{
        width:36px;
        height:36px;
    }

    .ll-badge{
        top:10px;
        left:10px;
        font-size:9px;
    }

    .ll-wishlist{
        top:10px;
        right:10px;
        width:30px;
        height:30px;
    }
}
</style>
<div class="container text-center" style="margin-top: 20px;">



    <div class="heading d-flex justify-content-between align-items-center mb-3">
        <h2 class="title mb-0">{{$title}}</h2>

        <a href="{{ url('shop') }}" class="view-all">
            View All <i class="icon-long-arrow-right"></i>
        </a>

    </div>
</div>
<div class="container-fluid">
    <div class="tab-content tab-content-carousel">
        <div class="tab-pane p-0 fade show active" id="products-featured-tab" role="tabpanel"
            aria-labelledby="products-featured-link">
<div class="owl-carousel ll-carousel"
data-toggle="owl"
data-owl-options='{
    "nav":false,
    "dots":false,
    "loop":false,
    "responsive":{
        "0":{
            "items":1.35,
            "margin":12
        },
        "480":{
            "items":2,
            "margin":12
        },
        "768":{
            "items":3,
            "margin":16
        },
        "992":{
            "items":4,
            "margin":20
        },
        "1200":{
            "items":5,
            "margin":20
        },
        "1600":{
            "items":6,
            "margin":20
        }
    }
}'>

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

                                    <img src="{{ asset('storage/'.$product->featured_image) }}">

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

                            <div class="ll-footer" style="gap: 10px;">

                                    <!-- <div class="delivery">

                                        <i class="fas fa-check-circle"></i>

                                        Delivery in 2 Days

                                    </div> -->
                                    <button type="button" class="shop btn btn-primary buyNow"
                                        data-product-id="{{ $product->id }}" >
                                        Buy Now
                                    </button>

                                
                                    @include('frontend.buttons.addtocart', ['product' => $product])

                            </div>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>
        </div>

    </div>
</div>