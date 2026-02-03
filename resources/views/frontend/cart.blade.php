@extends('frontend.partials.app')
@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('shop')}}">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <!-- @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif -->
    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($cartItems as $item)
                                <tr>
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="{{ url('shop-product-detail/' . $item->product->slug) }}">
                                                    <img src="{{ asset('storage/' . $item->product->featured_image) }}"
                                                        alt="{{ $item->product->name }}" style="width: 80px;">
                                                </a>
                                            </figure>
                                            <h3 class="product-title">
                                                <a href="{{ url('shop-product-detail/' . $item->product->slug) }}">{{ $item->product->name }}</a>
                                            </h3>
                                        </div>
                                    </td>
                                    <td class="price-col">₹{{ number_format($item->product->price, 2) }}</td>
                                    <td class="price-col">{{ $item->size ?? 'Free' }}</td>
                                    <td class="quantity-col">
                                        <div class="cart-product-quantity">
                                            <input type="number" class="form-control" value="{{ $item->quantity }}"
                                                min="1">
                                        </div>
                                    </td>
                                    <td class="total-col">
                                        ₹{{ number_format($item->product->price * $item->quantity, 2) }}
                                    </td>
                                    <td class="remove-col">
                                        <form method="POST" action="{{ route('cart.remove') }}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn-remove"><i class="icon-close"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Your cart is empty.</td>
                                </tr>
                                @endforelse
                                @php
                                $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
                                @endphp
                            </tbody>

                        </table><!-- End .table table-wishlist -->

                        <div class="cart-bottom">
                            <div class="cart-discount">@if(session()->has('coupon'))
                                <form action="{{ route('remove.coupon') }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="coupon_code"
                                            value="{{ session('coupon.code') }}" disabled>

                                        <div class="input-group-append">
                                            <button class="btn btn-danger" type="submit">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @else
                                <form action="{{ route('apply.coupon') }}" method="POST">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="coupon_code" required
                                            placeholder="Coupon code">

                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary-2" type="submit">
                                                Apply
                                            </button>

                                        </div>
                                    </div>
                                </form>
                                @endif

                            </div><!-- End .cart-discount -->

                            <a href="#" class="btn btn-outline-dark-2"><span>UPDATE CART</span><i
                                    class="icon-refresh"></i></a>
                        </div><!-- End .cart-bottom -->
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td>₹{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    @php
                                    $total = $subtotal;
                                    $discount = 0;
                                    $coupon = session('coupon');

                                    if ($coupon && $total >= $coupon['min_cart_value']) {
                                    $discount = $coupon['type'] === 'percent'
                                    ? ($total * $coupon['value'] / 100)
                                    : $coupon['value'];
                                    $total -= $discount;
                                    }
                                    @endphp
                                    @if(session()->has('coupon') && $discount > 0)
                                    <tr class="summary-subtotal">
                                        <td>Coupon Applied:</td>
                                        <td>- ₹{{ number_format($discount, 2) }}</td>
                                    </tr>
                                    @endif
                                    <tr class="summary-shipping">
                                        <td>Shipping:</td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <tr class="summary-shipping-row">
                                        <td>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="free-shipping" name="shipping"
                                                    class="custom-control-input shipping-option" data-price="0" checked>
                                                <label class="custom-control-label" for="free-shipping">Free
                                                    Shipping</label>
                                            </div>
                                        </td>
                                        <td>₹0.00</td>
                                    </tr>

                                    <tr class="summary-shipping-row">
                                        <td>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="standart-shipping" name="shipping"
                                                    class="custom-control-input shipping-option" data-price="40">
                                                <label class="custom-control-label"
                                                    for="standart-shipping">Standard:</label>
                                            </div>
                                        </td>
                                        <td>₹40.00</td>
                                    </tr>

                                    <tr class="summary-shipping-row">
                                        <td>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="express-shipping" name="shipping"
                                                    class="custom-control-input shipping-option" data-price="60">
                                                <label class="custom-control-label"
                                                    for="express-shipping">Express:</label>
                                            </div>
                                        </td>
                                        <td>₹60.00</td>
                                    </tr>

                                    <!-- <tr class="summary-shipping-estimate">
                                        <td>Estimate for Your Country<br> <a href="dashboard.html">Change address</a>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr> -->

                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td id="final-total" data-base="{{ $total }}">₹{{ number_format($total, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
<!-- <button id="buyNow" class="btn btn-primary btn-block">
    Checkout with Shiprocket
</button> -->


                            @if(auth()->check())
                            <a href="{{ url('checkout') }}" class="btn btn-outline-primary-2 btn-order btn-block">
                                PROCEED TO CHECKOUT
                            </a>
                            @else
                            <a href="#signin-modal" data-toggle="modal"
                                class="btn btn-outline-primary-2 btn-order btn-block">
                                <i class="icon-user"></i> Login to Checkout
                            </a>
                            @endif
                        </div><!-- End .summary -->

                        <a href="{{url('shop')}}" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE
                                SHOPPING</span><i class="icon-refresh"></i></a>
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
</main><!-- End .main -->

@endsection


<script src="https://checkout-ui.shiprocket.com/assets/js/channels/shopify.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('buyNow');

    btn.addEventListener('click', async function (e) {

        e.preventDefault(); // ⭐ required

        try {

            let res = await fetch("{{ route('shiprocket.token') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({})
            });

            let data = await res.json();

            console.log("TOKEN RESPONSE:", data);

            if (!data.result?.token) {
                alert("Token not generated");
                return;
            }

            HeadlessCheckout.addToCart(e, data.result.token);

        } catch (err) {
            console.error(err);
            alert("Checkout failed");
        }
    });

});
</script>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).on('change', '.shipping-option', function () {
        let shippingType = $(this).attr('id'); // free-shipping, standart-shipping, express-shipping
        let shippingLabel = $(this).siblings('label').text().trim();
        let shippingPrice = $(this).data('price');

        // Send AJAX to backend to store in session
        $.ajax({
            url: "{{ route('cart.shipping') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                type: shippingType,
                label: shippingLabel,
                price: shippingPrice
            },
            success: function (response) {
                console.log("Shipping updated:", response);
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const shippingOptions = document.querySelectorAll('.shipping-option');
        const finalTotalElement = document.getElementById('final-total');
        const baseTotal = parseFloat(finalTotalElement.getAttribute('data-base'));

        function updateTotal() {
            let shippingCharge = 0;

            shippingOptions.forEach(option => {
                if (option.checked) {
                    shippingCharge = parseFloat(option.getAttribute('data-price')) || 0;
                }
            });

            const newTotal = baseTotal + shippingCharge;
            finalTotalElement.textContent = '₹' + newTotal.toFixed(2);
        }

        // Add event listener to all shipping options
        shippingOptions.forEach(option => {
            option.addEventListener('change', updateTotal);
        });

        // Initial update in case pre-selected option has charge
        updateTotal();
    });

</script>
