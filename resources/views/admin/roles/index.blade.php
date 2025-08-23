@extends('admin.partial.app')
@section('content')


<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="mb-1">Roles List</h4>
    <!-- Role cards -->

    @can("role read")
    <div class="row g-6">
        @foreach($roles as $role)
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-normal mb-0 text-body">Total 4 users</h6>
                        <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                title="Vinnie Mostowy" class="avatar pull-up">
                                <img class="rounded-circle" src="{{asset('backend/assets/img/avatars/5.png')}}"
                                    alt="Avatar" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                title="Allen Rieske" class="avatar pull-up">
                                <img class="rounded-circle" src="{{asset('backend/assets/img/avatars/12.png')}}"
                                    alt="Avatar" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                title="Julee Rossignol" class="avatar pull-up">
                                <img class="rounded-circle" src="{{asset('backend/assets/img/avatars/6.png')}}"
                                    alt="Avatar" />
                            </li>
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                title="Kaith D'souza" class="avatar pull-up">
                                <img class="rounded-circle" src="{{asset('backend/assets/img/avatars/3.png')}}"
                                    alt="Avatar" />
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="role-heading">
                            <h5 class="mb-1">{{$role->name}}</h5>
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="role-edit-modal">
                                <span>Edit Role</span>
                            </a>
                        </div>
                        <a href="javascript:void(0);"><i class="icon-base ti tabler-copy icon-md text-heading"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @can('role create')
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card h-100">
                <div class="row h-100">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-4">
                            <img src="{{asset('backend/assets/img/illustrations/add-new-roles.png')}}" class="img-fluid"
                                alt="Image" width="83" />
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">
                                Add New Role
                            </button>
                            <p class="mb-0">
                                Add new role, <br />
                                if it doesn't exist.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
    @endcan
    <!--/ Role cards -->

    <!-- Add Role Modal -->
    <!-- Add Role Modal -->
    @can("role read")
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-6">
                        <h4 class="role-title">Add New Role</h4>
                        <p class="text-body-secondary">Set role permissions</p>
                    </div>
                    <!-- Add role form -->
                    @php
                    $groupedPermissions = $permissions->groupBy(function($perm) {
                        $parts = explode(' ', $perm->name);
                        return ($parts[1] ?? '') === 'categories'
                            ? $parts[0] . ' ' . $parts[1]      // e.g., 'blog categories'
                            : $parts[0];                       // e.g., 'blog', 'news', 'seo'
                    });
                    @endphp

                    <form action="{{ route('admin.roles.store') }}" method="POST" class="row g-3">
                        @csrf

                        <div class="col-12 form-control-validation mb-3">
                            <label class="form-label" for="modalRoleName">Role Name</label>
                            <input type="text" id="modalRoleName" name="name" class="form-control"
                                placeholder="Enter a role name" required />
                        </div>

                        <div class="col-12">
                            <h5 class="mb-3">Role Permissions</h5>
                            <div class="table-responsive">
                                <table class="table table-flush-spacing">
                                    <tbody>
                                        <tr>
                                            <td class="text-nowrap fw-medium">
                                                Administrator Access
                                                <i class="icon-base ti tabler-info-circle icon-xs"
                                                    data-bs-toggle="tooltip"
                                                    title="Allows full access to the system"></i>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <div class="form-check mb-0">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="selectAllCreate">
                                                        <label class="form-check-label" for="selectAllCreate">Select
                                                            All</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        @foreach ($groupedPermissions as $module => $perms)
                                        <tr>
                                            <td class="text-nowrap fw-medium text-capitalize">{{ $module }} Management
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-3 justify-content-end">
                                                    @foreach ($perms as $perm)
                                                    <div class="form-check mb-0">
                                                        <input type="checkbox" class="form-check-input"
                                                            name="permissions[]" value="{{ $perm->id }}"
                                                            id="perm_create_{{ $perm->id }}">
                                                        <label class="form-check-label"
                                                            for="perm_create_{{ $perm->id }}">{{ ucfirst(str_replace($module . ' ', '', $perm->name)) }}</label>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary me-sm-4 me-1">Submit</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                aria-label="Close">Cancel</button>
                        </div>
                    </form>
                    <!--/ Add role form -->
                </div>
            </div>
        </div>
    </div>
    @endcan
    <!--/ Add Role Modal -->

    <!-- / Add Role Modal -->
</div>
<script>
    document.getElementById('selectAllCreate').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });
</script>

@endsection
