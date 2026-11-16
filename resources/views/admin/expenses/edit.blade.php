@extends('admin.partial.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-header">Update Category</h5>
            @can("news categories edit")
            <div class="card-body">
                <form action="{{ route('admin.product-categories.update', $productCategory->id) }}" method="POST" class="row">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name"
                               value="{{ old('name', $productCategory->name) }}" placeholder="Enter category name" required>
                    </div>

                    <div class="mb-4">
                        <label for="categorySlug" class="form-label">Category Slug</label>
                        <input type="text" class="form-control" id="categorySlug" name="slug"
                               value="{{ old('slug', $productCategory->slug) }}" placeholder="Enter slug (optional)">
                    </div>

                    {{-- 🔽 Prototype Dropdown --}}
                    <div class="mb-4">
                        <label for="prototypeSelect" class="form-label">Select Prototype</label>
                        <select id="prototypeSelect" name="prototype_id" class="form-control" required>
                            <option value="">-- Select Prototype --</option>
                            @foreach ($prototypes as $prototype)
                                <option value="{{ $prototype->id }}"
                                    {{ old('prototype_id', $productCategory->prototype_id) == $prototype->id ? 'selected' : '' }}>
                                    {{ $prototype->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 🔽 Status Dropdown --}}
                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="active" {{ old('status', $productCategory->status) === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $productCategory->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Update Category</button>
                        <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-label-secondary">Cancel</a>
                    </div>
                </form>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection
