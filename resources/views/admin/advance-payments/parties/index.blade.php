@extends('admin.partial.app')
@section('title', 'Parties')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="d-flex justify-content-between mb-3"><h3>Parties</h3><a class="btn btn-primary" href="{{ route('advance-parties.create') }}">Add Party</a></div>
<div class="card"><table class="table mb-0"><thead><tr><th>Name</th><th>Type</th><th>Phone</th><th>Email</th><th></th></tr></thead><tbody>
@forelse($parties as $p)<tr><td>{{ $p->name }}</td><td>{{ ucfirst($p->party_type) }}</td><td>{{ $p->phone }}</td><td>{{ $p->email }}</td><td><a href="{{ route('advance-parties.edit',$p) }}">Edit</a> <form class="d-inline" method="POST" action="{{ route('advance-parties.destroy',$p) }}" onsubmit="return confirm('Delete this party?')">@csrf @method('DELETE')<button class="btn btn-link btn-sm text-danger p-0">Delete</button></form></td></tr>
@empty<tr><td colspan="5" class="text-center p-3">No parties found.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $parties->links() }}</div></div>
@endsection
