<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreSettlementRequest;
use App\Models\AdvancePaid;
use App\Models\AdvanceReceived;
use App\Models\AdvanceSettlement;
use App\Services\AdvancePaymentService;
use Illuminate\Http\Request;

class AdvanceSettlementController extends Controller
{
    private function resolveAdvance(string $type, int $id)
    {
        abort_unless(in_array($type, ['received', 'paid'], true), 404);
        $class = $type === 'received' ? AdvanceReceived::class : AdvancePaid::class;
        return $class::findOrFail($id);
    }

    public function create(string $type, int $id)
    {
        $advance = $this->resolveAdvance($type, $id);
        return view('admin/advance-payments.settlement-form', [
            'advance' => $advance, 'type' => $type,
            'action' => route('advance-settlements.store', [$type, $id]),
            'settlement' => new AdvanceSettlement(),
        ]);
    }

    public function store(StoreSettlementRequest $request, string $type, int $id, AdvancePaymentService $service)
    {
        $advance = $this->resolveAdvance($type, $id);
        $service->createSettlement($advance, $request->validated(), $request->user()->id);
        return redirect()->route($type === 'received' ? 'advance-received.show' : 'advance-paid.show', $advance)
            ->with('success', 'Settlement recorded.');
    }

    public function edit(AdvanceSettlement $settlement)
    {
        $advance = $settlement->settleable;
        $type = $advance instanceof AdvanceReceived ? 'received' : 'paid';
        return view('admin/advance-payments.settlement-form', [
            'advance' => $advance, 'type' => $type, 'settlement' => $settlement,
            'action' => route('advance-settlements.update', $settlement),
        ]);
    }

    public function update(StoreSettlementRequest $request, AdvanceSettlement $settlement, AdvancePaymentService $service)
    {
        $advance = $settlement->settleable;
        $type = $advance instanceof AdvanceReceived ? 'received' : 'paid';
        $service->updateSettlement($settlement, $request->validated());
        return redirect()->route($type === 'received' ? 'advance-received.show' : 'advance-paid.show', $advance)
            ->with('success', 'Settlement updated.');
    }

    public function destroy(AdvanceSettlement $settlement, AdvancePaymentService $service)
    {
        $advance = $settlement->settleable;
        $type = $advance instanceof AdvanceReceived ? 'received' : 'paid';
        $service->deleteSettlement($settlement);
        return redirect()->route($type === 'received' ? 'advance-received.show' : 'advance-paid.show', $advance)
            ->with('success', 'Settlement deleted.');
    }
}
