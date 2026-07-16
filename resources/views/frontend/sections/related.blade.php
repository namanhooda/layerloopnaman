<style>
    .product.ll-card{
    background:#fff;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.08);
    transition:.3s;
    border:1px solid #ececec;
    height:100%;
}

.product.ll-card:hover{
    transform:translateY(-6px);
    box-shadow:0 20px 45px rgba(0,0,0,.12);
}

.product-media{
    position:relative;
    background:#f5f6f8;
}

.product-media img{
    width:100%;
    height:250px;
    object-fit:cover;
    border-radius:18px;
    display:block;
}

.ll-badge{
    position:absolute;
    left:18px;
    top:18px;
    background:#47b84d;
    color:#fff;
    padding:8px 16px;
    border-radius:50px;
    font-size:12px;
    font-weight:700;
    letter-spacing:.5px;
    z-index:5;
}

.ll-wishlist{
    position:absolute;
    top:18px;
    right:18px;
    width:42px;
    height:42px;
    border:none;
    border-radius:50%;
    background:#222;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:5;
}

.ll-content{
    padding:18px;
}

.ll-title{
    font-size:15px;
    line-height:1.4;
    font-weight:550;
    height:41px;
    overflow:hidden;
}

.ll-title a{
    color:#222;
    text-decoration:none;
}

.ll-rating{
    color:#ff9b21;
    font-weight:600;
}

.ll-rating span{
    color:#999;
    font-size:14px;
}

.ll-price{
    font-size:23px;
    font-weight:700;
    color:#1e1e1e;
}

.ll-bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.ll-delivery{
    color:#45b649;
    font-size:15px;
    display:flex;
    align-items:center;
    gap:6px;
}

.ll-cart{
    width:48px;
    height:48px;
    border:none;
    border-radius:16px;
    background:#4CAF50;
    color:#fff;
    font-size:20px;
}

.ll-cart:hover{
    background:#3ea344;
}
</style>

<div class="container">
    <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
    <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "480": {
                                    "items":2
                                },
                                "768": {
                                    "items":3
                                },
                                "992": {
                                    "items":4
                                },
                                "1200": {
                                    "items":4,
                                    "nav": true,
                                    "dots": false
                                }
                            }
                        }'>
        @foreach($related as $product)

        <div class="product ll-card">

    <figure class="product-media">

        <span class="ll-badge">NEW</span>

        <button
            class="ll-wishlist add-to-wishlist "
            data-product-id="{{ $product->id }}">
            <i class="icon-heart-o"></i>
        </button>

        <a href="{{ url('shop-product-detail/'.$product->slug) }}">
            <img src="{{ asset('storage/'.$product->featured_image) }}"
                class="product-image"
                alt="{{ $product->name }}">
        </a>

    </figure>

    <div class="ll-content">

        <h3 class="ll-title">
            <a href="{{ url('shop-product-detail/'.$product->slug) }}">
                {{$product->name}}
            </a>
        </h3>

        <div class="ll-rating">
            ⭐ 4.8 <span>(205)</span>
        </div>

        <div class="ll-price">
            ₹{{ number_format($product->discounted_price,2) }}
        </div>

        <div class="ll-bottom">

                                    <!-- <div class="delivery">

                                        <i class="fas fa-check-circle"></i>

                                        Delivery in 2 Days

                                    </div> -->
                                    <button type="button" class="shop btn btn-primary buyNow"
                                        data-product-id="{{ $product->id }}">
                                        Buy Now
                                    </button>

            <button class="ll-cart">
                <i class="icon-shopping-cart"></i>
            </button>

        </div>

    </div>

</div>
        @endforeach

    </div><!-- End .owl-carousel -->
</div>
