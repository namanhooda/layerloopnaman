@extends('admin.partial.app')
@section('title', ucfirst($type).' Advance')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h3 class="mb-3">{{ $advance->exists ? 'Edit' : 'Create' }} Advance {{ ucfirst($type) }}</h3>
    <form method="POST" action="{{ route('admin.advance.store')}}" class="card card-body shadow-sm">
        @csrf
        @if($advance->exists) @method('PUT') @endif
        <div class="row g-3">

            <div class="col-md-4"><label class="form-label">Payment Type</label><select name="payment_mode"
                    class="form-select">
                    <option value="">Select</option>
                    <option value="received">Received</option>
                    <option value="Paid">Paid</option>
                </select></div>
            <div class="col-md-6">
                <label class="form-label">Party *</label>
                <select name="party_id" class="form-select" required>
                    <option value="">Select party</option>
                    @foreach($parties as $party)
                    <option value="{{ $party->id }}" @selected(old('party_id',$advance->
                        party_id)==$party->id)>{{ $party->name }} ({{ ucfirst($party->party_type) }})</option>
                    @endforeach
                </select>
                <div class="form-text"><a href="{{ route('advance-parties.create') }}" target="_blank">Create a new
                        party</a> if it is not listed.</div>
            </div>
            <div class="col-md-3"><label class="form-label">Advance date *</label><input type="date" name="advance_date"
                    class="form-control"
                    value="{{ old('advance_date', optional($advance->advance_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                    required></div>
            <div class="col-md-3"><label class="form-label">Advance amount *</label><input type="number" step="0.01"
                    min="0.01" name="amount" class="form-control" value="{{ old('amount',$advance->amount) }}" required>
            </div>
            <div class="col-md-4"><label class="form-label">Payment mode</label><select name="payment_mode"
                    class="form-select">
                    <option value="">Select</option>
                    <option value="online">Online</option>
                    <option value="cash">Cash</option>
                </select></div>
            <div class="col-md-4"><label class="form-label">Reference no.</label><input name="reference_no"
                    class="form-control" value="{{ old('reference_no',$advance->reference_no) }}"></div>
            <div class="col-12"><label class="form-label">Remarks</label><textarea name="remarks" class="form-control"
                    rows="3">{{ old('remarks',$advance->remarks) }}</textarea></div>
        </div>
        @if($advance->exists)
        <div class="alert alert-info mt-3 mb-0">Already settled:
            ₹{{ number_format((float)$advance->settlements()->sum('amount'),2) }}. The advance amount cannot be reduced
            below this value.</div>
        @endif
        <div class="mt-3"><button class="btn btn-primary">Save</button> <a class="btn btn-secondary"
                href="{{ $type==='received' ? route('advance-received.index') : route('advance-paid.index') }}">Cancel</a>
        </div>
    </form>
</div>
@endsection
