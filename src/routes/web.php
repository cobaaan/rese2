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

Route::get('/my_page', [ReseController::class,'myPage'])->middleware(['auth', 'verified']);
Route::post('/my_page', [ReseController::class,'myPage'])->middleware(['auth', 'verified']);
Route::post('/my_page_modal', [ReseController::class, 'modal'])->middleware(['auth', 'verified']);

Route::get('/thanks', [ReseController::class,'thanks'])->middleware(['auth', 'verified']);

Route::get('/done', [ReseController::class,'done']);

//Route::get('/menu', [ReseController::class,'menu']);

Route::post('/favorite/{id}', [FavoriteController::class, 'toggleFavorite'])->name('favorite.toggle');

Route::get('/admin_register', [AdminController::class, 'adminRegister']);

Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/create', [PaymentController::class, 'create'])->name('create');
    Route::post('/store', [PaymentController::class, 'store'])->name('store');
});

Route::post('/reserve', [ReserveController::class, 'reserve']);
Route::post('/cancel', [ReserveController::class, 'cancel']);

Route::post('/change_reserve', [ReserveController::class, 'changeReserve']);
Route::get('/change_reserve', [ReserveController::class, 'changeReserve'])->name('change_reserve');
Route::post('/update_reserve', [ReserveController::class, 'updateReserve']);

Route::get('/review', [ReviewController::class,'review'])->name('review');
Route::post('/review_post', [ReviewController::class,'reviewPost']);

Route::post('/mail_form', [MailController::class, 'mailForm']);
Route::get('/mail_form', [MailController::class, 'mailForm'])->name('mail_form');
Route::post('/send_mail', [MailController::class, 'sendMail']);

Route::post('/admin_create', [FortifyController::class, 'adminCreate']);
Route::get('/verify', [FortifyController::class,'verify']);

Route::get('/', [ShopController::class,'shopAll']);
Route::post('/', [ShopController::class,'shopAll']);
Route::get('/shop_manager', [ShopController::class, 'shopManager'])->name('shop_manager');
Route::get('/shop_reserve', [ShopController::class, 'shopReserve']);
Route::post('/shop_create', [ShopController::class, 'shopCreate']);
Route::post('/shop_update', [ShopController::class, 'shopUpdate']);
Route::get('/shop_detail', [ShopController::class,'shopDetail'])->name('shop_detail');
Route::post('/shop_detail', [ShopController::class,'shopDetail']);
Route::post('/modal', [ShopController::class,'modal']);