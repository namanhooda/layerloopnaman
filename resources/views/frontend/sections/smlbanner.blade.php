<style>
    .ll-feature-strip{
    background:linear-gradient(180deg,#062914,#03180d);
    border:1px solid rgba(62,211,88,.35);
    border-radius:18px;
    padding:18px 10px;
    margin:25px 0;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
}

.ll-feature-item{
    display:flex;
    align-items:center;
    gap:14px;
    padding:6px 18px;
    height:100%;
    border-right:1px solid rgba(255,255,255,.08);
}

.ll-feature-last{
    border-right:none;
}

.ll-feature-icon{
    width:44px;
    height:44px;
    min-width:44px;
    border:2px solid #39d353;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#39d353;
    font-size:22px;
}

.ll-feature-content h4{
    margin:0;
    color:#fff;
    font-size:15px;
    font-weight:700;
    line-height:1.2;
}

.ll-feature-content p{
    margin:2px 0 0;
    color:rgba(255,255,255,.75);
    font-size:12px;
    line-height:1.3;
}

@media (max-width:991px){

    .ll-feature-item{
        border-right:none;
        padding:12px;
    }

    .ll-feature-strip{
        padding:15px;
    }

    .ll-feature-icon{
        width:40px;
        height:40px;
        min-width:40px;
        font-size:18px;
    }

    .ll-feature-content h4{
        font-size:14px;
    }

    .ll-feature-content p{
        font-size:11px;
    }
}
</style>
<div class="container">
    <div class="ll-feature-strip">
        <div class="row g-0">

            <div class="col-6 col-lg-2">
                <div class="ll-feature-item">
                    <div class="ll-feature-icon">
                        <i class="icon-truck"></i>
                    </div>
                    <div class="ll-feature-content">
                        <h4>Free Shipping</h4>
                        <p>On Orders Above ₹999</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <div class="ll-feature-item">
                    <div class="ll-feature-icon">
                        <i class="icon-truck"></i>
                    </div>
                    <div class="ll-feature-content">
                        <h4>Fast Delivery</h4>
                        <p>2-5 Days Pan India</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <div class="ll-feature-item">
                    <div class="ll-feature-icon">
                        <i class="icon-check-circle"></i>
                    </div>
                    <div class="ll-feature-content">
                        <h4>Premium Quality</h4>
                        <p>Best Materials Used</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <div class="ll-feature-item">
                    <div class="ll-feature-icon">
                        <i class="icon-box"></i>
                    </div>
                    <div class="ll-feature-content">
                        <h4>Secure Packaging</h4>
                        <p>Safe & Damage Free</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <div class="ll-feature-item">
                    <div class="ll-feature-icon">
                        <i class="icon-rotate-left"></i>
                    </div>
                    <div class="ll-feature-content">
                        <h4>7 Days Return</h4>
                        <p>Hassle Free Returns</p>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <div class="ll-feature-item ll-feature-last">
                    <div class="ll-feature-icon">
                        <i class="icon-heart-o"></i>
                    </div>
                    <div class="ll-feature-content">
                        <h4>Made With Love</h4>
                        <p>Passion In Every Product</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>