@extends('frontend.partials.app')
@section('content')
<style>
    .card{

    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
    border-radius: 15px !important;;
    }
    .card-body {
    padding: 1.4rem 1.8rem 1.8rem 1.8rem !important;
    }
    @media screen and (max-width: 991px) {
    .table-mobile tr td {
        text-align: unset !important;
}
    }
</style>
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Order Success<span>Pages</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order Success</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="text-success">🎉 Order Placed Successfully!</h2>
            <p class="lead">Thank you, {{ $order->user->name }}. Your order has been placed.</p>
        </div>

        <!-- Order + Shipping Side by Side -->
        
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between">
                <!-- Order Details -->
                <div>
                    <h5 class="mb-3">Order Details</h5>
                    <p><strong>Order Code:</strong> {{ $order->order_code }}</p>
                    <p><strong>Status:</strong>
                        @if($order->status == 'Pending')
                        <span class="badge bg-success text-white">Pending</span>
                        @elseif($order->status == 'Cancelled')
                        <span class="badge bg-danger text-white">Cancelled</span>
                        @elseif($order->status == 'Delivered')
                        <span class="badge bg-primary text-white">Delivered</span>
                        @else
                        <span class="badge bg-secondary">{{ $order->status }}</span>
                        @endif
                    </p>
                    <p><strong>Total Amount:</strong> ₹{{ number_format($order->total, 2) }}</p>
                    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                </div>

                <!-- Shipping Address -->
                <div class="text-end">
                    <h5 class="mb-3">Shipping Address</h5>

                    <p>{{ $order->address->first_name }} {{ $order->address->last_name }}</p>

                    <p>{{ $order->address->address_line1 }}</p>
                    <p>{{ $order->address->address_line2 }}</p>

                    <p>{{ $order->address->city}}, {{ $order->address->state }} - {{ $order->address->zip }}</p>
                    <p>{{ $order->address->phone }} {{ $order->address->email }}</p>
                </div>
            </div>
        </div>

        <!-- Ordered Items -->
        
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Ordered Items</h5>
                <table class="table table-wishlist table-mobile">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Size</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->itemsData as $item)
                        <tr>
                            <td>
                                                <a href="{{ url('shop-product-detail/' . $item->product->slug) }}">
                                                    <img src="{{ asset('storage/' . $item->product->featured_image) }}"
                                                        alt="{{ $item->product->name }}" style="width: 80px;">
                                                </a>
                                            </td>
                            <td><a href="{{ url('shop-product-detail/' . $item->product->slug) }}">{{ $item->product->name }}</a></td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                                    <td class="price-col">{{ $item->size ?? 'Free' }}</td>
                            <td>₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @php
                        $subtotal = $order->itemsData->sum(fn($item) => $item->product->price * $item->quantity);
                        @endphp
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <!-- Main content (order details, products, etc.) -->
                    <div class="col-lg-8">
                        <!-- Your main content here -->
                    </div>

                    <aside class="col-lg-4">

                        <div class="summary summary-cart">
                            <table class="table table-summary">
                                <tbody>
                                    @php
                                    $total = $subtotal;
                                    $discount = 0;

                                    $total = $subtotal + $order->shipping_charges;
                                    if ($order->coupon_discount != null) {
                                        $total -= $order->coupon_discount;
                                    }
                                    @endphp
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td>₹{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    <tr class="summary-subtotal">
                                        <td>Shipping Charges:</td>
                                        <td>₹{{ number_format($order->shipping_charges, 2) }}</td>
                                    </tr>
                                    @if($order->coupon_discount != null)
                                    <tr class="summary-subtotal">
                                        <td>Coupon Applied:</td>
                                        <td>- ₹{{ number_format($order->coupon_discount, 2) }}</td>
                                    </tr>
                                    @endif

                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td id="final-total" data-base="{{ $total }}">₹{{ number_format($total, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <!-- Back to Shop -->
        <div class="text-center">
            <a href="{{ url('/shop') }}" class="btn btn-outline-primary">
                Continue Shopping <i class="icon-long-arrow-right"></i>
            </a>
        </div>
    </div>
</main>

@endsection
