@extends('admin.partial.app')

@section('content')
<div class="container-fluid">
    <h4>Edit Invoice: {{ $invoice->invoice_number }}</h4>

    <form method="POST"
          action="{{ route('admin.invoices.update', $invoice) }}">
        @csrf
        @method('PUT')

        @include('admin.invoices._form')
    </form>
</div>
@endsection