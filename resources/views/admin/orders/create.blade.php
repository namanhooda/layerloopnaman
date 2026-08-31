@extends('admin.partial.app')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12">
        <div class="card">

            <!-- Header with button -->
            <h5 class="card-header d-flex justify-content-between align-items-center">
                <span>Create Order</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-secondary">Back</a>
            </h5>

            <div class="card-body">
                <form action="{{ route('admin.orders.store') }}" method="POST" class="row">
                    @csrf

                    <!-- Shipment From -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Shipment From</label>
                        <select name="shipment_from" class="form-control" required>
                            <option value="">Select Shipment Source</option>

                            <option value="Website" {{ old('shipment_from') == 'Website' ? 'selected' : '' }}>
                                Website
                            </option>

                            <option value="Store" {{ old('shipment_from') == 'Store' ? 'selected' : '' }}>
                                Store
                            </option>

                            <option value="Nimbuspost" {{ old('shipment_from') == 'Nimbuspost' ? 'selected' : '' }}>
                                Nimbuspost
                            </option>

                            <option value="Shiprocket" {{ old('shipment_from') == 'Shiprocket' ? 'selected' : '' }}>
                                Shiprocket
                            </option>
                        </select>
                    </div>
                   <div class="mb-3 col-md-4">
    <label class="form-label d-flex justify-content-between align-items-center">
        <span>Select Address</span>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addressModal">
            + Add
        </button>
    </label>

    <select name="address_id" id="user_select" class="form-control" required></select>
</div>
<div class="mb-3 col-md-6">
    <label class="form-label">Add Product</label>
    <select id="product_select" class="form-control"></select>
</div><table class="table table-bordered mt-3" id="order_table">
    <thead>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
                    <!-- Sub Total -->


    <!-- SUBTOTAL -->
    <div class="col-md-4 mb-3">
        <label class="form-label">Subtotal</label>
        <input type="number" step="0.01" id="subtotal" name="subtotal" class="form-control" placeholder="Enter subtotal">
    </div>

    <!-- SHIPPING -->
    <div class="col-md-4 mb-3">
        <label class="form-label">Shipping Charges</label>
        <input type="number" step="0.01" id="shipping" name="shipping" class="form-control" placeholder="Enter shipping" value="0">
    </div>

    <!-- TOTAL -->
    <div class="col-md-4 mb-3">
        <label class="form-label">Total</label>
        <input type="number" step="0.01" id="total" name="total" class="form-control" readonly>
    </div>

                    <!-- Order Date -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Order Date</label>
                        <input type="date" class="form-control" name="order_date" required>
                    </div>

                    <!-- Status -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Order Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <!-- Payment Status -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-control" required>
                            <option value="">Select Payment Status</option>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>

                    <!-- Payment Mode -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Payment Mode</label>
                        <select name="payment_mode" class="form-control" required>
                            <option value="">Select Payment Mode</option>
                            <option value="cod">cod</option>
                            <option value="prepaid">prepaid</option>
                        </select>
                    </div>

                    <!-- Submit -->
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary me-2">Create Order</button>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-label-secondary">Cancel</a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="addressModal" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header">
    <h5 class="modal-title">Add New Address</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form id="addressForm">
<div class="modal-body row">

    <div class="col-md-6 mb-3">
        <label>First Name *</label>
        <input type="text" name="first_name" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Last Name</label>
        <input type="text" name="last_name" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Company</label>
        <input type="text" name="company" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Country *</label>
        <input type="text" name="country" class="form-control" value="India" required>
    </div>

    <div class="col-md-12 mb-3">
        <label>Address Line 1 *</label>
        <input type="text" name="address_line1" class="form-control" required>
    </div>

    <div class="col-md-12 mb-3">
        <label>Address Line 2</label>
        <input type="text" name="address_line2" class="form-control">
    </div>

    <div class="col-md-4 mb-3">
        <label>City *</label>
        <input type="text" name="city" class="form-control" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>State *</label>
        <input type="text" name="state" class="form-control" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>Zip *</label>
        <input type="text" name="zip" class="form-control" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control">
    </div>

</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary">Save Address</button>
</div>

</form>

</div>
</div>
</div>
<script>


