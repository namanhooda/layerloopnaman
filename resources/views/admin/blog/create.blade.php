@extends('admin.partial.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">Create Blog</h5>

            @can("blog create")
            <div class="card-body">
                <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="row">
                    @csrf

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter blog title" required>
                    </div>

                    <!-- Slug -->
                    <div class="mb-4">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" placeholder="Enter slug (optional)">
                    </div>

                    <!-- Featured Image -->
                    <div class="mb-4">
                        <label for="featured_image" class="form-label">Featured Image</label>
                        <input type="file" class="form-control" id="featured_image" name="featured_image">
                    </div>

                    <!-- Meta Title -->
                    <div class="mb-4">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Meta title for SEO">
                    </div>

                    <!-- Meta Description -->
                    <div class="mb-4">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="2" placeholder="Meta description for SEO"></textarea>
                    </div>

                    <!-- Tags -->
                    <div class="mb-4">
                        <label for="tags" class="form-label">Tags (comma-separated)</label>
                        <input type="text" class="form-control" id="tags" name="tags" placeholder="e.g., Laravel, PHP, Blog">
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" name="category_id" id="category_id" required>
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Author -->
                    <div class="mb-4">
                        <label for="author_name" class="form-label">Author Name</label>
                        <input type="text" class="form-control" id="author_name" name="author_name" placeholder="Author name" required>
                    </div>

                    <!-- Content -->
                    <div class="mb-4">
                        <label for="content" class="form-label">Blog Content</label>
                        <textarea class="form-control" id="editor" name="content" rows="5" placeholder="Write blog content here"></textarea>
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>

                    <!-- Publish Date -->
                    <div class="mb-4">
                        <label for="publish_at" class="form-label">Schedule Publish Date & Time</label>
                        <input type="datetime-local" class="form-control" name="publish_at" id="publish_at">
                    </div>
                    <!-- JSON-LD -->
                    <div class="mb-4">
                        <label class="form-label">Meta Data</label>
                        <textarea class="form-control" name="meta_data" rows="4"></textarea>
                        @error('meta_data') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- SEO Schema -->
                    <div class="mb-4">
                        <label for="seo_schema" class="form-label">SEO Schema (JSON-LD)</label>
                        <textarea class="form-control" id="seo_schema" name="seo_schema" rows="3" placeholder='{"@context": "https://schema.org", "@type": "BlogPosting", ...}'></textarea>
                    </div>

                    <!-- Submit -->
                    <div class="col-12 text-center demo-vertical-spacing">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Create Blog</button>
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
