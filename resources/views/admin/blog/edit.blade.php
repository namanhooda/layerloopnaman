@extends('admin.partial.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Edit Blog</h5>
            @can("blog edit")
            <div class="card-body">
                <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" class="row">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                               value="{{ old('title', $blog->title) }}" required>
                    </div>

                    <!-- Slug -->
                    <div class="mb-4">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug"
                               value="{{ old('slug', $blog->slug) }}">
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-4">
                        <label for="featured_image" class="form-label">Featured Image</label>
                        @if ($blog->featured_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="Current Image" width="150">
                            </div>
                        @endif
                        <input type="file" class="form-control" id="featured_image" name="featured_image">
                    </div>

                    <!-- Meta Title -->
                    <div class="mb-4">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                               value="{{ old('meta_title', $blog->meta_title) }}">
                    </div>

                    <!-- Meta Description -->
                    <div class="mb-4">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $blog->meta_description) }}</textarea>
                    </div>

                    <!-- Tags -->
                    <div class="mb-4">
                        <label for="tags" class="form-label">Tags (comma-separated)</label>
                        <input type="text" class="form-control" id="tags" name="tags"
                               value="{{ old('tags', $blog->tags) }}">
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" name="category_id" id="category_id" required>
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $blog->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Author -->
                    <div class="mb-4">
                        <label for="author_name" class="form-label">Author Name</label>
                        <input type="text" class="form-control" id="author_name" name="author_name"
                               value="{{ old('author_name', $blog->author_name) }}">
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <label for="content" class="form-label">Blog Content</label>
                        <textarea class="form-control" id="editor" name="content" rows="5">{{ old('content', $blog->content) }}</textarea>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="draft" {{ $blog->status == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ $blog->status == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ $blog->status == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <!-- Publish Date -->
                    <div class="mb-4">
                        <label for="publish_at" class="form-label">Schedule Publish Date & Time</label>
                        <input type="datetime-local" class="form-control" name="publish_at" id="publish_at"
                               value="{{ old('publish_at', optional($blog->publish_at)->format('Y-m-d\TH:i')) }}">
                    </div>
                    <!-- JSON-LD -->
                    <div class="mb-4">
                        <label class="form-label">Meta Data</label>
                        <textarea class="form-control" name="meta_data" rows="4">{{ $blog->meta_data ?? '' }}</textarea>
                        @error('meta_data') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- SEO Schema -->
                    <div class="mb-4">
                        <label for="seo_schema" class="form-label">SEO Schema (JSON-LD)</label>
                        <textarea class="form-control" id="seo_schema" name="seo_schema" rows="3">{{ old('seo_schema', json_encode($blog->seo_schema, JSON_PRETTY_PRINT)) }}</textarea>
                    </div>

                    <!-- Submit -->
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Update Blog</button>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-label-secondary">Cancel</a>
                    </div>
                </form>
            </div>
            @endcan
        </div>
    </div>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>CKEDITOR.replace('editor');</script>
@endsection
