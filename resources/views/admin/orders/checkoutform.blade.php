@extends('admin.partial.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12">
        <div class="card">

            <!-- Header with button -->
            <h5 class="card-header d-flex justify-content-between align-items-center">
                <span>Create Order</span>
                <a href="{{ route('shiprocket.checkout.order.webhook') }}" class="btn btn-sm btn-secondary">Back</a>
            </h5>

            <div class="card-body">
                <form action="{{ route('shiprocket.checkout.order.webhook') }}" method="POST" class="row">
                    @csrf

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Shiprocket Cart ID</label>
                        <input type="text" name="cart_id" class="form-control"
                            placeholder="Enter subtotal">
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary me-2">Create Order</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-label-secondary">Cancel</a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

@endsection
