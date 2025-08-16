<div class="modal fade" id="addReviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <style>
            .star-rating {
                direction: rtl;
                display: inline-flex;
                font-size: 1.5rem;
                gap: 0.2rem;
            }

            .star-rating input[type="radio"] {
                display: none;
            }

            .star-rating label {
                color: #ccc;
                cursor: pointer;
            }

            .star-rating input:checked~label,
            .star-rating label:hover,
            .star-rating label:hover~label {
                color: #f5b301;
            }

        </style>
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab"
                                    aria-controls="signin" aria-selected="true">Add Review</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-content-5">
                            <div class="tab-pane fade show active" id="signin" role="tabpanel"
                                aria-labelledby="signin-tab">
                                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="title">Review Title *</label>
                                        <input type="text" class="form-control" name="product_id" value="{{$product->id}}">
                                        <input type="text" class="form-control" name="title" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description *</label>
                                        <textarea class="form-control" name="description" rows="4" required></textarea>
                                    </div>


                                    <div class="form-group">
                                        <label for="rating">Rating *</label>
                                        <div class="star-rating">
                                            <input type="radio" name="rating" id="star5" value="5"><label for="star5"
                                                style="font-size: 3.4rem">&#9733;</label>
                                            <input type="radio" name="rating" id="star4" value="4"><label for="star4"
                                                style="font-size: 3.4rem">&#9733;</label>
                                            <input type="radio" name="rating" id="star3" value="3"><label for="star3"
                                                style="font-size: 3.4rem">&#9733;</label>
                                            <input type="radio" name="rating" id="star2" value="2"><label for="star2"
                                                style="font-size: 3.4rem">&#9733;</label>
                                            <input type="radio" name="rating" id="star1" value="1"><label for="star1"
                                                style="font-size: 3.4rem">&#9733;</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="image">Upload Image (Optional)</label>
                                        <input type="file" class="form-control-file" name="image" accept="image/*">
                                    </div>
                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>Submit</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
