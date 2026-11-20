@extends('admin.partial.app')
@section('title', 'Advance Details')
@section('content')
@php
    $received = $type === 'received';
    $base = $received ? 'advance-received' : 'advance-paid';
    $settled = (float) $advance->settlements->sum('amount');
    $balance = max(0, (float)$advance->amount - $settled);
    $percent = (float)$advance->amount > 0 ? min(100, ($settled / (float)$advance->amount) * 100) : 0;
@endphp
<div class="container-xxl flex-grow-1 container-p-y">
<div class="d-flex justify-content-between align-items-center mb-3">
    <div><h3>{{ $received ? 'Advance Received' : 'Advance Paid' }}</h3><div class="text-muted">{{ $advance->advance_no }}</div></div>
    <div><a class="btn btn-outline-primary" href="{{ route($base.'.edit',$advance) }}">Edit Advance</a> <a class="btn btn-primary" href="{{ route('advance-settlements.create',[$type,$advance->id]) }}">Add Settlement</a></div>
</div>
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card card-body"><small class="text-muted">Party</small><strong>{{ $advance->party->name }}</strong></div></div>
    <div class="col-md-3"><div class="card card-body"><small class="text-muted">Advance amount</small><strong>₹{{ number_format((float)$advance->amount,2) }}</strong></div></div>
    <div class="col-md-3"><div class="card card-body"><small class="text-muted">Settled</small><strong class="text-success">₹{{ number_format($settled,2) }}</strong></div></div>
    <div class="col-md-3"><div class="card card-body"><small class="text-muted">Balance</small><strong class="text-danger">₹{{ number_format($balance,2) }}</strong></div></div>
</div>
<div class="card card-body mb-4">
    <div class="d-flex justify-content-between"><strong>Settlement progress</strong><span>{{ number_format($percent,1) }}%</span></div>
    <div class="progress mt-2" style="height:12px"><div class="progress-bar bg-success" style="width:{{ $percent }}%"></div></div>
    <div class="mt-2"><span class="badge text-bg-{{ $advance->status==='fully_settled'?'success':($advance->status==='pending'?'warning':'info') }}">{{ str_replace('_',' ',ucfirst($advance->status)) }}</span></div>
</div>
<div class="card">
    <div class="card-header bg-white"><strong>Settlement history</strong></div>
    <div class="table-responsive"><table class="table mb-0">
        <thead><tr><th>Date</th><th>Reference</th><th>Mode</th><th class="text-end">Amount</th><th>Remarks</th><th></th></tr></thead>
        <tbody>@forelse($advance->settlements as $s)
        <tr><td>{{ $s->settlement_date->format('d M Y') }}</td><td>{{ $s->reference_no ?: '—' }}</td><td>{{ $s->payment_mode ?: '—' }}</td><td class="text-end">₹{{ number_format((float)$s->amount,2) }}</td><td>{{ $s->remarks }}</td><td class="text-nowrap"><a href="{{ route('advance-settlements.edit',$s) }}">Edit</a><form class="d-inline" method="POST" action="{{ route('advance-settlements.destroy',$s) }}" onsubmit="return confirm('Delete this settlement? The balance and status will be recalculated.')">@csrf @method('DELETE')<button class="btn btn-link btn-sm text-danger p-0">Delete</button></form></td></tr>
        @empty<tr><td colspan="6" class="text-center py-3">No settlements recorded.</td></tr>@endforelse</tbody>
    </table></div>
</div>
<div class="mt-3"><a class="btn btn-secondary" href="{{ route($base.'.index') }}">Back</a></div></div>
@endsection
