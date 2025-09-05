@extends('frontend.partials.app')
@section('content')
<main class="main">

    @include('frontend.sections.banner')
    @include('frontend.sections.brands')

    <div class="mb-3 mb-lg-5"></div><!-- End .mb-3 mb-lg-5 -->


    @include('frontend.sections.category')
    <div class="mb-3"></div><!-- End .mb-6 -->

    @include('frontend.sections.latest-tshirts')
    <div class="mb-5"></div><!-- End .mb-5 -->


    @include('frontend.sections.our-products')

    <div class="mb-5"></div><!-- End .mb-5 -->


    @include('frontend.sections.deals')
    <div class="mb-6"></div><!-- End .mb-6 -->


    @include('frontend.sections.topproducts')
    <div class="container">
        <hr class="mt-1 mb-6">
    </div><!-- End .container -->

    @include('frontend.sections.blogs')
</main><!-- End .main -->

@endsection
