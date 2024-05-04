<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReseController;
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
Route::get('/done', [ReseController::class,'done']);
Route::get('/', [ReseController::class,'shopAll'])->middleware(['auth', 'verified']);
Route::post('/', [ReseController::class,'shopAll'])->middleware(['auth', 'verified']);
Route::post('/shop_detail', [ReseController::class,'shopDetail']);
Route::get('/thanks', [ReseController::class,'thanks'])->middleware(['auth', 'verified']);
Route::get('/done', [ReseController::class,'done']);
Route::get('/menu1', [ReseController::class,'menu1']);
Route::get('/menu2', [ReseController::class,'menu2']);
Route::get('/menu', [ReseController::class,'menu']);

Route::post('/reserve', [ReseController::class, 'reserve']);

Route::post('/cancel', [ReseController::class, 'cancel']);


Route::post('/search', [ReseController::class, 'search']);

Route::post('/favorite/{id}', [ReseController::class, 'toggleFavorite'])->name('favorite.toggle');


Route::post('/change_reserve', [ReseController::class, 'changeReserve']);
Route::post('/update_reserve', [ReseController::class, 'updateReserve']);


Route::get('/review', [ReseController::class,'review']);

Route::get('/verify', [ReseController::class,'verify']);
//Route::get('/date', [ReseController::class, 'date'])->middleware(['auth', 'verified']);

