@php $total = 0; @endphp
<div class="dropdown-cart-products">
    @if(!empty($cartItems))
        @foreach($cartItems as $item)
            @php
                $price = $item['product']->discounted_price;
                $total += $price * $item['quantity'];
            @endphp
            <div class="product">
                <div class="product-cart-details">
                    <h4 class="product-title">
                        <a href="{{ url('product/' . $item['product']->slug) }}">
                            {{ $item['name'] ?? $item['product']->name }}
                        </a>
                    </h4>
                    <span class="cart-product-info">
                        <span class="cart-product-qty">{{ $item['quantity'] }}</span>
                        x ₹{{ number_format($price, 2) }}
                    </span>
                </div>
                <figure class="product-image-container">
                    <a href="{{ url('shop-product-detail/' . $item['product']->id) }}" class="product-image">
                        <img src="{{ asset('storage/' . $item['product']->featured_image) }}"
                             alt="product" style="width: 60px; height: auto;">
                    </a>
                </figure>
                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                    @csrf
                     @method('DELETE')
                    <button type="submit" class="btn-remove" title="Remove Product">
                        <i class="icon-close"></i>
                    </button>
                </form>
            </div>
        @endforeach
    @else
        <p class="text-center">Your cart is empty.</p>
    @endif
</div>

@if(!empty($cartItems))
    <div class="dropdown-cart-total">
        <span>Total</span>
        <span class="cart-total-price">₹{{ number_format($total, 2) }}</span>
    </div>
    <div class="dropdown-cart-action">
        <a href="{{ url('cart') }}" class="btn btn-primary">View Cart</a>
        <a href="{{ url('checkout') }}" class="btn btn-outline-primary-2">
            <span>Checkout</span><i class="icon-long-arrow-right"></i>
        </a>
    </div>
@endif
