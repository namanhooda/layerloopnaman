<style>
    /* Hide by default (mobile) */

    .bnr-hero-features {
        margin-top: 40px;
    }

    .bnr-feature-item {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #fff;
        font-weight: 500;
        font-size: 15px;
    }

    .bnr-feature-item i {
        width: 34px;
        height: 34px;
        border: 2px solid #3ddc5a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3ddc5a;
        font-size: 15px;
    }

    .btn-success {
        background: #55d85a;
        border: none;
        border-radius: 10px;
        font-weight: 600;
    }

    .btn-outline-light {
        border: 2px solid rgba(255, 255, 255, .6);
        border-radius: 10px;
        font-weight: 600;
    }

    .bnr-stats-section {
        padding-top: 15px;
    }

    .bnr-stats-section h3 {
        color: #55d85a;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .bnr-stats-section p {
        color: #ddd;
        margin: 0;
        font-size: 15px;
    }

    @media(max-width:768px) {

        .bnr-feature-item {
            justify-content: flex-start;
            font-size: 14px;
        }

        .bnr-stats-section h3 {
            font-size: 24px;
        }

        .btn {
            width: 100%;
        }
    }

    /* Default desktop images */
    .slide-1 {
        background-image: url('frontend/banners/banner 1.png');
    }

    .slide-2 {
        background-image: url('frontend/banners/banner 1.png');
    }

    .slide-3 {
        background-image: url('frontend/banners/banner 1.png');
    }

    .intro-slide {
        background-size: cover;
        background-position: center;
    }

    /* Mobile override */
    @media (max-width: 768px) {
        .slide-1 {
            background-image: url('frontend/banners/banner 1.png');
        }

        .slide-2 {
            background-image: url('frontend/banners/banner 1.png');
        }

        .slide-3 {
            background-image: url('frontend/banners/banner 1.png');
        }
    }

</style>
<div class="intro-slider-container">
    <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{"nav": false}'>
        <div class="intro-slide slide-1">
            <div class="container intro-content">
                <h3 class="intro-subtitle">CRAFTED WITH PRECISION</h3>
                <h1 class="intro-title">PRINTED WITH <br>PERFECTION.</h1>
                <h6>premium 3d printed idols, lithophanes, lamps, miniatures<br>and custom creations made with passion
                </h6>
                <h6>
                    <div class="row text-center g-3 mb-2 onlyweb" style="margin-left: -62px;">
                        <div class="col- col-md-8">
                            <div class="bnr-feature-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Premium Quality</span> &nbsp;&nbsp;
                            </div>
                            <div class="bnr-feature-item">
                                <i class="fas fa-tags"></i>
                                <span>Fast Pricing</span> &nbsp;&nbsp;
                            </div>
                            <div class="bnr-feature-item">
                                <i class="fas fa-box"></i>
                                <span>Secure Packaging</span> &nbsp;&nbsp;
                            </div>
                            <div class="bnr-feature-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Made in India</span> &nbsp;&nbsp;
                            </div>
                        </div>


                    </div>
                </h6>
                <a href="category.html" class="btn btn-primary btnshopnow">
                    <span>Shop Now</span>
                    <i class="icon-long-arrow-right"></i>
                </a>
                <div class="row text-center bnr-stats-section onlyweb" style="margin-left: -55px;">
                    <div class="col-6 col-md-2">
                        <h3>3000+</h3>
                        <p>Products</p>
                    </div>

                    <div class="col-6 col-md-2">
                        <h3>25K+</h3>
                        <p>Happy Customers</p>
                    </div>

                    <div class="col-6 col-md-2">
                        <h3>4.9★</h3>
                        <p>Average Rating</p>
                    </div>

                    <div class="col-6 col-md-2">
                        <h3>99.5%</h3>
                        <p>Orders Delivered</p>
                    </div>
                </div>
            </div><!-- End .container intro-content -->
        </div><!-- End .intro-slide -->

        <div class="intro-slide" style="background-image: url(assets/images/demos/demo-2/slider/slide-2.jpg);">
            <div class="container intro-content">
                <h3 class="intro-subtitle">Deals and Promotions</h3><!-- End .h3 intro-subtitle -->
                <h1 class="intro-title">Ypperlig <br>Coffee Table <br><span
                        class="text-primary"><sup>$</sup>49,99</span></h1><!-- End .intro-title -->

                <a href="category.html" class="btn btn-primary btnshopnow">
                    <span>Shop Now</span>
                    <i class="icon-long-arrow-right"></i>
                </a>
            </div><!-- End .container intro-content -->
        </div><!-- End .intro-slide -->

        <div class="intro-slide" style="background-image: url(assets/images/demos/demo-2/slider/slide-3.jpg);">
            <div class="container intro-content">
                <h3 class="intro-subtitle">Living Room</h3><!-- End .h3 intro-subtitle -->
                <h1 class="intro-title">
                    Make Your Living Room <br>Work For You.<br>
                    <span class="text-primary">
                        <sup class="text-white font-weight-light">from</sup><sup>$</sup>9,99
                    </span>
                </h1><!-- End .intro-title -->

                <a href="category.html" class="btn btn-primary btnshopnow">
                    <span>Shop Now</span>
                    <i class="icon-long-arrow-right"></i>
                </a>
            </div><!-- End .container intro-content -->
        </div><!-- End .intro-slide -->
    </div><!-- End .owl-carousel owl-simple -->

    <span class="slider-loader text-white"></span><!-- End .slider-loader -->
</div><!-- End .intro-slider-container -->
