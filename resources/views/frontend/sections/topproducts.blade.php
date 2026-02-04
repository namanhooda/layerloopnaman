
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
                    <div class="row justify-content-center">

                        @foreach($sale as $product)
                        <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                            <div class="product product-11 text-center product-manual">
                                <figure class="product-media">
                                    <a href="{{url('shop-product-detail/'.$product->slug)}}">
                                    <img src="{{ asset('storage/' . $product->featured_image) }}" alt="Product image" class="product-image product-image-manual">
                                     
                                    </a>

                                    
                                <div class="product-action-vertical">
                                    @php
                                    $isInWishlist = \App\Models\Wishlist::where(function ($query) use ($product) {
                                    $userId = auth()->id();
                                    $systemId = $userId ? null : hash('sha256', request()->userAgent() . '|' .
                                    request()->ip());

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
                                </div><!-- End .product-action-vertical -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#" class="prodcatlink">Lighting</a>
                                    </div>
                                    <h3 class="product-title"><a href="{{url('shop-product-detail/'.$product->slug)}}">{{$product->name}}</a></h3>
                                    <!-- End .product-title -->
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
                                </div><!-- End .product-body -->
                                
                            </div><!-- End .product -->
                        </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                        @endforeach

                    </div><!-- End .row -->
                </div><!-- End .products -->
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
            <div class="tab-pane p-0 fade" id="top-decor-tab" role="tabpanel" aria-labelledby="top-decor-link">
                <div class="products">
                    <div class="row justify-content-center">
                        <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                            <div class="product product-11 text-center">
                                <figure class="product-media">
                                    <a href="#">
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-8-1.jpg')}}"
                                            alt="Product image" class="product-image">
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-8-2.jpg')}}"
                                            alt="Product image" class="product-image-hover">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                                wishlist</span></a>
                                    </div><!-- End .product-action-vertical -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#" class="prodcatlink">Decor</a>
                                    </div>
                                    <h3 class="product-title"><a href="#">Madra Log Holder</a></h3>
                                    <!-- End .product-title -->
                                    <div class="product-price">
                                        
                                    </div><!-- End .product-price -->

                                    <div class="product-nav product-nav-dots">
                                        <a href="#" class="active" style="background: #333333;"><span
                                                class="sr-only">Color name</span></a>
                                        <a href="#" style="background: #927764;"><span class="sr-only">Color
                                                name</span></a>
                                    </div><!-- End .product-nav -->

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
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-11-1.jpg')}}"
                                            alt="Product image" class="product-image">
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-11-2.jpg')}}"
                                            alt="Product image" class="product-image-hover">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                                wishlist</span></a>
                                    </div><!-- End .product-action-vertical -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#" class="prodcatlink">Decor</a>
                                    </div>
                                    <h3 class="product-title"><a href="#">Original Outdoor Beanbag</a></h3>
                                    <!-- End .product-title -->
                                    <div class="product-price">
                                        $259,00
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
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-14-1.jpg')}}"
                                            alt="Product image" class="product-image">
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-14-2.jpg')}}"
                                            alt="Product image" class="product-image-hover">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                                wishlist</span></a>
                                    </div><!-- End .product-action-vertical -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#" class="prodcatlink">Decor</a>
                                    </div>
                                    <h3 class="product-title"><a href="#">Cushion Set 3 Pieces</a></h3>
                                    <!-- End .product-title -->
                                    <div class="product-price">
                                        $199,00
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
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-15-1.jpg')}}"
                                            alt="Product image" class="product-image">
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-15-2.jpg')}}"
                                            alt="Product image" class="product-image-hover">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                                wishlist</span></a>
                                    </div><!-- End .product-action-vertical -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#" class="prodcatlink">Decor</a>
                                    </div>
                                    <h3 class="product-title"><a href="#">Cushion Set 3 Pieces</a></h3>
                                    <!-- End .product-title -->
                                    <div class="product-price">
                                        $199,00
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
            <div class="tab-pane p-0 fade" id="top-light-tab" role="tabpanel" aria-labelledby="top-light-link">
                <div class="products">
                    <div class="row justify-content-center">
                        <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                            <div class="product product-11 text-center">
                                <figure class="product-media">
                                    <a href="#">
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-7-1.jpg')}}"
                                            alt="Product image" class="product-image">
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-7-2.jpg')}}"
                                            alt="Product image" class="product-image-hover">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                                wishlist</span></a>
                                    </div><!-- End .product-action-vertical -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#" class="prodcatlink">Lighting</a>
                                    </div>
                                    <h3 class="product-title"><a href="#">Petite Table Lamp</a></h3>
                                    <!-- End .product-title -->
                                    <div class="product-price">
                                        ₹ 
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
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-10-1.jpg')}}"
                                            alt="Product image" class="product-image">
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-10-2.jpg')}}"
                                            alt="Product image" class="product-image-hover">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                                wishlist</span></a>
                                    </div><!-- End .product-action-vertical -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#" class="prodcatlink">Lighting</a>
                                    </div>
                                    <h3 class="product-title"><a href="#">Carronade Large Suspension Lamp</a>
                                    </h3><!-- End .product-title -->
                                    <div class="product-price">
                                        ₹ 
                                    </div><!-- End .product-price -->

                                    <div class="product-nav product-nav-dots">
                                        <a href="#" class="active" style="background: #e8e8e8;"><span
                                                class="sr-only">Color name</span></a>
                                        <a href="#" style="background: #333333;"><span class="sr-only">Color
                                                name</span></a>
                                    </div><!-- End .product-nav -->

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
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-16-1.jpg')}}"
                                            alt="Product image" class="product-image">
                                        <img src="{{asset('frontend/assets/images/demos/demo-2/products/product-16-2.jpg')}}"
                                            alt="Product image" class="product-image-hover">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist "><span>add to
                                                wishlist</span></a>
                                    </div><!-- End .product-action-vertical -->
                                </figure><!-- End .product-media -->

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#" class="prodcatlink">Lighting</a>
                                    </div>
                                    <h3 class="product-title"><a href="#">Carronade Table Lamp</a></h3>
                                    <!-- End .product-title -->
                                    <div class="product-price">
                                        $499,00
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
