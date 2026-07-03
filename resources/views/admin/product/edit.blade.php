@extends('admin.partial.app')

@section('content')

<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/quill/typography.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/quill/katex.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/quill/editor.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('backend/assets/vendor/libs/tagify/tagify.css') }}" />

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="app-ecommerce">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Whoops!</strong>
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST"
              action="{{ route('admin.products.update',$product->id) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
                <div>
                    <h4 class="mb-1">Edit Product</h4>
                    <p class="mb-0">Update your product details</p>
                </div>

                <div class="d-flex gap-3">
                    <a href="{{ route('admin.products.index') }}"
                       class="btn btn-label-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Update Product
                    </button>
                </div>
            </div>

            <div class="row">

                <!-- LEFT SIDE -->
                <div class="col-lg-8">

                    <!-- PRODUCT INFO -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Product Information</h5>
                        </div>

                        <div class="card-body">

                            <!-- NAME -->
                            <div class="mb-4">
                                <label class="form-label">Product Name</label>

                                <input type="text"
                                       name="productTitle"
                                       class="form-control"
                                       value="{{ old('productTitle',$product->name) }}"
                                       required>
                            </div>

                            <!-- PROTOTYPE -->
                            <div class="mb-4">
                                <label class="form-label">Prototype</label>

                                <select name="prototype"
                                        id="prototype"
                                        class="form-select select2"
                                        required>

                                    <option value="">Select Prototype</option>

                                    @foreach($prototypes as $type)

                                        <option value="{{ $type->id }}"
                                            {{ old('prototype',$product->prototype) == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>

                                    @endforeach

                                </select>
                            </div>

                            <!-- CATEGORY -->
                            <div class="mb-4">
                                <label class="form-label">Category</label>

                                <select name="category"
                                        id="category"
                                        class="form-select select2"
                                        required>

                                    <option value="{{ $product->category }}" selected>
                                        {{ $product->category }}
                                    </option>

                                </select>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="mb-4">

                                <label class="form-label">Description</label>

                                <div class="form-control p-0">

                                    <div class="comment-toolbar border-bottom">
                                        <span class="ql-formats">
                                            <button class="ql-bold"></button>
                                            <button class="ql-italic"></button>
                                            <button class="ql-underline"></button>
                                            <button class="ql-list" value="ordered"></button>
                                            <button class="ql-list" value="bullet"></button>
                                        </span>
                                    </div>

                                    <div class="comment-editor border-0 pb-4"
                                         id="editor">
                                        {!! old('description',$product->description) !!}
                                    </div>

                                </div>

                                <input type="hidden"
                                       name="description"
                                       id="descriptionInput">
                            </div>

                        </div>
                    </div>

                    <!-- FEATURED IMAGE -->
                    <div class="card mb-4">

                        <div class="card-header">
                            <h5 class="mb-0">Featured Image</h5>
                        </div>

                        <div class="card-body">

                            @if($product->featured_image)

                                <div class="mb-3">
                                    <img src="{{ asset('storage/'.$product->featured_image) }}"
                                         width="150"
                                         class="rounded border">
                                </div>

                            @endif

                            <input type="file"
                                   name="featuredimage"
                                   class="form-control">

                        </div>
                    </div>

                    <!-- PRODUCT IMAGES -->
                    <div class="card mb-4">

                        <div class="card-header">
                            <h5 class="mb-0">Product Images</h5>
                        </div>

                        <div class="card-body">

                            @if($product->image_path)

                                <div class="d-flex flex-wrap gap-2 mb-3">

                                    @foreach(json_decode($product->image_path,true) as $img)

                                        <img src="{{ asset('storage/'.$img) }}"
                                             width="100"
                                             class="rounded border">

                                    @endforeach

                                </div>

                            @endif

                            <input type="file"
                                   name="images[]"
                                   class="form-control"
                                   multiple>

                        </div>
                    </div>

                    <!-- VARIANT -->
                    @php
                        $sizes = json_decode($product->size,true) ?? [];
                    @endphp

                    <div class="card mb-4 {{ $product->prototype == 1 ? '' : 'd-none' }}"
                         id="variantCard">

                        <div class="card-header">
                            <h5 class="mb-0">Sizes</h5>
                        </div>

                        <div class="card-body">

                            @foreach(['S','M','L','XL','XXL'] as $size)

                                <div class="form-check mb-2">

                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="sizes[]"
                                           value="{{ $size }}"
                                           id="size{{ $size }}"
                                           {{ in_array($size,$sizes) ? 'checked' : '' }}>

                                    <label class="form-check-label"
                                           for="size{{ $size }}">
                                        {{ $size }}
                                    </label>

                                </div>

                            @endforeach

                        </div>
                    </div>

                </div>

                <!-- RIGHT SIDE -->
                <div class="col-lg-4">

                    <!-- PRICING -->
                    <div class="card mb-4">

                        <div class="card-header">
                            <h5 class="mb-0">Pricing & Inventory</h5>
                        </div>

                        <div class="card-body">

                            <div class="mb-4">
                                <label class="form-label">Stock</label>

                                <input type="number"
                                       name="stock"
                                       class="form-control"
                                       value="{{ old('stock',$product->stock_quantity) }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Price</label>

                                <input type="number"
                                       name="discount_price"
                                       class="form-control"
                                       value="{{ old('discount_price',$product->discounted_price) }}">
                            </div>

                            <div class="form-check mb-4">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="charge_tax"
                                       id="charge_tax"
                                       {{ $product->charge_tax ? 'checked' : '' }}>

                                <label class="form-check-label"
                                       for="charge_tax">
                                    Charge tax on this product
                                </label>

                            </div>

                            <div class="form-check form-switch">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="in_stock"
                                       {{ $product->in_stock ? 'checked' : '' }}>

                                <label class="form-check-label">
                                    In Stock
                                </label>

                            </div>

                        </div>
                    </div>

                    <!-- OTHER SETTINGS -->
                    <div class="card mb-4">

                        <div class="card-header">
                            <h5 class="mb-0">Other Settings</h5>
                        </div>

                        <div class="card-body">

                            <!-- STATUS -->
                            <div class="mb-4">

                                <label class="form-label">Status</label>

                                <select name="status"
                                        class="form-select select2">

                                    <option value="Published"
                                        {{ $product->status == 'Published' ? 'selected' : '' }}>
                                        Published
                                    </option>

                                    <option value="Scheduled"
                                        {{ $product->status == 'Scheduled' ? 'selected' : '' }}>
                                        Scheduled
                                    </option>

                                    <option value="Inactive"
                                        {{ $product->status == 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>

                                </select>

                            </div>

                            <!-- TAGS -->
                            <div class="mb-4">

                                <label class="form-label">Tags</label>

                                <input type="text"
                                       name="tags"
                                       id="ecommerce-product-tags"
                                       class="form-control"
                                       value="{{ old('tags',$product->tags) }}">

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </form>

    </div>
</div>

<script src="{{ asset('backend/assets/vendor/libs/quill/quill.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('backend/assets/vendor/libs/tagify/tagify.js') }}"></script>

<script>

    // QUILL EDITOR
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    // FORM SUBMIT
    document.querySelector('form').addEventListener('submit', function () {

        document.querySelector('#descriptionInput').value =
            quill.root.innerHTML;

    });

    // SELECT2
    $(document).ready(function () {

        $('.select2').select2();

        // TAGIFY
        new Tagify(document.querySelector('#ecommerce-product-tags'));

    });

</script>

<script>

$(document).ready(function () {

    $('#prototype').on('change', function () {

        let prototypeId = $(this).val();

        // SHOW/HIDE SIZE CARD
        if (prototypeId == 1) {

            $('#variantCard').removeClass('d-none');

        } else {

            $('#variantCard').addClass('d-none');

        }

        // CATEGORY AJAX
        $.ajax({

            url: "{{ url('/get-categories') }}/" + prototypeId,
            type: "GET",

            success: function (response) {

                $('#category').empty();

                $('#category').append(
                    '<option value="">Select Category</option>'
                );

                $.each(response, function (key, category) {

                    $('#category').append(
                        `<option value="${category.id}">
                            ${category.name}
                        </option>`
                    );

                });

            }

        });

    });

});

</script>

@endsection