@extends('frontend.partials.app')
@section('content')

<main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="container">
	        	<div class="page-header page-header-big text-center" style="background-image: url('frontend/assets/images/contact-header-bg.jpg')">
        			<h1 class="page-title text-white">Contact us<span class="text-white">keep in touch with us</span></h1>
	        	</div><!-- End .page-header -->
            </div><!-- End .container -->

            <div class="page-content pb-0">
                <div class="container">
                	<div class="row">
                		<div class="col-lg-6 mb-2 mb-lg-0">
                			<h2 class="title mb-1">Contact Information</h2><!-- End .title mb-2 -->
                			<p class="mb-3">Have a question, custom request, or just want to say hi? We're here to help!.</p>
                			<div class="row">
                				<div class="col-sm-7">
                					<div class="contact-info">
                						<h3>The Office</h3>

                						<ul class="contact-list">
                							<li>
                								<i class="icon-map-marker"></i>
	                							Ward no 7, pana chulyan, Beri, PO:Beri, DIST:Jhajjar, Haryana, 124201
	                						</li>
                							<li>
                								<i class="icon-phone"></i>
                								<a href="tel:#">+91 8059808185</a>
                							</li>
                							<li>
                								<i class="icon-envelope"></i>
                								<a href="mailto:#">shop.layerloop@gmail.com</a>
                							</li>
                						</ul><!-- End .contact-list -->
                					</div><!-- End .contact-info -->
                				</div><!-- End .col-sm-7 -->

                				<div class="col-sm-5">
                					<div class="contact-info">
                						<h3><br></h3>

                						<ul class="contact-list">
                							<li>
                								<i class="icon-clock-o"></i>
	                							<span class="text-dark">Monday-Saturday</span> <br>10am-7pm IST
	                						</li>
                							<li>
                								<i class="icon-calendar"></i>
                								<span class="text-dark">Sunday</span> <br>12am-4pm IST
                							</li>
                						</ul><!-- End .contact-list -->
                					</div><!-- End .contact-info -->
                				</div><!-- End .col-sm-5 -->
                			</div><!-- End .row -->
                		</div><!-- End .col-lg-6 -->
                		<div class="col-lg-6">
                			<h2 class="title mb-1">Got Any Questions?</h2><!-- End .title mb-2 -->
                			<p class="mb-2">Use the form below to get in touch with the sales team</p>

                			<form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data" class="contact-form mb-3">
								@csrf
								<div class="row">
									<div class="col-sm-6">
										<label for="cname" class="sr-only">Name</label>
										<input type="text" class="form-control" id="cname" name="name" placeholder="Name *" required>
									</div>

									<div class="col-sm-6">
										<label for="cemail" class="sr-only">Email</label>
										<input type="email" class="form-control" id="cemail" name="email" placeholder="Email *" required>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">
										<label for="cphone" class="sr-only">Phone</label>
										<input type="tel" class="form-control" id="cphone" name="phone" placeholder="Phone">
									</div>

									<div class="col-sm-6">
										<label for="csubject" class="sr-only">Subject</label>
										<input type="text" class="form-control" id="csubject" name="subject" placeholder="Subject">
									</div>
								</div>

								<div class="row">
									<div class="col-sm-12">
										<label for="cattachment" class="sr-only">Attachment</label>
										<input type="file" class="form-control" id="cattachment" name="attachment">
									</div>
								</div>

								<label for="cmessage" class="sr-only">Message</label>
								<textarea class="form-control" cols="30" rows="4" id="cmessage" name="message" required placeholder="Message *"></textarea>

								<button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
									<span>SUBMIT</span>
									<i class="icon-long-arrow-right"></i>
								</button>
							</form>

                		</div><!-- End .col-lg-6 -->
                	</div><!-- End .row -->

                	<hr class="mt-4 mb-5">

                	
                </div><!-- End .container -->
            	<div id="map"><iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3504.9654014604424!2d77.2110193753188!3d28.54077387572726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce30a05ba07c3%3A0x68ef5a9a771e8da0!2sIndia%20Gate!5e0!3m2!1sen!2sin!4v1658234567890!5m2!1sen!2sin" 
    width="100%" 
    height="500" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
</iframe></div><!-- End #map -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

@endsection

        