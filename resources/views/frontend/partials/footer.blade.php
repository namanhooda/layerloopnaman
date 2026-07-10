<footer class="footer ftr-footer">

    {{-- Newsletter --}}
    @include('frontend.sections.subscribe')

    <style> 
        /*==================================================
        LayerLoop Premium Footer
            ==================================================*/

        .ftr-footer {
            background: #0f1317;
            color: #fff;
            margin-top: 0;
        }

        .ftr-footer-main {
            padding: 70px 0 50px;
            background: linear-gradient(180deg, #14191d, #0f1317);
            border-top: 1px solid rgba(255, 255, 255, .05);
        }

        /* Logo */

        .ftr-footer-logo {
            max-width: 220px;
            margin-bottom: 25px;
        }

        .ftr-footer-desc {
            color: #b8bec6;
            line-height: 1.9;
            font-size: 15px;
            margin-bottom: 28px;
        }

        /*==========================
        Widgets
        ==========================*/

        .ftr-footer-widget {
            margin-bottom: 30px;
        }

        .ftr-footer-widget h4 {
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
        }

        .ftr-footer-widget h4:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 40px;
            height: 3px;
            border-radius: 30px;
            background: #49c96d;
        }

        .ftr-footer-widget ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .ftr-footer-widget ul li {
            margin-bottom: 14px;
        }

        .ftr-footer-widget ul li:last-child {
            margin-bottom: 0;
        }

        .ftr-footer-widget ul li a {
            color: #b9c0c7;
            text-decoration: none;
            transition: .35s;
            position: relative;
            padding-left: 0;
            font-size: 15px;
        }

        .ftr-footer-widget ul li a:hover {
            color: #4ed36d;
            padding-left: 10px;
        }

        .ftr-footer-widget ul li a:before {
            content: "›";
            opacity: 0;
            position: absolute;
            left: -12px;
            transition: .35s;
        }

        .ftr-footer-widget ul li a:hover:before {
            opacity: 1;
        }

        /*==========================
      Contact Widget
            ==========================*/

        .ftr-contact-list li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 18px;
            color: #bfc5ca;
            line-height: 1.7;
        }

        .ftr-contact-list i {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #1d2328;
            color: #49c96d;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 15px;
        }

        .ftr-contact-list a {
            color: #bfc5ca;
        }

        .ftr-contact-list a:hover {
            color: #4fd56f;
        }

        /*==========================
      Payments
        ==========================*/

        .ftr-payment {
            margin-top: 25px;
        }

        .ftr-payment img {
            max-width: 220px;
            background: #fff;
            border-radius: 8px;
            padding: 8px;
        }

        /*==========================
       Social Icons
        ==========================*/

        .ftr-social {
            display: flex;
            gap: 12px;
        }

        .ftr-social a {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
            transition: .35s;
            text-decoration: none;
        }

        .ftr-social a:hover {
            transform: translateY(-4px);
        }

        .ftr-social-instagram {
            background: linear-gradient(45deg, #fd5949, #d6249f, #285AEB);
        }

        .ftr-social-facebook {
            background: #1877F2;
        }

        .ftr-social-youtube {
            background: #ff0000;
        }

        .ftr-social-pinterest {
            background: #E60023;
        }

        /*==========================
      Bottom Footer
        ==========================*/

        .ftr-footer-bottom {
            background: #0b0f12;
            border-top: 1px solid rgba(255, 255, 255, .06);
        }

        .ftr-footer-bottom .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 0;
        }

        .ftr-bottom-left {
            color: #c1c7cd;
            font-size: 14px;
        }

        .ftr-bottom-center {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .ftr-bottom-center span {
            color: #555;
        }

        .ftr-bottom-center a {
            color: #c2c8ce;
            text-decoration: none;
            transition: .3s;
        }

        .ftr-bottom-center a:hover {
            color: #49c96d;
        }

        .ftr-bottom-right {
            color: #b8c0c5;
            font-size: 14px;
        }

        /*==========================
       Hover Effects
==========================*/

        .ftr-footer-widget ul li {
            transition: .3s;
        }

        .ftr-footer-widget ul li:hover {
            transform: translateX(3px);
        }

        /*==========================
       Responsive
==========================*/

        @media(max-width:1199px) {

            .ftr-footer-main {
                padding: 60px 0;
            }

        }

        @media(max-width:991px) {

            .ftr-footer-main {
                text-align: center;
            }

            .ftr-footer-widget h4:after {
                left: 50%;
                transform: translateX(-50%);
            }

            .ftr-social {
                justify-content: center;
                margin-bottom: 25px;
            }

            .ftr-contact-list li {
                justify-content: center;
                text-align: left;
            }

            .ftr-payment {
                text-align: center;
            }

            .ftr-footer-bottom .container {
                flex-direction: column;
                gap: 12px;
            }

        }

        @media(max-width:767px) {

            .ftr-footer-main {
                padding: 45px 0;
            }

            .ftr-footer-widget {
                margin-bottom: 35px;
            }

            .ftr-footer-logo {
                max-width: 180px;
            }

            .ftr-footer-desc {
                font-size: 14px;
            }

            .ftr-footer-widget h4 {
                font-size: 18px;
            }

            .ftr-contact-list li {
                font-size: 14px;
            }

            .ftr-payment img {
                max-width: 180px;
            }

            .ftr-bottom-center {
                flex-wrap: wrap;
                justify-content: center;
            }

        }

        @media(max-width:575px) {

            .ftr-social {
                gap: 10px;
            }

            .ftr-social a {
                width: 38px;
                height: 38px;
            }

            .ftr-bottom-left,
            .ftr-bottom-center,
            .ftr-bottom-right {
                font-size: 13px;
                text-align: center;
            }

        }

    </style>

    <div class="ftr-footer-main">
        <div class="container">

            <div class="row">

                <!-- =======================================
                    ABOUT
                ========================================-->

                <div class="col-lg-4 col-md-12">

                    <div class="ftr-footer-about">

                        <img src="{{ asset('images/WhatsApp Image 2025-07-22 at 19.56.01.jpeg') }}"
                            class="ftr-footer-logo" alt="LayerLoop">

                        <p class="ftr-footer-desc">
                            We create premium 3D printed products with precision,
                            passion and innovation. From Murti, Lithophanes,
                            Moon Lamps, Anime Figures to DTF Printed T-Shirts,
                            every creation is crafted with perfection.
                        </p>

                        <div class="ftr-social">

                            <a href="https://www.instagram.com/layerloop.web/" target="_blank"
                                class="ftr-social-instagram">
                                <i class="icon-instagram"></i>
                            </a>

                            <a href="https://www.facebook.com/profile.php?id=61579088633589" target="_blank"
                                class="ftr-social-facebook">
                                <i class="icon-facebook-f"></i>
                            </a>

                            <a href="#" target="_blank" class="ftr-social-youtube">
                                <i class="icon-youtube"></i>
                            </a>

                            <a href="#" target="_blank" class="ftr-social-pinterest">
                                <i class="icon-pinterest"></i>
                            </a>

                        </div>

                    </div>

                </div>


                <!-- =======================================
                    SHOP
                ========================================-->

                <div class="col-lg-2 col-md-4 col-6">

                    <div class="ftr-footer-widget">

                        <h4>Shop</h4>

                        <ul>

                            <li>
                                <a href="{{ url('shop') }}">
                                    Aftr Products
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('shop?category=murti') }}">
                                    Murti
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('shop?category=lithophane') }}">
                                    Lithophane
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('shop?category=moon-lamp') }}">
                                    Moon Lamps
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('shop?category=anime') }}">
                                    Anime Figures
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('shop?category=tshirt') }}">
                                    T-Shirts
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>


                <!-- =======================================
                    CUSTOMER SERVICE
                ========================================-->

                <div class="col-lg-2 col-md-4 col-6">

                    <div class="ftr-footer-widget">

                        <h4>Customer Service</h4>

                        <ul>

                            <li>
                                <a href="{{ url('orders') }}">
                                    Track Order
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Shipping Policy
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Return & Refund
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('faq') }}">
                                    FAQs
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('contact_us') }}">
                                    Contact Us
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>


                <!-- =======================================
                    INFORMATION
                ========================================-->

                <div class="col-lg-2 col-md-4 col-6">

                    <div class="ftr-footer-widget">

                        <h4>Information</h4>

                        <ul>

                            <li>
                                <a href="{{ url('about') }}">
                                    About Us
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Our Process
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Privacy Policy
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    Terms & Conditions
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>


                <!-- =======================================
                    CONTACT
                ========================================-->

                <div class="col-lg-2 col-md-12">

                    <div class="ftr-footer-widget ftr-contact-widget">

                        <h4>Need Help?</h4>

                        <ul class="ftr-contact-list">

                            <li>
                                <i class="icon-phone"></i>

                                <a href="tel:+918059808185">
                                    +91 80598 08185
                                </a>
                            </li>

                            <li>

                                <i class="icon-envelope"></i>

                                <a href="mailto:support@layerloop.in">
                                    support@layerloop.in
                                </a>

                            </li>

                            <li>

                                <i class="icon-clock-o"></i>

                                Mon - Sat : 10 AM - 7 PM

                            </li>

                        </ul>


                        <div class="ftr-payment">

                            <img src="{{ asset('frontend/assets/images/payments.png') }}" alt="Payments">

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>


    <!--============================
        Bottom Footer
    =============================-->

    <div class="ftr-footer-bottom">

        <div class="container">

            <div class="ftr-bottom-left">

                © {{ date('Y') }} LayerLoop. Aftr Rights Reserved.

            </div>

            <div class="ftr-bottom-center">

                <a href="#">
                    Privacy Policy
                </a>

                <span>|</span>

                <a href="#">
                    Terms & Conditions
                </a>

            </div>

            <div class="ftr-bottom-right">

                Made with ❤️ in India

            </div>

        </div>

    </div>

</footer>
