@extends('frontend.partials.app')

@section('content')

<div class="container text-center" style="padding:80px 0">
    <h2>✅ Order Placed Successfully</h2>
    <p>Your order is confirmed. Tracking details will be shared soon.</p>

    <a href="{{ url('shop') }}" class="btn btn-primary">
        Continue Shopping
    </a>
</div>

@endsection
