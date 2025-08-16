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
    <div class="card">
        <h5 class="card-header d-flex justify-content-between align-items-center">
            <span>Product Prototypes</span>
            @can("news categories create")

            <button class="add-new btn btn-primary" data-bs-toggle='modal' data-bs-target='#addPermissionModal'>
                <i class="icon-base ti tabler-plus icon-xs me-0 me-sm-2"></i>
                <span class="d-none d-sm-inline-block">Add New</span>
            </button>
            @endcan
        </h5>
        @can("news categories read")
        <div class="card-datatable table-responsive">
            <table class="datatables-permissions table border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
        @endcan
        <!-- Offcanvas to add new user -->

    </div>
</div>
@can("news categories create")
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-simple">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-6">
                    <h3>Add New Prototype</h3>
                </div>
                <form action="{{ route('admin.product-prototypes.store') }}" method="POST" class="row">
                    @csrf

                    <div class="col-12 form-control-validation mb-4">
                        <label class="form-label" for="categoryName">Name</label>
                        <input type="text" id="categoryName" name="name" class="form-control"
                            placeholder="Enter Prototype name" required />
                    </div>

                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Create</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">
                            Discard
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endcan

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('backend/assets/js/extended-ui-sweetalert2.js')}}"></script>

@if(session('success'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: @json(session('success')),
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'error',
        title: 'Validation Error',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        showConfirmButton: false,
        timer: 5000
    });

    // Re-open modal on error
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
            ajax: '{{ route("admin.product-prototypes.index") }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'slug',
                    name: 'slug',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
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
