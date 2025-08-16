@extends('frontend.partials.app')
@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Checkout<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="checkout">
            <div class="container">
                <form action="{{ route('checkout.placeOrder') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-lg-9 summary">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="checkout-title mb-0">Billing Address</h2>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#addAddressModal">
                                    + Add New Address
                                </button>
                            </div>

                            <div class="row">
                                @forelse($addresses as $address)
                                    <div class="col-md-6 mb-3 ">
                                        <label class="w-100 address-card p-3 rounded shadow-sm border position-relative product-manual">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <input type="radio" name="billing_address" value="{{ $address->id }}" required class="mr-2" />
                                                    <strong>{{ $address->first_name }} {{ $address->last_name }}</strong>
                                                </div>
                                                <a href="#" class="text-muted edit-address" title="Edit Address">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </div>
                                            <div class="text-dark small">
                                                <p class="mb-1"><strong>Address:</strong> {{ $address->address }}, {{ $address->city }}, {{ $address->state }}</p>
                                                <p class="mb-1"><strong>Pin Code:</strong> {{ $address->zip }}</p>
                                                <p class="mb-0"><strong>Phone:</strong> +91 {{ $address->phone }}</p>
                                            </div>
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted ml-3">No addresses found. Please add one.</p>
                                @endforelse
                            </div>
                        </div>

                        <aside class="col-lg-3">
                            <div class="summary">
                                <h3 class="summary-title">Your Order</h3>

                                <table class="table table-summary">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $subtotal = 0; @endphp
                                        @foreach($cartItems as $item)
                                            @php
                                                $lineTotal = $item->product->price * $item->quantity;
                                                $subtotal += $lineTotal;
                                            @endphp
                                            <tr>
                                                <td>{{ $item->product->name }} × {{ $item->quantity }}</td>
                                                <td>${{ number_format($lineTotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="summary-subtotal">
                                            <td>Subtotal:</td>
                                            <td>${{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping:</td>
                                            <td>Free Shipping</td>
                                        </tr>
                                        <tr class="summary-total">
                                            <td>Total:</td>
                                            <td>${{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="accordion-summary" id="accordion-payment">
                                    <div class="card">
                                        <div class="card-header" id="heading-1">
                                            <h2 class="card-title">
                                                <a role="button" data-toggle="collapse" href="#collapse-1"
                                                    aria-expanded="true" aria-controls="collapse-1">
                                                    Cash on Delivery
                                                </a>
                                            </h2>
                                        </div>
                                        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1"
                                            data-parent="#accordion-payment">
                                            <div class="card-body">
                                                Pay with cash upon delivery.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading-1">
                                            <h2 class="card-title">
                                                <a role="button" data-toggle="collapse" href="#collapse-1"
                                                    aria-expanded="true" aria-controls="collapse-1">
                                                    Pay Online
                                                </a>
                                            </h2>
                                        </div>
                                        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1"
                                            data-parent="#accordion-payment">
                                            <div class="card-body">
                                                Pay with cash upon delivery.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="heading-1">
                                            <h2 class="card-title">
                                                <a role="button" data-toggle="collapse" href="#collapse-1"
                                                    aria-expanded="true" aria-controls="collapse-1">
                                                    Pay Using Wallet
                                                </a>
                                            </h2>
                                        </div>
                                        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1"
                                            data-parent="#accordion-payment">
                                            <div class="card-body">
                                                Pay with cash upon delivery.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block mt-3">
                                    <span class="btn-text">Place Order</span>
                                    <span class="btn-hover-text">Proceed to Checkout</span>
                                </button>
                            </div>
                        </aside>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('addresses.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>First Name *</label>
                            <input name="first_name" type="text" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label>Last Name *</label>
                            <input name="last_name" type="text" class="form-control" required>
                        </div>
                    </div>

                    <label>Company Name (Optional)</label>
                    <input name="company" type="text" class="form-control">

                    <label>Country *</label>
                    <input name="country" type="text" class="form-control" required>

                    <label>Street Address *</label>
                    <input name="address" type="text" class="form-control" required>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>City *</label>
                            <input name="city" type="text" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label>State *</label>
                            <input name="state" type="text" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>ZIP / Postal Code *</label>
                            <input name="zip" type="text" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label>Phone *</label>
                            <input name="phone" type="text" class="form-control" required>
                        </div>
                    </div>

                    <label>Email *</label>
                    <input name="email" type="email" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Address</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