$(document).ready(function(){

    function calculateRowTotal(row){
        let qty = parseFloat(row.find('.qty').val()) || 0;
        let price = parseFloat(row.find('.price').val()) || 0;

        let total = qty * price;

        row.find('.row_total').val(total.toFixed(2));
    }

    function calculateSubtotal(){
        let subtotal = 0;
        let hasValidProduct = false;

        $('#productBody tr').each(function(){
            let rowTotal = parseFloat($(this).find('.row_total').val()) || 0;

            if(rowTotal > 0){
                hasValidProduct = true;
            }

            subtotal += rowTotal;
        });

        // ✅ IMPORTANT FIX
        // Only override subtotal if products actually have value
        if(hasValidProduct){
            $('#subtotal').val(subtotal.toFixed(2));
        }

        calculateTotal();
    }

    function calculateTotal(){
        let subtotal = parseFloat($('#subtotal').val()) || 0;
        let shipping = parseFloat($('#shipping').val()) || 0;

        let total = subtotal + shipping;

        $('#total').val(total.toFixed(2));
    }

    // ✅ FIXED EVENT (important)
    $(document).on('input', '.qty, .price', function(){
        let row = $(this).closest('tr');
        calculateRowTotal(row);
        calculateSubtotal();
    });

    // SHIPPING CHANGE
    $('#shipping').on('input', function(){
        calculateTotal();
    });

    // MANUAL SUBTOTAL SUPPORT
    $('#subtotal').on('input', function(){
        calculateTotal();
    });

    // REMOVE ROW FIX
    $(document).on('click', '.removeRow', function(){
        $(this).closest('tr').remove();
        calculateSubtotal();
    });

});


$('#product_select').select2({
    placeholder: 'Search product',
    ajax: {
        url: "{{ route('admin.products.search') }}",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return { search: params.term };
        },
        processResults: function (data) {
            return {
                results: data.map(function(p) {
                    return {
                        id: p.id,
                        text: p.name,
                        price: p.price,
                        image: p.featured_image
                    };
                })
            };
        }
    },

    // 🔥 Render dropdown with image
    templateResult: formatProduct,

    // 🔥 Render selected item
    templateSelection: formatProductSelection,

    escapeMarkup: function(markup) {
        return markup;
    }
});
function formatProduct(product) {

    if (!product.id) {
        return product.text;
    }

    let imageUrl = product.image 
        ? '/storage/' + product.image 
        : '/default.png';

    return `
        <div style="display:flex; align-items:center;">
            <img src="${imageUrl}" width="40" height="40" style="margin-right:10px; border-radius:5px;">
            <div>
                <div>${product.text}</div>
                <small>₹${product.price}</small>
            </div>
        </div>
    `;
}

function formatProductSelection(product) {
    return product.text || product.name;
}
let rowIndex = 0;

$('#product_select').on('select2:select', function (e) {
    let data = e.params.data;

    rowIndex++;

    let row = `
        <tr data-id="${data.id}">
            <td>${rowIndex}</td>
            <td>
                <img src="/storage/${data.image}" width="40" class="me-2">
                ${data.text}
                <input type="hidden" name="products[${rowIndex}][product_id]" value="${data.id}">
            </td>
            <td>
                <input type="number" name="products[${rowIndex}][price]"  class="form-control price" value="${data.price}" readonly>
            </td>
            <td>
                <input type="number" name="products[${rowIndex}][quantity]" class="form-control qty" value="1" min="1">
            </td>
            <td class="row-total">${data.price}</td>
            <td>
                <button type="button" class="btn btn-sm btn-danger remove-row">X</button>
            </td>
        </tr>
    `;

    $('#order_table tbody').append(row);

    calculateTotal();
});
$(document).on('input', '.qty', function () {
    let row = $(this).closest('tr');
    let price = parseFloat(row.find('.price').val());
    let qty = parseInt($(this).val());

    let total = price * qty;

    row.find('.row-total').text(total.toFixed(2));

    calculateTotal();
});

$(document).on('click', '.remove-row', function () {
    $(this).closest('tr').remove();
    calculateTotal();
});
$('#user_select').select2({
    placeholder: 'Search by name, email, or phone',
    allowClear: true,
    ajax: {
        url: "{{ route('admin.users.search') }}",
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                search: params.term
            };
        },
        processResults: function (data) {
            return {
                results: data.map(function(address) {
                    return {
                        id: address.id,
                        text: address.first_name + ' ' + address.last_name + 
                              ' | ' + address.phone + 
                              ' | ' + address.email
                    };
                })
            };
        },
        cache: true
    }
});



$('#addressForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('admin.address.store') }}",
        type: "POST",
        data: $(this).serialize(),
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(res) {

            // Add new option to select2
            let option = new Option(
                res.first_name + ' ' + res.last_name + ' | ' + res.phone + ' | ' + res.email,
                res.id,
                true,
                true
            );

            $('#user_select').append(option).trigger('change');

            // Close modal
            $('#addressModal').modal('hide');

            // Reset form
            $('#addressForm')[0].reset();
        }
    });
});
</script>


@endsection
