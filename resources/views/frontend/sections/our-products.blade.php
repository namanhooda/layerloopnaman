<div class="container text-center">
    <h3>Our Products</h3>
</div>

<div class="container">
    <ul class="nav nav-pills nav-border-anim nav-big justify-content-center mb-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="products-featured-link" data-toggle="tab" href="#products-featured-tab"
                role="tab" aria-controls="products-featured-tab" aria-selected="true">Featured</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="products-sale-link" data-toggle="tab" href="#products-sale-tab" role="tab"
                aria-controls="products-sale-tab" aria-selected="false">On Sale</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="products-top-link" data-toggle="tab" href="#products-top-tab" role="tab"
                aria-controls="products-top-tab" aria-selected="false">Top Rated</a>
        </li>
    </ul>
</div><!-- End .container -->



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
                @foreach($featured as $products)
                <div class="product product-11 text-center product-manual">
                    <figure class="product-media">
                        <a href="{{url('shop-product-detail/'.$products->id)}}">
                            <img src="{{ asset('storage/' . $products->featured_image) }}" alt="Product image"
                                class="product-image product-image-manual">
                            <!-- <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-1-2.jpg')}}"
                                    alt="Product image" class="product-image-hover"> -->
                        </a>



                        <div class="product-action-vertical">
                            @php
                            $isInWishlist = \App\Models\Wishlist::where(function ($query) use ($products) {
                            $userId = auth()->id();
                            $systemId = $userId ? null : hash('sha256', request()->userAgent() . '|' . request()->ip());

                            if ($userId) {
                            $query->where('user_id', $userId);
                            } else {
                            $query->where('system_id', $systemId);
                            }
                            })->where('product_id', $products->id)->exists();
                            @endphp

                            <!-- Wishlist Button -->
                            <button type="button"
                                class="btn-product-icon btn-wishlist {{ $isInWishlist ? 'active' : '' }} btn-expandable add-to-wishlist {{ $isInWishlist ? 'wishlist-active' : '' }}"
                                data-product-id="{{ $products->id }}">
                                <span>{{ $isInWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}</span>
                            </button>
                        </div><!-- End .product-action-vertical -->
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <h3 class="product-title"><a
                                href="{{url('shop-product-detail/'.$products->id)}}">{{$products->name}}</a></h3>
                        <!-- End .product-title -->
                        <div class="product-price">
                            ₹ {{$products->discounted_price}}
                        </div><!-- End .product-price -->
                    </div><!-- End .product-body -->
                    <div class="product-action">
                        <input type="hidden" id="product-id-{{ $products->id }}" value="{{ $products->id }}">
                        <input type="hidden" id="quantity-{{ $products->id }}" value="1">
                        <button type="button" class="btn-product btn-cart" onclick="addToCart({{ $products->id }})">
                            <span>add to cart</span>
                        </button>
                    </div><!-- End .product-action -->
                </div><!-- End .product -->
                @endforeach

            </div><!-- End .owl-carousel -->
        </div><!-- .End .tab-pane -->
        <div class="tab-pane p-0 fade" id="products-sale-tab" role="tabpanel" aria-labelledby="products-sale-link">
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

                @foreach($sale as $products)
                <div class="product product-11 text-center product-manual">
                    <figure class="product-media">
                        <a href="{{url('shop-product-detail/'.$products->id)}}">
                            <img src="{{ asset('storage/' . $products->featured_image) }}" alt="Product image"
                                class="product-image product-image-manual">
                            <!-- <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-1-2.jpg')}}"
                                    alt="Product image" class="product-image-hover"> -->
                        </a>



                        <div class="product-action-vertical">
                            @php
                            $isInWishlist = \App\Models\Wishlist::where(function ($query) use ($products) {
                            $userId = auth()->id();
                            $systemId = $userId ? null : hash('sha256', request()->userAgent() . '|' . request()->ip());

                            if ($userId) {
                            $query->where('user_id', $userId);
                            } else {
                            $query->where('system_id', $systemId);
                            }
                            })->where('product_id', $products->id)->exists();
                            @endphp

                            <!-- Wishlist Button -->
                            <button type="button"
                                class="btn-product-icon btn-wishlist {{ $isInWishlist ? 'active' : '' }} btn-expandable add-to-wishlist {{ $isInWishlist ? 'wishlist-active' : '' }}"
                                data-product-id="{{ $products->id }}">
                                <span>{{ $isInWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}</span>
                            </button>
                        </div><!-- End .product-action-vertical -->
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <h3 class="product-title"><a
                                href="{{url('shop-product-detail/'.$products->id)}}">{{$products->name}}</a></h3>
                        <!-- End .product-title -->
                        <div class="product-price">
                            ₹ {{$products->discounted_price}}
                        </div><!-- End .product-price -->
                    </div><!-- End .product-body -->
                    <div class="product-action">
                        <input type="hidden" id="product-id-{{ $products->id }}" value="{{ $products->id }}">
                        <input type="hidden" id="quantity-{{ $products->id }}" value="1">
                        <button type="button" class="btn-product btn-cart" onclick="addToCart({{ $products->id }})">
                            <span>add to cart</span>
                        </button>
                    </div><!-- End .product-action -->
                </div><!-- End .product -->
                @endforeach


            </div><!-- End .owl-carousel -->
        </div><!-- .End .tab-pane -->
        <div class="tab-pane p-0 fade" id="products-top-tab" role="tabpanel" aria-labelledby="products-top-link">
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
                @foreach($rated as $products)
                <div class="product product-11 text-center product-manual">
                    <figure class="product-media">
                        <a href="{{url('shop-product-detail/'.$products->id)}}">
                            <img src="{{ asset('storage/' . $products->featured_image) }}" alt="Product image"
                                class="product-image product-image-manual">
                            <!-- <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-1-2.jpg')}}"
                                    alt="Product image" class="product-image-hover"> -->
                        </a>



                        <div class="product-action-vertical">
                            @php
                            $isInWishlist = \App\Models\Wishlist::where(function ($query) use ($products) {
                            $userId = auth()->id();
                            $systemId = $userId ? null : hash('sha256', request()->userAgent() . '|' . request()->ip());

                            if ($userId) {
                            $query->where('user_id', $userId);
                            } else {
                            $query->where('system_id', $systemId);
                            }
                            })->where('product_id', $products->id)->exists();
                            @endphp

                            <!-- Wishlist Button -->
                            <button type="button"
                                class="btn-product-icon btn-wishlist {{ $isInWishlist ? 'active' : '' }} btn-expandable add-to-wishlist {{ $isInWishlist ? 'wishlist-active' : '' }}"
                                data-product-id="{{ $products->id }}">
                                <span>{{ $isInWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}</span>
                            </button>
                        </div><!-- End .product-action-vertical -->
                    </figure><!-- End .product-media -->

                    <div class="product-body">
                        <h3 class="product-title"><a
                                href="{{url('shop-product-detail/'.$products->id)}}">{{$products->name}}</a></h3>
                        <!-- End .product-title -->
                        <div class="product-price">
                            ₹ {{$products->discounted_price}}
                        </div><!-- End .product-price -->
                    </div><!-- End .product-body -->
                    <div class="product-action">
                        <input type="hidden" id="product-id-{{ $products->id }}" value="{{ $products->id }}">
                        <input type="hidden" id="quantity-{{ $products->id }}" value="1">
                        <button type="button" class="btn-product btn-cart" onclick="addToCart({{ $products->id }})">
                            <span>add to cart</span>
                        </button>
                    </div><!-- End .product-action -->
                </div><!-- End .product -->
                @endforeach

            </div><!-- End .owl-carousel -->
        </div><!-- .End .tab-pane -->
    </div><!-- End .tab-content -->
</div><!-- End .container-fluid -->
