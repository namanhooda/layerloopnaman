
@php
    $isEdit = isset($invoice);

    $items = old('items', $isEdit
        ? $invoice->items->map(fn($item) => [
            'product_id' => $item->product_id,
            'description' => $item->description,
            'hsn_code' => $item->hsn_code,
            'quantity' => $item->quantity,
            'price' => $item->price,
            'discount' => $item->discount,
            'tax_rate' => $item->tax_rate,
        ])->toArray()
        : [[
            'product_id' => '',
            'description' => '',
            'hsn_code' => '',
            'quantity' => 1,
            'price' => 0,
            'discount' => 0,
            'tax_rate' => 18,
        ]]
    );
@endphp

<style>
    .invoice-section {
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .invoice-section h5 {
        margin-bottom: 20px;
        font-weight: 600;
    }
    .invoice-total {
        max-width: 400px;
        margin-left: auto;
    }
    .item-table input {
        min-width: 90px;
    }
</style>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="invoice-section">
    <h5>Invoice Information</h5>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Invoice Type *</label>
            <select name="invoice_type" id="invoice_type" class="form-control">
                <option value="manual"
                    @selected(old('invoice_type', $invoice->invoice_type ?? 'manual') == 'manual')>
                    Manual Invoice
                </option>
                <option value="order"
                    @selected(old('invoice_type', $invoice->invoice_type ?? '') == 'order')>
                    From Existing Order
                </option>
            </select>
        </div>

        <div class="col-md-4 mb-3" id="order-wrapper">
            <label>Select Order *</label>
            <select name="order_id" class="form-control">
                <option value="">Select Order</option>
                @foreach($orders as $order)
                    <option value="{{ $order->id }}"
                        @selected(old('order_id', $invoice->order_id ?? '') == $order->id)>
                        {{ $order->order_code }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mb-3">
            <label>Invoice Date *</label>
            <input type="date"
                   name="invoice_date"
                   class="form-control"
                   value="{{ old('invoice_date', isset($invoice) ? $invoice->invoice_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                   required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Due Date</label>
            <input type="date"
                   name="due_date"
                   class="form-control"
                   value="{{ old('due_date', isset($invoice) ? $invoice->due_date?->format('Y-m-d') : '') }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                @foreach(['draft','sent','cancelled'] as $status)
                    <option value="{{ $status }}"
                        @selected(old('status', $invoice->status ?? 'draft') == $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="invoice-section">
    <h5>Customer Information</h5>

    <div class="row">
        @foreach([
            'customer_name' => 'Customer Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'gstin' => 'GSTIN'
        ] as $field => $label)
            <div class="col-md-3 mb-3">
                <label>{{ $label }}</label>
                <input type="text"
                       name="{{ $field }}"
                       class="form-control"
                       value="{{ old($field, $invoice->$field ?? '') }}"
                       {{ $field == 'customer_name' ? 'required' : '' }}>
            </div>
        @endforeach
    </div>
</div>

<div class="invoice-section">
    <h5>Billing Address</h5>

    <div class="row">
        @foreach([
            'billing_address' => 'Address',
            'billing_city' => 'City',
            'billing_state' => 'State',
            'billing_pincode' => 'Pincode',
            'shipping_address' => 'Shipping Address',
            'shipping_city' => 'Shipping City',
            'shipping_state' => 'Shipping State',
            'shipping_pincode' => 'Shipping Pincode',
            'place_of_supply' => 'Place of Supply'
        ] as $field => $label)
            <div class="col-md-4 mb-3">
                <label>{{ $label }}</label>
                <input type="text"
                       name="{{ $field }}"
                       class="form-control"
                       value="{{ old($field, $invoice->$field ?? '') }}"
                       {{ $field == 'place_of_supply' ? 'required' : '' }}>
            </div>
        @endforeach
    </div>
</div>

<div class="invoice-section">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Invoice Items</h5>
        <button type="button" class="btn btn-sm btn-primary" id="add-item">
            + Add Item
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered item-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>HSN</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>GST %</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="invoice-items">
                @foreach($items as $i => $item)
                    <tr>
                        <td>
                            <input name="items[{{ $i }}][description]"
                                   class="form-control"
                                   value="{{ $item['description'] }}"
                                   required>
                        </td>
                        <td>
                            <input name="items[{{ $i }}][hsn_code]"
                                   class="form-control"
                                   value="{{ $item['hsn_code'] }}">
                        </td>
                        <td>
                            <input type="number" step="0.01" min="0.01"
                                   name="items[{{ $i }}][quantity]"
                                   class="form-control item-qty"
                                   value="{{ $item['quantity'] }}" required>
                        </td>
                        <td>
                            <input type="number" step="0.01" min="0"
                                   name="items[{{ $i }}][price]"
                                   class="form-control item-price"
                                   value="{{ $item['price'] }}" required>
                        </td>
                        <td>
                            <input type="number" step="0.01" min="0"
                                   name="items[{{ $i }}][discount]"
                                   class="form-control item-discount"
                                   value="{{ $item['discount'] }}">
                        </td>
                        <td>
                            <select name="items[{{ $i }}][tax_rate]"
                                    class="form-control item-tax">
                                @foreach([0,5,12,18,28] as $rate)
                                    <option value="{{ $rate }}"
                                        @selected($item['tax_rate'] == $rate)>
                                        {{ $rate }}%
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="item-total">0.00</td>
                        <td>
                            <button type="button"
                                    class="btn btn-danger btn-sm remove-item">
                                X
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="invoice-section">
    <h5>Additional Charges & Payment</h5>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>Invoice Discount</label>
            <input type="number" step="0.01" min="0"
                   name="discount_amount" id="invoice-discount"
                   class="form-control"
                   value="{{ old('discount_amount', $invoice->discount_amount ?? 0) }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>Shipping Charge</label>
            <input type="number" step="0.01" min="0"
                   name="shipping_charge" id="shipping-charge"
                   class="form-control"
                   value="{{ old('shipping_charge', $invoice->shipping_charge ?? 0) }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>Paid Amount</label>
            <input type="number" step="0.01" min="0"
                   name="paid_amount" id="paid-amount"
                   class="form-control"
                   value="{{ old('paid_amount', $invoice->paid_amount ?? 0) }}">
        </div>

        <div class="col-md-12">
            <label>Notes</label>
            <textarea name="notes" class="form-control">{{ old('notes', $invoice->notes ?? '') }}</textarea>
        </div>
    </div>
</div>

<div class="invoice-section invoice-total">
    <table class="table">
        <tr><th>Subtotal</th><td id="subtotal">₹0.00</td></tr>
        <tr><th>Item Discount</th><td id="item-discounts">₹0.00</td></tr>
        <tr><th>Taxable Amount</th><td id="taxable">₹0.00</td></tr>
        <tr><th>CGST</th><td id="cgst">₹0.00</td></tr>
        <tr><th>SGST</th><td id="sgst">₹0.00</td></tr>
        <tr><th>IGST</th><td id="igst">₹0.00</td></tr>
        <tr><th>Invoice Discount</th><td id="extra-discount">₹0.00</td></tr>
        <tr><th>Shipping</th><td id="shipping">₹0.00</td></tr>
        <tr class="font-weight-bold">
            <th>Grand Total</th><td id="grand-total">₹0.00</td>
        </tr>
        <tr><th>Due Amount</th><td id="due-total">₹0.00</td></tr>
    </table>
</div>

<button type="submit" class="btn btn-success">
    {{ $isEdit ? 'Update Invoice' : 'Create Invoice' }}
</button>

<a href="{{ route('admin.invoices.index') }}"
   class="btn btn-secondary">Cancel</a>

<script>
(function () {
    const body = document.getElementById('invoice-items');
    const orderType = document.getElementById('invoice_type');

    function toggleOrder() {
        document.getElementById('order-wrapper').style.display =
            orderType.value === 'order' ? '' : 'none';
    }

    orderType.addEventListener('change', toggleOrder);
    toggleOrder();

    function money(value) {
        return '₹' + Number(value || 0).toFixed(2);
    }

    function calculate() {
        let subtotal = 0;
        let discounts = 0;
        let taxable = 0;
        let cgst = 0;
        let sgst = 0;
        let igst = 0;

        const interState = (() => {
            const supply = document.querySelector('[name="place_of_supply"]').value.trim().toLowerCase();
            const seller = @json(config('invoice.seller_state')).trim().toLowerCase();
            return supply && seller && supply !== seller;
        })();

        body.querySelectorAll('tr').forEach(row => {
            const qty = Number(row.querySelector('.item-qty').value) || 0;
            const price = Number(row.querySelector('.item-price').value) || 0;
            const discount = Number(row.querySelector('.item-discount').value) || 0;
            const rate = Number(row.querySelector('.item-tax').value) || 0;

            const gross = qty * price;
            const itemTaxable = Math.max(0, gross - discount);
            const tax = itemTaxable * rate / 100;

            subtotal += gross;
            discounts += discount;
            taxable += itemTaxable;

            if (interState) {
                igst += tax;
            } else {
                cgst += tax / 2;
                sgst += tax / 2;
            }

            row.querySelector('.item-total').textContent =
                money(itemTaxable + tax);
        });

        const extraDiscount = Number(document.getElementById('invoice-discount').value) || 0;
        const shipping = Number(document.getElementById('shipping-charge').value) || 0;
        const paid = Number(document.getElementById('paid-amount').value) || 0;

        const grand = Math.max(0,
            taxable - extraDiscount + cgst + sgst + igst + shipping
        );

        const due = Math.max(0, grand - paid);

        document.getElementById('subtotal').textContent = money(subtotal);
        document.getElementById('item-discounts').textContent = money(discounts);
        document.getElementById('taxable').textContent = money(taxable);
        document.getElementById('cgst').textContent = money(cgst);
        document.getElementById('sgst').textContent = money(sgst);
        document.getElementById('igst').textContent = money(igst);
        document.getElementById('extra-discount').textContent = money(extraDiscount);
        document.getElementById('shipping').textContent = money(shipping);
        document.getElementById('grand-total').textContent = money(grand);
        document.getElementById('due-total').textContent = money(due);
    }

    function bindRow(row) {
        row.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', calculate);
            input.addEventListener('change', calculate);
        });

        row.querySelector('.remove-item').addEventListener('click', () => {
            if (body.querySelectorAll('tr').length > 1) {
                row.remove();
                calculate();
            }
        });
    }

    let index = body.querySelectorAll('tr').length;

    document.getElementById('add-item').addEventListener('click', () => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td><input name="items[${index}][description]" class="form-control" required></td>
            <td><input name="items[${index}][hsn_code]" class="form-control"></td>
            <td><input type="number" min="0.01" step="0.01" name="items[${index}][quantity]" class="form-control item-qty" value="1" required></td>
            <td><input type="number" min="0" step="0.01" name="items[${index}][price]" class="form-control item-price" value="0" required></td>
            <td><input type="number" min="0" step="0.01" name="items[${index}][discount]" class="form-control item-discount" value="0"></td>
            <td>
                <select name="items[${index}][tax_rate]" class="form-control item-tax">
                    <option value="0">0%</option>
                    <option value="5">5%</option>
                    <option value="12">12%</option>
                    <option value="18" selected>18%</option>
                    <option value="28">28%</option>
                </select>
            </td>
            <td class="item-total">₹0.00</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-item">X</button></td>
        `;

        body.appendChild(row);
        bindRow(row);
        index++;
        calculate();
    });

    body.querySelectorAll('tr').forEach(bindRow);

    document.querySelectorAll(
        '#invoice-discount, #shipping-charge, #paid-amount, [name="place_of_supply"]'
    ).forEach(el => {
        el.addEventListener('input', calculate);
        el.addEventListener('change', calculate);
    });

    calculate();
})();
</script>
