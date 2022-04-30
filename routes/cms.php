<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\MenuPositionController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductTagController;
use App\Http\Controllers\Admin\SlidesController;
use App\Http\Controllers\Admin\ProductAttributesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\MethodPaymentsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TransactionPcoinController;
use App\Http\Controllers\Admin\ReviewsController;

Route::get('/', 'App\Http\Controllers\Auth\AdminLoginController@dashboard')->name('admin.dashboard')->middleware('auth:admin');
Route::get('/login', 'App\Http\Controllers\Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/login', 'App\Http\Controllers\Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/logout', 'App\Http\Controllers\Auth\AdminLoginController@logout')->name('admin.logout');

Route::middleware('auth:admin')->group(function (){

    Route::resource('admin', AdminController::class)->except(['show']);
    Route::get('admin/dataTable', 'App\Http\Controllers\Admin\AdminController@dataTable')->name('admin.data_table');

    Route::resource('user', UserController::class)->except(['show']);
    Route::get('user/change-password/{id}', 'App\Http\Controllers\Admin\UserController@changePassword')->name('user.change_password');
    Route::post('user/change-password/{id}', 'App\Http\Controllers\Admin\UserController@changePasswordStore')->name('user.change_password_store');
    Route::get('user/dataTable', 'App\Http\Controllers\Admin\UserController@dataTable')->name('user.data_table');

    Route::resource('transaction-pcoin', TransactionPcoinController::class)->except(['show']);
    Route::get('transaction-pcoin/datatTable', 'App\Http\Controllers\Admin\TransactionPcoinController@dataTable')->name('transaction-pcoin.data_table');


    Route::resource('category', CategoryController::class)->except(['show']);
    Route::get('category/dataTable', 'App\Http\Controllers\Admin\CategoryController@dataTable')->name('category.data_table');

    Route::resource('product-category', ProductCategoryController::class)->except(['show']);
    Route::get('product-category/dataTable', 'App\Http\Controllers\Admin\ProductCategoryController@dataTable')->name('product-category.data_table');

    Route::resource('tag', TagController::class)->except(['show']);
    Route::get('tag/dataTable', 'App\Http\Controllers\Admin\TagController@dataTable')->name('tag.data_table');

    Route::resource('slides', SlidesController::class)->except(['show']);
    Route::get('slides/dataTable', 'App\Http\Controllers\Admin\SlidesController@dataTable')->name('slides.data_table');

    Route::resource('reviews', ReviewsController::class)->except(['show']);
    Route::get('reviews/dataTable', 'App\Http\Controllers\Admin\ReviewsController@dataTable')->name('reviews.data_table');


    Route::resource('product', ProductController::class)->except(['show']);
    Route::get('product/dataTable', 'App\Http\Controllers\Admin\ProductController@dataTable')->name('product.data_table');

    Route::resource('order', OrderController::class)->except(['show']);
    Route::get('order/dataTable', 'App\Http\Controllers\Admin\OrderController@dataTable')->name('order.data_table');

    Route::resource('product-tag', ProductTagController::class)->except(['show']);
    Route::get('product-tag/dataTable', 'App\Http\Controllers\Admin\ProductTagController@dataTable')->name('product-tag.data_table');

    Route::resource('product-attributes', ProductAttributesController::class)->except(['show']);
    Route::get('product-attributes/dataTable', 'App\Http\Controllers\Admin\ProductAttributesController@dataTable')->name('product-attributes.data_table');

    //Danh sách các thuộc tính của 1 loại thuộc tính
    Route::get('product-attributes/{id}/attributes/index', 'App\Http\Controllers\Admin\ProductAttributesController@attributesIndex')->name('attributes_index');
    Route::get('product-attributes/{id}/attributes/create', 'App\Http\Controllers\Admin\ProductAttributesController@attributesCreate')->name('attributes_create');
    Route::post('product-attributes/{id}/attributes/store', 'App\Http\Controllers\Admin\ProductAttributesController@attributesStore')->name('attributes_store');
    Route::get('product-attributes/{id?}/attributes/edit/{attribute_id}', 'App\Http\Controllers\Admin\ProductAttributesController@attributesEdit')->name('attributes_edit');
    Route::put('product-attributes/{id?}/attributes/update/{attribute_id}', 'App\Http\Controllers\Admin\ProductAttributesController@attributesUpdate')->name('attributes_update');
    Route::delete('product-attributes/{id?}/attributes/destroy/{attribute_id}', 'App\Http\Controllers\Admin\ProductAttributesController@attributesDestroy')->name('attributes_destroy');
    Route::get('product-attributes/{id}/attributes/dataTable', 'App\Http\Controllers\Admin\ProductAttributesController@attributesDataTable')->name('attributes_dataTable');


    Route::resource('post', PostController::class)->except(['show']);
    Route::get('post/dataTable', 'App\Http\Controllers\Admin\PostController@dataTable')->name('post.data_table');

    Route::resource('methodpayments', MethodPaymentsController::class)->except(['show']);
    Route::get('methodpayments/dataTable', 'App\Http\Controllers\Admin\MethodPaymentsController@dataTable')->name('methodpayments.data_table');

    Route::resource('page', PageController::class)->except(['show']);
    Route::get('page/dataTable', 'App\Http\Controllers\Admin\PageController@dataTable')->name('page.data_table');

    Route::resource('role', RoleController::class)->except(['show']);
    Route::get('role/dataTable', 'App\Http\Controllers\Admin\RoleController@dataTable')->name('role.data_table');

    Route::resource('menuposition', MenuPositionController::class)->except(['show']);
    Route::get('menuposition/dataTable', 'App\Http\Controllers\Admin\MenuPositionController@dataTable')->name('menuposition.data_table');

    //sửa menu item
    Route::get('menuposition/menu/{menuId}', 'App\Http\Controllers\Admin\MenuPositionController@MenuEdit')->name('menu.edit');
    Route::post('menu-update/{menuId}', 'App\Http\Controllers\Admin\MenuPositionController@MenuUpdate')->name('menu.update');

    Route::get('setting', 'App\Http\Controllers\Admin\SettingController@index')->name('setting.index');
    Route::post('setting/update', 'App\Http\Controllers\Admin\SettingController@update')->name('setting.update');



    Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')->name('ckfinder_connector');
    Route::any('/ckfinder/browser', function (){
        return view('plugins.ckfinder.browser');
    })->name('ckfinder_browser');
//    Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')->name('ckfinder_browser');

    //check trang thai the nap
    Route::post('check-card-status', 'App\Http\Controllers\Admin\TransactionPcoinController@checkCardStatus')->name('check_card_status');

});

