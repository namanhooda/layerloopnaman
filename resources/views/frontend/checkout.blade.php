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
                                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                    data-target="#addAddressModal">
                                    + Add New Address
                                </button>
                            </div>

                            <div class="row">
                                @forelse($addresses as $address)
                                <div class="col-md-6 mb-3 ">
                                    <label
                                        class="w-100 address-card p-3 rounded shadow-sm border position-relative product-manual">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <input type="radio" name="billing_address" value="{{ $address->id }}"
                                                    required class="mr-2" />
                                                <strong>{{ $address->first_name }} {{ $address->last_name }}</strong>
                                            </div>
                                            <a href="#" class="text-muted edit-address" title="Edit Address">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </div>
                                        <div class="text-dark small">
                                            <p class="mb-1"><strong>Address:</strong> {{ $address->address }},
                                                {{ $address->city }}, {{ $address->state }}</p>
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
                                        $total = $subtotal;
                                        $discount = 0;
                                        $coupon = session('coupon');
                                        if ($coupon && $total >= $coupon['min_cart_value']) {
                                        $discount = $coupon['type'] === 'percent'
                                        ? ($total * $coupon['value'] / 100)
                                        : $coupon['value'];
                                        $total -= $discount;
                                        }
                                        // ✅ Apply shipping charges from session
                                        $shipping = session('shipping');
                                        $shippingCharge = 0;
                                        $shippingType = null;

                                        if ($shipping && isset($shipping['price'])) {
                                            $shippingCharge = (float) $shipping['price'];
                                            $shippingType = $shipping['type'] ?? 'free-shipping';
                                            $total += $shippingCharge;
                                        }
                                        @endphp
                                        <tr>
                                            <td>{{ $item->product->name }} × {{ $item->quantity }}</td>
                                            <td>₹ {{ number_format($lineTotal, 2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr class="summary-subtotal">
                                            <td>Subtotal:</td>
                                            <td>₹ {{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Shipping
                                                @if(session()->has('shipping'))
                                                ({{ session('shipping.type') }})
                                                @endif:
                                            </td>
                                            <td>
                                                @if(session()->has('shipping'))₹{{ session('shipping.price') }}
                                                @else
                                                Free Shipping
                                                @endif 
                                                <input type="hidden" name="shipping_type" value="{{$shippingType}}">
                                                <input type="hidden" name="shipping_charges" value="{{$shippingCharge}}">
                                            </td>
                                        </tr>
                                        <tr class="summary-total">
                                            <td>Total:</td>
                                            <td>₹ {{ number_format($total, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="accordion-summary" id="accordion-payment">
                                    <!-- Pay Online -->
                                    <div class="card">
                                        <div class="card-header" id="heading-1">
                                            <h2 class="card-title">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input payment-method"
                                                        name="payment_method" id="pay-online" value="online" checked
                                                        data-target="#collapse-1">
                                                    <label class="custom-control-label" for="pay-online">
                                                        Pay Online
                                                    </label>
                                                </div>
                                            </h2>
                                        </div>
                                        <div id="collapse-1" class="collapse show" aria-labelledby="heading-1"
                                            data-parent="#accordion-payment">
                                            <div class="card-body">
                                                Pay online using cards, UPI, or net banking.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pay Using Wallet -->
                                    <div class="card">
                                        <div class="card-header" id="heading-2">
                                            <h2 class="card-title">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input payment-method"
                                                        name="payment_method" id="pay-wallet" value="wallet"
                                                        data-target="#collapse-2">
                                                    <label class="custom-control-label" for="pay-wallet">
                                                        Pay Using Wallet
                                                    </label>
                                                </div>
                                            </h2>
                                        </div>
                                        <div id="collapse-2" class="collapse" aria-labelledby="heading-2"
                                            data-parent="#accordion-payment">
                                            <div class="card-body">
                                                Pay quickly with your wallet balance.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cash on Delivery -->
                                    <div class="card">
                                        <div class="card-header" id="heading-3">
                                            <h2 class="card-title">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input payment-method"
                                                        name="payment_method" id="pay-cod" value="cod"
                                                        data-target="#collapse-3">
                                                    <label class="custom-control-label" for="pay-cod">
                                                        Cash on Delivery
                                                    </label>
                                                </div>
                                            </h2>
                                        </div>
                                        <div id="collapse-3" class="collapse" aria-labelledby="heading-3"
                                            data-parent="#accordion-payment">
                                            <div class="card-body">
                                                ₹100 extra will be charged if you select cash on delivery.
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

    @include('frontend.modals.add-address-model')

@endsection
