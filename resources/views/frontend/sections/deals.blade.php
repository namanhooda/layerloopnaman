<style>
    /*=============================
 LayerLoop Memory Banner
=============================*/

    .dd-memory-section {
        padding: 60px 0;
        background: #f8f8f8;
    }

    .dd-memory-banner {

        min-height: 250px;

        border-radius: 28px;

        overflow: hidden;

        background:url('{{ asset("images/deal.jpeg") }}') no-repeat left center;

        background-size: cover;

        box-shadow: 0 15px 40px rgba(0, 0, 0, .08);

    }

    .dd-memory-content {

        padding: 35px 20px;

        position: relative;

        z-index: 2;
    }

    .dd-memory-tag {

        display: block;

        color: #55b64d;

        font-size: 13px;

        font-weight: 700;

        letter-spacing: 2px;

        text-transform: uppercase;

        margin-bottom: 12px;
    }

    .dd-memory-content h2 {

        font-size: 48px;

        font-weight: 800;

        color: #111;

        line-height: 1.15;

        margin-bottom: 18px;
    }

    .dd-memory-content p {

        color: #666;

        font-size: 16px;

        line-height: 1.8;

        margin-bottom: 25px;
    }

    .dd-upload-btn {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 10px;

        background: #53b94c;

        color: #fff !important;

        padding: 14px 30px;

        border-radius: 10px;

        font-size: 16px;

        font-weight: 700;

        transition: .3s;

        text-decoration: none;
    }

    .dd-upload-btn:hover {

        background: #44a63d;

        color: #fff;

        transform: translateY(-2px);
    }

    /* Feature Card */

    .dd-feature-box {

        width: 92%;

        margin: 0 auto;

        background: #fff;

        border-radius: 18px;

        overflow: hidden;

        box-shadow: 0 12px 35px rgba(0, 0, 0, .08);
    }

    .dd-feature-item {

        display: flex;

        align-items: center;

        gap: 18px;

        padding: 22px;

        border-bottom: 1px solid #efefef;
    }

    .dd-feature-item:last-child {

        border-bottom: none;
    }

    .dd-feature-icon {

        width: 56px;

        height: 56px;

        min-width: 56px;

        border: 2px solid #4fb94b;

        border-radius: 50%;

        display: flex;

        align-items: center;

        justify-content: center;

        color: #4fb94b;

        font-size: 22px;
    }

    .dd-feature-item h5 {

        margin: 0;

        font-size: 17px;

        font-weight: 700;

        color: #222;
    }

    .dd-feature-item p {

        margin: 4px 0 0;

        font-size: 14px;

        color: #777;
    }

    /*============================
 Tablet
============================*/

    @media(max-width:1199px) {

        .dd-memory-banner {

            min-height: 350px;
        }

        .dd-memory-content h2 {

            font-size: 42px;
        }

        .dd-feature-box {

            width: 100%;
        }

    }

    /*============================
 Mobile
============================*/

@media (max-width:991px){

.dd-memory-banner{

    background:#fff;

    position:relative;

    border-radius:20px;

    overflow:hidden;

    padding-top:260px;

    min-height:auto;
}

/* Image only at top-left */

.dd-memory-banner::before{

    content:"";

    position:absolute;

    top:0;

    left:0;

    width:48%;

    height:260px;

    background:url('{{ asset("images/deal.jpeg") }}') left top;

    background-size:cover;

    border-radius:20px 0 0 0;
}

.dd-memory-content{

    padding:20px;

    text-align:left;
}

.dd-memory-tag{

    font-size:12px;

    margin-bottom:10px;
}

.dd-memory-content h3{

    font-size:36px;

    line-height:1.15;

    margin-bottom:15px;

    color:#222;
}

.dd-memory-content p{

    font-size:15px;

    line-height:1.6;

    margin-bottom:20px;
}

.dd-upload-btn{

    width:100%;

    justify-content:center;

    margin-top:10px;
}

.dd-feature-box{

    width:100%;

    margin:20px 0 0;

    border-radius:15px;

    box-shadow:none;

    border:1px solid #eee;
}

.dd-feature-item{

    padding:18px;
}

}


/*============================
Small Mobile
============================*/

@media (max-width:575px){

.dd-memory-banner{

    padding-top:230px;
}

.dd-memory-banner::before{

    width:100%;

    height:230px;
}

.dd-memory-content{

    padding:18px;
}

.dd-memory-content h3{

    font-size:28px;
}

.dd-memory-content p{

    font-size:14px;
}

.dd-feature-item{

    padding:16px;
}

.dd-feature-icon{

    width:46px;

    height:46px;

    min-width:46px;
}

}

</style>
<section class="dd-memory-section">
    <div class="container">

        <div class="dd-memory-banner">

            <div class="row align-items-center h-100 g-0">

                <!-- Empty Space (Image Area) -->
                <div class="col-lg-4"></div>

                <!-- Content -->
                <div class="col-lg-4">

                    <div class="dd-memory-content">

                        <span class="dd-memory-tag">
                            PERSONALIZED JUST FOR YOU
                        </span>

                        <h3>
                            Turn Your Memories
                            Into Beautiful Light.
                        </h3>

                        <p>
                            Upload any photo and we'dd create a custom lithophane,
                            moon lamp or frame that glows with your memories.
                        </p>

                        <a href="{{ url('customize') }}" class="dd-upload-btn">
                            Upload Your Photo
                            <i class="icon-upload"></i>
                        </a>

                    </div>

                </div>

                <!-- Features -->
                <div class="col-lg-4">

                    <div class="dd-feature-box">

                        <div class="dd-feature-item">
                            <div class="dd-feature-icon">
                                <i class="icon-picture"></i>
                            </div>

                            <div>
                                <h5>Easy Upload</h5>
                                <p>Upload your favorite photo</p>
                            </div>
                        </div>

                        <div class="dd-feature-item">
                            <div class="dd-feature-icon">
                                <i class="icon-eye"></i>
                            </div>

                            <div>
                                <h5>Live Preview</h5>
                                <p>See preview before print</p>
                            </div>
                        </div>

                        <div class="dd-feature-item">
                            <div class="dd-feature-icon">
                                <i class="icon-award"></i>
                            </div>

                            <div>
                                <h5>Premium Quality</h5>
                                <p>Best 3D printing quality</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>
