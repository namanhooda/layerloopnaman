@extends('admin.partial.app')

@section('content')
<div class="container-fluid">
    <h4>Create Invoice</h4>

    <form method="POST" action="{{ route('admin.invoices.store') }}">
        @csrf
        @include('admin.invoices._form')
    </form>
</div>
@endsection