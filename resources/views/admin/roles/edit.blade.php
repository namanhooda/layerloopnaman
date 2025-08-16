@extends('admin.partial.app')
@section('content')


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-12 col-lg-12 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-6">
                <div class="card-body pt-12">
                    @php
                    $groupedPermissions = $permissions->groupBy(function($perm) {
                        $parts = explode(' ', $perm->name);
                        return ($parts[1] ?? '') === 'categories'
                            ? $parts[0] . ' ' . $parts[1]      // e.g., 'blog categories'
                            : $parts[0];                       // e.g., 'blog', 'news', 'seo'
                    });

                    $rolePermissions = $role->permissions->pluck('id')->toArray();
                    @endphp
                    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-12 form-control-validation mb-3">
                            <label class="form-label" for="modalRoleName">Role Name</label>
                            <input type="text" id="modalRoleName" name="name" class="form-control"
                                value="{{ $role->name }}" required />
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
                                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                                        <label class="form-check-label" for="selectAll">Select
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
                                                            id="perm_{{ $perm->id }}"
                                                            {{ in_array($perm->id, $rolePermissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="perm_{{ $perm->id }}">{{ ucfirst(str_replace($module . ' ', '', $perm->name)) }}</label>
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
                            <button type="submit" class="btn btn-primary me-sm-4 me-1">Update Role</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-label-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 order-0 order-md-1">
                <!-- User Pills -->

                <!--/ User Pills -->



                <!-- Activity Timeline -->

                <!-- /Activity Timeline -->

            </div>
            <!--/ User Content -->
        </div>

    </div>
    <script>
        document.getElementById('selectAll').addEventListener('change', function () {
            const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

    </script>

    @endsection
