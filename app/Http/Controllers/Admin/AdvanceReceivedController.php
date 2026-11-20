<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreAdvanceRequest;
use App\Models\AdvanceReceived;
use App\Models\Party;
use App\Services\AdvancePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdvanceReceivedController extends Controller
{
    public function index(Request $request)
    {
        $query = AdvanceReceived::with('party')->withSum('settlements', 'amount')->latest('advance_date');
        if ($request->filled('status')) $query->where('status', $request->string('status'));
        if ($request->filled('party_id')) $query->where('party_id', $request->integer('party_id'));
        if ($request->filled('from')) $query->whereDate('advance_date', '>=', $request->date('from'));
        if ($request->filled('to')) $query->whereDate('advance_date', '<=', $request->date('to'));

        return view('admin/advance-payments.index', [
            'advances' => $query->paginate(20)->withQueryString(),
            'parties' => Party::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin/advance-payments.form', [
            'type' => 'received', 'advance' => new AdvanceReceived(),
            'parties' => Party::orderBy('name')->get(), 'action' => route('advance-received.store'),
        ]);
    }

    public function store(StoreAdvanceRequest $request)
    {
        AdvanceReceived::create([
            ...$request->validated(),
            'advance_no' => 'AR-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
            'created_by' => $request->user()->id,
            'status' => 'pending',
        ]);

        return redirect()->route('advance-received.index')->with('success', 'Advance received created.');
    }

    public function show(AdvanceReceived $advance_received)
    {
        $advance_received->load(['party', 'settlements' => fn ($q) => $q->latest('settlement_date')]);
        return view('admin/advance-payments.show', ['advance' => $advance_received, 'type' => 'received']);
    }

    public function edit(AdvanceReceived $advance_received)
    {
        return view('admin/advance-payments.form', [
            'type' => 'received', 'advance' => $advance_received,
            'parties' => Party::orderBy('name')->get(), 'action' => route('advance-received.update', $advance_received),
        ]);
    }

    public function update(StoreAdvanceRequest $request, AdvanceReceived $advance_received, AdvancePaymentService $service)
    {
        $service->updateAdvance($advance_received, $request->validated());
        return redirect()->route('advance-received.show', $advance_received)->with('success', 'Advance updated.');
    }

    public function destroy(AdvanceReceived $advance_received, AdvancePaymentService $service)
    {
        $service->deleteAdvance($advance_received);
        return redirect()->route('advance-received.index')->with('success', 'Advance deleted.');
    }
}
