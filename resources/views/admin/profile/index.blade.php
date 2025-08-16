@extends('admin.partial.app')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            {{-- Update Profile --}}
            <div class="card mb-6">
                <form method="POST" action="{{ route('user-profile-information.update') }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="d-flex align-items-start align-items-sm-center gap-6">
                            <img src="{{asset('storage/'.Auth::user()->profile)}}" alt="user-avatar"
                                class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                            <div class="button-wrapper">
                                <label for="profile_photo" class="btn btn-primary me-3 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload new photo</span>
                                    <i class="icon-base ti tabler-upload d-block d-sm-none"></i>
                                    <input type="file" name="photo" id="profile_photo" class="account-file-input" hidden
                                        accept="image/*" />
                                </label>
                                <button type="button" class="btn btn-label-secondary account-image-reset mb-4"
                                    onclick="document.getElementById('profile_photo').value = null;">
                                    <i class="icon-base ti tabler-reset d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Reset</span>
                                </button>
                                <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-4">
                        <div class="row gy-4 gx-6 mb-6">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    value="{{ old('name', Auth::user()->name) }}" required />
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    value="{{ old('email', Auth::user()->email) }}" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phoneNumber">Phone Number</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text">In (+91)</span>
                                    <input type="text" id="phone" name="phone" class="form-control"
                                    value="{{ old('name', Auth::user()->phone) }}" placeholder="Enter Mobile" />
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="country">Status</label>
                                <select id="country" class="select2 form-select" name="status">
                                    <option value="">Select</option>
                                    <option value="0" {{ Auth::user()->status == 0 ? 'selected' : '' }}>In Active</option>
                                    <option value="1" {{ Auth::user()->status == 1 ? 'selected' : '' }}>Active</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-3">Save changes</button>
                            <button type="reset" class="btn btn-label-secondary">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Change Password --}}
            <div class="card mb-6">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body pt-1">
                    <form method="POST" action="{{ route('user-password.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input class="form-control" type="password" id="current_password"
                                    name="current_password" required />
                            </div>
                        </div>
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <input class="form-control" type="password" id="password" name="password" required />
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input class="form-control" type="password" id="password_confirmation"
                                    name="password_confirmation" required />
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-3">Save changes</button>
                            <button type="reset" class="btn btn-label-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="card">
                <h5 class="card-header">Delete Account</h5>
                <div class="card-body">
                    <form method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="alert alert-warning">
                            <h5 class="alert-heading mb-1">Are you sure you want to delete your account?</h5>
                            <p class="mb-0">Once you delete your account, there is no going back.</p>
                        </div>
                        <div class="form-check my-3">
                            <input class="form-check-input" type="checkbox" id="confirmDelete"
                                onclick="document.querySelector('.deactivate-account').disabled = !this.checked;">
                            <label class="form-check-label" for="confirmDelete">I confirm my account
                                deactivation</label>
                        </div>
                        <button type="submit" class="btn btn-danger deactivate-account" disabled>Deactivate
                            Account</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
