@extends('frontend.partials.app')
@section('content')

<link rel="stylesheet" href="{{asset('custom/detail.css')}}">
<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('shop')}}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
            </ol>

            <nav class="product-pager ml-auto" aria-label="Product">

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
                                    alt="Product image" style="    border-radius: 10px;">
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
                            <!-- Product Badge -->
                            <div>
                                <span class="product-badge">
                                    BESTSELLER
                                </span>
                            </div>

                            <!-- Product Title -->
                            <h1 class="new-product-title">
                                {{ $product->name }}
                            </h1>

                            <!-- Rating & SKU -->
                            <div class="product-meta-new">

                                <div class="rating-box">

                                    <div class="rating-stars">
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star"></i>
                                        <i class="icon-star-half"></i>
                                    </div>

                                    <span class="rating-score">
                                        4.9
                                    </span>

                                    <a href="#product-review-link" class="review-link">
                                        (124 Reviews)
                                    </a>

                                </div>

                                <span class="meta-divider">|</span>

                                <div class="sku-box">
                                    SKU:
                                    <strong>
                                        {{ $product->code ?? ('LL-IDOL-'.$product->id) }}
                                    </strong>
                                </div>

                            </div>

                            @php
                            $price = $product->price;
                            $salePrice = $product->discounted_price;

                            $discount = 0;

                            if($price > 0 && $salePrice < $price){ $discount=round((($price - $salePrice) / $price) *
                                100); } @endphp <div class="price-wrapper">

                                <span class="sale-price">
                                    ₹{{ number_format($salePrice,2) }}
                                </span>

                                @if($price > $salePrice)
                                <span class="old-price">
                                    ₹{{ number_format($price,2) }}
                                </span>
                                @endif

                                @if($discount)
                                <span class="discount-badge">
                                    {{ $discount }}% OFF
                                </span>
                                @endif

                        </div>

                        <!-- Product Description -->
                        <div class="product-description">

                            <p class="description-text" id="productDescription">
                                {{ $product->description ?? "Discover our premium 3D printed creations and custom DTF printed products, designed with precision, durability, and exceptional craftsmanship. Perfect for home décor, gifting, collectibles, and personalized creations that bring your imagination to life." }}
                            </p>

                            <button class="read-more-btn" id="toggleDescription">
                                Read More
                            </button>

                        </div>


                        <!-- Product Features -->
                        <div class="product-features">

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="icon-box"></i>
                                </div>

                                <div class="feature-content">
                                    <h6>Premium</h6>
                                    <span>3D Prints</span>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="icon-map-marker"></i>
                                </div>

                                <div class="feature-content">
                                    <h6>Made in</h6>
                                    <span>India</span>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="icon-lock"></i>
                                </div>

                                <div class="feature-content">
                                    <h6>Secure</h6>
                                    <span>Packaging</span>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="icon-refresh"></i>
                                </div>

                                <div class="feature-content">
                                    <h6>7 Days</h6>
                                    <span>Easy Returns</span>
                                </div>
                            </div>

                        </div>

                        @php
                        $isClothing = in_array($product->prototype, ['clothing', 1]);
                        @endphp
                        @if($product->size || $isClothing)

                        @php
                        $sizes = [];

                        if($product->size){
                        $sizes = json_decode($product->size, true);
                        }

                        if($isClothing){
                        $sizes = ['S','M','L','XL','XXL'];
                        }
                        @endphp

                        <div class="product-option">

                            <label class="option-title">
                                Select Size
                            </label>

                            <div class="size-list">

                                @foreach($sizes as $size)

                                <label class="size-box">

                                    <input type="radio" name="size_{{ $product->id }}" value="{{ $size }}"
                                        class="size-radio" {{ $loop->first ? 'checked' : '' }}>

                                    <span>{{ $size }}</span>

                                </label>

                                @endforeach

                            </div>

                            <input type="hidden" id="size-{{ $product->id }}" value="{{ $sizes[0] ?? '' }}">

                        </div>

                        @endif



                        <div class="purchase-options">

                            <!-- Quantity -->

                            <div class="quantity-wrapper">

                                <label class="option-title">
                                    Quantity
                                </label>

                                <div class="quantity-box">

                                    <button type="button" class="qty-btn minus">
                                        −
                                    </button>

                                    <input type="number" id="quantity-{{ $product->id }}" class="qty-input" value="1"
                                        min="1" max="10">

                                    <button type="button" class="qty-btn plus">
                                        +
                                    </button>

                                </div>

                            </div>

                            <!-- Stock -->

                            <div class="stock-wrapper">

                                <label class="option-title">
                                    Availability
                                </label>

                                <div class="stock-status">

                                    <span class="stock-dot"></span>

                                    <span>In Stock</span>

                                </div>

                                <small class="stock-note">
                                    Ready to dispatch in 24–48 Hours
                                </small>

                            </div>

                        </div>

                        <div class="product-actions">

                            <input type="hidden" id="product-id-{{ $product->id }}" value="{{ $product->id }}">

                            <!-- Buy Now -->

                            <button type="button" class="btn-buy-new" onclick="buyNow({{ $product->id }})">

                                <i class="icon-bolt"></i>

                                Buy Now

                            </button>
                            <!-- Add To Cart -->

                            <button type="button" class="btn-cart-new" onclick="addToCart({{ $product->id }})">

                                <i class="icon-shopping-cart"></i>

                                Add to Cart

                            </button>


                            <!-- Wishlist -->

                            <button type="button" class="wishlist-circle add-to-wishlist"
                                data-product-id="{{ $product->id }}" title="Add to Wishlist">

                                <i class="icon-heart-o"></i>

                            </button>

                        </div>

                        <!-- Product Service Cards -->
                        <!-- <div class="service-grid">

                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="icon-truck"></i>
                                </div>

                                <div class="service-content">
                                    <h5>Free Shipping</h5>
                                    <p>Free shipping across India on eligible orders.</p>
                                </div>
                            </div>

                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="icon-lock"></i>
                                </div>

                                <div class="service-content">
                                    <h5>100% Secure Payment</h5>
                                    <p>Encrypted payment with trusted gateways.</p>
                                </div>
                            </div>

                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="icon-refresh"></i>
                                </div>

                                <div class="service-content">
                                    <h5>Easy Returns</h5>
                                    <p>Simple replacement for damaged products.</p>
                                </div>
                            </div>

                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="icon-whatsapp"></i>
                                </div>

                                <div class="service-content">
                                    <h5>Need Help?</h5>
                                    <p>
                                        <a href="https://wa.me/918059808185" target="_blank">
                                            Chat on WhatsApp
                                        </a>
                                    </p>
                                </div>
                            </div>

                        </div> -->

                        <div class="guarantee-strip">

                            <span><i class="icon-check"></i> Premium Quality</span>

                            <span><i class="fa fa-shield"  aria-hidden="true"></i> Secure Checkout</span>

                            <span><i class="icon-truck"></i> Fast Delivery</span>

                            <span><i class="icon-refresh"></i> Easy Returns</span>

                        </div>
                        <div class="product-footer-modern">

                            <!-- Category -->

                            <!-- <div class="footer-block">

                                <span class="footer-title">
                                    Category
                                </span>

                                <a href="#" class="category-pill">
                                    {{ $product->categoryData->name ?? '3D Printed Products' }}
                                </a>

                            </div> -->

                            <!-- SKU -->

                            <!-- <div class="footer-block">

                                <span class="footer-title">
                                    SKU
                                </span>

                                <span class="sku-pill">
                                    {{ $product->sku ?? ('LL-'.$product->id) }}
                                </span>

                            </div> -->

                            <!-- Tags -->

                            <!-- <div class="footer-block">

                                <span class="footer-title">
                                    Tags
                                </span>

                                <div class="tag-list">

                                    <span>3D Print</span>

                                    <span>LayerLoop</span>

                                    <span>Premium</span>

                                    <span>Gift</span>

                                </div>

                            </div> -->

                            <!-- Share -->

                            <div class="footer-block">

                                <span class="footer-title">
                                    Share
                                </span>

                                <div class="share-icons">

                                    <a href="https://www.facebook.com/profile.php?id=61579088633589" target="_blank">
                                        <i class="icon-facebook-f"></i>
                                    </a>

                                    <a href="https://wa.me/918059808185" target="_blank">
                                        <i class="icon-whatsapp"></i>
                                    </a>

                                    <a href="https://www.instagram.com/layerloop.web/" target="_blank">
                                        <i class="icon-instagram"></i>
                                    </a>

                                    <a href="#">
                                        <i class="icon-youtube"></i>
                                    </a>

                                    <button type="button" class="copy-link-btn" onclick="copyProductLink()">

                                        <i class="icon-link"></i>

                                    </button>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="product-details-tab">
        <ul class="nav nav-pills justify-content-center" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab"
                    aria-controls="product-desc-tab" aria-selected="true">Description</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab"
                    aria-controls="product-info-tab" aria-selected="false">Additional information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab"
                    aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab"
                    aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
            </li>
        </ul>
        <div class="tab-content content-div-r">
            <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                aria-labelledby="product-desc-link">
                <div class="product-desc-content">
                    <h3>Product Information</h3>
                    <p>We are a specialized 3D printing business offering a wide range of high-quality 3D printed
                        products crafted with precision and care. Our collection includes 3D model idols, decorative
                        frames, lamps, customized models, and modern home décor items, designed to add a unique and
                        elegant touch to your space.</p>
                    <ul>
                        <li>We are a specialized 3D printing business offering a wide range of high-quality 3D
                            printed products crafted with precision and care. Our collection includes 3D model
                            idols, decorative frames, lamps, customized models, and modern home décor items,
                            designed to add a unique and elegant touch to your space. </li>
                        <li>Our designs combine creativity with functionality, making them suitable for home décor,
                            gifting, office spaces, temples, and personal collections.</li>
                        <li>We focus on clean detailing, accurate dimensions, and premium aesthetics, ensuring every
                            product meets high standards before dispatch.</li>
                    </ul>

                    <p>Whether you are looking for a spiritual idol, a decorative piece, or a customized 3D model,
                        our products are designed to reflect craftsmanship and innovation.</p>
                </div><!-- End .product-desc-content -->
            </div><!-- .End .tab-pane -->
            <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                <div class="product-desc-content">
                    <h3>Information</h3>
                    <ul>
                        <li>Material: High-quality 3D printing material (PLA / Resin / PETG – depending on product)
                        </li>
                        <li>Manufacturing Process: Advanced 3D printing technology with precision detailing</li>
                        <li>Finish: Smooth matte or semi-gloss finish (may vary by design)</li>
                        <li>Color Options: Available in multiple colors (custom colors on request)</li>
                        <li>Customization: Custom sizes, colors, and designs available on request</li>
                        <li>Usage: Suitable for home décor, gifting, office décor, temples, and display purposes
                        </li>
                        <li>Care Instructions: Clean gently with a dry or soft cloth; avoid water and direct heat
                        </li>
                        <li>Care Instructions: Clean gently with a dry or soft cloth; avoid water and direct heat
                        </li>
                        <li>Packaging: Securely packed to prevent damage during transit</li>
                        <li>Country of Origin: Made in India</li>
                    </ul>
                    <p>Note: Since these products are 3D printed, slight variations in texture, color, or layer
                        lines may occur. These are natural characteristics of the 3D printing process and not
                        considered defects.</p>
                </div><!-- End .product-desc-content -->
            </div><!-- .End .tab-pane -->
            <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                aria-labelledby="product-shipping-link">
                <div class="product-desc-content">
                    <h3>Delivery & returns</h3>
                    <p>We deliver to over 100 countries around the world. For full details of the delivery options
                        we offer, please view our <a href="#">Delivery information</a><br>
                        We hope you’ll love every purchase, but if you ever need to return an item you can do so
                        within a month of receipt. For full details of how to make a return, please view our <a
                            href="#">Returns information</a></p>
                </div><!-- End .product-desc-content -->
            </div><!-- .End .tab-pane -->
            <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                <div class="reviews">
                    <h3>Reviews (2)</h3>
                    <div class="review">
                        <div class="row no-gutters">
                            <div class="col-auto">
                                <h4><a href="#">Samanta J.</a></h4>
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 80%;"></div><!-- End .ratings-val -->
                                    </div><!-- End .ratings -->
                                </div><!-- End .rating-container -->
                                <span class="review-date">6 days ago</span>
                            </div><!-- End .col -->
                            <div class="col">
                                <h4>Good, perfect size</h4>

                                <div class="review-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus cum dolores
                                        assumenda asperiores facilis porro reprehenderit animi culpa atque
                                        blanditiis commodi perspiciatis doloremque, possimus, explicabo, autem fugit
                                        beatae quae voluptas!</p>
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
                                        laudantium iste amet. Cum non voluptate eos enim, ab cumque nam, modi, quas
                                        iure illum repellendus, blanditiis perspiciatis beatae!</p>
                                </div><!-- End .review-content -->

                                <div class="review-action">
                                    <a href="#"><i class="icon-thumbs-up"></i>Helpful (0)</a>
                                    <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                </div><!-- End .review-action -->
                            </div><!-- End .col-auto -->
                        </div><!-- End .row -->
                    </div><!-- End .review -->
                </div><!-- End .reviews -->
            </div><!-- .End .tab-pane -->
        </div><!-- End .tab-content -->
    </div><!-- End .product-details-tab -->


    @include('frontend.sections.owl-products', ['products' => $related, 'title' => 'You May Also Like'])

    </div><!-- End .page-content -->
