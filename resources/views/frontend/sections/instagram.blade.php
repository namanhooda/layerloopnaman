<style>
    /*=========================
Instagram
=========================*/

.ig-section{

    padding:70px 0;

    background:#fff;
}

.ig-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:25px;
}

.ig-header h2{

    font-size:40px;

    font-weight:800;
}

.ig-header a{

    color:#45b34d;

    font-weight:700;
}

.ig-card{

    display:block;

    position:relative;

    border-radius:16px;

    overflow:hidden;

    aspect-ratio:1;

}

.ig-card img{

    width:100%;

    height:100%;

    object-fit:cover;

    transition:.4s;
}

.ig-overlay{

    position:absolute;

    inset:0;

    background:rgba(0,0,0,.45);

    display:flex;

    justify-content:center;

    align-items:center;

    opacity:0;

    transition:.3s;
}

.ig-overlay i{

    color:#fff;

    font-size:32px;
}

.ig-card:hover img{

    transform:scale(1.08);
}

.ig-card:hover .ig-overlay{

    opacity:1;
}

.ig-view-card{

    width:150px;

    aspect-ratio:1;

    background:#fff;

    border:1px solid #eee;

    border-radius:18px;

    display:flex;

    flex-direction:column;

    justify-content:center;

    align-items:center;

    text-decoration:none;

    color:#333;

    transition:.3s;
}

.ig-view-card i{

    font-size:42px;

    color:#E1306C;

    margin-bottom:15px;
}

.ig-view-card:hover{

    transform:translateY(-5px);

    box-shadow:0 15px 30px rgba(0,0,0,.08);
}

/* MOBILE */

.ig-mobile-header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:18px;
}

.ig-mobile-header h3{

    font-size:30px;

    font-weight:800;
}

.ig-mobile-header a{

    color:#45b34d;

    font-weight:700;
}

.ig-mobile-card{

    display:block;

    overflow:hidden;

    border-radius:12px;

    aspect-ratio:1;
}

.ig-mobile-card img{

    width:100%;

    height:100%;

    object-fit:cover;
}

.ig-follow-btn{

    margin-top:22px;

    display:flex;

    justify-content:center;

    align-items:center;

    gap:10px;

    height:56px;

    border:1px solid #ddd;

    border-radius:14px;

    color:#222;

    font-weight:700;
}

.ig-follow-btn i{

    color:#E1306C;

    font-size:24px;
}
</style><section class="ig-section">

    <div class="container d-none d-lg-block">

        <div class="ig-header">

            <h2>From Our Instagram</h2>

            <a href="https://instagram.com/layerloop.in" target="_blank">
                View All
            </a>

        </div>

        <div class="row gx-3">

            @foreach($instagrams->take(6) as $image)

            <div class="col">

                <a href="{{ $image->link }}" target="_blank" class="ig-card">

                    <img src="{{ asset('storage/'.$image->image) }}">

                    <div class="ig-overlay">

                        <i class="icon-instagram"></i>

                    </div>

                </a>

            </div>

            @endforeach

            <div class="col-auto">

                <a href="https://www.instagram.com/layerloop.web/"
                   target="_blank"
                   class="ig-view-card">

                    <i class="icon-instagram"></i>

                    <span>View More</span>

                </a>

            </div>

        </div>

    </div>


    <!-- MOBILE -->

    <div class="container d-lg-none">

        <div class="ig-mobile-header">

            <h3>From Our Instagram</h3>

            <a href="https://instagram.com/layerloop.in" target="_blank">

                View All

            </a>

        </div>

        <div class="row g-2">

            @foreach($instagrams->take(6) as $image)

            <div class="col-4">

                <a href="{{ $image->link }}"
                   class="ig-mobile-card">

                    <img src="{{ asset('storage/'.$image->image) }}">

                </a>

            </div>

            @endforeach

        </div>

        <a href="https://www.instagram.com/layerloop.web/"
           class="ig-follow-btn">

            <i class="icon-instagram"></i>

            Follow @layerloop.in

        </a>

    </div>

</section>