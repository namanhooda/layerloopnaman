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

                            <button type="button" class="btn-buy-new buyNow"
                                        data-product-id="{{ $product->id }}">

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



    @include('frontend.sections.owl-products', ['products' => $related, 'title' => 'You May Also Like'])
    @include('frontend.sections.product-detail')

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
