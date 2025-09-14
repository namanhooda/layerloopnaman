@extends('frontend.partials.app')
@section('content')

<style>
    .table th,
    .table td {
        padding-left: 10px;
    }

</style>
<main class="main">
    <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        <div class="container">
            <h1 class="page-title">My Orders<span>Shop</span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('account')}}">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">Orders</li>
            </ol>
        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="dashboard">
            <div class="container">
                <div class="row">

                    @include('frontend.user.aside')
                    <div class="col-md-8 col-lg-9">
                        <table class="table table-wishlist table-mobile">
                            <thead>
                                <tr>

                                    <th>Order Id</th>
                                    <th>Order Total</th>
                                    <th>Order Status</th>
                                    <th>Payment Status</th>
                                    <th>Total Items</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                @php
                                $totalItems = App\Models\OrderItem::where('order_id', $order->id)->sum('quantity');
                                @endphp
                                <tr>
                                    <td class="product-col">{{$order->order_code}}
                                    </td>
                                    <td class="product-col">₹ {{$order->total}}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                        <span class="badge rounded-pill bg-primary">Pending</span>
                                        @elseif($order->status == 'cancelled')
                                        <span class="badge rounded-pill bg-danger">Cancelled</span>
                                        @elseif($order->status == 'Delivered')
                                        <span class="badge rounded-pill bg-success">Delivered</span>
                                        @else
                                        <span class="badge rounded-pill bg-secondary">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td class="product-col">{{$order->payment_mod}}</td>
                                    <td class="product-col">{{$totalItems}}</td>


                                    <td class="product-col">
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('orders.show', $order->order_code) }}"
                                                class="btn btn-primary btn-sm">View</a>
                                            @if($order->status == 'pending')
                                            <!-- Cancel button triggers modal -->
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#cancelOrderModal{{ $order->id }}">
                                                Cancel
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="cancelOrderModal{{ $order->id }}" tabindex="-1"
                                                aria-labelledby="cancelOrderLabel{{ $order->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('orders.cancel', $order->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="cancelOrderLabel{{ $order->id }}">Cancel Order
                                                                    #{{ $order->order_code }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Cancel Reason -->
                                                                <div class="mb-3">
                                                                    <label for="cancel_reason{{ $order->id }}"
                                                                        class="form-label">Reason</label>
                                                                    <select name="cancel_reason"
                                                                        id="cancel_reason{{ $order->id }}"
                                                                        class="form-select" required>
                                                                        <option value="">Select reason</option>
                                                                        <option value="Ordered by mistake">Ordered by
                                                                            mistake</option>
                                                                        <option value="Found cheaper elsewhere">Found
                                                                            cheaper elsewhere</option>
                                                                        <option value="Delivery time too long">Delivery
                                                                            time too long</option>
                                                                        <option value="Changed my mind">Changed my mind
                                                                        </option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                                <!-- Cancel Note -->
                                                                <div class="mb-3">
                                                                    <label for="cancel_note{{ $order->id }}"
                                                                        class="form-label">Additional Note</label>
                                                                    <textarea name="cancel_note"
                                                                        id="cancel_note{{ $order->id }}"
                                                                        class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-danger">Confirm
                                                                    Cancel</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Orders Yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div><!-- End .col-lg-9 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .dashboard -->
    </div><!-- End .page-content -->
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection
