<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Auth::routes(['verify' => true]);
Route::get('/', 'App\Http\Controllers\FrontEnd\HomeController@home')->name('home');

Route::get('/{slug}-c{id}.html', 'App\Http\Controllers\FrontEnd\CategoryController@category')
    ->where([
        'slug' => '[a-zA-Z-_\d+]+',
        'id' => '(\d+)(?!.*\d)'
    ])->name('category');
Route::get('{slug}-p{id}.html', 'App\Http\Controllers\FrontEnd\PostController@post')
    ->where([
        'slug' => '[a-zA-Z-_\d+]+',
        'id' => '(\d+)(?!.*\d)'
    ])->name('post');
Route::get('/{slug}-pg{id}.html', 'App\Http\Controllers\FrontEnd\PageController@page')
    ->where([
    'slug' => '[a-zA-Z-_\d+]+',
    'id' => '(\d+)(?!.*\d)'
    ])->name('page');
Route::get('/{slug}-t{id}', 'App\Http\Controllers\FrontEnd\TagController@tag')
    ->where([
        'slug' => '[a-zA-Z-_\d+history_order]+',
        'id' => '(\d+)(?!.*\d)'
    ])->name('tag');

Route::get('/{slug}-prc{id}.html', 'App\Http\Controllers\FrontEnd\ProductCategoryController@category')
    ->where([
        'slug' => '[a-zA-Z-_\d+]+',
        'id' => '(\d+)(?!.*\d)'
    ])->name('product_category');
Route::get('/{slug}-d{id}.html', 'App\Http\Controllers\FrontEnd\ProductController@product')
    ->where([
        'slug' => '[a-zA-Z-_\d+]+',
        'id' => '(\d+)(?!.*\d)'
    ])->name('product');
Route::get('/tim-kiem', 'App\Http\Controllers\FrontEnd\ProductController@search')->name('search');
Route::get('/profile.html', 'App\Http\Controllers\FrontEnd\UserController@profile')->name('profile')->middleware(['auth', 'verified']);
Route::post('/update-profile', 'App\Http\Controllers\FrontEnd\UserController@updateProfile')->name('update_profile')->middleware(['auth', 'verified']);
Route::post('/update-password', 'App\Http\Controllers\FrontEnd\UserController@updatePassword')->name('update_password')->middleware(['auth', 'verified']);

Route::post('/add-to-cart', 'App\Http\Controllers\FrontEnd\OrderController@addToCart')->name('ajax_add_to_cart')->middleware(['auth', 'verified']);
Route::delete('/delete-item-from-cart', 'App\Http\Controllers\FrontEnd\OrderController@deleteItemFromCart')->name('ajax_delete_item_from_cart');
//Route::post('/quick-buy/{id}', 'App\Http\Controllers\FrontEnd\OrderController@quickBuy')->name('quick_buy');

Route::get('/xac-nhan-thanh-toan', 'App\Http\Controllers\FrontEnd\OrderController@showCart')->name('show_cart');
Route::get('/thanh-toan', 'App\Http\Controllers\FrontEnd\OrderController@checkOut')->name('check_out');
Route::post('/thanh-toan', 'App\Http\Controllers\FrontEnd\OrderController@submitCheckout')->name('submit_checkout');
Route::get('/thanh-toan-thanh-cong/{id}', 'App\Http\Controllers\FrontEnd\OrderController@checkoutSuccess')->name('checkout_success');
Route::get('/chi-tiet-don-hang/{id}', 'App\Http\Controllers\FrontEnd\OrderController@orderDetail')->name('order_detail')->middleware(['auth', 'verified']);
Route::post('/update-qty', 'App\Http\Controllers\FrontEnd\OrderController@updateQty')->name('update_qty');

//lịch sử giao dịch
Route::get('transaction-history-by-card/dataTable', 'App\Http\Controllers\FrontEnd\UserController@transactionHistoryByCard')->name('transaction_history_by_card')->middleware(['auth', 'verified']);
Route::get('transaction-history-by-bank/dataTable', 'App\Http\Controllers\FrontEnd\UserController@transactionHistoryByBank')->name('transaction_history_by_bank')->middleware(['auth', 'verified']);

//lịch sử mua hàng
Route::get('history-order', 'App\Http\Controllers\FrontEnd\UserController@historyOrder')->name('history_order')->middleware(['auth', 'verified']);


//Nạp thẻ
Route::post('nap-pcoin','App\Http\Controllers\FrontEnd\UserController@payCoinByCardPhone')->name('pay_coin_by_card_phone')->middleware(['auth', 'verified']);
Route::post('callback-card-phone', 'App\Http\Controllers\FrontEnd\CardController@callBackCardPhone')->name('callback_card_phone');

//gửi request order mua pcoin bằng cách ck ngân hàng
Route::get('nap-pcoin-bang-ck-ngan-hang', 'App\Http\Controllers\FrontEnd\AlepayController@payCoin')->name('pay_coin_by_banking')->middleware(['auth', 'verified']);
Route::post('nap-pcoin-bang-ck-ngan-hang', 'App\Http\Controllers\FrontEnd\AlepayController@payCoinSubmit')->name('pay_coin_by_banking_submit')->middleware(['auth', 'verified']);
Route::post('review', 'App\Http\Controllers\FrontEnd\UserController@review')->name('submit_review')->middleware(['auth', 'verified']);

//return url alepay checkout
Route::get('alepay-return-url', 'App\Http\Controllers\FrontEnd\AlepayController@returnUrl')->name('alepay_return_url')->middleware(['auth', 'verified']);
Route::get('alepay-cancel-url/{id}', 'App\Http\Controllers\FrontEnd\AlepayController@cancelUrl')->name('alepay_cancel_url')->middleware(['auth', 'verified']);


//thanh toán ngân lượng bằng api alepay
Route::get('callback-alepay', 'App\Http\Controllers\FrontEnd\AlepayController@callbackAlepay')->name('callback_alepay');


