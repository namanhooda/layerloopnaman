@extends('frontend.partials.app')
@section('content')

<main class="main"><div class="page-header text-center" style="background-image: url('frontend/assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Our Work<span>Gallary</span></h1>
        </div><!-- End .container -->
    </div>
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gallary</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="container">
	        	<iframe 
    src="https://drive.google.com/embeddedfolderview?id=1BxQrimR_CrKMutrdgKCZUG7W5qqQfqjF#grid"
    style="width:100%; height:600px; border:0;">
</iframe>
            </div><!-- End .container -->

            <div class="page-content pb-0">
                <div class="container">
                   
                    <div class="mb-5"></div><!-- End .mb-4 -->
                </div><!-- End .container -->

                <div class="mb-2"></div><!-- End .mb-2 -->

             
            </div><!-- End .page-content -->
        </main><!-- End .main -->

@endsection

        