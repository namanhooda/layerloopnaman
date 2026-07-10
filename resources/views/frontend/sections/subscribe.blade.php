<style>
    /* ==========================================
   LayerLoop Newsletter
==========================================*/

.ll-newsletter-wrap{
    padding:35px 0;
    background:#fff;
}

.ll-newsletter-box{
    background:linear-gradient(90deg,#07140f,#0f2b1d,#13361f);
    border-radius:18px;
    padding:28px 35px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:35px;
    overflow:hidden;
    position:relative;
    border:1px solid rgba(76,175,80,.15);
}

.ll-newsletter-box::before{
    content:'';
    position:absolute;
    inset:0;
    background:
    radial-gradient(circle at left,#38d46d22 0%,transparent 45%),
    radial-gradient(circle at right,#59ff9b22 0%,transparent 35%);
    pointer-events:none;
}

.ll-newsletter-left{
    display:flex;
    align-items:center;
    gap:22px;
    z-index:2;
    flex:1;
}

.ll-newsletter-icon{
    width:78px;
    height:78px;
    min-width:78px;
    border-radius:18px;
    background:rgba(63,210,108,.12);
    display:flex;
    align-items:center;
    justify-content:center;
    border:1px solid rgba(76,175,80,.25);
}

.ll-newsletter-icon i{
    font-size:34px;
    color:#48d26d;
}

.ll-newsletter-content h3{
    color:#fff;
    font-size:32px;
    font-weight:700;
    margin-bottom:8px;
}

.ll-newsletter-content p{
    color:#cfd7d3;
    margin:0;
    font-size:15px;
    line-height:1.7;
}

.ll-newsletter-tags{
    margin-top:18px;
    display:flex;
    flex-wrap:wrap;
    gap:25px;
}

.ll-newsletter-tags span{
    color:#e4e4e4;
    font-size:14px;
    display:flex;
    align-items:center;
}

.ll-newsletter-tags i{
    color:#4ade80;
    margin-right:8px;
    font-size:15px;
}

.ll-newsletter-right{
    width:520px;
    position:relative;
    z-index:2;
}

.ll-newsletter-form{
    display:flex;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.25);
}

.ll-newsletter-form input{
    flex:1;
    border:none;
    height:62px;
    padding:0 22px;
    font-size:15px;
    background:#fff;
}

.ll-newsletter-form input:focus{
    outline:none;
}

.ll-newsletter-form button{
    border:none;
    width:185px;
    background:linear-gradient(135deg,#46d66f,#29b856);
    color:#fff;
    font-weight:700;
    font-size:15px;
    transition:.3s;
}

.ll-newsletter-form button:hover{
    background:linear-gradient(135deg,#29b856,#1f9a46);
}

/* Mobile */

@media(max-width:991px){

.ll-newsletter-box{
    flex-direction:column;
    text-align:center;
    padding:25px;
}

.ll-newsletter-left{
    flex-direction:column;
}

.ll-newsletter-right{
    width:100%;
}

.ll-newsletter-form{
    flex-direction:column;
}

.ll-newsletter-form input{
    width:100%;
}

.ll-newsletter-form button{
    width:100%;
    height:58px;
}

.ll-newsletter-tags{
    justify-content:center;
}

}

@media(max-width:576px){

.ll-newsletter-content h3{
    font-size:24px;
}

.ll-newsletter-content p{
    font-size:14px;
}

.ll-newsletter-tags{
    gap:12px;
    flex-direction:column;
}

}
</style><div class="ll-newsletter-wrap">
    <div class="container">
        <div class="ll-newsletter-box">

            <div class="ll-newsletter-left">
                <div class="ll-newsletter-icon">
                    <i class="icon-envelope-open"></i>
                </div>

                <div class="ll-newsletter-content">
                    <h3>Get 10% Off On Your First Order!</h3>
                    <p>
                        Subscribe to our newsletter and get exclusive offers,
                        new arrivals and exciting updates.
                    </p>

                    <div class="ll-newsletter-tags">
                        <span><i class="icon-check-circle"></i> No Spam</span>
                        <span><i class="icon-check-circle"></i> Unsubscribe Anytime</span>
                        <span><i class="icon-check-circle"></i> Exclusive Offers</span>
                    </div>
                </div>
            </div>

            <div class="ll-newsletter-right">
                <form action="#">
                    <div class="ll-newsletter-form">
                        <input type="email"
                               placeholder="Enter your email address"
                               required>

                        <button type="submit">
                            Subscribe Now
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>