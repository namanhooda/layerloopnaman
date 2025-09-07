
<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-labelledby="addAddressModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('addresses.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>First Name *</label>
                            <input name="first_name" type="text" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label>Last Name *</label>
                            <input name="last_name" type="text" class="form-control" required>
                        </div>
                    </div>

                    <label>Company Name (Optional)</label>
                    <input name="company" type="text" class="form-control">

                    <label>Country *</label>
                    <input name="country" type="text" class="form-control" required>

                    <label>Street Address *</label>
                    <input name="address" type="text" class="form-control" required>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>City *</label>
                            <input name="city" type="text" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label>State *</label>
                            <input name="state" type="text" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <label>ZIP / Postal Code *</label>
                            <input name="zip" type="text" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label>Phone *</label>
                            <input name="phone" type="text" class="form-control" required>
                        </div>
                    </div>

                    <label>Email *</label>
                    <input name="email" type="email" class="form-control" required>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Address</button>
                </div>
            </div>
        </form>
    </div>
</div>