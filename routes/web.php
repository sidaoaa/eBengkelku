<?php

use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsedCarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressDeliveryController;
use App\Http\Controllers\WorkshopSellerController;
use App\Http\Controllers\ServiceSellerController;
use App\Http\Controllers\SparePartSellerController;
use App\Http\Controllers\ProductSellerController;
use App\Http\Controllers\UsedCarSellerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rute untuk Login dan Registrasi
Route::prefix('login')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
   Route::post('forgot', [LoginController::class, 'forgot'])->name('login.forgot');
    Route::get('lupa_password', [LoginController::class, 'lupa_password'])->name('login.lupa_password');
    Route::post('/signin', [LoginController::class, 'signin'])->name('login.signin');   
    Route::post('reset_password', [LoginController::class, 'reset_password'])->name('login.reset_password');
    Route::get('register', [LoginController::class, 'registerPage'])->name('login.register');
    Route::post('/register', [LoginController::class, 'register'])->name('register.submit');

});

// Rute untuk Beranda
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/info', 'home.info')->name('info');
Route::view('/info/guide', 'home.guide')->name('info.guide');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout.submit');

// Rute untuk Event
Route::prefix('event')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('event');
    Route::get('register/{id}', [EventController::class, 'register'])->name('event.register');
    Route::post('register', [EventController::class, 'store'])->name('event.store');
    Route::get('register/detail/{id}', [EventController::class, 'detail_register'])->name('register.detail');
    Route::post('register/payment/{id}', [EventController::class, 'payment'])->name('register.payment');
    Route::post('register/checkout/{id}', [EventController::class, 'checkout'])->name('register.checkout');
    Route::get('payment/detail/{id}/pay/{idp}', [EventController::class, 'paymentDetail'])->name('payment.detail');
});

// Rute untuk Workshop
Route::get('workshop', [WorkshopController::class, 'index'])->name('workshop');
Route::post('books/store', [WorkshopController::class, 'store'])->name('ulasan');

// Rute untuk Produk
Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product');

    Route::get('detail/{id}/{ps}', [ProductController::class, 'detail'])->name('product.detail');
    Route::post('add-to-cart/{id}/{ps}', [ProductController::class, 'add_to_cart'])->name('product.add_to_cart');
});

// Rute untuk Mobil Bekas
Route::prefix('used_car')->group(function () {
    Route::get('/', [UsedCarController::class, 'index'])->name('used_car');
    Route::get('item/{id}', [UsedCarController::class, 'itemCar'])->name('used_car.item');
    Route::get('owner/{id}', [UsedCarController::class, 'owner'])->name('usedcar.owner');
    Route::post('filter', [UsedCarController::class, 'filterCar'])->name('filter.car');
});



// Rute untuk Profil
Route::prefix('profile')->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');    
    Route::get('profile/dashboard', [ProfileController::class, 'dashboard'])->name('profile.dashboard');
    Route::get('profile/my_order', [ProfileController::class, 'my_order'])->name('my_order');
    Route::post('update_profile', [ProfileController::class, 'update_profile'])->name('profile.update_profile');
    Route::post('upload', [ProfileController::class, 'upload'])->name('profile.upload');
    Route::post('log', [ProfileController::class, 'log'])->name('profile.log');
    Route::post('log-sale', [ProfileController::class, 'log_sale'])->name('profile.log_sale');
    Route::post('change_password', [ProfileController::class, 'change_password'])->name('profile.change_password');
});

// Rute untuk Keranjang
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart');
    Route::get('delete-item/{id}', [CartController::class, 'deleteItemOrder'])->name('delete.order_item');
    Route::post('add-qty', [CartController::class, 'add_qty'])->name('product.add_qty');
    Route::post('checkout/{id}', [CartController::class, 'method_payment'])->name('cart.method_payment');
    Route::post('checkout/', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('checkout/success/{id}', [CartController::class, 'checkoutDetail'])->name('cart.detail');
    Route::post('confirm-payment', [CartController::class, 'confirmPayment'])->name('cart.confirm');
    Route::post('confirm-payment/success', [CartController::class, 'confirmPaymentStore'])->name('cart.confirm.payment');
    Route::get('get-order/approve/{id}', [CartController::class, 'getApproveOrder'])->name('get.approveorder');
    Route::post('order/approve', [CartController::class, 'ApproveOrder'])->name('approve.order');
    Route::post('order/shipping', [CartController::class, 'shippingOrder'])->name('shipping.order');
});

