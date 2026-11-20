@extends('admin.partial.app')

@section('title', 'Contracts')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Contract Management</h4>
        <p class="text-muted mb-0">Manage LayerLoop agreements, exclusivity and legal records.</p>
    </div>
    <a href="{{ route('admin.contracts.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Create Contract
    </a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Contracts</h5>
        <span class="text-muted small">Search, filter and manage agreements</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover" id="contracts-table">
            <thead>
                <tr>
                    <th>#</th><th>Contract No.</th><th>Title</th><th>Type</th>
                    <th>Party</th><th>Period</th><th>Status</th><th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    $('#contracts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.contracts.index") }}',
        columns: [
            {data:'DT_RowIndex', name:'id', orderable:false, searchable:false},
            {data:'contract_number', name:'contract_number'},
            {data:'title', name:'title'},
            {data:'type_name', name:'type.name'},
            {data:'party', name:'party_name'},
            {data:'period', name:'start_date', orderable:false, searchable:false},
            {data:'status_badge', name:'status'},
            {data:'action', name:'action', orderable:false, searchable:false}
        ],
        order: [[1, 'desc']]
    });
});
</script>
@endpush
