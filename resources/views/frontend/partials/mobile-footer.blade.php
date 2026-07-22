<style>
/*==================================
LayerLoop Mobile Navigation
==================================*/

.ll-mobile-nav{

    position:fixed;

    left:0;

    right:0;

    bottom:0;

    height:82px;

    background:#fff;

    border-radius:24px 24px 0 0;

    display:flex;

    justify-content:space-around;

    align-items:flex-end;

    padding:0 8px 10px;

    box-shadow:0 -8px 35px rgba(0,0,0,.08);

    z-index:99999;
}

/* Normal Item */

.ll-nav-item{

    flex:1;

    text-align:center;

    text-decoration:none;

    color:#222;

    font-size:11px;

    font-weight:600;

    transition:.3s;
}

.ll-nav-item i{

    display:block;

    font-size:22px;

    margin-bottom:6px;

    transition:.3s;
}

.ll-nav-item span{

    display:block;
}

/* Active */

.ll-active{

    color:#4CAF50 !important;
}

.ll-active i{

    color:#4CAF50;
}

/* Center Button */

.ll-nav-center{

    position:relative;

    width:90px;

    margin-top:-38px;

    text-align:center;

    text-decoration:none;

    color:#222;

    font-size:12px;

    font-weight:600;
}

.ll-center-circle{

    width:68px;

    height:68px;

    margin:0 auto 6px;

    border-radius:50%;

    background:#4CAF50;

    border:5px solid #fff;

    display:flex;

    align-items:center;

    justify-content:center;

    box-shadow:0 10px 30px rgba(76,175,80,.35);

    transition:.3s;
}

.ll-center-circle i{

    color:#fff;

    font-size:26px;

    margin:0;
}

.ll-nav-center:hover .ll-center-circle{

    transform:translateY(-3px);
}

/* Wishlist Badge */

.ll-icon-wrap{

    position:relative;

    display:inline-block;
}

.ll-count{

    position:absolute;

    top:-8px;

    right:-10px;

    width:18px;

    height:18px;

    border-radius:50%;

    background:#ff3b30;

    color:#fff;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:10px;

    font-weight:700;
}

/* Desktop Hide */

@media(min-width:992px){

.ll-mobile-nav{

    display:none;
}

}

/* Space for fixed footer */

body{

    padding-bottom:95px;
}
</style>
<div class="ll-mobile-nav d-lg-none">

    <!-- Home -->
    <a href="{{ url('/') }}"
       class="ll-nav-item {{ request()->is('/') ? 'll-active' : '' }}">

        <i class="fa-solid fa-house"></i>
        <span>Home</span>

    </a>

    <!-- Shop -->
    <a href="{{ url('shop') }}"
       class="ll-nav-item {{ request()->is('shop*') ? 'll-active' : '' }}">

        <i class="fa-solid fa-bag-shopping"></i>
        <span>Shop</span>

    </a>

    <!-- Custom -->
    <a href="{{ url('customize') }}" class="ll-nav-center">

        <div class="ll-center-circle">

            <i class="fa-regular fa-pen-to-square"></i>

        </div>

        <span>Custom</span>

    </a>

    <!-- Wishlist -->
    <a href="{{ url('wishlist') }}"
       class="ll-nav-item {{ request()->is('wishlist*') ? 'll-active' : '' }}">

        <div class="ll-icon-wrap">

            <i class="fa-regular fa-heart"></i>

            @if(\App\Helpers\CartHelper::getWishlistCount())

                <span class="ll-count">

                    {{ \App\Helpers\CartHelper::getWishlistCount() }}

                </span>

            @endif

        </div>

        <span>Wishlist</span>

    </a>

    <!-- Account -->
    <a href="{{ url('cart') }}"
       class="ll-nav-item {{ request()->is('cart*') ? 'll-active' : '' }}">

        <i class="fa fa-shopping-cart"></i>
        <span>Cart</span>

    </a>

</div>