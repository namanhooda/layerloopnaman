@extends('frontend.partials.app')
@section('content')
<main class="main">

    @include('frontend.sections.banner')

    <div class="mb-3 mb-lg-5"></div><!-- End .mb-3 mb-lg-5 -->

   @include('frontend.sections.topcategories')
    @include('frontend.sections.smlbanner')
    @include('frontend.sections.our-products')


    @include('frontend.sections.deals')
    @include('frontend.sections.latest-tshirts')
    @include('frontend.sections.howitwork')
    @include('frontend.sections.collections')
    @include('frontend.sections.reviews')
    @include('frontend.sections.instagram')
        

    <div class="mb-3"></div><!-- End .mb-6 -->

    <div class="mb-5"></div><!-- End .mb-5 -->



    <div class="mb-5"></div><!-- End .mb-5 -->


    <div class="mb-6"></div><!-- End .mb-6 -->


    @include('frontend.sections.topproducts')
    <div class="container">
        <hr class="mt-1 mb-6">
    </div><!-- End .container -->

    @include('frontend.sections.blogs')
</main><!-- End .main -->

@endsection
