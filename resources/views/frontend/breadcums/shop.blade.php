<style>
    /*==========================
SHOP HEADER
==========================*/

.ll-shop-header{

    background:#050505;

    color:#fff;

    padding:35px 0;

    margin-bottom:35px;

}

.ll-shop-top{

    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:10px;

}

.ll-title-area h1{

    font-size:52px;

    font-weight:700;

    margin-bottom:12px;

    color:#fff;

}

.ll-title-area span{

    color:#22C55E;

}

.ll-breadcrumb{

    display:flex;

    align-items:center;

    gap:12px;

    font-size:15px;

}

.ll-breadcrumb a{

    color:#fff;

}

.ll-breadcrumb span{

    color:#22C55E;

}

.ll-features{

    display:flex;

    gap:45px;

}

.ll-feature{

    display:flex;

    align-items:center;

    gap:15px;

}

.ll-feature .icon{

    width:52px;

    height:52px;

    border-radius:14px;

    border:1px solid rgba(255,255,255,.08);

    display:flex;

    justify-content:center;

    align-items:center;

    color:#22C55E;

    font-size:22px;

}

.ll-feature h6{

    color:#fff;

    margin:0;

    font-size:15px;

    font-weight:600;

}

.ll-feature p{

    margin:2px 0 0;

    color:#bbb;

    font-size:13px;

}

/*==========================
TABLET
==========================*/

@media(max-width:991px){

.ll-shop-top{

flex-direction:column;

align-items:flex-start;

}

.ll-features{

width:100%;

display:grid;

/* grid-template-columns:repeat(3,1fr); */

gap:18px;

}

}

/*==========================
MOBILE
==========================*/

@media(max-width:767px){

.ll-shop-header{

background:#fff;

padding:0px 0;

margin-bottom:20px;

border-bottom:1px solid #eee;

}

.ll-title-area h1{

font-size:42px;

color:#111;

}

.ll-breadcrumb a{

color:#111;

}

.ll-breadcrumb{

font-size:14px;


}

.ll-features{

display:grid;

grid-template-columns:repeat(3,1fr);

gap:0;

border-top:1px solid #eee;

border-bottom:1px solid #eee;


}

.ll-feature{

flex-direction:column;

text-align:center;

padding:10px;

}

.ll-feature:last-child{

display:none;

}

.ll-feature .icon{

width:50px;

height:50px;

border:none;

background:#F6FFF8;

font-size:24px;

}

.ll-feature h6{

font-size:15px;

color:#222;

margin-top:10px;

}

.ll-feature p{

font-size:13px;

color:#666;

line-height:1.4;

}

}

/*==========================
SMALL MOBILE
==========================*/

@media(max-width:480px){

.ll-title-area h1{

font-size:30px;

}

.ll-features{

grid-template-columns:repeat(3,1fr);

}

.ll-feature{

padding:15px 8px;

}

}
</style>
<section class="ll-shop-header">

    <div class="container">

        <div class="ll-shop-top">

            <div class="ll-title-area">

                <h2>
                    
                     Our <span>{{ $pageDescription }}</span>
                </h2>

                <div class="ll-breadcrumb">

                    <a href="{{ url('/') }}">Home</a>

                    <i class="fas fa-chevron-right"></i>

                    <span>@if($pageTitle) {{ $pageTitle }} / @endif {{ $pageDescription }}</span>

                </div>

            </div>

            <div class="ll-features">

                <div class="ll-feature">

                    <div class="icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>

                    <div class="text">

                        <h6>Premium Quality</h6>

                        <p>Finest 3D Prints</p>

                    </div>

                </div>

                <div class="ll-feature">

                    <div class="icon">
                        <i class="fas fa-lock"></i>
                    </div>

                    <div class="text">

                        <h6>Secure Checkout</h6>

                        <p>100% Safe & Secure</p>

                    </div>

                </div>

                <div class="ll-feature">

                    <div class="icon">
                        <i class="fas fa-truck"></i>
                    </div>

                    <div class="text">

                        <h6>Fast Delivery</h6>

                        <p>Pan India Delivery</p>

                    </div>

                </div>

                <div class="ll-feature">

                    <div class="icon">
                        <i class="fas fa-undo-alt"></i>
                    </div>

                    <div class="text">

                        <h6>Easy Returns</h6>

                        <p>Hassle Free Returns</p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>