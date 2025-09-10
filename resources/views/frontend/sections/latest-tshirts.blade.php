
    <div class="container text-center">
        <h3>Latest Tshirts</h3>
    </div>

    <div class="container-fluid">
        <div class="tab-content tab-content-carousel">
            <div class="tab-pane p-0 fade show active" id="products-featured-tab" role="tabpanel"
                aria-labelledby="products-featured-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                    data-owl-options='{
                                "nav": false, 
                                "dots": true,
                                "margin": 20,
                                "loop": false,
                                "responsive": {
                                    "0": {
                                        "items":2
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
                                        "items":5
                                    },
                                    "1600": {
                                        "items":6,
                                        "nav": true
                                    }
                                }
                            }'>
                    @foreach($clothes as $products)
                    <div class="product product-11 text-center product-manual">
                        <figure class="product-media">
                            <a href="{{url('shop-product-detail/'.$products->id)}}">
                                <img src="{{ asset('storage/' . $products->featured_image) }}" alt="Product image"
                                    class="product-image product-image-manual">
                            </a>

                            
                                <div class="product-action-vertical">
                                    <button type="button"
                                        class="btn-product-icon btn-wishlist btn-expandable add-to-wishlist"
                                        data-product-id="{{ $products->id }}">
                                        <span>Add to wishlist</span>
                                    </button>
                                </div>
                        </figure>

                        <div class="product-body">
                            <h3 class="product-title"><a href="{{url('shop-product-detail/'.$products->id)}}">{{$products->name}}</a></h3>
                            <div class="product-price">
                                ₹ {{$products->discounted_price}} <span
                                    style="font-size: 12px;"><del>{{$products->discounted_price}} </del></span>
                            </div>
                        </div>

                        <div class="product-action">
                                <input type="hidden" id="product-id-{{ $products->id }}" value="{{ $products->id }}">
                                <input type="hidden" id="quantity-{{ $products->id }}" value="1">
                                <button type="button" class="btn-product btn-cart"
                                    onclick="addToCart({{ $products->id }})">
                                    <span>add to cart</span>
                                </button>
                            </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    