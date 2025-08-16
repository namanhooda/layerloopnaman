@extends('frontend.partials.app')

@section('content')

<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">Wishlist<span>Shop</span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Shop</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">
            <table class="table table-wishlist table-mobile">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock Status</th>
                        <th>Add to Cart</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wishlist as $item)
                        <tr>
                            <td class="product-col">
                                <div class="product">
                                    <figure class="product-media">
                                        <a href="{{ url('shop-product-detail/' . $item->product->id) }}">
                                            <img src="{{ asset('storage/' . $item->product->featured_image) }}" alt="Product image">
                                        </a>
                                    </figure>
                                    <h3 class="product-title">
                                        <a href="#">{{ $item->product->name }}</a>
                                    </h3>
                                </div>
                            </td>
                            <td class="price-col">₹{{ number_format($item->product->discounted_price, 2) }}</td>
                            <td class="stock-col">
                                @if($item->product->stock_quantity > 0)
                                    <span class="in-stock">In stock</span>
                                @else
                                    <span class="out-of-stock">Out of stock</span>
                                @endif
                            </td>
                            <td class="action-col">
                                @if($item->product->stock_quantity > 0)
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-outline-primary-2 btn-block">
                                            <i class="icon-cart-plus"></i> Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-outline-primary-2 btn-block disabled">Out of Stock</button>
                                @endif
                            </td>
                            <td class="remove-col">
							<form action="{{ route('wishlist.destroy', $item->id) }}" method="POST">
								@csrf
								@method('DELETE')
								<button class="btn-remove" type="submit"><i class="icon-close"></i></button>
							</form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Your wishlist is empty.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

@endsection
