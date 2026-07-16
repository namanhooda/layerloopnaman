<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>LayerLoop - 3d pronted Store</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Layerloop - 3d pronted Store">
    <meta name="google-site-verification" content="SA4k7tR0Adq975MTs1RDqcRfGaIvdiJ7OLnqR2A4qrg" />
    <meta name="author" content="p-themes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('frontend/assets/images/icons/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('frontend/assets/images/icons/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('frontend/assets/images/icons/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('frontend/assets/images/icons/favicon-32x32.png')}}">
    <link rel="mask-icon" href="{{asset('frontend/assets/images/icons/favicon-32x32.png')}}" color="#666666">
    <link rel="shortcut icon" href="{{asset('frontend/assets/images/icons/favicon-32x32.png')}}">
    <meta name="apple-mobile-web-app-title" content="Layerloop">
    <meta name="application-name" content="Layerloop">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="{{asset('frontend/assets/images/icons/favicon-32x32.png')}}">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{asset('frontend/assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css')}}">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/plugins/owl-carousel/owl.carousel.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/plugins/magnific-popup/magnific-popup.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/plugins/jquery.countdown.css')}}">



<link rel="stylesheet" href="https://checkout-ui.shiprocket.com/assets/styles/shopify.css">


    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/custom.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/skins/skin-demo-2.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/demos/demo-2.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-T8NR051ED9"></script>

    <style>


    .shop {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: #4CAF50;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: .3s;
        text-decoration: none;

    }

     @media(max-width:767px) {

     

        .shops {
            min-width: 100px !important;
        }
}
    </style>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-T8NR051ED9');
    </script>
</head>

<body>

    <div class="page-wrapper">
        @include('frontend.partials.header')


            @yield('content')
        
        @include('frontend.partials.footer')
        @include('frontend.partials.mobile-footer')
        <div class="mobile-footer">
           <a href="{{url('/')}}" title="My account">
                        <div class="icon">
                            <i class="icon-user" style="    margin-bottom: -15px;"></i>
                            Home
                        </div>
                    </a>
            <a href="{{url('shop')}}" title="My account">
                        <div class="icon">
                            <i class="icon-shopping-bag" style="margin-bottom:-15px;"></i>

                            Shop
                        </div>
                    </a>
            <a href="{{ url('wishlist') }}" title="Wishlist">
                <div class="icon position-relative">
                    <i class="icon-heart-o" style="margin-bottom: -15px;"></i>
                    Wishlist
                    <span class="badge bg-danger position-absolute" style="top: 0; right: 0; font-size: 10px;">
                        {{ \App\Helpers\CartHelper::getWishlistCount() }}
                    </span>
                </div>
            </a>
            <a href="{{url('cart')}}" title="My account">
                        <div class="icon">
                            <i class="icon-shopping-cart" style="    margin-bottom: -15px;"></i>
                            Cart
                        </div>
                    </a>
        </div>
        <!-- End .footer -->
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

        @include('frontend.partials.mobile-header')
    <!-- Mobile Menu -->

    <!-- Sign in / Register Modal -->
    <!-- Sign In / Register Modal -->
<div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin" role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="tab-content-5">

                            {{-- Sign In Form --}}
                            <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email Address *</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password *</label>
                                        <input type="password" class="form-control" name="password" required>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>LOG IN</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="signin-remember">
                                            <label class="custom-control-label" for="signin-remember">Remember Me</label>
                                        </div>

                                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot Your Password?</a>
                                    </div>
                                </form>
                            </div>

                            {{-- Register Form --}}
                            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                                <form action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Name *</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone *</label>
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password *</label>
                                        <input type="password" class="form-control" name="password" required>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>SIGN UP</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>

                                        <!-- <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="register-policy" required>
                                            <label class="custom-control-label" for="register-policy">I agree to the <a href="#">privacy policy</a> *</label>
                                        </div> -->
                                    </div>
                                </form>
                            </div>

                        </div><!-- End .tab-content -->

                        <div class="form-choice">
                            <p class="text-center">or sign in with</p>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a href="" class="btn btn-login btn-g">
                                        <i class="icon-google"></i> Login With Google
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div><!-- End .form-tab -->
                </div><!-- End .form-box -->
            </div><!-- End .modal-body -->
        </div><!-- End .modal-content -->
    </div><!-- End .modal-dialog -->
</div>


    @include('frontend.modals.add-to-cart-model')


<!-- End .modal -->
    
    @include('frontend.partials.newsletter')


</body>

    <!-- @if(session('success'))
    <script>
        Swal.fire({
            title: '🎉 Product Added!',
            text: "{{ session('success') }}",
            icon: 'success',
            showConfirmButton: true,
            confirmButtonText: 'Continue Shopping 🛍️',
            confirmButtonColor: '#00b894',
            background: '#f9f9f9',
            customClass: {
                popup: 'animated fadeInDown faster'
            },
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif -->
    <!-- Plugins JS File -->

    <script src="{{asset('frontend/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/jquery.hoverIntent.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/superfish.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/jquery.plugin.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/jquery.magnific-popup.min.js')}}"></script>
    <script src="{{asset('frontend/assets/js/jquery.countdown.min.js')}}"></script>
    <!-- Main JS File -->
    <script src="{{asset('frontend/assets/js/main.js')}}"></script>
    <script src="{{asset('frontend/assets/js/demos/demo-2.js')}}"></script>


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://checkout-ui.shiprocket.com/assets/js/channels/shopify.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        document.querySelectorAll(".buyNow").forEach(function (button) {

            button.addEventListener("click", async function (event) {

                event.preventDefault();

                const productId = this.dataset.productId;

                console.log("Product:", productId);

                try {

                    const response = await fetch("{{ route('shiprocket.token') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    });

                    const data = await response.json();

                    console.log(data);

                    if (!data.success) {

                        alert("Unable to generate Shiprocket token.");

                        return;
                    }

                    if (typeof HeadlessCheckout === "undefined") {

                        alert("Shiprocket Checkout JS not loaded.");

                        return;
                    }

                    HeadlessCheckout.addToCart(
                        event,
                        data.access_token, {
                            fallbackUrl: "{{ url('/checkout') }}",
                            isInitiatedFromApp: false
                        }
                    );

                } catch (error) {

                    console.error(error);

                    alert("Something went wrong.");

                }

            });

        });

    });

