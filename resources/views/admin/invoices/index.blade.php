
@extends('admin.partial.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Invoice Management</h4>

        <a href="{{ route('admin.invoices.create') }}"
           class="btn btn-primary">
            <i class="fas fa-plus"></i> Create Invoice
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" class="row mb-3">
        <div class="col-md-4">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search invoice or customer"
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="payment_status" class="form-control">
                <option value="">All Payment Status</option>
                @foreach(['unpaid','partial','paid'] as $status)
                    <option value="{{ $status }}"
                        @selected(request('payment_status') == $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.invoices.index') }}"
               class="btn btn-secondary">Clear</a>
        </div>
    </form>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Invoice No.</th>
                        <th>Customer</th>
                        <th>Invoice Date</th>
                        <th>Grand Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Payment</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $loop->iteration + $invoices->firstItem() - 1 }}</td>

                        <td>{{ $invoice->invoice_number }}</td>

                        <td>{{ $invoice->customer_name }}</td>

                        <td>{{ $invoice->invoice_date->format('d-m-Y') }}</td>

                        <td>₹{{ number_format($invoice->grand_total, 2) }}</td>

                        <td>₹{{ number_format($invoice->paid_amount, 2) }}</td>

                        <td>₹{{ number_format($invoice->due_amount, 2) }}</td>

                        <td>
                            <span class="badge
                                {{ $invoice->payment_status == 'paid'
                                    ? 'badge-success'
                                    : ($invoice->payment_status == 'partial'
                                        ? 'badge-warning'
                                        : 'badge-danger') }}">
                                {{ ucfirst($invoice->payment_status) }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('admin.invoices.show', $invoice) }}"
                               class="btn btn-sm btn-info">View</a>

                            <a href="{{ route('admin.invoices.edit', $invoice) }}"
                               class="btn btn-sm btn-primary">Edit</a>

                            <form action="{{ route('admin.invoices.destroy', $invoice) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this invoice?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            No invoices found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $invoices->links() }}
    </div>

</div>
@endsection
