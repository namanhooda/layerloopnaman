@extends('frontend.partials.app')
@section('content')
<style>
    .btn-wishlist {
        border: none !important;
        outline: none;
        background-color: transparent;
        box-shadow: none;
    }

    .product-details-quantity {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .qty-input::-webkit-inner-spin-button,
    .qty-input::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Remove arrows in Firefox */
    .qty-input {
        -moz-appearance: textfield;
    }

    .qty-btn {
        background-color: #64c474;
        color: white;
        border: none;
        padding: 5px 12px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 4px;
        user-select: none;
    }

    .qty-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .qty-input {
        width: 60px;
        text-align: center;
        font-size: 16px;
        padding: 5px;
    }
    @media (min-width: 1024px) {
    .content-div-r {
        margin-left: 126px;
        margin-right: 125px;
    }
    }


</style>
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
                            <h1 class="product-title">{{$product->name}}</h1>

                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: 80%;"></div>
                                </div>
                                <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
                            </div>

                            <div class="product-price">
                                ₹{{ $product->discounted_price }}
                                <span
                                    style="text-decoration: line-through; color: red; margin-left: 10px;font-size: 12px;">
                                    ₹{{ $product->price }}
                                </span>
                            </div>

                            <div class="product-content">
                                <p>{{$product->description ?? "Discover our premium 3D printed creations and custom DTF printed T-shirts, made for style and durability. From intricate 3D printed products to vibrant DTF T-shirts, we bring your ideas to life with quality and care."}}
                                </p>
                            </div>

                            @if($product->color)
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
                            @endif

                            @if($product->size)
                            @php
                            $selectedSizes = $product->size ? json_decode($product->size) : [];
                            @endphp

                            <div class="details-filter-row details-row-size">
                                <label for="size">Size:</label>
                                <div class="select-custom">
                                    <select name="size" id="size" class="form-control">
                                        <option value="#" {{ empty($selectedSizes) ? 'selected' : '' }}>Select a size
                                        </option>
                                        <option value="S" {{ in_array('S', $selectedSizes) ? 'selected' : '' }}>Small
                                        </option>
                                        <option value="M" {{ in_array('M', $selectedSizes) ? 'selected' : '' }}>Medium
                                        </option>
                                        <option value="L" {{ in_array('L', $selectedSizes) ? 'selected' : '' }}>Large
                                        </option>
                                        <option value="XL" {{ in_array('XL', $selectedSizes) ? 'selected' : '' }}>Extra
                                            Large</option>
                                        <option value="XXL" {{ in_array('XXL', $selectedSizes) ? 'selected' : '' }}>XXL
                                        </option>
                                    </select>
                                </div>

                                <a href="#" class="size-guide"><i class="icon-th-list"></i> size guide</a>
                            </div>
                            @endif


                            <div class="details-filter-row details-row-size">
                                <label for="qty">Qty:</label>
                                <div class="product-details-quantity">
                                    <button type="button" class="qty-btn minus">-</button>
                                    <input type="number" id="quantity-{{ $product->id }}" name="quantity"
                                        class="form-control qty-input" value="1" min="1" max="10" step="1" required>
                                    <button type="button" class="qty-btn plus">+</button>
                                </div>
                            </div>

                            <div class="product-details-action">
                                <input type="hidden" id="product-id-{{ $product->id }}" value="{{ $product->id }}"
                                    style="">
                                <button type="button" class="btn-product btn-cart"
                                    onclick="addToCart({{ $product->id }})"
                                    style="color: #fff;border-color: #64c474;background-color: #64c474;">
                                    <span>add to cart</span>
                                </button>

                                <div class="details-action-wrapper">
                                    <button type="button" class="btn-product btn-wishlist add-to-wishlist"
                                        title="Wishlist" data-product-id="{{ $product->id }}">
                                        <span>Add to Wishlist</span>
                                    </button>
                                </div>
                            </div>

                            <div class="product-details-footer">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="#" class="prodcatlink">{{$product->categoryData->name ?? ''}}</a>
                                </div>

                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>

                                    <a href="{{url('https://www.facebook.com/profile.php?id=61579088633589')}}" class="social-icon social-facebook" title="Facebook" target="_blank"><i
                                            class="icon-facebook-f"></i></a>
                                    <a href="https://wa.me/918059808185" 
   class="social-icon social-whatsapp" 
   title="WhatsApp" 
   target="_blank">
    <i class="icon-whatsapp"></i>
</a>

                                    <a href="{{url('https://www.instagram.com/layerloop.web/')}}"
                                        class="social-icon social-instagram" title="Instagram" target="_blank"><i
                                            class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon social-youtube" title="Youtube" target="_blank"><i
                                            class="icon-youtube"></i></a>
                                    <a href="#" class="social-icon social-pinterest" title="Pinterest"
                                        target="_blank"><i class="icon-pinterest"></i></a>
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
                                <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                            </li>
                        </ul>
                        <div class="tab-content content-div-r">
                            <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                                <div class="product-desc-content">
                                    <h3>Product Information</h3>
                                    <p>We are a specialized 3D printing business offering a wide range of high-quality 3D printed products crafted with precision and care. Our collection includes 3D model idols, decorative frames, lamps, customized models, and modern home décor items, designed to add a unique and elegant touch to your space.</p>
                                    <ul>
                                        <li>We are a specialized 3D printing business offering a wide range of high-quality 3D printed products crafted with precision and care. Our collection includes 3D model idols, decorative frames, lamps, customized models, and modern home décor items, designed to add a unique and elegant touch to your space. </li>
                                        <li>Our designs combine creativity with functionality, making them suitable for home décor, gifting, office spaces, temples, and personal collections.</li>
                                        <li>We focus on clean detailing, accurate dimensions, and premium aesthetics, ensuring every product meets high standards before dispatch.</li>
                                    </ul>

                                    <p>Whether you are looking for a spiritual idol, a decorative piece, or a customized 3D model, our products are designed to reflect craftsmanship and innovation.</p>
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                                <div class="product-desc-content">
                                    <h3>Information</h3>
                                    <ul>
                                        <li>Material: High-quality 3D printing material (PLA / Resin / PETG – depending on product)</li>
                                        <li>Manufacturing Process: Advanced 3D printing technology with precision detailing</li>
                                        <li>Finish: Smooth matte or semi-gloss finish (may vary by design)</li>
                                        <li>Color Options: Available in multiple colors (custom colors on request)</li>
                                        <li>Customization: Custom sizes, colors, and designs available on request</li>
                                        <li>Usage: Suitable for home décor, gifting, office décor, temples, and display purposes</li>
                                        <li>Care Instructions: Clean gently with a dry or soft cloth; avoid water and direct heat</li>
                                        <li>Care Instructions: Clean gently with a dry or soft cloth; avoid water and direct heat</li>
                                        <li>Packaging: Securely packed to prevent damage during transit</li>
                                        <li>Country of Origin: Made in India</li>
                                    </ul>
                                    <p>Note: Since these products are 3D printed, slight variations in texture, color, or layer lines may occur. These are natural characteristics of the 3D printing process and not considered defects.</p>
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                                <div class="product-desc-content">
                                    <h3>Delivery & returns</h3>
                                    <p>We deliver to over 100 countries around the world. For full details of the delivery options we offer, please view our <a href="#">Delivery information</a><br>
                                    We hope you’ll love every purchase, but if you ever need to return an item you can do so within a month of receipt. For full details of how to make a return, please view our <a href="#">Returns information</a></p>
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
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus cum dolores assumenda asperiores facilis porro reprehenderit animi culpa atque blanditiis commodi perspiciatis doloremque, possimus, explicabo, autem fugit beatae quae voluptas!</p>
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
                                                        <div class="ratings-val" style="width: 100%;"></div><!-- End .ratings-val -->
                                                    </div><!-- End .ratings -->
                                                </div><!-- End .rating-container -->
                                                <span class="review-date">5 days ago</span>
                                            </div><!-- End .col -->
                                            <div class="col">
                                                <h4>Very good</h4>

                                                <div class="review-content">
                                                    <p>Sed, molestias, tempore? Ex dolor esse iure hic veniam laborum blanditiis laudantium iste amet. Cum non voluptate eos enim, ab cumque nam, modi, quas iure illum repellendus, blanditiis perspiciatis beatae!</p>
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

        @include('frontend.sections.related')

    </div><!-- End .page-content -->
</main><!-- End .main -->

@include('frontend.modals.addReview')
<script>
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
