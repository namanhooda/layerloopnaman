<div class="container">
            <h2 class="title text-center mb-4">You May Also Like</h2><!-- End .title text-center -->
            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl"
                data-owl-options='{
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
                
                        <div class="product  product-11 product-manual">
                            <figure class="product-media">
                                <span class="product-label label-new">New</span>
                                <a href="{{ url('shop-product-detail/' . $product->id) }}">
                                    <!-- <img src="assets/images/products/product-1.jpg" alt="Product image"
                                        class="product-image"> -->
                                    <img src="{{ asset('storage/' . $product->featured_image) }}" alt="Product image"
                                        class="product-image product-image-manual">

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
                        </div><!-- End .product-action -->

                            </figure><!-- End .product-media -->

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#" class="prodcatlink">{{$product->category}}</a>
                                </div><!-- End .product-cat -->
                                <h3 class="product-title"><a
                                        href="{{ url('shop-product-detail/' . $product->id) }}">{{$product->name}}</a>
                                </h3>
                                <!-- End .product-title -->
                                <div class="product-price">
                                    ₹{{$product->discounted_price}}
                                </div><!-- End .product-price -->
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 0%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( 0 Reviews )</span>
                                </div><!-- End .rating-container -->

                                <div class="product-nav product-nav-dots"></a>

                                </div><!-- End .product-nav -->
                            </div>
                            
                                @include('frontend.buttons.addtocart')
                        </div>
                @endforeach

            </div><!-- End .owl-carousel -->
        </div>