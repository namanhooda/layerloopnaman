@extends('admin.partial.app')
@section('title', 'Party')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h3 class="mb-3">{{ $party->exists ? 'Edit' : 'Create' }} Party</h3>
<form method="POST" action="{{ $action }}" class="card card-body">
@csrf @if($party->exists) @method('PUT') @endif
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Name *</label><input name="name" class="form-control" value="{{ old('name',$party->name) }}" required></div>
<div class="col-md-6"><label class="form-label">Type *</label><select name="party_type" class="form-select" required>@foreach(['customer','vendor','employee','other'] as $t)<option value="{{ $t }}" @selected(old('party_type',$party->party_type)==$t)>{{ ucfirst($t) }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Phone</label><input name="phone" class="form-control" value="{{ old('phone',$party->phone) }}"></div>
<div class="col-md-6"><label class="form-label">Email</label><input name="email" type="email" class="form-control" value="{{ old('email',$party->email) }}"></div>
<div class="col-12"><label class="form-label">Address</label><textarea name="address" class="form-control">{{ old('address',$party->address) }}</textarea></div>
<div class="col-md-6"><label class="form-label">Existing model class (optional)</label><select name="partyable_type" class="form-select"><option value="">Standalone party</option>@foreach(config('advance-payments.partyable_models',[]) as $model)<option value="{{ $model }}" @selected(old('partyable_type',$party->partyable_type)==$model)>{{ class_basename($model) }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">Existing record ID</label><input type="number" min="1" name="partyable_id" class="form-control" value="{{ old('partyable_id',$party->partyable_id) }}"><div class="form-text">Enter the ID from the selected existing model.</div></div>
</div>
<div class="mt-3"><button class="btn btn-primary">Save Party</button><a class="btn btn-secondary" href="{{ route('advance-parties.index') }}">Cancel</a></div>
</form></div>
@endsection
