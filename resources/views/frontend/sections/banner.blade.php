<style>
    /* Default desktop images */
.slide-1 { background-image: url('frontend/assets/images/demos/demo-2/slider/slide-1.jpg'); }
.slide-2 { background-image: url('frontend/assets/images/demos/demo-2/slider/slide-2.jpg'); }
.slide-3 { background-image: url('frontend/assets/images/demos/demo-2/slider/slide-3.jpg'); }

.intro-slide {
    background-size: cover;
    background-position: center;
}

/* Mobile override */
@media (max-width: 768px) {
    .slide-1 { background-image: url('frontend/assets/images/demos/demo-2/slider/slide-1-mobile.jpg'); }
    .slide-2 { background-image: url('frontend/assets/images/demos/demo-2/slider/slide-2-mobile.jpg'); }
    .slide-3 { background-image: url('frontend/assets/images/demos/demo-2/slider/slide-3-mobile.jpg'); }
}
</style>
<div class="intro-slider-container">
        <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl"
            data-owl-options='{"nav": false}'>
            <div class="intro-slide  slide-1" >
                
                <div class="container intro-content">
                    <h3 class="intro-subtitle">ssCustomized</h3>
                    <h1 class="intro-title" style="margin-bottom: 0px !important;">Customized Lithiofanes</h1><h2 style="color: lightgrey !important;">Convert Your Image To Lightbox.</h2>

                    <a href="{{url('shop')}}" class="btn btn-primary">
                        <span>Shop Now</span>
                        <i class="icon-long-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="intro-slide slide-2" >
                <div class="container intro-content">
                    <h3 class="intro-subtitle">Lamps</h3><!-- End .h3 intro-subtitle -->
                    <h1 class="intro-title">Ypperlig <br>Moon lamps <br><span
                            class="text-primary">
                            <!-- <sup>$</sup>49,99</span> -->
                        </h1><!-- End .intro-title -->

                    <a href="{{url('shop')}}" class="btn btn-primary">
                        <span>Shop Now</span>
                        <i class="icon-long-arrow-right"></i>
                    </a>
                </div><!-- End .container intro-content -->
            </div><!-- End .intro-slide -->

            <div class="intro-slide slide-3" >
                <div class="container intro-content">
                    <h3 class="intro-subtitle">Customized</h3><!-- End .h3 intro-subtitle -->

                    <h1 class="intro-title" style="margin-bottom: 0px !important;">Customized Tshirts </h1>
                    <h2 style="color: lightgrey !important;">Walk In Style With Our Tshirts.</h2>
                    
                            <!-- <span class="text-primary">
                            <sup class="text-white font-weight-light">from</sup><sup>$</sup>9,99
                        </span> -->
                    <a href="{{url('shop')}}" class="btn btn-primary">
                        <span>Shop Now</span>
                        <i class="icon-long-arrow-right"></i>
                    </a>
                </div><!-- End .container intro-content -->
            </div><!-- End .intro-slide -->
        </div><!-- End .owl-carousel owl-simple -->

        <span class="slider-loader text-white"></span><!-- End .slider-loader -->
    </div><!-- End .intro-slider-container -->
