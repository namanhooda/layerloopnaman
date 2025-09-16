<div class="blog-posts">
    <div class="container">
        <h2 class="title text-center">From Our Blog</h2><!-- End .title-lg text-center -->

        <div class="owl-carousel owl-simple carousel-with-shadow" data-toggle="owl" data-owl-options='{
                            "nav": false, 
                            "dots": true,
                            "items": 3,
                            "margin": 20,
                            "loop": false,
                            "responsive": {
                                "0": {
                                    "items":1
                                },
                                "600": {
                                    "items":2
                                },
                                "992": {
                                    "items":3
                                }
                            }
                        }'>
            @foreach($blogs as $blog)
            <article class="entry entry-display">
                <figure class="entry-media">
                    <a href="{{url('blog-detail/'. $blog->slug)}}">
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="Blog Image">

                    </a>
                </figure><!-- End .entry-media -->

                <div class="entry-body text-center">
                    <div class="entry-meta">
                        <a href="{{url('blog-detail/'. $blog->slug)}}">{{ $blog->created_at->format('M d, Y') }}</a>
                    </div><!-- End .entry-meta -->

                    <h3 class="entry-title">
                        <a href="{{url('blog-detail/'. $blog->slug)}}">{{$blog->title}}</a>
                    </h3><!-- End .entry-title -->

                    <div class="entry-content">
                        <a href="{{url('blog-detail/'. $blog->slug)}}" class="read-more">Continue Reading</a>
                    </div><!-- End .entry-content -->
                </div><!-- End .entry-body -->
            </article><!-- End .entry -->
            @endforeach
            <article class="entry entry-display">
                <figure class="entry-media">
                    <a href="#">
                        <img src="{{asset('frontend/assets/images/demos/demo-2/blog/post-2.jpg')}}" alt="image desc">
                    </a>
                </figure><!-- End .entry-media -->

                <div class="entry-body text-center">
                    <div class="entry-meta">
                        <a href="#">Dec 12, 2018</a>, 0 Comments
                    </div><!-- End .entry-meta -->

                    <h3 class="entry-title">
                        <a href="#">Fusce lacinia arcuet nulla.</a>
                    </h3><!-- End .entry-title -->

                    <div class="entry-content">
                        <a href="#" class="read-more">Continue Reading</a>
                    </div><!-- End .entry-content -->
                </div><!-- End .entry-body -->
            </article><!-- End .entry -->

            <article class="entry entry-display">
                <figure class="entry-media">
                    <a href="#">
                        <img src="{{asset('frontend/assets/images/demos/demo-2/blog/post-3.jpg')}}" alt="image desc">
                    </a>
                </figure><!-- End .entry-media -->

                <div class="entry-htmlbody text-center">
                    <div class="entry-meta">
                        <a href="#">Dec 19, 2018</a>, 2 Comments
                    </div><!-- End .entry-meta -->

                    <h3 class="entry-title">
                        <a href="#">Quisque volutpat mattis eros.</a>
                    </h3><!-- End .entry-title -->

                    <div class="entry-content">
                        <a href="#" class="read-more">Continue Reading</a>
                    </div><!-- End .entry-content -->
                </div><!-- End .entry-body -->
            </article><!-- End .entry -->
        </div><!-- End .owl-carousel -->

        <div class="more-container text-center mt-2">
            <a href="blog.html" class="btn btn-outline-darker btn-more"><span>View more articles</span><i
                    class="icon-long-arrow-right"></i></a>
        </div><!-- End .more-container -->
    </div><!-- End .container -->
</div><!-- End .blog-posts -->
