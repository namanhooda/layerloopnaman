<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with('order')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('invoice_number', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->status, fn($q, $status) =>
                $q->where('status', $status)
            )
            ->when($request->payment_status, fn($q, $status) =>
                $q->where('payment_status', $status)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $orders = Order::select('id', 'order_code')
            ->latest()
            ->limit(500)
            ->get();

        return view('admin.invoices.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $data = $this->validateInvoice($request);

        $invoice = DB::transaction(function () use ($data) {

            $invoice = Invoice::create([
                ...$this->invoiceDetails($data),
                'invoice_number' => 'TEMP-' . uniqid(),
                'subtotal' => 0,
                'taxable_amount' => 0,
                'grand_total' => 0,
                'paid_amount' => 0,
                'due_amount' => 0,
            ]);

            $invoice->update([
                'invoice_number' => 'LLINV-' .
                    now()->format('Y') . '-' .
                    str_pad($invoice->id, 6, '0', STR_PAD_LEFT),
            ]);

            $this->saveItems($invoice, $data);

            $this->calculateTotals($invoice, $data);

            return $invoice;
        });

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['items', 'order']);

        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $invoice->load('items');

        $orders = Order::select('id', 'order_code')
            ->latest()
            ->limit(500)
            ->get();

        return view('admin.invoices.edit', compact(
            'invoice',
            'orders'
        ));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $this->validateInvoice($request);

        DB::transaction(function () use ($invoice, $data) {

            $invoice->update($this->invoiceDetails($data));

            $invoice->items()->delete();

            $this->saveItems($invoice, $data);

            $this->calculateTotals($invoice, $data);
        });

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->payment_status === 'paid') {
            return back()->with(
                'error',
                'Paid invoices cannot be deleted.'
            );
        }

        $invoice->delete();

        return redirect()
            ->route('admin.invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    private function validateInvoice(Request $request): array
    {
        $data = $request->validate([
            'invoice_type' => 'required|in:manual,order',
            'order_id' => 'nullable|required_if:invoice_type,order|exists:orders,id',

            'customer_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'gstin' => 'nullable|string|max:20',

            'billing_address' => 'nullable|string',
            'billing_city' => 'nullable|string|max:255',
            'billing_state' => 'nullable|string|max:255',
            'billing_pincode' => 'nullable|string|max:10',

            'shipping_address' => 'nullable|string',
            'shipping_city' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_pincode' => 'nullable|string|max:10',

            'place_of_supply' => 'required|string|max:255',

            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',

            'discount_amount' => 'nullable|numeric|min:0',
            'shipping_charge' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',

            'status' => 'required|in:draft,sent,cancelled',
            'notes' => 'nullable|string',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.description' => 'required|string|max:255',
            'items.*.hsn_code' => 'nullable|string|max:20',
            'items.*.quantity' => 'required|numeric|gt:0',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.tax_rate' => 'required|numeric|in:0,5,12,18,28',
        ]);

        return $data;
    }

    private function invoiceDetails(array $data): array
    {
        return [
            'invoice_type' => $data['invoice_type'],
            'order_id' => $data['invoice_type'] === 'order'
                ? $data['order_id']
                : null,

            'customer_name' => $data['customer_name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'gstin' => $data['gstin'] ?? null,

            'billing_address' => $data['billing_address'] ?? null,
            'billing_city' => $data['billing_city'] ?? null,
            'billing_state' => $data['billing_state'] ?? null,
            'billing_pincode' => $data['billing_pincode'] ?? null,

            'shipping_address' => $data['shipping_address'] ?? null,
            'shipping_city' => $data['shipping_city'] ?? null,
            'shipping_state' => $data['shipping_state'] ?? null,
            'shipping_pincode' => $data['shipping_pincode'] ?? null,

            'place_of_supply' => $data['place_of_supply'],
            'invoice_date' => $data['invoice_date'],
            'due_date' => $data['due_date'] ?? null,

            'discount_amount' => $data['discount_amount'] ?? 0,
            'shipping_charge' => $data['shipping_charge'] ?? 0,

            'status' => $data['status'],
            'notes' => $data['notes'] ?? null,
        ];
    }

    private function saveItems(Invoice $invoice, array $data): void
    {
        $sellerState = config('invoice.seller_state');

        $isInterState = strcasecmp(
            trim($data['place_of_supply']),
            trim($sellerState)
        ) !== 0;

        foreach ($data['items'] as $item) {

            $quantity = (float) $item['quantity'];
            $price = (float) $item['price'];
            $discount = (float) ($item['discount'] ?? 0);
            $taxRate = (float) $item['tax_rate'];

            $gross = round($quantity * $price, 2);

            if ($discount > $gross) {
                throw ValidationException::withMessages([
                    'items' => 'Item discount cannot exceed its amount.',
                ]);
            }

            $taxable = round($gross - $discount, 2);
            $tax = round($taxable * $taxRate / 100, 2);

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item['product_id'] ?? null,
                'description' => $item['description'],
                'hsn_code' => $item['hsn_code'] ?? null,
                'quantity' => $quantity,
                'price' => $price,
                'discount' => $discount,
                'tax_rate' => $taxRate,
                'taxable_amount' => $taxable,
                'cgst_amount' => $isInterState ? 0 : round($tax / 2, 2),
                'sgst_amount' => $isInterState ? 0 : round($tax - round($tax / 2, 2), 2),
                'igst_amount' => $isInterState ? $tax : 0,
                'total' => round($taxable + $tax, 2),
            ]);
        }
    }

    private function calculateTotals(
        Invoice $invoice,
        array $data
    ): void {
        $items = $invoice->items;

        $subtotal = $items->sum(fn($item) =>
            $item->quantity * $item->price
        );

        $itemDiscounts = $items->sum('discount');

        $taxable = $items->sum('taxable_amount');

        $cgst = $items->sum('cgst_amount');
        $sgst = $items->sum('sgst_amount');
        $igst = $items->sum('igst_amount');

        $invoiceDiscount = (float) ($data['discount_amount'] ?? 0);

        $shipping = (float) ($data['shipping_charge'] ?? 0);

        $totalTax = $cgst + $sgst + $igst;

        $grandTotal = max(
            0,
            round($taxable - $invoiceDiscount + $totalTax + $shipping, 2)
        );

        $paid = (float) ($data['paid_amount'] ?? 0);

        if ($paid > $grandTotal) {
            throw ValidationException::withMessages([
                'paid_amount' => 'Paid amount cannot exceed invoice total.',
            ]);
        }

        $due = round($grandTotal - $paid, 2);

        $paymentStatus = $due <= 0
            ? 'paid'
            : ($paid > 0 ? 'partial' : 'unpaid');

        $invoice->update([
            'subtotal' => $subtotal,
            'discount_amount' => $itemDiscounts + $invoiceDiscount,
            'taxable_amount' => $taxable,
            'cgst_amount' => $cgst,
            'sgst_amount' => $sgst,
            'igst_amount' => $igst,
            'shipping_charge' => $shipping,
            'grand_total' => $grandTotal,
            'paid_amount' => $paid,
            'due_amount' => $due,
            'payment_status' => $paymentStatus,
        ]);
    }
}
