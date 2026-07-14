@extends('frontend.partials.app')

@section('content')
<style>
    .crt-cart-page {
        background: #f8f9fb;
        padding: 35px 0 70px;
    }

    .crt-breadcrumb {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        margin-bottom: 18px;
        color: #777;
    }

    .crt-breadcrumb a {
        color: #666;
        text-decoration: none;
    }

    .crt-cart-title {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 28px;
    }

    .crt-cart-title span {
        color: #16a34a;
    }

    .crt-cart-features {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 14px;
        padding: 18px 24px;
        margin-bottom: 35px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, .04);
    }

    .crt-cart-features div {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #555;
        font-weight: 500;
    }

    .crt-cart-card {

        background: #fff;

        border: 1px solid #ececec;

        border-radius: 20px;

        padding: 22px 26px;

        margin-bottom: 20px;

    }

    .crt-cart-row {
        display: flex;
        align-items: center;
        gap: 0px;
    }

    .crt-product {
        flex: 1;
        display: flex;
        align-items: center;
        min-width: 0;
    }

    .crt-info {
        margin-left: 18px;
        flex: 1;
    }

    .crt-price {
        width: 100px;
        text-align: center;
        font-size: 16px;
        font-weight: 700;
        color: #555;
    }

    .crt-quantity {
        width: 150px;
        display: flex;
        justify-content: center;
    }

    .crt-total {
        width: 120px;
        text-align: right;
        font-size: 18px;
        font-weight: 700;
        color: #28a745;
    }

    .crt-delete {
        width: 40px;
        display: flex;
        justify-content: flex-end;
    }

    .crt-remove {

        width: 36px;

        height: 36px;

        border-radius: 50%;

        border: none;

        background: #f4f4f4;

    }

    .crt-qty {

        display: flex;

        align-items: center;

        justify-content: space-between;

        width: 130px;

        height: 48px;

        border: 1px solid #e5e5e5;

        border-radius: 12px;

        overflow: hidden;

        background: #fff;

    }

    .crt-qty button {

        width: 40px;

        height: 48px;

        border: none;

        background: #fff;

        font-size: 22px;

        font-weight: 600;

        cursor: pointer;

    }

    .crt-qty button:hover {

        background: #f5f5f5;

    }

    .crt-qty input {

        width: 40px;

        border: none;

        text-align: center;

        background: transparent;

        font-size: 18px;

        font-weight: 700;

        outline: none;

        box-shadow: none;

    }

    .crt-cart-image {

        width: 90px;

        height: 90px;

        object-fit: contain;

        border-radius: 10px;

        background: #f7f7f7;

        padding: 8px;

    }

    .crt-info h5 {

        font-size: 15px;

        font-weight: 700;

        line-height: 1.25;

        margin-bottom: 10px;

    }

    .crt-remove {

        width: 34px;

        height: 34px;

        border-radius: 50%;

        border: none;

        background: #f2f2f2;

        color: #777;

        font-size: 18px;

    }

    .crt-summary {
        background: #fff;
        border-radius: 18px;
        padding: 28px;
        position: sticky;
        top: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, .05);
        border: 1px solid #ececec;
    }

    .crt-summary h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 25px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        font-size: 17px;
    }

    .shipping-options label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        cursor: pointer;
        font-size: 15px;
    }

    .shipping-options input {
        margin-right: 10px;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
        font-size: 26px;
        font-weight: 700;
    }

    .summary-total strong {
        color: #16a34a;
    }

    .crt-progress {
        margin-top: 25px;
        margin-bottom: 25px;
        background: #f7faf7;
        padding: 15px;
        border-radius: 12px;
    }

    .progress {
        height: 8px;
        margin-top: 10px;
        border-radius: 30px;
        background: #e7e7e7;
    }

    .progress-bar {
        background: #16a34a;
    }

    .crt-summary .btn-success {
        background: #16a34a;
        border: none;
        border-radius: 12px;
        height: 55px;
        font-size: 18px;
        font-weight: 700;
    }

    .crt-summary .btn-success:hover {
        background: #12863d;
    }

    .crt-summary .btn-outline-success {
        border-radius: 12px;
        height: 52px;
        font-weight: 600;
    }

    .crt-summary .btn-light {
        border-radius: 12px;
        height: 52px;
        background: #fff;
        border: 1px solid #ddd;
    }

    .crt-coupon {
        display: flex;
        gap: 15px;
        margin-top: 25px;
    }

    .crt-coupon input {
        flex: 1;
        height: 55px;
        border-radius: 12px;
        border: 1px solid #ddd;
        padding: 0 18px;
    }

    .crt-coupon button {
        width: 140px;
        border: none;
        border-radius: 12px;
        background: #16a34a;
        color: #fff;
        font-weight: 700;
    }

    .crt-coupon button:hover {
        background: #13883f;
    }

    @media(max-width:992px) {

        .crt-summary {
            position: relative;
        }

    }

