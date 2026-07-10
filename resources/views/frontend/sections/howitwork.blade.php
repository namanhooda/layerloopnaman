<style>
    /*==================================
 HOW IT WORKS
==================================*/

.hw-section{
    padding:70px 0;
    background:#fff;
}

.hw-heading{
    margin-bottom:45px;
}

.hw-heading span{

    color:#53b94c;

    font-weight:700;

    letter-spacing:2px;

    font-size:13px;

    text-transform:uppercase;
}

.hw-heading h2{

    font-size:42px;

    font-weight:800;

    margin:12px 0;
}

.hw-heading p{

    color:#777;

    font-size:16px;
}

/* Card */

.hw-card{

    position:relative;

    background:#fff;

    border:1px solid #ededed;

    border-radius:18px;

    padding:28px 22px;

    display:flex;

    align-items:flex-start;

    gap:18px;

    transition:.35s;

    height:100%;
}

.hw-card:hover{

    transform:translateY(-6px);

    box-shadow:0 18px 40px rgba(0,0,0,.08);

    border-color:#53b94c;
}

/* Icon */

.hw-icon{

    width:58px;

    height:58px;

    min-width:58px;

    border-radius:50%;

    background:#edf9ed;

    display:flex;

    align-items:center;

    justify-content:center;

    color:#53b94c;

    font-size:24px;
}

/* Content */

.hw-content h5{

    margin:0 0 8px;

    font-size:18px;

    font-weight:700;
}

.hw-content p{

    margin:0;

    color:#777;

    line-height:1.7;

    font-size:14px;
}

/* Dotted Connector */

.hw-line{

    position:absolute;

    right:-55px;

    top:50%;

    width:70px;

    border-top:3px dotted #b7e5b7;
}

.hw-last .hw-line{

    display:none;
}

/*=========================
Tablet
=========================*/

@media(max-width:991px){

.hw-line{

    display:none;
}

.hw-card{

    padding:24px 20px;
}

.hw-heading h2{

    font-size:34px;
}

}

/*=========================
Mobile
=========================*/

@media(max-width:575px){

.hw-section{

    padding:50px 0;
}

.hw-heading{

    margin-bottom:30px;
}

.hw-heading h2{

    font-size:28px;
}

.hw-card{

    border-radius:15px;

    padding:18px;
}

.hw-icon{

    width:48px;

    height:48px;

    min-width:48px;

    font-size:20px;
}

.hw-content h5{

    font-size:16px;
}

.hw-content p{

    font-size:13px;
}

}
</style><section class="hw-section">
    <div class="container">

        <div class="hw-heading text-center">
            <span>Simple Process</span>
            <h2>How It Works</h2>
            <p>Create your personalized product in just four easy steps.</p>
        </div>

        <div class="row g-4 justify-content-center">

            <!-- Step 1 -->
            <div class="col-lg-3 col-md-6">
                <div class="hw-card">

                    <div class="hw-icon">
                        <i class="icon-picture"></i>
                    </div>

                    <div class="hw-content">
                        <h5>Upload / Choose</h5>
                        <p>Upload your favorite photo or choose from our designs.</p>
                    </div>

                    <div class="hw-line"></div>

                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-lg-3 col-md-6">
                <div class="hw-card">

                    <div class="hw-icon">
                        <i class="icon-edit"></i>
                    </div>

                    <div class="hw-content">
                        <h5>Customize</h5>
                        <p>Preview and customize your product exactly the way you like.</p>
                    </div>

                    <div class="hw-line"></div>

                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-lg-3 col-md-6">
                <div class="hw-card">

                    <div class="hw-icon">
                        <i class="icon-cog"></i>
                    </div>

                    <div class="hw-content">
                        <h5>We Print</h5>
                        <p>Printed using premium 3D printers with exceptional quality.</p>
                    </div>

                    <div class="hw-line"></div>

                </div>
            </div>

            <!-- Step 4 -->
            <div class="col-lg-3 col-md-6">
                <div class="hw-card hw-last">

                    <div class="hw-icon">
                        <i class="icon-truck"></i>
                    </div>

                    <div class="hw-content">
                        <h5>Delivered</h5>
                        <p>Safely packed and delivered right to your doorstep.</p>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>