<style>
    /* ==========================================
   LayerLoop Newsletter
==========================================*/

    .sbs-newsletter-wrap {
        padding: 35px 0;
        background: #fff;
    }

    .sbs-newsletter-box {
        background: linear-gradient(90deg, #07140f, #0f2b1d, #13361f);
        border-radius: 18px;
        padding: 28px 35px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 35px;
        overflow: hidden;
        position: relative;
        border: 1px solid rgba(76, 175, 80, .15);
    }

    .sbs-newsletter-box::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at left, #38d46d22 0%, transparent 45%),
            radial-gradient(circle at right, #59ff9b22 0%, transparent 35%);
        pointer-events: none;
    }

    .sbs-newsletter-left {
        display: flex;
        align-items: center;
        gap: 22px;
        z-index: 2;
        flex: 1;
    }

    .sbs-newsletter-icon {
        width: 78px;
        height: 78px;
        min-width: 78px;
        border-radius: 18px;
        background: rgba(63, 210, 108, .12);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(76, 175, 80, .25);
    }

    .sbs-newsletter-icon i {
        font-size: 34px;
        color: #48d26d;
    }

    .sbs-newsletter-content h3 {
        color: #fff;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .sbs-newsletter-content p {
        color: #cfd7d3;
        margin: 0;
        font-size: 15px;
        line-height: 1.7;
    }

    .sbs-newsletter-tags {
        margin-top: 18px;
        display: flex;
        flex-wrap: wrap;
        gap: 25px;
    }

    .sbs-newsletter-tags span {
        color: #e4e4e4;
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .sbs-newsletter-tags i {
        color: #4ade80;
        margin-right: 8px;
        font-size: 15px;
    }

    .sbs-newsletter-right {
        width: 520px;
        position: relative;
        z-index: 2;
    }

    .sbs-newsletter-form {
        display: flex;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
    }

    .sbs-newsletter-form input {
        flex: 1;
        border: none;
        height: 62px;
        padding: 0 22px;
        font-size: 15px;
        background: #fff;
    }

    .sbs-newsletter-form input:focus {
        outline: none;
    }

    .sbs-newsletter-form button {
        border: none;
        width: 185px;
        background: linear-gradient(135deg, #46d66f, #29b856);
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        transition: .3s;
    }

    .sbs-newsletter-form button:hover {
        background: linear-gradient(135deg, #29b856, #1f9a46);
    }

    /* Mobile */

 @media(max-width:768px){

.sbs-newsletter-box{

    display:grid;

    grid-template-columns:1fr 170px;

    grid-template-areas:
    "left right"
    "tags tags";

    gap:15px;

    padding:18px;

}

.sbs-newsletter-left{
    grid-area:left;
}

.sbs-newsletter-right{
    grid-area:right;
    width:100%;
}

.sbs-newsletter-tags{
    grid-area:tags;

    display:flex;

    justify-content:space-between;

    margin-top:0;
}

.sbs-newsletter-form{

    display:flex;
    flex-direction:column;
    gap:8px;

    background:none;

    box-shadow:none;

}

.sbs-newsletter-form input{

    height:40px;
    border-radius:8px;

}

.sbs-newsletter-form button{

    height:40px;
    width:100%;
    border-radius:8px;

}

.sbs-newsletter-icon{

    display:none;

}

.sbs-newsletter-content h3{

    font-size:18px;
    margin-bottom:8px;

}

.sbs-newsletter-content p{

    font-size:13px;

}

.sbs-newsletter-tags span{

    font-size:12px;

}

}

</style>
<div class="sbs-newsletter-wrap">
    <div class="container">
        <div class="sbs-newsletter-box">

    <div class="sbs-newsletter-left">

        <div class="sbs-newsletter-content">

            <h3>Get 10% Off On Your First Order!</h3>

            <p>
                Subscribe to our newsletter and get exclusive offers,
                new arrivals and exciting updates.
            </p>

        </div>

    </div>


    <div class="sbs-newsletter-right">

        <form>

            <div class="sbs-newsletter-form">

                <input type="email"
                    placeholder="Enter your email address">

                <button>
                    Subscribe Now
                </button>

            </div>

        </form>

    </div>


    <!-- MOVE THIS OUTSIDE -->
    <div class="sbs-newsletter-tags">

        <span><i class="icon-check-circle"></i> No Spam</span>

        <span><i class="icon-check-circle"></i> Unsubscribe Anytime</span>

        <span><i class="icon-check-circle"></i> Exclusive Offers</span>

    </div>

</div>
    </div>
</div>
