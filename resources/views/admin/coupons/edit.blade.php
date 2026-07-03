@extends('admin.partial.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Edit Coupon</h5>

            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Success/Error Message --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST" class="row">
                    @csrf
                    @method('PUT')

                    <!-- Coupon Code -->
                    <div class="mb-3 col-md-6">
                        <label for="code" class="form-label">Coupon Code</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="code" 
                            name="code"
                            value="{{ old('code', $coupon->code) }}"
                            required
                        >
                    </div>

                    <!-- Type -->
                    <div class="mb-3 col-md-6">
                        <label for="type" class="form-label">Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option value="fixed" 
                                {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>
                                Fixed
                            </option>

                            <option value="percentage" 
                                {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>
                                Percentage
                            </option>
                        </select>
                    </div>

                    <!-- Value -->
                    <div class="mb-3 col-md-6">
                        <label for="value" class="form-label">Value</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            class="form-control" 
                            id="value" 
                            name="value"
                            value="{{ old('value', $coupon->value) }}"
                            required
                        >
                    </div>

                    <!-- Min Cart Value -->
                    <div class="mb-3 col-md-6">
                        <label for="min_cart_value" class="form-label">Minimum Cart Value</label>
                        <input 
                            type="number" 
                            step="0.01" 
                            class="form-control" 
                            id="min_cart_value" 
                            name="min_cart_value"
                            value="{{ old('min_cart_value', $coupon->min_cart_value) }}"
                            required
                        >
                    </div>

                    <!-- Start Date -->
                    <div class="mb-3 col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="start_date" 
                            name="start_date"
                            value="{{ old('start_date', \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d')) }}"
                            required
                        >
                    </div>

                    <!-- End Date -->
                    <div class="mb-3 col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            id="end_date" 
                            name="end_date"
                            value="{{ old('end_date', \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d')) }}"
                            required
                        >
                    </div>

                    <!-- Max Usage -->
                    <div class="mb-3 col-md-6">
                        <label for="max_usage" class="form-label">Max Usage</label>
                        <input 
                            type="number" 
                            class="form-control" 
                            id="max_usage" 
                            name="max_usage"
                            value="{{ old('max_usage', $coupon->max_usage) }}"
                            required
                        >
                    </div>

                    <!-- Is Active -->
                    <div class="mb-3 col-md-6">
                        <label for="is_active" class="form-label">Is Active</label>
                        <select name="is_active" id="is_active" class="form-control" required>
                            <option value="1" 
                                {{ old('is_active', $coupon->is_active) == 1 ? 'selected' : '' }}>
                                Yes
                            </option>

                            <option value="0" 
                                {{ old('is_active', $coupon->is_active) == 0 ? 'selected' : '' }}>
                                No
                            </option>
                        </select>
                    </div>

                    <!-- Submit -->
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">
                            Update Coupon
                        </button>

                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-label-secondary">
                            Cancel
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection