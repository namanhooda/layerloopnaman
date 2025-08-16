@extends('frontend.partials.app')
@section('content')
<style>
.btn-wishlist {
    border: none !important;
    outline: none;
    background-color: transparent; /* Optional if you want no background */
    box-shadow: none; /* Optional if you want to remove any shadow */
}</style>
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">Extended Description</li>
            </ol>

            <nav class="product-pager ml-auto" aria-label="Product">
                <a class="product-pager-link product-pager-prev" href="#" aria-label="Previous" tabindex="-1">
                    <i class="icon-angle-left"></i>
                    <span>Prev</span>
                </a>

                <a class="product-pager-link product-pager-next" href="#" aria-label="Next" tabindex="-1">
                    <span>Next</span>
                    <i class="icon-angle-right"></i>
                </a>
            </nav>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <div class="product-details-top mb-2">
                <div class="row">
                    <div class="col-md-6">
                        <div class="product-gallery">
                            <figure class="product-main-image">

                                <img id="product-zoom" src="{{ asset('storage/' . $product->featured_image) }}"
                                    data-zoom-image="{{ asset('storage/' . $product->featured_image) }}"
                                    alt="Product image">
                                <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                    <i class="icon-arrows"></i>
                                </a>
                            </figure>
                            @php
                            $images = json_decode($product->image_path, true);
                            @endphp
                            <div id="product-zoom-gallery" class="product-image-gallery">
                                @if($images)
                                @foreach ($images as $key => $image)
                                <a class="product-gallery-item {{ $key === 0 ? 'active' : '' }}" href="#"
                                    data-image="{{ asset('storage/' . $image) }}"
                                    data-zoom-image="{{ asset('storage/' . $image) }}">
                                    <img src="{{ asset('storage/' . $image) }}" alt="product image {{ $key + 1 }}"
                                        class="product-image-manual" style="height: 120px !important;">
                                </a>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="product-details">
                            <h1 class="product-title">{{$product->name}}</h1>

                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 80%;"></div>
                                </div>
                                <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
                            </div>

                            <div class="product-price">
                                ₹{{ $product->discounted_price }}
                                <span style="text-decoration: line-through; color: red; margin-left: 10px;font-size: 12px;">
                                    ₹{{ $product->price }}
                                </span>
                            </div>

                            <div class="product-content">
                                <p>{{$product->description ?? "Sed egestas, ante et vulputate volutpat, eros pede semper est, vitae luctus metus libero eu augue. Morbi purus libero, faucibus adipiscing. Sed lectus."}}
                                </p>
                            </div>

                            <div class="details-filter-row details-row-size">
                                <label>Color:</label>

                                <div class="product-nav product-nav-dots">
                                    <a href="#" class="active" style="background: #eab656;"><span class="sr-only">Color
                                            name</span></a>
                                    <a href="#" style="background: #333333;"><span class="sr-only">Color name</span></a>
                                    <a href="#" style="background: #3a588b;"><span class="sr-only">Color name</span></a>
                                    <a href="#" style="background: #caab97;"><span class="sr-only">Color name</span></a>
                                </div>
                            </div>

                            <div class="details-filter-row details-row-size">
                                <label for="size">Size:</label>
                                <div class="select-custom">
                                    <select name="size" id="size" class="form-control">
                                        <option value="#" selected="selected">Select a size</option>
                                        <option value="s">Small</option>
                                        <option value="m">Medium</option>
                                        <option value="l">Large</option>
                                        <option value="xl">Extra Large</option>
                                    </select>
                                </div>

                                <a href="#" class="size-guide"><i class="icon-th-list"></i>size guide</a>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST">
                            <div class="details-filter-row details-row-size">
                                <label for="qty">Qty:</label>
                                <div class="product-details-quantity">
                                    <input type="number" id="qty" name="quantity" class="form-control" value="1" min="1" max="10"
                                        step="1" data-decimals="0" required>
                                </div>
                            </div>

                            <div class="product-details-action">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn-product btn-cart">
                                        <span>Add to Cart</span>
                                    </button>
                                </form>

                                <div class="details-action-wrapper">
                                    <!-- <a href="#" class="btn-product btn-wishlist" title="Wishlist"><span>Add to
                                            Wishlist</span></a> -->
                                    <form action="{{ route('wishlist.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn-product btn-wishlist" title="Wishlist">
                                            <span>Add to Wishlist</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="#">{{$product->category}}</a>
                                </div>

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>
                                    <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                            class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                            class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                            class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i
                                            class="icon-pinterest"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-details-tab product-details-extended">
            <div class="container">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab"
                            role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab"
                            aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab"
                            role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab"
                            role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                    </li>
                </ul>
            </div><!-- End .container -->

            <div class="tab-content">
                <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                    aria-labelledby="product-desc-link">
                    <div class="product-desc-content">
                        <div class="product-desc-row bg-image"
                            style="background-image: url('assets/images/products/single/extended/bg-1.jpg')">
                            <div class="container">
                                <div class="row justify-content-end">
                                    <div class="col-sm-6 col-lg-4">
                                        <h2>Product Information</h2>
                                        <ul>
                                            <li>Faux suede fabric upper</li>
                                            <li>Tie strap buckle detail</li>
                                            <li>Block heel</li>
                                            <li>Open toe</li>
                                            <li>Heel Height: 7cm / 2.5 inches</li>
                                        </ul>
                                    </div><!-- End .col-lg-4 -->
                                </div><!-- End .row -->
                            </div><!-- End .container -->
                        </div><!-- End .product-desc-row -->

                        <div class="product-desc-row bg-image text-white"
                            style="background-image: url('assets/images/products/single/extended/bg-2.jpg')">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h2>Design</h2>
                                        <p>The perfect choice for the summer months. These wedges are perfect for
                                            holidays and home, with the thick cross-over strap design and heel strap
                                            with an adjustable buckle fastening. Featuring chunky soles with an
                                            espadrille and cork-style wedge. </p>
                                    </div><!-- End .col-md-6 -->

                                    <div class="col-md-6">
                                        <h2>Fabric & care</h2>
                                        <p>As part of our Forever Comfort collection, these wedges have ultimate
                                            cushioning with soft padding and flexi soles. Perfect for strolls into the
                                            old town on holiday or a casual wander into the village.</p>
                                    </div><!-- End .col-md-6 -->
                                </div><!-- End .row -->

                                <div class="mb-5"></div><!-- End .mb-3 -->

                                <img src="assets/images/products/single/extended/sign.png" alt=""
                                    class="ml-auto mr-auto">
                            </div><!-- End .container -->
                        </div><!-- End .product-desc-row -->

                        <div class="product-desc-row bg-image"
                            style="background-image: url('assets/images/products/single/extended/bg-3.jpg')">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <blockquote>
                                            <p>“ Everything is important - <br>that success is in the details. ”</p>

                                            <cite>– Steve Jobs</cite>
                                        </blockquote>
                                        <p>Nullam mollis. Ut justo. Suspendisse potenti. Sed egestas, ante et vulputate
                                            volutpat, eros pede semper est, vitae luctus metus libero eu augue. </p>
                                    </div><!-- End .col-lg-5 -->
                                </div><!-- End .row -->
                            </div><!-- End .container -->
                        </div><!-- End .product-desc-row -->
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                    <div class="product-desc-content">
                        <div class="container">
                            <h3>Information</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat
                                mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper
                                suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam
                                porttitor mauris sit amet orci. </p>

                            <h3>Fabric & care</h3>
                            <ul>
                                <li>Faux suede fabric</li>
                                <li>Gold tone metal hoop handles.</li>
                                <li>RI branding</li>
                                <li>Snake print trim interior </li>
                                <li>Adjustable cross body strap</li>
                                <li> Height: 31cm; Width: 32cm; Depth: 12cm; Handle Drop: 61cm</li>
                            </ul>

                            <h3>Size</h3>
                            <p>one size</p>
                        </div><!-- End .container -->
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                    aria-labelledby="product-shipping-link">
                    <div class="product-desc-content">
                        <div class="container">
                            <h3>Delivery & returns</h3>
                            <p>We deliver to over 100 countries around the world. For full details of the delivery
                                options we offer, please view our <a href="#">Delivery information</a><br>
                                We hope you’ll love every purchase, but if you ever need to return an item you can do so
                                within a month of receipt. For full details of how to make a return, please view our <a
                                    href="#">Returns information</a></p>
                        </div><!-- End .container -->
                    </div><!-- End .product-desc-content -->
                </div><!-- .End .tab-pane -->
                <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                    aria-labelledby="product-review-link">
                    <div class="reviews">
                        <div class="container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="mb-0">Reviews (2)</h3>
                                <button class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                    data-target="#addReviewModal">
                                    + Add Review
                                </button>
                            </div>
                            <div class="review">
                                <div class="row no-gutters">
                                    <div class="col-auto">
                                        <h4><a href="#">Samanta J.</a></h4>
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <div class="ratings-val" style="width: 80%;"></div>
                                                <!-- End .ratings-val -->
                                            </div><!-- End .ratings -->
                                        </div><!-- End .rating-container -->
                                        <span class="review-date">6 days ago</span>
                                    </div><!-- End .col -->
                                    <div class="col">
                                        <h4>Good, perfect size</h4>

                                        <div class="review-content">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus cum
                                                dolores assumenda asperiores facilis porro reprehenderit animi culpa
                                                atque blanditiis commodi perspiciatis doloremque, possimus, explicabo,
                                                autem fugit beatae quae voluptas!</p>
                                        </div><!-- End .review-content -->

                                        <div class="review-action">
                                            <a href="#"><i class="icon-thumbs-up"></i>Helpful (2)</a>
                                            <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                        </div><!-- End .review-action -->
                                    </div><!-- End .col-auto -->
                                </div><!-- End .row -->
                            </div><!-- End .review -->

                            <div class="review">
                                <div class="row no-gutters">
                                    <div class="col-auto">
                                        <h4><a href="#">John Doe</a></h4>
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <div class="ratings-val" style="width: 100%;"></div>
                                                <!-- End .ratings-val -->
                                            </div><!-- End .ratings -->
                                        </div><!-- End .rating-container -->
                                        <span class="review-date">5 days ago</span>
                                    </div><!-- End .col -->
                                    <div class="col">
                                        <h4>Very good</h4>

                                        <div class="review-content">
                                            <p>Sed, molestias, tempore? Ex dolor esse iure hic veniam laborum blanditiis
                                                laudantium iste amet. Cum non voluptate eos enim, ab cumque nam, modi,
                                                quas iure illum repellendus, blanditiis perspiciatis beatae!</p>
                                        </div><!-- End .review-content -->

                                        <div class="review-action">
                                            <a href="#"><i class="icon-thumbs-up"></i>Helpful (0)</a>
                                            <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                        </div><!-- End .review-action -->
                                    </div><!-- End .col-auto -->
                                </div><!-- End .row -->
                            </div><!-- End .review -->
                        </div><!-- End .container -->
                    </div><!-- End .reviews -->
                </div><!-- .End .tab-pane -->
            </div><!-- End .tab-content -->
        </div>
        @include('frontend.sections.related')

    </div><!-- End .page-content -->
</main><!-- End .main -->

@include('frontend.modals.addReview')


@endsection
