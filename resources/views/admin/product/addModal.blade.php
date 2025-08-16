<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
        <form class="add-new-user pt-0" id="addNewUserForm" method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="mb-6 form-control-validation">
                <label class="form-label" for="add-user-fullname">Full Name</label>
                <input type="text" class="form-control" id="add-user-fullname" name="name" placeholder="John Doe" />
            </div>
            <div class="mb-6 form-control-validation">
                <label class="form-label" for="add-user-email">Email</label>
                <input type="email" id="add-user-email" class="form-control" name="email"
                    placeholder="john.doe@example.com" />
            </div>
            <div class="mb-6">
                <label class="form-label" for="add-user-contact">Contact</label>
                <input type="text" id="add-user-contact" class="form-control" name="mobile" placeholder="9999999999" />
            </div>
            <div class="mb-6">
                <label class="form-label" for="user-role">User Role</label>
                <select id="user-role" name="role_id" class="form-select" required>
                    <option value="" disabled selected>Select a Role</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary me-3">Submit</button>
            <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
        </form>
    </div>
</div>