@media (max-width:768px){

.crt-cart-card{
    position:relative;
    padding:15px;
    border-radius:18px;
}

.crt-cart-row{
    display:grid;
    grid-template-columns:90px 1fr;
    grid-template-areas:
        "image info"
        "price qty";
    gap:15px;
    align-items:start;
}

.crt-product{
    grid-area:image / image / info / info;
    display:flex;
    align-items:flex-start;
}

.crt-cart-image{
    width:82px;
    height:82px;
    padding:6px;
    margin-right:12px;
}

.crt-info{
    flex:1;
    margin-left:0;
}

.crt-info h5{
    font-size:15px;
    line-height:1.35;
    margin-bottom:8px;
    font-weight:700;
}

.crt-info .text-muted{
    font-size:13px;
    margin-bottom:4px;
}

.crt-info .text-success{
    font-size:13px;
}


    .crt-total{
        display:none !important;
    }

    .crt-price{
        display:block !important;
        width:auto;
        margin-top:15px;
        font-size:16px;
        font-weight:700;
        color:#222;
    }



.crt-quantity{
    grid-area:qty;
    width:auto;
    display:flex;
    justify-content:flex-end;
    margin-top:8px;
}

.crt-qty{
    width:120px;
    height:42px;
}

.crt-qty button{
    width:36px;
    height:42px;
    font-size:20px;
}

.crt-qty input{
    width:40px;
    font-size:16px;
}


.crt-delete{
    position:absolute;
    right:12px;
    top:12px;
    width:auto;
}

.crt-remove{
    width:26px;
    height:26px;
    font-size:16px;
}
/* MOBILE CARD */

.crt-cart-mobile{
    display:block;
    background:#fff;
    border:1px solid #ececec;
    border-radius:18px;
    padding:14px;
    margin-bottom:18px;
    position:relative;
}

.mobile-top{
    display:flex;
    align-items:flex-start;
    gap:14px;
}

.mobile-image{
    width:85px;
    height:85px;
    object-fit:contain;
    background:#fafafa;
    border-radius:10px;
    padding:6px;
    flex-shrink:0;
}

.mobile-info{
    flex:1;
}

.mobile-info h5{
    font-size:18px;
    font-weight:700;
    line-height:1.35;
    margin-bottom:8px;
}

.mobile-info div{
    font-size:13px;
    color:#777;
}

.mobile-info .stock{
    color:#1fa74b;
    font-weight:600;
    margin-top:5px;
}

.mobile-bottom{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:18px;
}

.mobile-price{
    font-size:24px;
    font-weight:700;
    color:#222;
}

.crt-remove-mobile{
    position:absolute;
    right:10px;
    top:10px;
    width:26px;
    height:26px;
    border:none;
    border-radius:50%;
    background:#f2f2f2;
    color:#777;
    font-size:15px;
}

.crt-remove-mobile:hover{
    background:#ef4444;
    color:#fff;
}

.mobile-bottom .crt-qty{
    width:120px;
    height:42px;
}

.mobile-bottom .crt-qty button{
    width:36px;
    height:42px;
}

.mobile-bottom .crt-qty input{
    width:40px;
}

}

</style>

<link rel="stylesheet" href="https://checkout-ui.shiprocket.com/assets/styles/shopify.css">
<main class="main crt-cart-page">

    <div class="container">

        {{-- Breadcrumb --}}

        <nav class="crt-breadcrumb">

            <a href="{{ url('/') }}">Home</a>

            <span>/</span>

            <a href="{{ url('shop') }}">Shop</a>

            <span>/</span>

            <strong>Your Cart</strong>

        </nav>

        <h1 class="crt-cart-title">

            Your Shopping <span>Cart</span>

        </h1>

        {{-- Features --}}

        <div class="crt-cart-features">

            <div>

                <i class="icon-shield-check"></i>

                100% Secure Checkout

            </div>

            <div>

                <i class="icon-refresh"></i>

                7 Days Easy Returns

            </div>

            <div>

                <i class="icon-truck"></i>

                Free Shipping Above ₹999

            </div>

            <div>

                <i class="icon-headphones"></i>

                24×7 Support

            </div>

        </div>

        @php

        $subtotal = $cartItems->sum(fn($item)=>$item->product->price * $item->quantity);

        @endphp

        <div class="row">

            {{-- LEFT --}}

            <div class="col-lg-8">

                @forelse($cartItems as $item)
