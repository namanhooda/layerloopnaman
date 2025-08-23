<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{RoleController, PermissionController, UserController, ProfileController, ProductController, ProductCategoryController, OrderController, CouponController, PrototypeController, InvoiceController};
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\{CartController, FrontendController, AddressController, WishlistController};
use Laravel\Fortify\Features;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ContactController;




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


//// cart & Checkout
Route::get('/send-mail', [FrontendController::class, 'sendMail']);
Route::get('/', [FrontendController::class, 'index'])->name('index');
Route::get('about', [FrontendController::class, 'about'])->name('about');
Route::get('contact_us', [FrontendController::class, 'contactUs'])->name('contact_us');
Route::get('faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('blogs', [FrontendController::class, 'blogs'])->name('blogs');
Route::get('blog-detail', [FrontendController::class, 'blogDetail'])->name('blog-detail');
Route::get('shop', [FrontendController::class, 'shop'])->name('shop');
Route::get('category/{category_name}', [FrontendController::class, 'categoryProduct'])->name('categoryProduct');
Route::get('/search-suggestions', [FrontendController::class, 'searchSuggestions']);


Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('shop-product-detail/{id}', [FrontendController::class, 'detail'])->name('index');
Route::get('account', [FrontendController::class, 'account'])->name('account');
Route::post('adrrrs', [FrontendController::class, 'storeReview'])->name('reviews.store');
//// cart & Checkout
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'add'])->name('cart.remove');
Route::get('cart', [CartController::class, 'cart'])->name('cart');

Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('ads', [AddressController::class, 'store'])->name('addresses.store');
Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply.coupon');
Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('remove.coupon');

//// Frontend Auth Routes
Route::middleware('auth')->group(function () {
    Route::resource('wishlist', WishlistController::class)->only(['index', 'store', 'destroy']);
});

Route::post('/checkout/place-order', [CartController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/checkout/verify-order', [CartController::class, 'verifyPayment'])->name('order.payment.verify');
Route::get('/order-success', function () {
    return view('frontend.order-success');
})->name('order.success');

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

            Route::resource('blog-categories', BlogCategoryController::class);
            Route::resource('blogs', App\Http\Controllers\Admin\BlogController::class);
            Route::resource('product-prototypes', PrototypeController::class) ->parameters(['product-prototypes' => 'prototype']);
            Route::resource('product-categories', ProductCategoryController::class);
            Route::resource('news', ProductController::class);
            Route::resource('pages', PageController::class);
            Route::resource('products', ProductController::class);
            Route::resource('invoices', InvoiceController::class);
            Route::resource('coupons', CouponController::class);
            Route::resource('newsletters', NewsLetterController::class);
        });
    });
});
