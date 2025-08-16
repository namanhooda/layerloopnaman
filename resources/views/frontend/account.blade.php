@extends('frontend.partials.app')
@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">My Account<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Account</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->


    <div class="page-content">
        <div class="container">
            <h2 class="title text-center mb-3">Your Account</h2><!-- End .title mb-2 -->

            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4" style="border-radius: 15px;">
                    <div class="banner" style="border-radius: 15px;">
                        <a href="#">
                            <img src="{{asset('frontend/assets/images/banners/3cols/banner-1.jpg')}}" alt="Banner" style="border-radius: 15px;">
                        </a>

                        <div class="banner-content">
                            <h4 class="banner-title">Your Orders</h4><!-- End .banner-subtitle -->
                            <h3 class="banner-subtitle">Track, return, or buy things again</h3>
                            <!-- End .banner-title -->
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div><!-- End .col-md-6 -->
                <div class="col-md-6 col-lg-4" style="border-radius: 15px;">
                    <div class="banner" style="border-radius: 15px;">
                        <a href="#">
                            <img src="{{asset('frontend/assets/images/banners/3cols/banner-1.jpg')}}" alt="Banner" style="border-radius: 15px;">
                        </a>
                        <div class="banner-content">
                            <h4 class="banner-title">Login & Security</h4>
                            <h3 class="banner-subtitle">Edit login, name, and mobile number</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" style="border-radius: 15px;">
                    <div class="banner" style="border-radius: 15px;">
                        <a href="#">
                            <img src="{{asset('frontend/assets/images/banners/3cols/banner-1.jpg')}}" alt="Banner" style="border-radius: 15px;">
                        </a>

                        <div class="banner-content">
                            <h4 class="banner-title">Your Addresses</h4><!-- End .banner-subtitle -->
                            <h3 class="banner-subtitle">Edit addresses for orders and gifts</h3>
                            <!-- End .banner-title -->
                        </div><!-- End .banner-content -->
                    </div><!-- End .banner -->
                </div>
                <div class="col-md-6 col-lg-4" style="border-radius: 15px;">
                    <div class="banner" style="border-radius: 15px;">
                        <a href="#">
                            <img src="{{asset('frontend/assets/images/banners/3cols/banner-1.jpg')}}" alt="Banner" style="border-radius: 15px;">
                        </a>
                        <div class="banner-content">
                            <h4 class="banner-title">Your Wishlist</h4>
                            <h3 class="banner-subtitle">Track, return, or buy things again</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" style="border-radius: 15px;">
                    <div class="banner" style="border-radius: 15px;">
                        <a href="#">
                            <img src="{{asset('frontend/assets/images/banners/3cols/banner-1.jpg')}}" alt="Banner" style="border-radius: 15px;">
                        </a>
                        <div class="banner-content">
                            <h4 class="banner-title">Your Wallet</h4>
                            <h3 class="banner-subtitle">Track, return, or buy things again</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4" style="border-radius: 15px;">
                    <div class="banner" style="border-radius: 15px;">
                        <a href="#">
                            <img src="{{asset('frontend/assets/images/banners/3cols/banner-1.jpg')}}" alt="Banner" style="border-radius: 15px;" style="border-radius: 15px;">
                        </a>
                        <div class="banner-content">
                            <h4 class="banner-title">Contact Us</h4>
                            <h3 class="banner-subtitle">Track, return, or buy things again</h3>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="mb-4">
        </div><!-- End .container -->
    </div><!-- End .container -->

</main><!-- End .main -->

@endsection
