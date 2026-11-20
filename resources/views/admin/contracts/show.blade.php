@extends('admin.partial.app')
@section('title', 'Contract Details')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h4 class="mb-1">{{ $contract->title }}</h4><p class="text-muted mb-0">{{ $contract->contract_number }} · {{ $contract->type?->name }}</p></div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.contracts.pdf', $contract) }}" class="btn btn-outline-primary"><i class="ti ti-file-type-pdf me-1"></i> PDF</a>
        @if($contract->isEditable()) <a href="{{ route('admin.contracts.edit', $contract) }}" class="btn btn-primary">Edit</a> @endif
    </div>
</div>
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card mb-4"><div class="card-header"><h5 class="mb-0">Agreement details</h5></div><div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><small class="text-muted">Party</small><div class="fw-semibold">{{ $contract->party_name }}</div>{{ $contract->company_name }}</div>
                <div class="col-md-6"><small class="text-muted">Business unit</small><div>{{ config('layerloop-contracts.business_units.'.$contract->business_unit, $contract->business_unit) }}</div></div>
                <div class="col-md-6"><small class="text-muted">Period</small><div>{{ $contract->start_date?->format('d M Y') ?? '—' }} – {{ $contract->end_date?->format('d M Y') ?? 'Open' }}</div></div>
                <div class="col-md-6"><small class="text-muted">Territory / exclusivity</small><div>{{ ucfirst($contract->territory_type ?? 'Not specified') }} / {{ $contract->is_exclusive ? 'Exclusive' : 'Non-exclusive' }}</div></div>
                <div class="col-12"><small class="text-muted">Scope</small><p class="mb-0">{{ $contract->scope_of_work ?: '—' }}</p></div>
                <div class="col-12"><small class="text-muted">Restrictions</small><p class="mb-0">{{ $contract->special_restrictions ?: '—' }}</p></div>
            </div>
        </div></div>
        <div class="card mb-4"><div class="card-header"><h5 class="mb-0">Covered products / STL models</h5></div><div class="table-responsive"><table class="table"><thead><tr><th>Model</th><th>Code</th><th>Restriction</th></tr></thead><tbody>
            @forelse($contract->products as $product)<tr><td>{{ $product->product_name }}</td><td>{{ $product->product_code ?: '—' }}</td><td>{{ ucfirst($product->restriction_type) }}</td></tr>@empty<tr><td colspan="3" class="text-center text-muted">No products attached.</td></tr>@endforelse
        </tbody></table></div></div>
        <div class="card"><div class="card-header"><h5 class="mb-0">Conditions</h5></div><div class="card-body">
            @forelse($contract->conditions as $i => $condition)
                <div class="mb-3"><div class="fw-semibold">{{ $i+1 }}. {{ $condition->condition_title }}</div><div class="text-muted">{{ $condition->condition_description }}</div></div>
            @empty<p class="text-muted mb-0">No conditions attached.</p>@endforelse
        </div></div>
    </div>
    <div class="col-lg-4">
        <div class="card mb-4"><div class="card-body">
            <small class="text-muted">Status</small><h5>{{ ucfirst($contract->status) }}</h5>
            <small class="text-muted">Created</small><p>{{ $contract->created_at->format('d M Y, h:i A') }}</p>
            <small class="text-muted">Email / Phone</small><p>{{ $contract->email ?: '—' }}<br>{{ $contract->phone ?: '—' }}</p>
            @if($contract->status === 'draft')
            <form method="POST" action="{{ route('admin.contracts.destroy', $contract) }}" onsubmit="return confirm('Delete this draft?')">@csrf @method('DELETE')<button class="btn btn-outline-danger w-100">Delete Draft</button></form>
            @endif
        </div></div>
        <div class="card"><div class="card-header"><h5 class="mb-0">Activity history</h5></div><div class="card-body">
            @forelse($contract->activityLogs->sortByDesc('created_at') as $log)
                <div class="mb-3"><div class="fw-semibold">{{ ucfirst(str_replace('_',' ',$log->action)) }}</div><small class="text-muted">{{ $log->created_at->format('d M Y, h:i A') }}</small><div>{{ $log->description }}</div></div>
            @empty<p class="text-muted">No activity recorded.</p>@endforelse
        </div></div>
    </div>
</div>
</div>
@endsection