// // Rute untuk Alamat Pengiriman
// Route::prefix('address_delivery')->group(function () {
//     Route::post('pagination', [AddressDeliveryController::class, 'pagination'])->name('address_delivery.pagination');
//     Route::post('save', [AddressDeliveryController::class, 'save'])->name('address_delivery.save');
//     Route::post('update', [AddressDeliveryController::class, 'update'])->name('address_delivery.update');
//     Route::post('delete', [AddressDeliveryController::class, 'delete'])->name('address_delivery.delete');
// });

// // Rute untuk Penjual Workshop
// Route::prefix('workshop_seller')->group(function () {
//     Route::post('pagination', [WorkshopSellerController::class, 'pagination'])->name('workshop_seller.pagination');
//     Route::post('save', [WorkshopSellerController::class, 'save'])->name('workshop_seller.save');
//     Route::post('update', [WorkshopSellerController::class, 'update'])->name('workshop_seller.update');
//     Route::post('delete', [WorkshopSellerController::class, 'delete'])->name('workshop_seller.delete');
// });

// // Rute untuk Penjual Service
// Route::prefix('service_seller')->group(function () {
//     Route::post('pagination', [ServiceSellerController::class, 'pagination'])->name('services_seller.pagination');
//     Route::post('save', [ServiceSellerController::class, 'save'])->name('services_seller.save');
//     Route::post('update', [ServiceSellerController::class, 'update'])->name('services_seller.update');
//     Route::post('delete', [ServiceSellerController::class, 'delete'])->name('services_seller.delete');
// });

// // Rute untuk Penjual Spare Part
// Route::prefix('spare_part_seller')->group(function () {
//     Route::any('pagination', [SparePartSellerController::class, 'pagination'])->name('spare_part_seller.pagination');
//     Route::post('save', [SparePartSellerController::class, 'save'])->name('spare_part_seller.save');
//     Route::post('update', [SparePartSellerController::class, 'update'])->name('spare_part_seller.update');
//     Route::post('delete', [SparePartSellerController::class, 'delete'])->name('spare_part_seller.delete');
// });

// // Rute untuk Penjual Produk
// Route::prefix('product_seller')->group(function () {
//     Route::post('pagination', [ProductSellerController::class, 'pagination'])->name('product_seller.pagination');
//     Route::post('save', [ProductSellerController::class, 'save'])->name('product_seller.save');
//     Route::post('update', [ProductSellerController::class, 'update'])->name('product_seller.update');
//     Route::post('delete', [ProductSellerController::class, 'delete'])->name('product_seller.delete');
// });

// // Rute untuk Penjual Mobil Bekas
// Route::prefix('used_car_seller')->group(function () {
//     Route::post('pagination', [UsedCarSellerController::class, 'pagination'])->name('used_car_seller.pagination');
//     Route::post('save', [UsedCarSellerController::class, 'save'])->name('used_car_seller.save');
//     Route::post('update', [UsedCarSellerController::class, 'update'])->name('used_car_seller.update');
//     Route::post('delete', [UsedCarSellerController::class, 'delete'])->name('used_car_seller.delete');
//     Route::get('{id}/hapus_foto_mobil', [UsedCarSellerController::class, 'hapus_foto_mobil'])->name('used_car_seller.hapus_foto_mobil');
//     Route::get('sold/{id}', [UsedCarSellerController::class, 'soldOut'])->name('usedcar.soldout');
// });

// // Rute untuk Kirim WA
// Route::get('sendwa', [ProfileController::class, 'sendwa'])->name('sendwa');
