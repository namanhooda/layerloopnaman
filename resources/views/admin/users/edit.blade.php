@extends('admin.partial.app')
@section('content')


<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-4 col-lg-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-6">
                <div class="card-body pt-12">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            @if($user->profile)
                            <img class="img-fluid rounded mb-4" src="{{asset('storage/'.$user->profile)}}" height="120"
                                width="120" alt="User avatar" />
                            @else
                            <img class="img-fluid rounded mb-4" src="{{asset('backend/assets/img/avatars/1.png')}}"
                                height="120" width="120" alt="User avatar" />
                            @endif
                            <div class="user-info text-center">
                                <h5>{{$user->name}}</h5>
                                <span class="badge bg-label-secondary">Author</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-4 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled mb-6">
                            <li class="mb-2">
                                <span class="h6">Email:</span>
                                <span>{{$user->email}}</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6">Status:</span>
                                <span>@if($user->status== 0) Inactive @else Active @endif</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6">Role:</span>
                                <span>Author</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6">Contact:</span>
                                <span>{{$user->phone}}</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center">
                            <a href="javascript:;" class="btn btn-label-danger suspend-user">Delete User</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ User Sidebar -->

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 order-0 order-md-1">
            <!-- User Pills -->

            <!--/ User Pills -->


            <!-- Activity Timeline -->
            <div class="card mb-6">
                <h5 class="card-header">Edit Details</h5>

                @can("users edit")
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row gx-4">
                            <!-- Name -->
                            <div class="mb-4 col-12 col-sm-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-4 col-12 col-sm-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <!-- Phone -->
                            <div class="mb-4 col-12 col-sm-6">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" name="mobile"
                                    value="{{ old('mobile', $user->phone) }}">
                            </div>

                            <!-- Image -->
                            <div class="mb-4 col-12 col-sm-6">
                                <label class="form-label">Profile Image</label>
                                <input type="file" class="form-control" name="image">
                                @if($user->image)
                                <img src="{{ asset('storage/'.$user->image) }}" width="80" class="mt-2 rounded" />
                                @endif
                            </div>

                            <!-- Password -->
                            <div class="mb-4 col-12 col-sm-6">
                                <label class="form-label">New Password (optional)</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4 col-12 col-sm-6">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>

                            <!-- Status -->
                            <div class="mb-4 col-12 col-sm-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary">Update User</button>
                            </div>
                        </div>
                    </form>

                </div>
                @endcan
            </div>
            <!-- /Activity Timeline -->

            <!-- Activity Timeline -->

            <!-- /Activity Timeline -->

        </div>
        <!--/ User Content -->
    </div>

</div>

@endsection
