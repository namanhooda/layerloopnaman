<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContractRequest;
use App\Models\{Contract, ContractType};
use App\Services\{ContractNumberService, ContractExclusivityService};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Contract::with('type')->select('contracts.*');
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('type_name', fn ($row) => optional($row->type)->name)
                ->addColumn('party', fn ($row) => e($row->party_name).($row->company_name ? '<br><small>'.e($row->company_name).'</small>' : ''))
                ->addColumn('period', fn ($row) => ($row->start_date?->format('d M Y') ?? '—').' to '.($row->end_date?->format('d M Y') ?? 'Open'))
                ->addColumn('status_badge', function ($row) {
                    $map = ['draft'=>'secondary','pending'=>'warning','issued'=>'info','signed'=>'primary','active'=>'success','expired'=>'dark','terminated'=>'danger'];
                    $color = $map[$row->status] ?? 'secondary';
                    return '<span class="badge bg-label-'.$color.'">'.e(ucfirst($row->status)).'</span>';
                })
                ->addColumn('action', fn ($row) => view('admin.contracts.partials.actions', compact('row'))->render())
                ->rawColumns(['party','status_badge','action'])
                ->make(true);
        }

        return view('admin.contracts.index');
    }

    public function create()
    {
        $types = ContractType::where('is_active', true)->orderBy('name')->get();
        return view('admin.contracts.create', compact('types'));
    }

    public function store(
        StoreContractRequest $request,
        ContractNumberService $numbers,
        ContractExclusivityService $exclusivity
    ) {
        $data = $request->validated();
        $productRows = $data['products'] ?? [];
        $conditionRows = $data['conditions'] ?? [];
        $productIds = collect($productRows)->pluck('product_id')->filter()->all();

        $exclusivity->assertNoConflict($data, $productIds);

        $contract = DB::transaction(function () use ($data, $productRows, $conditionRows, $numbers) {
            unset($data['products'], $data['conditions']);
            $data['contract_number'] = $numbers->next();
            $data['created_by'] = auth()->id();
            $data['status'] = 'draft';
            $contract = Contract::create($data);

            foreach ($productRows as $index => $product) {
                $contract->products()->create($product);
            }
            foreach ($conditionRows as $index => $condition) {
                $condition['sort_order'] = $index;
                $contract->conditions()->create($condition);
            }
            $contract->logActivity('created', 'Contract draft created.');
            return $contract;
        });

        return redirect()->route('admin.contracts.show', $contract)->with('success', 'Contract created successfully.');
    }

    public function show(Contract $contract)
    {
        $contract->load(['type','products','conditions','parties','documents','notices','activityLogs']);
        return view('admin.contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        abort_unless($contract->isEditable(), 403, 'Issued or signed contracts must be amended through a new version.');
        $types = ContractType::where('is_active', true)->orderBy('name')->get();
        $contract->load(['products','conditions']);
        return view('admin.contracts.edit', compact('contract','types'));
    }

    public function update(
        StoreContractRequest $request,
        Contract $contract,
        ContractExclusivityService $exclusivity
    ) {
        abort_unless($contract->isEditable(), 403, 'This contract is locked.');
        $data = $request->validated();
        $products = $data['products'] ?? [];
        $conditions = $data['conditions'] ?? [];
        $exclusivity->assertNoConflict($data, collect($products)->pluck('product_id')->filter()->all(), $contract->id);

        DB::transaction(function () use ($contract, $data, $products, $conditions) {
            $old = $contract->only(['title','status','start_date','end_date','is_exclusive','territory_type']);
            unset($data['products'], $data['conditions']);
            $contract->update($data);
            $contract->products()->delete();
            $contract->conditions()->delete();
            foreach ($products as $product) $contract->products()->create($product);
            foreach ($conditions as $index => $condition) {
                $condition['sort_order'] = $index;
                $contract->conditions()->create($condition);
            }
            $contract->logActivity('updated', 'Contract draft updated.', $old, $contract->only(array_keys($old)));
        });

        return redirect()->route('admin.contracts.show', $contract)->with('success', 'Contract updated.');
    }

    public function destroy(Contract $contract)
    {
        abort_unless($contract->status === 'draft', 403, 'Only draft contracts can be deleted.');
        $contract->logActivity('deleted', 'Draft contract deleted.');
        $contract->delete();
        return redirect()->route('admin.contracts.index')->with('success', 'Draft contract deleted.');
    }

    public function pdf(Contract $contract)
    {
        $contract->load(['type','products','conditions','parties']);
        abort_unless(class_exists(\Barryvdh\DomPDF\Facade\Pdf::class), 500, 'Install barryvdh/laravel-dompdf.');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.contracts.pdf', compact('contract'));
        return $pdf->download($contract->contract_number.'.pdf');
    }

    public function renew(Contract $contract)
    {
        abort_unless(in_array($contract->status, ['active','expired'], true), 422);
        $new = $contract->replicate();
        $new->contract_number = app(ContractNumberService::class)->next();
        $new->parent_contract_id = $contract->id;
        $new->version = $contract->version + 1;
        $new->status = 'draft';
        $new->signed_at = null;
        $new->issued_at = null;
        $new->terminated_at = null;
        $new->created_by = auth()->id();
        $new->save();

        foreach ($contract->products as $product) $new->products()->create($product->only(['product_id','product_name','product_code','stl_file_name','restriction_type','remarks']));
        foreach ($contract->conditions as $condition) $new->conditions()->create($condition->only(['condition_title','condition_description','condition_type','is_mandatory','sort_order']));
        $new->logActivity('renewal_draft_created', 'Renewal draft created from '.$contract->contract_number);

        return redirect()->route('admin.contracts.edit', $new)->with('success', 'Renewal draft created.');
    }
}
