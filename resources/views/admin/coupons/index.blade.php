@extends('admin.partial.app')
@section('content')

<link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet"
    href="{{asset('backend/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('backend/assets/vendor/libs/@form-validation/form-validation.css')}}" />
<script src="{{ asset('backend/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.js') }}"></script>
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/animate-css/animate.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />


<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Permission Table -->
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Coupons</span>
            <a href="{{ route('admin.coupons.create') }}" class="add-new btn btn-primary">
                <i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i>
                <span class="d-none d-sm-inline-block">Add New Coupon</span>
            </a>

        </h5>
        <div class="card-datatable table-responsive">
            <table class="datatables-permissions table border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                </thead>
            </table>
        </div>

    </div>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('backend/assets/js/extended-ui-sweetalert2.js')}}"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('
        success ') }}',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });

</script>
@endif
@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: `{!! implode('<br>', $errors->all()) !!}`
    });

    // Optional: re-open modal after redirect
    const addModal = new bootstrap.Modal(document.getElementById('addPermissionModal'));
    addModal.show();

</script>
@endif
<script src="{{asset('backend/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
<script>
    $(function () {
        $('.datatables-permissions').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.coupons.index") }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'coupon_code',
                    name: 'coupon_code'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    });
    $(document).on('click', '.edit-permission', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');

        $('#editPermissionName').val(name);
        $('#editPermissionForm').data('id', id); // For submit later
    });

</script>
