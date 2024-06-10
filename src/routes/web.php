<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FortifyController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
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

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [FortifyController::class, 'login']);
Route::post('/logout', [FortifyController::class, 'logout'])->name('logout');

/*  FavoriteController  */
Route::post('/favorite/{id}', [FavoriteController::class, 'toggleFavorite'])->name('favorite.toggle');

/*  FortifyController  */
/*
Route::middleware(['auth', 'verified'])->prefix('/admin')->group(function () {
Route::post('/create', [FortifyController::class, 'adminCreate']);
Route::get('/verify', [FortifyController::class,'verify']);
Route::get('/register', [FortifyController::class, 'adminRegister']);
});
*/
Route::middleware(['auth:admin'])->prefix('/admin')->group(function () {
    Route::post('/create', [FortifyController::class, 'adminCreate']);
    Route::get('/verify', [FortifyController::class,'verify']);
    Route::get('/register', [FortifyController::class, 'adminRegister']);
});

/*  MailController  */
/*
Route::middleware(['auth', 'verified'])->prefix('/mail')->group(function () {
Route::match(['get', 'post'], '/form', [MailController::class, 'mailForm'])->name('mail_form');
Route::post('/send', [MailController::class, 'sendMail']);
});
*/

Route::middleware(['auth:admin'])->prefix('/mail')->group(function () {
    Route::match(['get', 'post'], '/form', [MailController::class, 'mailForm'])->name('mail_form');
    Route::post('/send', [MailController::class, 'sendMail']);
});

/*  PaymentController  */
Route::post('/payment/store', [PaymentController::class, 'store'])->name('payment.store')->middleware(['auth', 'verified']);

/*  ReseController  */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::match(['get', 'post'], '/mypage', [ReseController::class, 'myPage']);
    Route::post('/mypage/modal', [ReseController::class, 'modal']);
    Route::get('/thanks', [ReseController::class,'thanks']);
    Route::get('/done', [ReseController::class,'done']);
});

/*  ReserveController  */
Route::middleware(['auth', 'verified'])->prefix('/reserve')->group(function (){
    Route::post('', [ReserveController::class, 'reserve']);
    Route::post('/cancel', [ReserveController::class, 'cancel']);
    Route::match(['get', 'post'], '/change', [ReserveController::class, 'changeReserve'])->name('change_reserve');
    Route::post('/update', [ReserveController::class, 'updateReserve']);
});

/*  ReviewController  */
Route::middleware(['auth', 'verified'])->prefix('/review')->group(function (){
    Route::get('', [ReviewController::class,'review'])->name('review');
    Route::post('/post', [ReviewController::class,'reviewPost']);
});

/*  ShopController  */
/*
Route::middleware(['auth', 'verified'])->prefix('/shop')->group(function() {
Route::get('/manager', [ShopController::class, 'shopManager'])->name('shop_manager');
Route::get('/reserve', [ShopController::class, 'shopReserve']);
Route::post('/create', [ShopController::class, 'shopCreate']);
Route::post('/update', [ShopController::class, 'shopUpdate']);
Route::get('/visit', [ShopController::class,'visit'])->name('visit');
Route::post('/visited', [ShopController::class,'visited']);
});
*/

Route::middleware(['auth:manager'])->prefix('/shop')->group(function() {
    Route::get('/manager', [ShopController::class, 'shopManager'])->name('shop_manager');
    Route::get('/reserve', [ShopController::class, 'shopReserve']);
    Route::post('/create', [ShopController::class, 'shopCreate']);
    Route::post('/update', [ShopController::class, 'shopUpdate']);
    //Route::get('/visit', [ShopController::class,'visit'])->name('visit');
    //Route::post('/visited', [ShopController::class,'visited']);
});

Route::prefix('/shop')->group(function() {
    Route::match(['get', 'post'], '/detail', [ShopController::class, 'shopDetail'])->name('shop_detail');
    Route::post('/modal', [ShopController::class,'modal']);
    Route::get('/visit', [ShopController::class,'visit'])->name('visit');
    Route::post('/visited', [ShopController::class,'visited']);
});

Route::match(['get', 'post'], '/', [ShopController::class, 'shopAll']);