<div class="crt-cart-mobile d-md-none">

    <button class="crt-remove-mobile">×</button>

    <div class="mobile-top">

        <img src="{{ asset('storage/'.$item->product->featured_image) }}"
             class="mobile-image">

        <div class="mobile-info">

            <h5>{{ $item->product->name }}</h5>

            <div>Material : PLA</div>

            <div class="stock">● In Stock</div>

        </div>

    </div>

    <div class="mobile-bottom">

        <div class="mobile-price">
            ₹{{ number_format($item->product->price,2) }}
        </div>

        <div class="crt-qty">

            <button>-</button>

            <input value="{{ $item->quantity }}" readonly>

            <button>+</button>

        </div>

    </div>

</div>
                <div class="crt-cart-card d-none d-md-block">

                    <div class="crt-cart-row">

                        <div class="crt-product">

                            <img class="crt-cart-image" src="{{ asset('storage/'.$item->product->featured_image) }}"
                                alt="{{ $item->product->name }}">

                            <div class="crt-info">

                                <h5>{{ $item->product->name }}</h5>

                                <div class="text-muted">
                                    Material : PLA
                                </div>

                                <div class="text-success">
                                    ● In Stock
                                </div>

                            </div>

                        </div>

                        <div class="crt-price">
                            ₹{{ number_format($item->product->price,2) }}
                        </div>

                        <div class="crt-quantity">

                            <div class="crt-qty">

                                <button class="qty-minus" data-id="{{ $item->id }}">−</button>

                                <input type="text" value="{{ $item->quantity }}" readonly>

                                <button class="qty-plus" data-id="{{ $item->id }}">+</button>

                            </div>

                        </div>

                        <div class="crt-total">

                            ₹{{ number_format($item->product->price * $item->quantity,2) }}

                        </div>

                        <div class="crt-delete">

                            <form action="{{ route('cart.remove') }}" method="POST">

    @csrf
    @method('DELETE')

    <input type="hidden"
           name="cart_item_id"
           value="{{ $item->id }}">

    <button class="crt-remove-mobile">
        ×
    </button>

</form>

                        </div>

                    </div>

                </div>

                @empty

                <div class="alert alert-warning">

                    Your cart is empty.

                </div>

                @endforelse

                {{-- Coupon --}}


            </div>

            {{-- RIGHT --}}

            <div class="col-lg-4">

                <div class="crt-summary">

                    <h3>

                        Order Summary

                    </h3>

                    <div class="summary-row">


                    </div>


                    <div class="crt-progress">

                        <smacrt>

                            🎉 You are eligible for FREE SHIPPING

                        </smacrt>

                        <div class="progress">

                            <div class="progress-bar" style="width:100%">

                            </div>

                        </div>

                    </div>

                    <div class="summary-total">

                        <span>

                            Total

                        </span>

                        <strong>

                            ₹{{ number_format($subtotal,2) }}

                        </strong>

                    </div>

                    <button
    type="button"
    id="cartCheckout"
    class="btn btn-success btn-lg btn-block">

    Proceed To Checkout

</button>


                    <a href="{{ url('shop') }}" class="btn btn-light btn-block mt-3">

                        Continue Shopping →

                    </a>

                </div>

            </div>

        </div>

    </div>

</main>

@endsection
@push('scripts')

<script src="https://checkout-ui.shiprocket.com/assets/js/channels/shopify.js"></script>

<script>

document.getElementById('cartCheckout').addEventListener('click', async function(event){

    event.preventDefault();

    try{

        const response = await fetch("{{ route('shiprocket.cart.token') }}",{

            method:'POST',

            headers:{

                'Content-Type':'application/json',

                'Accept':'application/json',

                'X-CSRF-TOKEN':'{{ csrf_token() }}'

            }

        });

        const data = await response.json();

        console.log(data);

        if(!data.success){

            alert(data.message);

            return;

        }

        HeadlessCheckout.addToCart(

            event,

            data.access_token,

            {

                fallbackUrl:"{{ url('/checkout') }}",

                isInitiatedFromApp:false

            }

        );

    }catch(error){

        console.error(error);

        alert("Something went wrong.");

    }

});

</script>

@endpush
