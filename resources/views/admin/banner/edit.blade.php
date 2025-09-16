@extends('admin.partial.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Edit Banner</h5>
            <div class="card-body">
                <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="row">
                    @csrf
                    @method('PUT')

                    <!-- Desktop Image -->
                    <div class="mb-4">
                        <label class="form-label">Desktop Image</label>
                        @if($banner->image)
                            <div class="mb-2"><img src="{{ asset($banner->image) }}" width="200"></div>
                        @endif
                        <input type="file" class="form-control" name="image">
                    </div>

                    <!-- Mobile Image -->
                    <div class="mb-4">
                        <label class="form-label">Mobile Image</label>
                        @if($banner->mobile_image)
                            <div class="mb-2"><img src="{{ asset($banner->mobile_image) }}" width="200"></div>
                        @endif
                        <input type="file" class="form-control" name="mobile_image">
                    </div>

                    <!-- URL -->
                    <div class="mb-4">
                        <label class="form-label">Redirect URL</label>
                        <input type="url" class="form-control" name="url" value="{{ old('url', $banner->url) }}">
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title', $banner->title) }}">
                    </div>

                    <!-- Sub Title -->
                    <div class="mb-4">
                        <label class="form-label">Sub Title</label>
                        <input type="text" class="form-control" name="sub_title" value="{{ old('sub_title', $banner->sub_title) }}">
                    </div>

                    <!-- Price Title -->
                    <div class="mb-4">
                        <label class="form-label">Price Title</label>
                        <input type="text" class="form-control" name="price_title" value="{{ old('price_title', $banner->price_title) }}">
                    </div>

                    <!-- Price -->
                    <div class="mb-4">
                        <label class="form-label">Price</label>
                        <input type="text" class="form-control" name="price" value="{{ old('price', $banner->price) }}">
                    </div>

                    <!-- Submit -->
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Update Banner</button>
                        <a href="{{ route('admin.banner.index') }}" class="btn btn-label-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
