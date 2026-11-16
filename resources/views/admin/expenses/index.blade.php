
@extends('admin.partial.app')

@section('content')

<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<script src="{{ asset('backend/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.js') }}"></script>

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">

        <h5 class="card-header d-flex justify-content-between align-items-center">

            <span>Expenses</span>

            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addExpenseModal">

                <i class="ti tabler-plus me-1"></i>
                Add New Expense

            </button>

        </h5>

        <div class="card-datatable table-responsive">

            <table class="table border-top datatables-expenses">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>

            </table>

        </div>

    </div>

</div>

<div class="modal fade" id="addExpenseModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-body">

                <button type="button" class="btn-close btn-pinned"
                        data-bs-dismiss="modal"></button>

                <div class="text-center mb-4">
                    <h3>Add New Expense</h3>
                </div>

                <form action="{{ route('admin.expenses.store') }}"
                      method="POST" class="row">

                    @csrf

                    <div class="col-12 mb-3">
                        <label class="form-label">Expense Date</label>
                        <input type="date" name="expense_date"
                               class="form-control"
                               value="{{ old('expense_date', date('Y-m-d')) }}"
                               required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Expense Title</label>
                        <input type="text" name="title"
                               class="form-control"
                               placeholder="Enter expense title" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach([
                                'Electricity',
                                'Rent',
                                'Salary',
                                'Packaging',
                                'Raw Material',
                                'Shipping',
                                'Marketing',
                                'Maintenance',
                                'Travel',
                                'Other'
                            ] as $category)
                                <option value="{{ $category }}">
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Amount (₹)</label>
                        <input type="number" name="amount"
                               class="form-control"
                               step="0.01" min="0.01"
                               placeholder="Enter amount" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-control">
                            <option value="">Select Payment Method</option>
                            <option value="Cash">Cash</option>
                            <option value="UPI">UPI</option>
                            <option value="Bank Transfer">Bank Transfer</option>
                            <option value="Debit Card">Debit Card</option>
                            <option value="Credit Card">Credit Card</option>
                        </select>
                    </div>

                    <div class="col-12 mb-4">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"
                                  rows="3"
                                  placeholder="Enter description"></textarea>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-2">
                            Save Expense
                        </button>

                        <button type="button" class="btn btn-label-secondary"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection

@section('scripts')
<script>
$(function () {

    $('.datatables-expenses').DataTable({

        processing: true,
        serverSide: true,

        ajax: '{{ route("admin.expenses.index") }}',

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'expense_date', name: 'expense_date' },
            { data: 'title', name: 'title' },
            { data: 'category', name: 'category' },
            { data: 'amount', name: 'amount' },
            { data: 'payment_method', name: 'payment_method' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]

    });

});
</script>
@endsection
