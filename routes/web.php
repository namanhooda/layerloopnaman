<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{RoleController, PermissionController, UserController, ProfileController, ProductController, ProductCategoryController, OrderController, CouponController, PrototypeController, InvoiceController};
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\{CartController,ShipmentsController, CheckoutController, FrontendController, AddressController, WishlistController};
use Laravel\Fortify\Features;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\ShiprocketWebhookController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TestController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;



Route::get('/testdatanmn', [TestController::class, 'index']);


Route::get('/admin/orders/{id}/create-shipment', [OrderController::class, 'createShipment'])->name('orders.createShipment');
Route::post('/shiprocket/webhook/order', [ShiprocketWebhookController::class, 'handle']);
Route::post('/shiprocket-token', [CheckoutController::class, 'generateToken'])
    ->name('shiprocket.token');

    Route::get('/checkout-success', function () {
    return view('frontend.checkout-success');
})->name('checkout.success');




Route::get('/admin/orders/shipments/nimbuspost', [ShipmentsController::class, 'fetchShipmentsNimbus'])->name('orders.nimbusShipment');
Route::get('/admin/orders/shipments/shiprocket', [ShipmentsController::class, 'fetchShipmentsShiorocket'])->name('orders.ShiprocketShipment');




Route::get('/get-categories/{prototype}', [ProductController::class, 'getCategories'])->name('get.categories');

Route::middleware(['web'])->group(function () {
    // Login page - only show if not logged in
    Route::get('/login', [CustomAuthenticatedSessionController::class, 'create'])->middleware('guest')->name('login');
    // Handle login submission
    Route::post('/login', [CustomAuthenticatedSessionController::class, 'store']);
    // Logout route
    Route::post('/logout', [CustomAuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');
});
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/logout', [CustomAuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::get('/sitemap.xml', function (Request $request) {
    $sitemap = Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create('/about'))
        ->add(Url::create('/contact_us'))
        ->add(Url::create('/faq'))
        ->add(Url::create('/blogs'))
        ->add(Url::create('/shop'));
    return $sitemap->toResponse($request); // <- Only works if Spatie version supports it
});

Route::get('/whatsapp', [WhatsAppController::class, 'form'])->name('whatsapp.form');
Route::post('/whatsapp/send', [WhatsAppController::class, 'send'])->name('whatsapp.send');
Route::get('/products/bulk', [TestController::class, 'form'])->name('bulk_upload');
Route::post('/products/bulk-upload', [TestController::class, 'bulkUpload'])->name('products.bulk_upload');


Route::get('auth/google', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->stateless()->user();
    $user = User::updateOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'password' => $googleUser->getName().'@12345',
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]
    );
    Auth::login($user);
    return redirect('/dashboard'); // change to your home/dashboard
});

Route::get('/ajax-search', [SearchController::class, 'ajax']);


//// cart & Checkout
Route::get('/send-mail', [FrontendController::class, 'sendMail']);
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('about', [FrontendController::class, 'about'])->name('about');
Route::get('contact_us', [FrontendController::class, 'contactUs'])->name('contact_us');
Route::get('faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('blogs', [FrontendController::class, 'blogs'])->name('blogs');
Route::get('blog-detail/{slug}', [FrontendController::class, 'blogDetail'])->name('blog-detail');
Route::get('shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('category/{category_name}', [FrontendController::class, 'categoryProduct'])->name('categoryProduct');
Route::get('/search-suggestions', [FrontendController::class, 'searchSuggestions']);

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('shop-product-detail/{slug}', [FrontendController::class, 'detail'])->name('index');
Route::post('adrrrs', [FrontendController::class, 'storeReview'])->name('reviews.store');
//// cart & Checkout
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/add/wishlist', [CartController::class, 'addWishlist'])->name('cart.add.wishlist');
Route::delete('/cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');
Route::get('cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/shipping', [App\Http\Controllers\CartController::class, 'setShipping'])->name('cart.shipping');
Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply.coupon');
Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('remove.coupon');

//// Wishlist 
Route::resource('wishlist', WishlistController::class)->only(['index', 'store', 'destroy']);

Route::middleware('auth')->group(function () {
    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/checkout/verify-order', [CheckoutController::class, 'verifyPayment'])->name('order.payment.verify');
    Route::get('/order/success/{code}', [CheckoutController::class, 'success'])->name('order.success');
    Route::post('ads', [AddressController::class, 'store'])->name('addresses.store');

    Route::get('account', [App\Http\Controllers\AuthUserController::class, 'account'])->name('account');
    Route::get('orders', [App\Http\Controllers\AuthUserController::class, 'orders'])->name('orders');
    Route::post('orders-cancel/{id}', [App\Http\Controllers\AuthUserController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('orders-show/{code}', [App\Http\Controllers\AuthUserController::class, 'orderDetail'])->name('orders.show');
    Route::get('account-settings', [App\Http\Controllers\AuthUserController::class, 'accountSettings'])->name('accountSettings');
    Route::get('addresses', [App\Http\Controllers\AuthUserController::class, 'addresses'])->name('addresses');
    Route::get('wallet', [App\Http\Controllers\AuthUserController::class, 'wallet'])->name('wallet');
    Route::put('user-profile-update', [App\Http\Controllers\AuthUserController::class, 'updateProfile'])->name('profile.update');
});



Route::middleware(['role:Admin'])->group(function () {
    Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::prefix('admin')->name('admin.')->group(function () {

            Route::get('contact', [ContactController::class, 'index'])->name('contact.index');

            Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
            Route::resource('roles', RoleController::class);
            Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class)->except(['create', 'show']);
            Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->except(['create', 'show']);

            //// ecom
            Route::get('/ecom-dashboard', [DashboardController::class, 'ecomDashboard'])->name('ecom.dashboard');
            Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
            Route::get('order-detail/{id}', [OrderController::class, 'show'])->name('orders.show');

            Route::resource('blog-categories', App\Http\Controllers\Admin\BlogCategoryController::class);
            Route::resource('blogs', App\Http\Controllers\Admin\BlogController::class);
            Route::resource('product-prototypes', PrototypeController::class) ->parameters(['product-prototypes' => 'prototype']);
            Route::resource('product-categories', ProductCategoryController::class);
            Route::resource('pages', PageController::class);
            Route::resource('products', ProductController::class);
            Route::resource('invoices', InvoiceController::class);
            Route::resource('coupons', CouponController::class);
            Route::resource('newsletters', NewsLetterController::class);
            Route::resource('banner', App\Http\Controllers\Admin\BannerController::class);

            Route::get('variant/{id}', [App\Http\Controllers\Admin\ProductController::class, 'variantCreate'])->name('products.variant');

            Route::get('setting', [App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
            Route::post('setting-update', [App\Http\Controllers\SettingController::class, 'update'])->name('setting-update');
        });
    });
});
