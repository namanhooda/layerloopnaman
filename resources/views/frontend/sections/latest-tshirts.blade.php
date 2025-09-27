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
                @foreach($clothes as $product)
                <div class="product product-11 text-center product-manual">
                    <figure class="product-media">
                        <a href="{{ url('shop-product-detail/' . $product->id) }}">
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
                        </div>
                    </figure>

                    <div class="product-body">
                        <h3 class="product-title">
                            <a href="{{ url('shop-product-detail/' . $product->id) }}">{{ $product->name }}</a>
                        </h3>
                        <div class="product-price">
                            ₹{{ $product->discounted_price }}
                            <span style="font-size: 12px;">
                                <del>{{ $product->original_price }}</del>
                                <!-- Assuming you have the original price stored -->
                            </span>
                        </div>
                    </div>


                    @include('frontend.buttons.addtocart')
                </div>
                @endforeach


            </div>
        </div>
    </div>
</div>