</script>


<script>
const input = document.getElementById('product-search');
const overlay = document.getElementById('search-overlay');
const suggestionsBox = document.getElementById('search-suggestions');
const productsBox = document.getElementById('search-products');

input.addEventListener('focus', () => {
    overlay.classList.remove('d-none');
});

document.querySelector('.search-close').onclick = () => {
    overlay.classList.add('d-none');
};

input.addEventListener('keyup', function () {
    let q = this.value.trim();
    if (q.length < 2) return;

    fetch(`/ajax-search?q=${q}`)
        .then(res => res.json())
        .then(data => {

            // Suggestions
            suggestionsBox.innerHTML = '';
            data.suggestions.forEach(item => {
                suggestionsBox.innerHTML += `<li>${item}</li>`;
            });

            // Products
            productsBox.innerHTML = '';
            data.products.forEach(p => {
                productsBox.innerHTML += `
                    <div class="search-product-card">
                        <img src="${p.image}">
                        ${p.discount ? `<span class="badge">SAVE ${p.discount}%</span>` : ''}
                        <p>${p.name}</p>
                        <strong>₹ ${p.price}</strong>
                    </div>
                `;
            });
        });
});
</script>

<script>
    let customizeModalInstance = null;

    // Open modal
    function openCustomizeModal(productId) {
        document.getElementById('customize-product-id').value = productId;
        let modalEl = document.getElementById('customizeModal');
        customizeModalInstance = new bootstrap.Modal(modalEl);
        customizeModalInstance.show();
    }

    // Submit customized product
    function submitCustomizedCart() {
        let product_id = document.getElementById('customize-product-id').value;
        let quantity = document.getElementById("quantity-" + product_id).value;
        let size = document.getElementById('customize-size').value;
        let imageInput = document.getElementById('customize-image').files[0];

        if (!size) {
            showToastr('error', 'Please select a size.');
            return;
        }

        let formData = new FormData();
        formData.append('product_id', product_id);
        formData.append('quantity', quantity);
        formData.append('size', size);
        if (imageInput) {
            formData.append('image', imageInput);
        }

        fetch("{{ route('cart.add') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(".cart-count").textContent = data.cart_count;
                document.querySelector(".dropdown-menu").innerHTML = data.cart_html;
                showToastr('success', data.message);

                // ✅ Close modal and reset form
                let modalEl = document.getElementById('customizeModal');
                customizeModalInstance.hide();
                modalEl.querySelector('#customize-size').value = '';
                modalEl.querySelector('#customize-image').value = '';
            } else {
                showToastr('error', data.message ?? "Something went wrong!");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showToastr('error', "Unexpected error occurred!");
        });
    }

    // Add normal product to cart
function addToCart(productId) {
    let product_id = document.getElementById("product-id-" + productId).value;
    let quantity   = document.getElementById("quantity-" + productId).value;

    let sizeSelect = document.getElementById("size-" + productId);
    let size = sizeSelect ? sizeSelect.value : null;

    if (sizeSelect && !size) {
        showToastr('error', 'Please select a size');
        return;
    }

    fetch("{{ route('cart.add') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ product_id, quantity, size })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector(".cart-count").textContent = data.cart_count;
            document.querySelector(".dropdown-menu").innerHTML = data.cart_html;
            showToastr('success', data.message);
        } else {
            showToastr('error', data.message ?? "Something went wrong!");
        }
    });
}

</script>

<script>
document.querySelectorAll(".add-to-wishlist").forEach(button => {
    button.addEventListener("click", function () {

        let productId = this.dataset.productId;
        let btn = this;

        let sizeSelect = document.getElementById("size-" + productId);
        let size = sizeSelect ? sizeSelect.value : null;

        // ✅ require size if dropdown exists
        if (sizeSelect && !size) {
            showToastr('error', 'Please select a size');
            return;
        }

        fetch("{{ route('wishlist.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                product_id: productId,
                size: size
            })
        })
        .then(response => response.json())
        .then(data => {

            if (data.success) {
                document.querySelector(".wishlist-count").textContent = data.count;

                btn.classList.add("active");
                btn.innerHTML = `<span>In wishlist</span>`;

                showToastr('success', data.message);
            } else {
                showToastr('error', data.message ?? "Something went wrong!");
            }
        });
    });
});

</script>



   <script>
    function showToastr(type, message) {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-top-right",
            timeOut: 5000
        };

        if (type === 'success') {
            toastr.success(message, 'Success');
        } else {
            toastr.error(message, 'Error');
        }
    }

    @if(session('success'))
        showToastr('success', @json(session('success')));
    @endif

    @if(session('error'))
        showToastr('error', @json(session('error')));
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            showToastr('error', @json($error));
        @endforeach
    @endif
</script>

@stack('scripts')

<script src="https://checkout-ui.shiprocket.com/assets/js/channels/shopify.js"></script>
</body>



</html>