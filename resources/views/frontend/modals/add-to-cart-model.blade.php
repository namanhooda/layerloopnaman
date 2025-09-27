<div class="modal fade" id="customizeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Customize Your Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" ></button>
            </div>
            <div class="modal-body">
                <div class="form-box">
                    <input type="hidden" id="customize-product-id">

                    <label for="size">Size:</label>
                    <div class="select-custom mb-3">
                        <select name="size" id="customize-size" class="form-control">
                            <option value="">Select a size</option>
                            <option value="S">Small</option>
                            <option value="M">Medium</option>
                            <option value="L">Large</option>
                            <option value="XL">Extra Large</option>
                            <option value="XXL">XXL</option>
                        </select>
                    </div>

                    <label for="customize-image">Upload Image:</label>
                    <input type="file" id="customize-image" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitCustomizedCart()">Add to Cart</button>
            </div>
        </div>
    </div>
</div>
