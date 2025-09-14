@extends('frontend.partials.app')
@section('content')
<style>
	.card {

        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        border-radius: 15px !important;
        ;
    }
</style>
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">My Addresses<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('account')}}">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Addresses</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <div class="row">

                    @include('frontend.user.aside')
                    <div class="col-md-8 col-lg-9">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-address" role="tabpanel"
                                aria-labelledby="tab-address-link">
                                <h5>Addresses</h5>

                                <div class="row">
                                    @foreach($addresses as $address)
                                    <div class="col-lg-6">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Billing Address</h3>
                                                <p>
                                                    {{ $address->first_name }} {{ $address->last_name }} <br>
                                                    {{ $address->company }} <br>
                                                    {{ $address->address_line1 }} <br>
                                                    @if($address->address_line2)
                                                    {{ $address->address_line2 }} <br>
                                                    @endif
                                                    {{ $address->city }}, {{ $address->state }} {{ $address->zip }} <br>
                                                    {{ $address->phone }} <br>
                                                    {{ $address->email }} <br>
                                                    <a href="">Edit <i class="icon-edit"></i></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <!-- End .col-lg-6 -->

                                    <div class="col-lg-6">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Shipping Address</h3><!-- End .card-title -->

                                                <p>You have not set up this type of address yet.<br>
                                                    <button type="button" class="btn btn-sm btn-outline-primary my-button"
                                                        data-toggle="modal" data-target="#addAddressModal">
                                                        + Add New Address
                                                    </button>

                                                    @include('frontend.modals.add-address-model')</p>
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                            </div><!-- .End .tab-pane -->
                        </div>
                    </div><!-- End .col-lg-9 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
</main>

@endsection
