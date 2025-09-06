@extends('frontend.partials.app')
@section('content')

<main class="main">
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">F.A.Q<span>Pages</span></h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">FAQ</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                	<h2 class="title text-center mb-3">Shipping Information</h2><!-- End .title -->
        			<div class="accordion accordion-rounded" id="accordion-1">
					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading-1">
					            <h2 class="card-title">
					                <a role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
					                    How will my parcel be delivered?
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1" data-parent="#accordion-1">
					            <div class="card-body">
					                Your order will be shipped via trusted courier partners like Delhivery, Bluedart, or India Post, depending on your location. You will receive a tracking link once your order has been dispatched.
					            </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->

					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading-2">
					            <h2 class="card-title">
					                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
					                    Do I pay for delivery?
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse-2" class="collapse" aria-labelledby="heading-2" data-parent="#accordion-1">
					            <div class="card-body">
We offer free shipping across India on all prepaid orders. Cash on delivery (COD) may include a small additional fee, which will be shown at checkout.
					            </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->

					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading-3">
					            <h2 class="card-title">
					                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
					                    Will I be charged customs fees?
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse-3" class="collapse" aria-labelledby="heading-3" data-parent="#accordion-1">
					            <div class="card-body">
Currently, we ship only within India, so there are no customs duties or import fees involved.
					            </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->

					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading-4">
					            <h2 class="card-title">
					                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
					                    My item has become faulty
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse-4" class="collapse" aria-labelledby="heading-4" data-parent="#accordion-1">
					            <div class="card-body">
We're sorry to hear that! If your product arrives damaged or becomes faulty within 7 days of delivery, please contact us with images, and we’ll arrange a replacement or refund based on the issue.
					            </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->
					</div><!-- End .accordion -->

                	<h2 class="title text-center mb-3">Orders and Returns</h2><!-- End .title -->
        			<div class="accordion accordion-rounded" id="accordion-2">
					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading2-1">
					            <h2 class="card-title">
					                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse2-1" aria-expanded="false" aria-controls="collapse2-1">
					                    Tracking my order
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse2-1" class="collapse" aria-labelledby="heading2-1" data-parent="#accordion-2">
					            <div class="card-body">
Once your order is shipped, you’ll receive an email and SMS with a tracking number. You can also track it anytime from your account dashboard.
					            </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->

					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading2-2">
					            <h2 class="card-title">
					                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse2-2" aria-expanded="false" aria-controls="collapse2-2">
					                    I haven’t received my order
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse2-2" class="collapse" aria-labelledby="heading2-2" data-parent="#accordion-2">
					            <div class="card-body">
If your order is delayed beyond the estimated delivery time, please contact us at shop.layerloop@gmail.com or call +91 8059808185. We'll help you track and resolve it quickly.
					            </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->

					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading2-3">
					            <h2 class="card-title">
					                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse2-3" aria-expanded="false" aria-controls="collapse2-3">
					                    How can I return an item?
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse2-3" class="collapse" aria-labelledby="heading2-3" data-parent="#accordion-2">
					            <div class="card-body">
We accept returns only if the product is defective, damaged during shipping, or the wrong item was sent. Contact us within 7 days of delivery with photo proof, and we’ll guide you through the return or exchange process.
					            </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->
					</div><!-- End .accordion -->

                	<h2 class="title text-center mb-3">Payments</h2><!-- End .title -->
                	<div class="accordion accordion-rounded" id="accordion-3">
					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading3-1">
					            <h2 class="card-title">
					                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse3-1" aria-expanded="false" aria-controls="collapse3-1">
					                    What payment types can I use?
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse3-1" class="collapse" aria-labelledby="heading3-1" data-parent="#accordion-3">
					            <div class="card-body">
We accept major payment methods including UPI, credit/debit cards, net banking, and wallets via secure Razorpay checkout. COD is also available for select pin codes.
					            </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->

					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading3-2">
					            <h2 class="card-title">
					                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse3-2" aria-expanded="false" aria-controls="collapse3-2">
					                    Can I pay by Gift Card?
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse3-2" class="collapse" aria-labelledby="heading3-2" data-parent="#accordion-3">
					            <div class="card-body">
We currently do not accept gift cards, but we’re working on adding this feature in the future.
					            </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->

					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading3-3">
					            <h2 class="card-title">
					                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse3-3" aria-expanded="false" aria-controls="collapse3-3">
					                    I can't make a payment
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse3-3" class="collapse" aria-labelledby="heading3-3" data-parent="#accordion-3">
					            <div class="card-body">
Make sure your internet connection is stable and your card or UPI app has sufficient balance. If it still doesn't work, try another payment method or contact us for help.
					            </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->

					    <div class="card card-box card-sm bg-light">
					        <div class="card-header" id="heading3-4">
					            <h2 class="card-title">
					                <a class="collapsed" role="button" data-toggle="collapse" href="#collapse3-4" aria-expanded="false" aria-controls="collapse3-4">
					                    Has my payment gone through?
					                </a>
					            </h2>
					        </div><!-- End .card-header -->
					        <div id="collapse3-4" class="collapse" aria-labelledby="heading3-4" data-parent="#accordion-3">
					            <div class="card-body">
Once payment is successful, you’ll receive an order confirmation via email and SMS. If you’re unsure, check your bank statement or contact us with your payment details for verification.
					            </div><!-- End .card-body -->
					        </div><!-- End .collapse -->
					    </div><!-- End .card -->
					</div><!-- End .accordion -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->

            <div class="cta cta-display bg-image pt-4 pb-4" style="background-image: url(frontend/assets/images/backgrounds/cta/bg-7.jpg);">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-9 col-xl-7">
                            <div class="row no-gutters flex-column flex-sm-row align-items-sm-center">
                                <div class="col">
                                    <h3 class="cta-title text-white">If You Have More Questions</h3><!-- End .cta-title -->
                                    <p class="cta-desc text-white">We're just a message away. Reach out and we'll help you with anything you need.</p><!-- End .cta-desc -->
                                </div><!-- End .col -->

                                <div class="col-auto">
                                    <a href="{{url('contact_us')}}" class="btn btn-outline-white"><span>CONTACT US</span><i class="icon-long-arrow-right"></i></a>
                                </div><!-- End .col-auto -->
                            </div><!-- End .row no-gutters -->
                        </div><!-- End .col-md-10 col-lg-9 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .cta -->
        </main><!-- End .main -->

@endsection

        