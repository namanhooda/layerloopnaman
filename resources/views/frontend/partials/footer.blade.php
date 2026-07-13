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
        
        .modal-body ul {
    list-style: disc !important;
    padding-left: 20px !important;
    margin-bottom: 1rem;
}

.modal-body ol {
    list-style: decimal !important;
    padding-left: 20px !important;
    margin-bottom: 1rem;
}

.modal-body li {
    display: list-item !important;
    margin-bottom: 8px;
    color: #333;
}
.modal-body{
    margin: 20px;
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
    <a href="#" data-bs-toggle="modal" data-bs-target="#shippingModal">
        Shipping Policy
    </a>
</li>

<li>
    <a href="#" data-bs-toggle="modal" data-bs-target="#refundModal">
        Return & Refund Policy
    </a>
</li>

<li>
    <a href="#" data-bs-toggle="modal" data-bs-target="#codModal">
        Cash on Delivery
    </a>
</li>

                            <!-- <li>
                                <a href="{{ url('faq') }}">
                                    FAQs
                                </a>
                            </li> -->

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
    <a href="#" data-bs-toggle="modal" data-bs-target="#privacyPolicyModal">
        Privacy Policy
    </a>
</li>

<li>
    <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">
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



<!-- Privacy Policy Modal -->
<div class="modal fade" id="privacyPolicyModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Privacy Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p>
                    At <strong>LayerLoop</strong>, we respect your privacy and are committed to protecting your personal information.
                </p>

                <h6>Information We Collect</h6>

                <ul>
                    <li>Name</li>
                    <li>Email Address</li>
                    <li>Phone Number</li>
                    <li>Shipping & Billing Address</li>
                    <li>Order Details</li>
                    <li>Payment Information (processed securely through payment gateways)</li>
                </ul>

                <h6>How We Use Your Information</h6>

                <ul>
                    <li>To process your orders</li>
                    <li>To ship products</li>
                    <li>To provide customer support</li>
                    <li>To send order updates</li>
                    <li>To improve our website and services</li>
                </ul>

                <h6>Data Security</h6>

                <p>
                    Your information is stored securely and is never sold or shared with third parties except trusted payment and shipping partners.
                </p>

                <h6>Cookies</h6>

                <p>
                    Our website may use cookies to improve browsing experience and website performance.
                </p>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Terms & Conditions</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p>
                    By purchasing from LayerLoop, you agree to the following terms.
                </p>

                <h6>Products</h6>

                <p>
                    We manufacture premium 3D printed products including idols, miniatures, lamps, home decor, custom models, figurines and personalized gifts.
                </p>

                <h6>3D Printing Characteristics</h6>

                <ul>
                    <li>Minor layer lines are natural.</li>
                    <li>Small color differences may occur.</li>
                    <li>Dimensions may vary slightly (±2-3 mm).</li>
                </ul>

                <h6>Customized Products</h6>

                <p>
                    Customized products are manufactured specifically for you and cannot be cancelled or returned once production begins.
                </p>

                <h6>Pricing</h6>

                <p>
                    Prices may change without prior notice. Applicable taxes and shipping charges will be calculated during checkout.
                </p>

                <h6>Copyright</h6>

                <p>
                    All product designs, images and website content belong to LayerLoop.
                </p>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="shippingModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Shipping Policy</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <h6>Order Processing</h6>

                <p>
                    Every LayerLoop product is manufactured using premium 3D printing technology. Orders are generally prepared within <strong>2-4 business days</strong>.
                </p>

                <h6>Delivery Time</h6>

                <p>
                    Standard delivery takes approximately <strong>5-7 business days</strong> after dispatch depending on your location.
                </p>

                <h6>Courier Partners</h6>

                <ul>
                    <li>Delhivery</li>
                    <li>Blue Dart</li>
                    <li>DTDC</li>
                    <li>Xpressbees</li>
                    <li>Ekart</li>
                </ul>

                <h6>Tracking</h6>

                <p>
                    Tracking details will be sent via Email, SMS or WhatsApp once your order is dispatched.
                </p>

                <h6>Delays</h6>

                <p>
                    Shipping may be delayed due to weather conditions, public holidays, courier delays or unforeseen circumstances.
                </p>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="refundModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Return & Refund Policy</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <h6>Returns</h6>

                <p>
                    Returns are accepted only if:
                </p>

                <ul>
                    <li>Product arrives damaged.</li>
                    <li>Wrong product is delivered.</li>
                    <li>Major manufacturing defect.</li>
                </ul>

                <h6>Report Within</h6>

                <p>
                    Please report any issue within <strong>48 hours</strong> of delivery with an unboxing video and product photos.
                </p>

                <h6>Non-Returnable Items</h6>

                <ul>
                    <li>Customized Products</li>
                    <li>Personalized Models</li>
                    <li>Made-to-order Items</li>
                    <li>Products damaged after delivery</li>
                </ul>

                <h6>Refund</h6>

                <p>
                    Approved refunds are processed within <strong>5-7 business days</strong> through the original payment method.
                </p>

                <h6>Replacement</h6>

                <p>
                    Depending on the issue, we may provide a replacement instead of a refund.
                </p>

            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="codModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Cash on Delivery (COD)</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <p>
                    LayerLoop offers Cash on Delivery on selected products and eligible PIN codes.
                </p>

                <h6>Availability</h6>

                <p>
                    COD is available only for serviceable locations.
                </p>

                <h6>Verification</h6>

                <p>
                    Our team may contact you via phone or WhatsApp to verify COD orders before dispatch.
                </p>

                <h6>Customized Products</h6>

                <p>
                    Customized and personalized products require full advance payment before production begins.
                </p>

                <h6>Cancellation</h6>

                <p>
                    Repeated cancellation or refusal of COD orders may result in COD being disabled for future purchases.
                </p>

                <h6>Inspection</h6>

                <p>
                    Please inspect the package upon delivery. If you notice visible damage, refuse the package and contact our support immediately.
                </p>

            </div>

        </div>
    </div>
</div>




</footer>


