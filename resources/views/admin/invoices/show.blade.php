@extends('admin.partial.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4 invoice-page-actions">
        <h4 class="mb-0">Invoice Details</h4>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary">
                Back
            </a>
            <a href="{{ route('admin.invoices.edit', $invoice) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <button onclick="window.print()" class="btn btn-dark">
                <i class="fas fa-print me-1"></i> Print
            </button>
        </div>
    </div>

    <div class="row invoice-preview">

        {{-- Invoice --}}
        <div class="col-xl-9 col-md-8 col-12 mb-4">
            <div class="card invoice-preview-card p-sm-4 p-3" id="print-invoice">

                {{-- Header --}}
                <div class="card-body invoice-preview-header rounded mb-4">
                    <div class="d-flex justify-content-between flex-wrap gap-4">

                        <div class="text-heading">
                            <img src="{{ asset('images/Picsart_25-07-25_13-03-50-331.png') }}" alt="Molla Logo"
                                style="width: 180px; max-width: 100%; height: auto; margin-bottom: 15px;">

                            <p class="mb-1">{{ config('invoice.seller_address') }}</p>

                            <p class="mb-1">
                                UDYAM REGISTRATION:
                                {{ config('invoice.seller_gstin') ?? 'UDYAM-HR-07-0040228' }}
                            </p>
                        </div>

                        <div class="text-md-end">
                            <h4 class="fw-bold mb-2">TAX INVOICE</h4>

                            <h5 class="text-primary mb-3">
                                #{{ $invoice->invoice_number }}
                            </h5>

                            <div class="mb-1">
                                <span class="text-muted">Invoice Date:</span>
                                <strong>{{ $invoice->invoice_date->format('d-m-Y') }}</strong>
                            </div>

                            <div>
                                <span class="text-muted">Due Date:</span>
                                <strong>
                                    {{ $invoice->due_date?->format('d-m-Y') ?? '-' }}
                                </strong>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Customer Details --}}
                <div class="card-body px-0">
                    <div class="row">

                        <div class="col-xl-6 col-md-12 col-sm-6 mb-4">
                            <h6 class="fw-bold text-heading mb-3">Invoice To:</h6>

                            <h6 class="mb-1">{{ $invoice->customer_name }}</h6>

                            <p class="mb-1">{{ $invoice->billing_address }}</p>

                            <p class="mb-1">
                                {{ $invoice->billing_city }},
                                {{ $invoice->billing_state }}
                                - {{ $invoice->billing_pincode }}
                            </p>

                            <p class="mb-1">
                                Phone: {{ $invoice->phone ?? '-' }}
                            </p>

                            <p class="mb-1">
                                Email: {{ $invoice->customer_email ?? '-' }}
                            </p>

                            <p class="mb-0">
                                GSTIN: {{ $invoice->gstin ?? '-' }}
                            </p>
                        </div>

                        <div class="col-xl-6 col-md-12 col-sm-6 mb-4">
                            <h6 class="fw-bold text-heading mb-3">Ship To:</h6>

                            <p class="mb-1">{{ $invoice->customer_name }}</p>

                            <p class="mb-1">
                                {{ $invoice->shipping_address ?: $invoice->billing_address }}
                            </p>

                            <p class="mb-1">
                                {{ $invoice->shipping_city ?: $invoice->billing_city }},
                                {{ $invoice->shipping_state ?: $invoice->billing_state }}
                                - {{ $invoice->shipping_pincode ?: $invoice->billing_pincode }}
                            </p>

                            <p class="mb-1">
                                Place of Supply:
                                <strong>{{ $invoice->place_of_supply }}</strong>
                            </p>

                            <p class="mb-0">
                                Invoice Type:
                                <strong>{{ ucfirst($invoice->invoice_type) }}</strong>
                            </p>
                        </div>

                    </div>
                </div>

                {{-- Items Table --}}
                <div class="table-responsive border rounded mb-3">
                    <table class="table m-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Description</th>
                                <th>HSN</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Discount</th>
                                <th class="text-end">Taxable</th>
                                <th class="text-end">GST</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($invoice->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="text-heading fw-medium">
                                    {{ $item->description }}
                                </td>

                                <td>{{ $item->hsn_code ?? '-' }}</td>

                                <td class="text-end">
                                    ₹{{ number_format($item->price, 2) }}
                                </td>

                                <td class="text-end">
                                    {{ $item->quantity }}
                                </td>

                                <td class="text-end">
                                    ₹{{ number_format($item->discount, 2) }}
                                </td>

                                <td class="text-end">
                                    ₹{{ number_format($item->taxable_amount, 2) }}
                                </td>

                                <td class="text-end">
                                    {{ $item->tax_rate }}%
                                </td>

                                <td class="text-end fw-medium">
                                    ₹{{ number_format($item->total, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    No invoice items found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Totals --}}
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="align-top ps-0">
                                    <p class="mb-1">
                                        <span class="me-2 h6">Salesperson:</span>
                                        <span>Naman Hooda</span>
                                    </p>
                                    <p class="mb-1">
                                        <span class="me-2 h6">Mobile:</span>
                                        <span>8059000064</span>
                                    </p>
                                </td>

                                <td class="text-end" style="min-width: 180px;">
                                    <p class="mb-2">Subtotal:</p>
                                    <p class="mb-2">Discount:</p>
                                    <p class="mb-2">Taxable Amount:</p>
                                    <p class="mb-2">CGST:</p>
                                    <p class="mb-2">SGST:</p>
                                    <p class="mb-2">IGST:</p>
                                    <p class="mb-2">Shipping:</p>
                                    <h6 class="border-top pt-3 mb-2">Grand Total:</h6>
                                    <p class="mb-2">Paid Amount:</p>
                                    <h6 class="text-danger mb-0">Balance Due:</h6>
                                </td>

                                <td class="text-end fw-medium text-heading pe-0" style="min-width: 130px;">
                                    <p class="mb-2">
                                        ₹{{ number_format($invoice->subtotal, 2) }}
                                    </p>
                                    <p class="mb-2">
                                        ₹{{ number_format($invoice->discount_amount, 2) }}
                                    </p>
                                    <p class="mb-2">
                                        ₹{{ number_format($invoice->taxable_amount, 2) }}
                                    </p>
                                    <p class="mb-2">
                                        ₹{{ number_format($invoice->cgst_amount, 2) }}
                                    </p>
                                    <p class="mb-2">
                                        ₹{{ number_format($invoice->sgst_amount, 2) }}
                                    </p>
                                    <p class="mb-2">
                                        ₹{{ number_format($invoice->igst_amount, 2) }}
                                    </p>
                                    <p class="mb-2">
                                        ₹{{ number_format($invoice->shipping_charge, 2) }}
                                    </p>
                                    <h6 class="border-top pt-3 mb-2">
                                        ₹{{ number_format($invoice->grand_total, 2) }}
                                    </h6>
                                    <p class="mb-2">
                                        ₹{{ number_format($invoice->paid_amount, 2) }}
                                    </p>
                                    <h6 class="text-danger mb-0">
                                        ₹{{ number_format($invoice->due_amount, 2) }}
                                    </h6>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <hr class="mt-4">
<div class="row align-items-center mt-4">
    <div class="col-4 text-start">
        
                            <img src="{{ asset('images/Picsart_25-07-25_13-03-50-331.png') }}" alt="Molla Logo"
                                style="width: 180px; max-width: 100%; height: auto; margin-bottom: 2px;">
        
            <h6 style="margin-left: 10px; margin-top: -17px; letter-spacing: 3px;"><strong>We Print For you</strong></h6>
    </div>

    <div class="col-4 text-center">
        <strong style="font-size: 14px;">Thank you for your business!</strong>
        <p class="text-muted small mb-0">
            This is a computer-generated invoice.
        </p>
    </div>

    <div class="col-4 text-end">
        <strong style="color: black;">Beri, Jhajjar Haryana - 124201</strong>
        <p class="text-muted small mb-0">8059808185, shop.layerloop@gmail.com.
        </p>
    </div>
</div>

            </div>
        </div>

        {{-- Invoice Actions --}}
        <div class="col-xl-3 col-md-4 col-12 invoice-actions">
            <div class="card">
                <div class="card-body">

                    <button onclick="window.print()" class="btn btn-primary d-grid w-100 mb-3">
                        <i class="fas fa-print me-2"></i> Print Invoice
                    </button>

                    <a href="{{ route('admin.invoices.edit', $invoice) }}"
                        class="btn btn-outline-secondary d-grid w-100 mb-3">
                        <i class="fas fa-edit me-2"></i> Edit Invoice
                    </a>

                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-outline-secondary d-grid w-100">
                        <i class="fas fa-list me-2"></i> All Invoices
                    </a>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Payment Status</span>
                        <span class="badge bg-label-primary">
                            {{ ucfirst($invoice->payment_status) }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Invoice Status</span>
                        <span class="badge bg-label-secondary">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .invoice-preview-header {
        background: #f5f5f9;
        padding: 25px;
    }

    .invoice-preview-card {
        border: 1px solid #e5e5e5;
    }

    .invoice-preview-card .table th {
        white-space: nowrap;
        font-size: 13px;
    }

    .invoice-preview-card .table td {
        vertical-align: middle;
        font-size: 13px;
    }

    @media print {
        @page {
            size: A4;
            margin: 12mm;
        }

        body * {
            visibility: hidden !important;
        }

        #print-invoice,
        #print-invoice * {
            visibility: visible !important;
        }

        #print-invoice {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .invoice-page-actions,
        .invoice-actions {
            display: none !important;
        }

        .invoice-preview {
            display: block !important;
        }

        .invoice-preview>div {
            width: 100% !important;
            max-width: 100% !important;
        }

        .invoice-preview-header {
            background: #f5f5f9 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .table-responsive {
            overflow: visible !important;
        }

        .table {
            width: 100% !important;
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
        }
    }

</style>

@endsection
