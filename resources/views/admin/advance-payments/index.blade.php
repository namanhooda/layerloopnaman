@extends('admin.partial.app')
@section('title', 'Advance Payments')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Advance Payments</h3>
        <a class="btn btn-primary" href="{{ route('admin.advance.create') }}">Add Advance</a>
    </div>
    <form class="row g-2 mb-3">
        <div class="col-md-3"><select class="form-select" name="party_id">
                <option value="">All parties</option>@foreach($parties as $party)<option value="{{ $party->id }}"
                    @selected(request('party_id')==$party->id)>{{ $party->name }}</option>@endforeach
            </select></div>
        <div class="col-md-2"><select class="form-select" name="status">
                <option value="">All statuses</option>@foreach(['pending','partially_settled','fully_settled'] as $s)
                <option value="{{ $s }}" @selected(request('status')===$s)>{{ str_replace('_',' ',ucfirst($s)) }}
                </option>@endforeach
            </select></div>
        <div class="col-md-2"><input class="form-control" type="date" name="from" value="{{ request('from') }}"></div>
        <div class="col-md-2"><input class="form-control" type="date" name="to" value="{{ request('to') }}"></div>
        <div class="col-md-3"><button class="btn btn-outline-primary">Filter</button> <a
                class="btn btn-outline-secondary" href="{{ route('advance-received.index') }}">Reset</a></div>
    </form>
    <div class="table-responsive bg-white rounded shadow-sm">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Advance No.</th>
                    <th>Date</th>
                    <th>Party</th>
                    <th class="text-end">Advance</th>
                    <th class="text-end">Settled</th>
                    <th class="text-end">Balance</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($advances as $a)
                <tr>
                    <td>{{ $a->advance_no }}</td>
                    <td>{{ $a->advance_date->format('d M Y') }}</td>
                    <td>{{ $a->party->name }}</td>
                    <td class="text-end">{{ number_format($a->amount,2) }}</td>
                    <td class="text-end">{{ number_format((float)$a->settlements_sum_amount,2) }}</td>
                    <td class="text-end">
                        {{ number_format(max(0,(float)$a->amount-(float)$a->settlements_sum_amount),2) }}</td>
                    <td><span
                            class="badge text-bg-{{ $a->status === 'fully_settled' ? 'success' : ($a->status === 'pending' ? 'warning' : 'info') }}">{{ str_replace('_',' ',ucfirst($a->status)) }}</span>
                    </td>
                    <td class="text-nowrap"><a href="{{ route('advance-received.show',$a) }}">View</a> · <a
                            href="{{ route('advance-received.edit',$a) }}">Edit</a>
                        <form class="d-inline" method="POST" action="{{ route('advance-received.destroy',$a) }}"
                            onsubmit="return confirm('Delete this advance?')">@csrf @method('DELETE')<button
                                class="btn btn-link btn-sm text-danger p-0">Delete</button></form>
                    </td>
                </tr>
                @empty<tr>
                    <td colspan="8" class="text-center py-4">No advances found.</td>
                </tr>@endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $advances->links() }}</div>
</div>
@endsection
