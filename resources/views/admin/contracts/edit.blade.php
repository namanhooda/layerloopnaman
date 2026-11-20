@extends('admin.partial.app')
@section('title', 'Edit Contract')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h4 class="mb-1">Edit Contract</h4><p class="text-muted mb-0">{{ $contract->contract_number }}</p></div>
    <a href="{{ route('admin.contracts.show', $contract) }}" class="btn btn-label-secondary">Back</a>
</div>
<form method="POST" action="{{ route('admin.contracts.update', $contract) }}">
    <div class="card"><div class="card-body">
        @include('admin.contracts._form')
    </div><div class="card-footer d-flex justify-content-end">
        <button class="btn btn-primary">Update Draft</button>
    </div></div>
</form>
@endsection
