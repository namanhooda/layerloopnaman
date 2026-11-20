@extends('admin.partial.app')
@section('title', 'Create Contract')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h4 class="mb-1">Create Contract</h4><p class="text-muted mb-0">Create a new LayerLoop agreement.</p></div>
    <a href="{{ route('admin.contracts.index') }}" class="btn btn-label-secondary">Back</a>
</div>
<form method="POST" action="{{ route('admin.contracts.store') }}">
    <div class="card"><div class="card-body">
        @include('admin.contracts._form')
    </div><div class="card-footer d-flex justify-content-end gap-2">
        <button class="btn btn-primary">Save Draft</button>
    </div></div>
</form></div>
@endsection
