<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <style>
            .star-rating {
                direction: rtl;
                display: inline-flex;
                font-size: 1.5rem;
                gap: 0.2rem;
            }

            .star-rating input[type="radio"] {
                display: none;
            }

            .star-rating label {
                color: #ccc;
                cursor: pointer;
            }

            .star-rating input:checked~label,
            .star-rating label:hover,
            .star-rating label:hover~label {
                color: #f5b301;
            }

        </style>
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab"
                                    aria-controls="signin" aria-selected="true">Add Address</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-content-5">
                            <div class="tab-pane fade show active" id="signin" role="tabpanel"
                                aria-labelledby="signin-tab">
                                <form action="{{ route('addresses.store') }}" method="POST">
                                    @csrf
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

                                    <label>House / Flat / Block No *</label>
                                    <input name="address_line1" type="text" class="form-control" required>

                                    <label>Appartment / Road / Area *</label>
                                    <input name="address_line2" type="text" class="form-control" required>
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
