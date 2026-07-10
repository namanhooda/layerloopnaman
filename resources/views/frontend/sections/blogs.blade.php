<style>
    /*==========================
FROM BLOG
==========================*/

.fb-section{

    padding:70px 0;

    background:#fff;
}

.fb-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:30px;
}

.fb-header h2{

    margin:0;

    font-size:42px;

    font-weight:800;

    color:#222;
}

.fb-view-all{

    color:#53b94c;

    font-weight:700;

    text-decoration:none;
}

.fb-view-all:hover{

    color:#3fa940;
}

/* Card */

.fb-card{

    display:flex;

    align-items:center;

    gap:18px;

    padding:14px;

    border:1px solid #ececec;

    border-radius:18px;

    background:#fff;

    transition:.35s;

    min-height:170px;
}

.fb-card:hover{

    transform:translateY(-5px);

    box-shadow:0 18px 40px rgba(0,0,0,.08);
}

/* Image */

.fb-image{

    width:145px;

    min-width:145px;

    height:135px;

    border-radius:14px;

    overflow:hidden;

    display:block;
}

.fb-image img{

    width:100%;

    height:100%;

    object-fit:cover;

    transition:.4s;
}

.fb-card:hover img{

    transform:scale(1.08);
}

/* Content */

.fb-content{

    flex:1;
}

.fb-category{

    display:block;

    color:#53b94c;

    font-size:11px;

    font-weight:700;

    letter-spacing:1px;

    text-transform:uppercase;

    margin-bottom:8px;
}

.fb-content h3{

    margin:0 0 10px;

    font-size:23px;

    line-height:1.35;

    font-weight:700;
}

.fb-content h3 a{

    color:#222;

    text-decoration:none;
}

.fb-content p{

    color:#666;

    font-size:15px;

    line-height:1.7;

    margin-bottom:14px;
}

.fb-meta{

    display:flex;

    gap:10px;

    color:#999;

    font-size:13px;
}

/* Owl */

.fb-carousel .owl-nav{

    position:absolute;

    top:-75px;

    right:0;
}

.fb-carousel .owl-prev,

.fb-carousel .owl-next{

    width:44px;

    height:44px;

    border-radius:50%!important;

    border:1px solid #ddd!important;

    background:#fff!important;

    color:#222!important;

    margin-left:10px;

    transition:.3s;
}

.fb-carousel .owl-prev:hover,

.fb-carousel .owl-next:hover{

    background:#53b94c!important;

    color:#fff!important;

    border-color:#53b94c!important;
}

/* Tablet */

@media(max-width:991px){

.fb-header h2{

    font-size:34px;
}

.fb-image{

    width:120px;

    min-width:120px;

    height:120px;
}

}

/* Mobile */

@media(max-width:767px){

.fb-header{

    flex-direction:column;

    align-items:flex-start;

    gap:10px;
}

.fb-header h2{

    font-size:28px;
}

.fb-card{

    flex-direction:column;

    align-items:flex-start;
}

.fb-image{

    width:100%;

    min-width:100%;

    height:220px;
}

.fb-content{

    width:100%;
}

.fb-content h3{

    font-size:20px;
}

.fb-carousel .owl-nav{

    position:static;

    text-align:center;

    margin-top:25px;
}

}
</style><section class="fb-section">

    <div class="container">

        <div class="fb-header">

            <h2>From Our Blog</h2>

            <a href="{{ url('blog') }}" class="fb-view-all">
                View All Posts
                <i class="icon-long-arrow-right"></i>
            </a>

        </div>

    </div>

    <div class="container-fluid">

        <div class="owl-carousel fb-carousel"

            data-toggle="owl"

            data-owl-options='{

                "nav":true,

                "dots":false,

                "margin":20,

                "loop":true,

                "responsive":{

                    "0":{"items":1},

                    "576":{"items":1},

                    "768":{"items":2},

                    "992":{"items":3},

                    "1200":{"items":3}

                }

            }'>

            @foreach($blogs as $blog)

            <article class="fb-card">

                <a href="{{ url('blog-detail/'.$blog->slug) }}" class="fb-image">

                    <img src="{{ asset('storage/'.$blog->featured_image) }}"
                        alt="{{ $blog->title }}">

                </a>

                <div class="fb-content">

                    <span class="fb-category">

                        {{ strtoupper($blog->category->name ?? 'BLOG') }}

                    </span>

                    <h3>

                        <a href="{{ url('blog-detail/'.$blog->slug) }}">

                            {{ \Illuminate\Support\Str::limit($blog->title,55) }}

                        </a>

                    </h3>

                    <p>

                        {{ \Illuminate\Support\Str::limit(strip_tags($blog->description),90) }}

                    </p>

                    <div class="fb-meta">

                        <span>{{ $blog->created_at->format('M d, Y') }}</span>

                        <span>•</span>

                        <span>5 min read</span>

                    </div>

                </div>

            </article>

            @endforeach

        </div>

    </div>

</section>