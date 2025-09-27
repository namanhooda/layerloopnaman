<form action="{{ route('products.bulk_upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="images">Select Images</label>
        <input type="file" name="images[]" multiple class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Upload Products</button>
</form>
