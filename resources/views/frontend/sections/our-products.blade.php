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
                @foreach($featured as $product)
                <div class="product product-11 text-center product-manual">
                    <figure class="product-media">
                        <a href="{{url('shop-product-detail/'.$product->slug)}}">
                            <img src="{{ asset('storage/' . $product->featured_image) }}" alt="Product image"
                                class="product-image product-image-manual">
                            <!-- <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-1-2.jpg')}}"
                                    alt="Product image" class="product-image-hover"> -->
                        </a>



                        <div class="product-action-vertical">
                            @php
                            $isInWishlist = \App\Models\Wishlist::where(function ($query) use ($product) {
                            $userId = auth()->id();
                            $systemId = $userId ? null : hash('sha256', request()->userAgent() . '|' . request()->ip());

                            if ($userId) {
                            $query->where('user_id', $userId);
                            } else {
                            $query->where('system_id', $systemId);
                            }
                            })->where('product_id', $product->id)->exists();
                            @endphp

                            <!-- Wishlist Button -->
                            <button type="button"
                                class="btn-product-icon btn-wishlist {{ $isInWishlist ? 'active' : '' }} btn-expandable add-to-wishlist {{ $isInWishlist ? 'wishlist-active' : '' }}"
                                data-product-id="{{ $product->id }}">
                                <span>{{ $isInWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}</span>
                            </button>
                        </div>
                    </figure>

                    <div class="product-body">
                        <h3 class="product-title"><a
                                href="{{url('shop-product-detail/'.$product->slug)}}">{{$product->name}}</a></h3>
                        <div class="product-price">
                            ₹ {{$product->discounted_price}}
                        </div>
                        
                                
                                @php
                                    $ratingPercent = rand(70, 100);   // 70% to 100%
                                    $reviewsCount = rand(5, 20);      // 5 to 20 reviews
                                @endphp

                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: {{ $ratingPercent }}%;"></div>
                                    </div>
                                    <span class="ratings-text">
                                        ( {{ $reviewsCount }} Reviews )
                                    </span>
                                </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
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

                @foreach($sale as $product)
                <div class="product product-11 text-center product-manual">
                    <figure class="product-media">
                        <a href="{{url('shop-product-detail/'.$product->slug)}}">
                            <img src="{{ asset('storage/' . $product->featured_image) }}" alt="Product image"
                                class="product-image product-image-manual">
                            <!-- <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-1-2.jpg')}}"
                                    alt="Product image" class="product-image-hover"> -->
                        </a>
                        <div class="product-action-vertical">
                            @php
                            $isInWishlist = \App\Models\Wishlist::where(function ($query) use ($product) {
                            $userId = auth()->id();
                            $systemId = $userId ? null : hash('sha256', request()->userAgent() . '|' . request()->ip());

                            if ($userId) {
                            $query->where('user_id', $userId);
                            } else {
                            $query->where('system_id', $systemId);
                            }
                            })->where('product_id', $product->id)->exists();
                            @endphp

                            <!-- Wishlist Button -->
                            <button type="button"
                                class="btn-product-icon btn-wishlist {{ $isInWishlist ? 'active' : '' }} btn-expandable add-to-wishlist {{ $isInWishlist ? 'wishlist-active' : '' }}"
                                data-product-id="{{ $product->id }}">
                                <span>{{ $isInWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}</span>
                            </button>
                        </div>
                    </figure>
                    <div class="product-body">
                        <h3 class="product-title"><a
                                href="{{url('shop-product-detail/'.$product->slug)}}">{{$product->name}}</a></h3>
                        <div class="product-price">
                            ₹ {{$product->discounted_price}}
                        </div>
                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="width: 0%;"></div>
                            </div>
                            <span class="ratings-text">( 0 Reviews )</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
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
                @foreach($rated as $product)
                <div class="product product-11 text-center product-manual">
                    <figure class="product-media">
                        <a href="{{url('shop-product-detail/'.$product->slug)}}">
                            <img src="{{ asset('storage/' . $product->featured_image) }}" alt="Product image"
                                class="product-image product-image-manual">
                            <!-- <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-1-2.jpg')}}"
                                    alt="Product image" class="product-image-hover"> -->
                        </a>
                        <div class="product-action-vertical">
                            @php
                            $isInWishlist = \App\Models\Wishlist::where(function ($query) use ($product) {
                            $userId = auth()->id();
                            $systemId = $userId ? null : hash('sha256', request()->userAgent() . '|' . request()->ip());

                            if ($userId) {
                            $query->where('user_id', $userId);
                            } else {
                            $query->where('system_id', $systemId);
                            }
                            })->where('product_id', $product->id)->exists();
                            @endphp

                            <!-- Wishlist Button -->
                            <button type="button"
                                class="btn-product-icon btn-wishlist {{ $isInWishlist ? 'active' : '' }} btn-expandable add-to-wishlist {{ $isInWishlist ? 'wishlist-active' : '' }}"
                                data-product-id="{{ $product->id }}">
                                <span>{{ $isInWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}</span>
                            </button>
                        </div>
                    </figure>

                    <div class="product-body">
                        <h3 class="product-title"><a
                                href="{{url('shop-product-detail/'.$product->slug)}}">{{$product->name}}</a></h3>
                        <div class="product-price">
                            ₹ {{$product->discounted_price}}
                        </div>
                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="width: 0%;"></div>
                            </div>
                            <span class="ratings-text">( 0 Reviews )</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
