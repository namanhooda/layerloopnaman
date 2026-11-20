@extends('admin.partial.app')
@section('title', 'Settlement')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
@php $editing = $settlement->exists; @endphp
<h3 class="mb-3">{{ $editing ? 'Edit' : 'Add' }} Settlement</h3>
<div class="alert alert-info">Advance: <strong>{{ $advance->advance_no }}</strong> · Original: ₹{{ number_format((float)$advance->amount,2) }} · Current settled: ₹{{ number_format((float)$advance->settlements()->sum('amount'),2) }} · Balance: ₹{{ number_format((float)$advance->balance_amount,2) }}</div>
<form method="POST" action="{{ $action }}" class="card card-body">
    @csrf @if($editing) @method('PUT') @endif
    <div class="row g-3">
        <div class="col-md-4"><label class="form-label">Settlement date *</label><input type="date" name="settlement_date" class="form-control" value="{{ old('settlement_date',optional($settlement->settlement_date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" required></div>
        <div class="col-md-4"><label class="form-label">Settlement amount *</label><input type="number" step="0.01" min="0.01" name="amount" class="form-control" value="{{ old('amount',$settlement->amount) }}" required></div>
        <div class="col-md-4"><label class="form-label">Payment mode</label><select name="payment_mode" class="form-select"><option value="">Select</option>@foreach(config('advance-payments.payment_modes',[]) as $key=>$label)<option value="{{ $key }}" @selected(old('payment_mode',$settlement->payment_mode)==$key)>{{ $label }}</option>@endforeach</select></div>
        <div class="col-md-6"><label class="form-label">Reference no.</label><input name="reference_no" class="form-control" value="{{ old('reference_no',$settlement->reference_no) }}"></div>
        <div class="col-12"><label class="form-label">Remarks</label><textarea name="remarks" class="form-control" rows="3">{{ old('remarks',$settlement->remarks) }}</textarea></div>
    </div>
    <div class="mt-3"><button class="btn btn-primary">Save Settlement</button><a class="btn btn-secondary" href="{{ $type==='received' ? route('advance-received.show',$advance) : route('advance-paid.show',$advance) }}">Cancel</a></div>
</form></div>
@endsection