</main><!-- End .main -->

@include('frontend.modals.addReview')

<script>
    document.addEventListener("DOMContentLoaded", function () {

        document.querySelectorAll(".quantity-box").forEach(function (box) {

            let input = box.querySelector(".qty-input");

            box.querySelector(".plus").addEventListener("click", function () {

                let value = parseInt(input.value) || 1;

                let max = parseInt(input.max) || 99;

                if (value < max) {

                    input.value = value + 1;

                }

            });

            box.querySelector(".minus").addEventListener("click", function () {

                let value = parseInt(input.value) || 1;

                let min = parseInt(input.min) || 1;

                if (value > min) {

                    input.value = value - 1;

                }

            });

        });

    });

    document.addEventListener("DOMContentLoaded", function () {

        document.querySelectorAll(".size-radio").forEach(function (radio) {

            radio.addEventListener("change", function () {

                let hidden =
                    this.closest(".product-option")
                    .querySelector("input[type='hidden']");

                hidden.value = this.value;

            });

        });

    });

    document.addEventListener("DOMContentLoaded", function () {

        const btn = document.getElementById("toggleDescription");
        const desc = document.getElementById("productDescription");

        if (btn) {

            btn.addEventListener("click", function () {

                desc.classList.toggle("expanded");

                if (desc.classList.contains("expanded")) {
                    btn.innerHTML = "Read Less";
                } else {
                    btn.innerHTML = "Read More";
                }

            });

        }

    });
    document.addEventListener('DOMContentLoaded', function () {
        // Select all quantity groups
        document.querySelectorAll('.product-details-quantity').forEach(function (qtyContainer) {
            const qtyInput = qtyContainer.querySelector('.qty-input');
            const plusBtn = qtyContainer.querySelector('.qty-btn.plus');
            const minusBtn = qtyContainer.querySelector('.qty-btn.minus');

            plusBtn.addEventListener('click', function () {
                let current = parseInt(qtyInput.value) || 1;
                if (current < parseInt(qtyInput.max)) {
                    qtyInput.value = current + 1;
                }
            });

            minusBtn.addEventListener('click', function () {
                let current = parseInt(qtyInput.value) || 1;
                if (current > parseInt(qtyInput.min)) {
                    qtyInput.value = current - 1;
                }
            });
        });
    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const mainImage = document.getElementById('product-zoom');

        document.querySelectorAll('.product-gallery-item').forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();

                const newImage = this.getAttribute('data-image');
                const zoomImage = this.getAttribute('data-zoom-image');

                // Change main image
                mainImage.src = newImage;
                mainImage.setAttribute('data-zoom-image', zoomImage);

                // Active class toggle
                document.querySelectorAll('.product-gallery-item').forEach(el => {
                    el.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

    });

</script>


@endsection
