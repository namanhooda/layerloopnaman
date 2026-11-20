@csrf
@if(isset($contract)) @method('PUT') @endif

<div class="row g-3">
    <div class="col-md-8">
        <label class="form-label">Contract title *</label>
        <input name="title" class="form-control" required value="{{ old('title', $contract->title ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Contract type *</label>
        <select name="contract_type_id" class="form-select" required>
            <option value="">Select type</option>
            @foreach($types as $type)
                <option value="{{ $type->id }}" @selected(old('contract_type_id', $contract->contract_type_id ?? '') == $type->id)>{{ $type->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Business unit *</label>
        <select name="business_unit" class="form-select" required>
            @foreach(config('layerloop-contracts.business_units') as $key => $label)
                <option value="{{ $key }}" @selected(old('business_unit', $contract->business_unit ?? '3d_printing') == $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Party type *</label>
        <select name="party_type" class="form-select" required>
            @foreach(['individual','company','seller','franchise','other'] as $value)
                <option value="{{ $value }}" @selected(old('party_type', $contract->party_type ?? 'individual') == $value)>{{ ucfirst($value) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label">Party name *</label>
        <input name="party_name" class="form-control" required value="{{ old('party_name', $contract->party_name ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Company / Shop name</label>
        <input name="company_name" class="form-control" value="{{ old('company_name', $contract->company_name ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $contract->email ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Phone</label>
        <input name="phone" class="form-control" value="{{ old('phone', $contract->phone ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="2">{{ old('address', $contract->address ?? '') }}</textarea>
    </div>
    <div class="col-md-2"><label class="form-label">City</label><input name="city" class="form-control" value="{{ old('city', $contract->city ?? '') }}"></div>
    <div class="col-md-2"><label class="form-label">State</label><input name="state" class="form-control" value="{{ old('state', $contract->state ?? '') }}"></div>
    <div class="col-md-2"><label class="form-label">Country</label><input name="country" class="form-control" value="{{ old('country', $contract->country ?? 'India') }}"></div>
    <div class="col-md-3"><label class="form-label">Start date</label><input type="date" name="start_date" class="form-control" value="{{ old('start_date', isset($contract) ? $contract->start_date?->format('Y-m-d') : '') }}"></div>
    <div class="col-md-3"><label class="form-label">End date</label><input type="date" name="end_date" class="form-control" value="{{ old('end_date', isset($contract) ? $contract->end_date?->format('Y-m-d') : '') }}"></div>
    <div class="col-md-3">
        <label class="form-label">Territory type</label>
        <select name="territory_type" class="form-select">
            <option value="">Not applicable</option>
            @foreach(['global','country','state','district','city','custom'] as $value)
                <option value="{{ $value }}" @selected(old('territory_type', $contract->territory_type ?? '') == $value)>{{ ucfirst($value) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label d-block">Exclusive rights?</label>
        <input type="hidden" name="is_exclusive" value="0">
        <div class="form-check form-switch mt-2">
            <input type="checkbox" class="form-check-input" name="is_exclusive" value="1" @checked(old('is_exclusive', $contract->is_exclusive ?? false))>
            <label class="form-check-label">Exclusive agreement</label>
        </div>
    </div>
    <div class="col-md-3"><label class="form-label">Payment amount</label><input type="number" step="0.01" min="0" name="payment_amount" class="form-control" value="{{ old('payment_amount', $contract->payment_amount ?? '') }}"></div>
    <div class="col-md-3">
        <label class="form-label">Payment type</label>
        <select name="payment_type" class="form-select">
            <option value="">Select</option>
            @foreach(['fixed','royalty','percentage','none'] as $value)
                <option value="{{ $value }}" @selected(old('payment_type', $contract->payment_type ?? '') == $value)>{{ ucfirst($value) }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6"><label class="form-label">Payment terms</label><textarea name="payment_terms" class="form-control" rows="2">{{ old('payment_terms', $contract->payment_terms ?? '') }}</textarea></div>
    <div class="col-md-6"><label class="form-label">Scope of work</label><textarea name="scope_of_work" class="form-control" rows="3">{{ old('scope_of_work', $contract->scope_of_work ?? '') }}</textarea></div>
    <div class="col-md-6"><label class="form-label">Special restrictions</label><textarea name="special_restrictions" class="form-control" rows="3">{{ old('special_restrictions', $contract->special_restrictions ?? '') }}</textarea></div>
    <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="3">{{ old('description', $contract->description ?? '') }}</textarea></div>
    <div class="col-12"><label class="form-label">Internal notes (not printed in contract)</label><textarea name="internal_notes" class="form-control" rows="2">{{ old('internal_notes', $contract->internal_notes ?? '') }}</textarea></div>
</div>

<div class="alert alert-info mt-4 mb-0">
    Product/model and dynamic clause repeaters are supported by the database and request layer. Connect your preferred Select2/Tagify repeater UI before production use; do not issue a contract until covered products and clauses have been reviewed.
</div>
