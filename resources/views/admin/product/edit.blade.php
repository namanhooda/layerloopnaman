@extends('admin.partial.app')

@section('content')

<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/quill/typography.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/quill/katex.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/quill/editor.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/dropzone/dropzone.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/tagify/tagify.css') }}" />

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="app-ecommerce">
        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Whoops!</strong> There were some problems with your input:
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Add Product -->
        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1">Edit Product #{{$product->code}}</h4>
                    <p class="mb-0">Orders placed across your store</p>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    
                    <button type="submit" class="btn btn-primary">Update product</button>
                </div>
            </div>

            <div class="row">
                <!-- Left column -->
                <div class="col-12 col-lg-8">
                    <!-- Product Information -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <h5 class="card-tile mb-0">Product information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="productTitle" placeholder="Product title" value="{{$product->name}}" required />
                            </div>

                            <div class="row mb-6">
                                <div class="col">
                                    <label class="form-label">SKU</label>
                                    <input type="text" class="form-control" name="productSku" value="{{$product->sku}}" placeholder="SKU" required />
                                </div>
                                <div class="col">
                                    <label class="form-label">Barcode</label>
                                    <input type="text" class="form-control" name="productBarcode" value="{{$product->barcode}}" placeholder="0123-4567" />
                                </div>
                            </div>

                            <div>
    <label class="mb-1">Description (Optional)</label>
    <div class="form-control p-0">
        <div class="comment-toolbar border-0 border-bottom">
            <div class="d-flex justify-content-start">
                <span class="ql-formats me-0">
                    <button class="ql-bold"></button>
                    <button class="ql-italic"></button>
                    <button class="ql-underline"></button>
                    <button class="ql-list" value="ordered"></button>
                    <button class="ql-list" value="bullet"></button>
                    <button class="ql-link"></button>
                    <button class="ql-image"></button>
                </span>
            </div>
        </div>
        <div class="comment-editor border-0 pb-6" id="ecommerce-category-description"></div>
    </div>
    <input type="hidden" name="description" id="descriptionInput" value="{{ $product->description }}">
</div>

                        </div>
                    </div>
                    <!-- Media -->
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">Featured Image</h5>
                            <a href="javascript:void(0);" class="fw-medium">Add media from URL</a>
                        </div>
                        <div class="card-body">
                            <input type="file" name="featuredimage" class="form-control mb-3">

                            @if(!empty($product->featured_image))
                                <div class="mt-2">
                                    <label class="form-label">Current Featured Image:</label><br>
                                    <img src="{{ asset('storage/' . $product->featured_image) }}" alt="Featured Image" style="max-width: 200px; height: auto;" class="img-thumbnail">
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Media -->
                    <div class="card mb-6">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">Product Images</h5>
                            <a href="javascript:void(0);" class="fw-medium">Add media from URL</a>
                        </div>
                        <div class="card-body">
                            <input type="file" name="images[]" class="form-control mb-3" multiple>

                            @if(!empty($product->image_path))
                                <div class="row mt-3">
                                    @foreach(json_decode($product->image_path, true) as $img)
                                        <div class="col-md-3 mb-3">
                                            <img src="{{ asset('storage/' . $img) }}" alt="Product Image" style="max-width: 100%; height: auto;" class="img-thumbnail">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Inventory -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Inventory</h5>
                        </div>
                        <div class="card-body">
                            <label class="form-label">Add to Stock</label>
                            <input type="number" name="stock" class="form-control mb-4" placeholder="Quantity" value="{{$product->stock_quantity}}" required />
                            <div>
                                <h6 class="mb-2 fw-normal">Product in stock now: 0</h6>
                                <h6 class="mb-2 fw-normal">Last updated: {{ now()->format('d M, Y') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right column -->
                <div class="col-12 col-lg-4">
                    <!-- Pricing -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Pricing</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-6">
                                <label class="form-label">Base Price</label>
                                <input type="number" name="price" class="form-control" value="{{$product->price}}" placeholder="Price" required />
                            </div>
                            <div class="mb-6">
                                <label class="form-label">Discounted Price</label>
                                <input type="number" name="discount_price" class="form-control" value="{{$product->discounted_price}}" placeholder="Discounted Price" />
                            </div>
                            <div class="form-check ms-2 mt-2 mb-4">
                                <input class="form-check-input" type="checkbox" name="charge_tax" id="price-charge-tax"
                                    {{ isset($product) && $product->charge_tax ? 'checked' : '' }} />
                                <label class="switch-label" for="price-charge-tax">Charge tax on this product</label>
                            </div>

                            {{-- In Stock Toggle --}}
                            <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                <span class="mb-0">In stock</span>
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="in_stock" id="in_stock" class="form-check-input"
                                        {{ isset($product) && $product->in_stock ? 'checked' : '' }} />
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Organize -->
                    <div class="card mb-6">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Organize</h5>
                        </div>
                        <div class="card-body">
                        <div class="mb-6">
    <label class="form-label">Category</label>
    <select name="category" class="form-select select2" required>
        <option value="">Select Category</option>
        <option value="Household" {{ $product->category == 'Household' ? 'selected' : '' }}>Household</option>
        <option value="Management" {{ $product->category == 'Management' ? 'selected' : '' }}>Management</option>
        <option value="Electronics" {{ $product->category == 'Electronics' ? 'selected' : '' }}>Electronics</option>
        <option value="Office" {{ $product->category == 'Office' ? 'selected' : '' }}>Office</option>
        <option value="Automotive" {{ $product->category == 'Automotive' ? 'selected' : '' }}>Automotive</option>
    </select>
</div>

<div class="mb-6">
    <label class="form-label">Status</label>
    <select name="status" class="form-select select2">
        <option value="Published" {{ $product->status == 'Published' ? 'selected' : '' }}>Published</option>
        <option value="Scheduled" {{ $product->status == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
        <option value="Inactive" {{ $product->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
    </select>
</div>

                            <div>
                                <label class="form-label">Tags</label>
                                <input name="tags" id="ecommerce-product-tags" class="form-control" value="{{$product->tags}}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<script src="{{ asset('backend/assets/vendor/libs/quill/katex.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/quill/quill.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/tagify/tagify.js') }}"></script>

<script>
    // Initialize Quill
    const quill = new Quill('#ecommerce-category-description', {
        theme: 'snow'
    });

    // On form submit, set hidden input
    document.querySelector('form').addEventListener('submit', function () {
        document.querySelector('#descriptionInput').value = quill.root.innerHTML;
    });

    // Init Select2 and Tagify
    $(document).ready(function () {
        $('.select2').select2();
    });

    new Tagify(document.querySelector('#ecommerce-product-tags'));
</script>

@endsection
