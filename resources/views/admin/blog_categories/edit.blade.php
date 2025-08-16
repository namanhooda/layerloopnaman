@extends('admin.partial.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-6">
        <div class="card">
            <h5 class="card-header">Update Category</h5>

            @can("blog categories edit")
            <div class="card-body">
                <form action="{{ route('admin.blog-categories.update', $blogCategory->id) }}" method="POST" class="row">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name"
                               value="{{ old('name', $blogCategory->name) }}" placeholder="Enter category name" required>
                    </div>

                    <div class="mb-4">
                        <label for="categorySlug" class="form-label">Category Slug</label>
                        <input type="text" class="form-control" id="categorySlug" name="slug"
                               value="{{ old('slug', $blogCategory->slug) }}" placeholder="Enter slug (optional)">
                    </div>

                    {{-- Optional textarea for description --}}
                    {{-- 
                    <div class="mb-4">
                        <label for="categoryDesc" class="form-label">Description</label>
                        <textarea class="form-control" id="categoryDesc" name="description" rows="3">{{ old('description', $blogCategory->description ?? '') }}</textarea>
                    </div> 
                    --}}

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
