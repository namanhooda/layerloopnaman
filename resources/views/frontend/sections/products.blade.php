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