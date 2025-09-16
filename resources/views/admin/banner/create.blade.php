@extends('admin.partial.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Create Banner</h5>

            <div class="card-body">
                <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data" class="row">
                    @csrf

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter banner title" required>
                    </div>

                    <!-- Sub Title -->
                    <div class="mb-4">
                        <label for="sub_title" class="form-label">Sub Title</label>
                        <input type="text" class="form-control" id="sub_title" name="sub_title" placeholder="Enter sub title">
                    </div>

                    <!-- URL -->
                    <div class="mb-4">
                        <label for="url" class="form-label">Redirect URL</label>
                        <input type="url" class="form-control" id="url" name="url" placeholder="https://example.com">
                    </div>

                    <!-- Price Title -->
                    <div class="mb-4">
                        <label for="price_title" class="form-label">Price Title</label>
                        <input type="text" class="form-control" id="price_title" name="price_title" placeholder="E.g. Starting from">
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter price">
                    </div>

                    <!-- Desktop Image -->
                    <div class="mb-4">
                        <label for="image" class="form-label">Banner Image (Desktop)</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>

                    <!-- Mobile Image -->
                    <div class="mb-4">
                        <label for="mobile_image" class="form-label">Banner Image (Mobile)</label>
                        <input type="file" class="form-control" id="mobile_image" name="mobile_image">
                    </div>

                    <!-- Submit -->
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Create Banner</button>
                        <a href="{{ route('admin.banner.index') }}" class="btn btn-label-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
