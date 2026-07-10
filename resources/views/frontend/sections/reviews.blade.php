<style>
    /*==================================
LayerLoop Reviews
===================================*/

.rv-section{

    padding:70px 0;

    background:#fff;
}

.rv-header{

    margin-bottom:30px;
}

.rv-header h2{

    font-size:42px;

    font-weight:800;

    color:#222;
}

.rv-card{

    display:flex;

    align-items:center;

    gap:20px;

    background:#fff;

    border:1px solid #ececec;

    border-radius:18px;

    padding:18px;

    transition:.35s;

    min-height:170px;
}

.rv-card:hover{

    transform:translateY(-5px);

    box-shadow:0 18px 40px rgba(0,0,0,.08);
}

.rv-image{

    width:110px;

    min-width:110px;

    height:110px;

    overflow:hidden;

    border-radius:14px;
}

.rv-image img{

    width:100%;

    height:100%;

    object-fit:cover;
}

.rv-content{

    flex:1;
}

.rv-stars{

    color:#FDBB2D;

    font-size:18px;

    letter-spacing:2px;

    margin-bottom:10px;
}

.rv-content p{

    color:#555;

    font-size:15px;

    line-height:1.7;

    margin-bottom:15px;
}

.rv-content h5{

    margin:0;

    font-size:17px;

    font-weight:700;
}

.rv-content span{

    color:#999;

    font-size:13px;
}

/* Owl Buttons */

.rv-carousel .owl-nav{

    position:absolute;

    right:0;

    top:-70px;
}

.rv-carousel .owl-prev,

.rv-carousel .owl-next{

    width:44px;

    height:44px;

    border-radius:50%!important;

    background:#fff!important;

    border:1px solid #ddd!important;

    color:#222!important;

    margin-left:10px;

    transition:.3s;
}

.rv-carousel .owl-prev:hover,

.rv-carousel .owl-next:hover{

    background:#4CAF50!important;

    color:#fff!important;

    border-color:#4CAF50!important;
}

@media(max-width:767px){

.rv-header h2{

    font-size:30px;
}

.rv-card{

    flex-direction:column;

    text-align:center;
}

.rv-image{

    width:100px;

    height:100px;
}

.rv-carousel .owl-nav{

    position:static;

    text-align:center;

    margin-top:20px;
}

}
</style><section class="rv-section">

    <div class="container">

        <div class="rv-header">

            <h2>What Our Customers Say</h2>

        </div>

    </div>

    <div class="container-fluid">

        <div class="owl-carousel rv-carousel"

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

            <!-- Review 1 -->

            <div class="rv-card">

                <div class="rv-image">

                    <img src="{{ asset('images/reviews/review1.jpg') }}">

                </div>

                <div class="rv-content">

                    <div class="rv-stars">

                        ★★★★★

                    </div>

                    <p>

                        Amazing quality and perfect finishing.
                        Exactly like the picture. Highly recommended!

                    </p>

                    <h5>Rahul Sharma</h5>

                    <span>Verified Buyer</span>

                </div>

            </div>

            <!-- Review 2 -->

            <div class="rv-card">

                <div class="rv-image">

                    <img src="{{ asset('images/reviews/review2.jpg') }}">

                </div>

                <div class="rv-content">

                    <div class="rv-stars">

                        ★★★★★

                    </div>

                    <p>

                        The lithophane came out beautiful.
                        My parents loved their anniversary gift.

                    </p>

                    <h5>Priya Mehta</h5>

                    <span>Verified Buyer</span>

                </div>

            </div>

            <!-- Review 3 -->

            <div class="rv-card">

                <div class="rv-image">

                    <img src="{{ asset('images/reviews/review3.jpg') }}">

                </div>

                <div class="rv-content">

                    <div class="rv-stars">

                        ★★★★★

                    </div>

                    <p>

                        Fast delivery and excellent packaging.
                        Will definitely order again.

                    </p>

                    <h5>Aman Verma</h5>

                    <span>Verified Buyer</span>

                </div>

            </div>

            <!-- Review 4 -->

            <div class="rv-card">

                <div class="rv-image">

                    <img src="{{ asset('images/reviews/review4.jpg') }}">

                </div>

                <div class="rv-content">

                    <div class="rv-stars">

                        ★★★★★

                    </div>

                    <p>

                        Beautiful craftsmanship and premium quality.
                        Worth every rupee.

                    </p>

                    <h5>Sneha Kapoor</h5>

                    <span>Verified Buyer</span>

                </div>

            </div>

        </div>

    </div>

</section>