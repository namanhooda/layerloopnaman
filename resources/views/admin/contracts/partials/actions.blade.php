<div class="d-flex align-items-center gap-1">
    <a href="{{ route('admin.contracts.show', $row) }}" class="btn btn-sm btn-icon btn-text-secondary" title="View">
        <i class="ti ti-eye"></i>
    </a>
    @if($row->isEditable())
        <a href="{{ route('admin.contracts.edit', $row) }}" class="btn btn-sm btn-icon btn-text-secondary" title="Edit">
            <i class="ti ti-edit"></i>
        </a>
    @endif
    <a href="{{ route('admin.contracts.pdf', $row) }}" class="btn btn-sm btn-icon btn-text-secondary" title="PDF">
        <i class="ti ti-file-type-pdf"></i>
    </a>
    @if(in_array($row->status, ['active','expired']))
        <form method="POST" action="{{ route('admin.contracts.renew', $row) }}">
            @csrf
            <button class="btn btn-sm btn-icon btn-text-secondary" title="Create renewal draft"><i class="ti ti-refresh"></i></button>
        </form>
    @endif
</div>
