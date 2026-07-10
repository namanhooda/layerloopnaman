<style>
    /*==============================
Explore Collections
===============================*/

.lc-section{
    padding:60px 0;
    background:#fff;
}

.lc-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;
}

.lc-header h2{

    margin:0;

    font-size:42px;

    font-weight:800;

    color:#222;
}

.lc-view-all{

    color:#4CAF50;

    font-weight:700;

    font-size:15px;

    text-decoration:none;
}

.lc-view-all:hover{

    color:#2f9b39;
}

.lc-col{

    margin-bottom:20px;
}

.lc-card{

    position:relative;

    display:block;

    overflow:hidden;

    border-radius:18px;

    height:260px;

    background:#eee;

    box-shadow:0 5px 20px rgba(0,0,0,.08);

    transition:.35s;
}

.lc-card img{

    width:100%;

    height:100%;

    object-fit:cover;

    transition:.5s;
}

.lc-card::after{

    content:"";

    position:absolute;

    left:0;

    right:0;

    bottom:0;

    height:95px;

    background:linear-gradient(to top,
    rgba(0,0,0,.90),
    rgba(0,0,0,.60),
    rgba(0,0,0,0));

    transition:.35s;
}

.lc-overlay{

    position:absolute;

    left:0;

    right:0;

    bottom:18px;

    z-index:2;

    text-align:center;

    padding:0 12px;
}

.lc-overlay h4{

    color:#fff;

    font-size:22px;

    font-weight:700;

    line-height:1.2;

    margin-bottom:5px;

    overflow:hidden;

    display:-webkit-box;

    -webkit-line-clamp:2;

    -webkit-box-orient:vertical;
}

.lc-overlay p{

    margin:0;

    color:#ececec;

    font-size:14px;
}

.lc-card:hover{

    transform:translateY(-8px);

    box-shadow:0 20px 40px rgba(0,0,0,.15);
}

.lc-card:hover img{

    transform:scale(1.08);
}

/* Tablet */

@media(max-width:991px){

.lc-header h2{

    font-size:34px;
}

.lc-card{

    height:240px;
}

}

/* Mobile */

@media(max-width:767px){

.lc-header{

    flex-direction:column;

    align-items:flex-start;

    gap:10px;
}

.lc-header h2{

    font-size:28px;
}

.lc-card{

    height:210px;

    border-radius:15px;
}

.lc-overlay{

    bottom:15px;
}

.lc-overlay h4{

    font-size:18px;
}

.lc-overlay p{

    font-size:12px;
}

}
</style><section class="lc-section">
    <div class="container">

        <div class="lc-header">
            <h2>Explore Our Collections</h2>

            <a href="{{ url('shop') }}" class="lc-view-all">
                View All Collections
                <i class="icon-long-arrow-right"></i>
            </a>
        </div>

        <div class="row">

            @foreach($collection as $product)

            <div class="col-6 col-md-4 col-lg-2 lc-col">

                <a href="{{ url('shop-product-detail/'.$product->slug) }}" class="lc-card">

                    <img src="{{ asset('storage/'.$product->featured_image) }}"
                        alt="{{ $product->name }}">

                    <div class="lc-overlay">

                        <h4>
                            {{ \Illuminate\Support\Str::limit($product->name,20) }}
                        </h4>

                        <p>Explore Collection</p>

                    </div>

                </a>

            </div>

            @endforeach

        </div>

    </div>
</section>