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

    <div class="card mb-6">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-6 col-lg-3">
                        <div
                            class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-0">{{ $orderscount['pending']}}</h4>
                                <p class="mb-0">Pending </p>
                            </div>
                            <span class="avatar me-sm-6">
                                <span class="avatar-initial bg-label-secondary rounded text-heading">
                                    <i class="icon-base ti tabler-calendar-stats icon-26px text-heading"></i>
                                </span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-6" />
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div
                            class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-0">{{ $orderscount['delivered']}}</h4>
                                <p class="mb-0">Delivered</p>
                            </div>
                            <span class="avatar p-2 me-lg-6">
                                <span class="avatar-initial bg-label-secondary rounded"><i
                                        class="icon-base ti tabler-checks icon-26px text-heading"></i></span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none" />
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div
                            class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                            <div>
                                <h4 class="mb-0">{{ $orderscount['cancelled']}}</h4>
                                <p class="mb-0">Cancelled</p>
                            </div>
                            <span class="avatar p-2 me-sm-6">
                                <span class="avatar-initial bg-label-secondary rounded"><i
                                        class="icon-base ti tabler-wallet icon-26px text-heading"></i></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-0">{{ $orderscount['rto']}}</h4>
                                <p class="mb-0">Rto</p>
                            </div>
                            <span class="avatar p-2">
                                <span class="avatar-initial bg-label-secondary rounded"><i
                                        class="icon-base ti tabler-alert-octagon icon-26px text-heading"></i></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Permission Table -->
    <div class="card">
       <h5 class="card-header d-flex justify-content-between align-items-center">
    <span>Orders</span>

    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm">Create Order</a>
</h5>
        @can("users read")
        <div class="card-datatable table-responsive">
            <table class="datatables-permissions table border-top">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order Code</th>
                        <th>Mobile</th>
                        <th>Name</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment Mode</th>
                        <th>Shipment From</th>
                        <th>Order Date</th>
                        <!-- <th>Actions</th> -->
                    </tr>
                </thead>
                </thead>
            </table>
        </div>
        @endcan

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
            ajax: '{{ route("admin.orders.index") }}',
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'order_code',
                    name: 'order_code'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'payment_mod',
                    name: 'payment_mod'
                },
                {
                    data: 'shipment_from',
                    name: 'shipment_from'
                },
                {
                    data: 'order_date',
                    name: 'order_date'
                }
                // ,
                // {
                //     data: 'actions',
                //     name: 'actions',
                //     orderable: false,
                //     searchable: false
                // }
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
