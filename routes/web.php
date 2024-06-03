<?php

use App\Http\Controllers\AdminPageController;
use App\Http\Controllers\CuttingController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\StoneController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhomeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FilialController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductFilialSizeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubtypeController;
use App\Http\Controllers\SizeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',
[PageController::class,'show_welcome'])->name('show_welcome');

Route::get('/categories/type/get', [TypeController::class,'show'])->name('getTypes');
Route::get('/categories/brand/get', [BrandController::class,'show'])->name('getBrands');
Route::get('/categories/cutting/get', [CuttingController::class,'show'])->name('getCuttings');
Route::get('/categories/material/get', [MaterialController::class,'show'])->name('getMaterials');
Route::get('/categories/sample/get', [SampleController::class,'show'])->name('getSamples');
Route::get('/categories/stone/get', [StoneController::class,'show'])->name('getStones');
Route::get('/categories/whom/get', [WhomeController::class,'show'])->name('getWhomes');
Route::get('filials/index/get',[FilialController::class,'show'])->name('getFilials');

Route::get('total',[OrderController::class,'new_order'])->name('new_order');

Route::group(['middleware'=>['admin','auth'],'prefix'=>'admin'],function(){

    Route::get('/profile',[AdminPageController::class,'admin_profile'])->name('admin_profile');
    Route::post('/profile/edit',[UserController::class,'update'])->name('admin_profile_edit');
    Route::get('/profile/delete',[UserController::class,'destroy'])->name('admin_profile_destroy');

    Route::get('/categories/index',
    [AdminPageController::class,'show_categories'])->name('show_categories');

    Route::get('/filials/index',
    [AdminPageController::class,'show_filials'])->name('show_filials');

    Route::get('/products/index',
    [AdminPageController::class,'show_products'])->name('show_products');

    Route::get('/products/add',
    [AdminPageController::class,'show_products_add'])->name('show_products_add');

    Route::get('/products/edit/{id?}',
    [AdminPageController::class,'show_products_edit'])->name('show_products_edit');

    Route::post('/categories/type/save',
    [TypeController::class,'store'])->name('TypeSave');

    Route::post('/categories/cutting/save',
    [CuttingController::class,'store'])->name('CuttingSave');

    Route::post('/categories/material/save',
    [MaterialController::class,'store'])->name('MaterialSave');

    Route::post('/categories/sample/save',
    [SampleController::class,'store'])->name('SampleSave');

    Route::post('/categories/stone/save',
    [StoneController::class,'store'])->name('StoneSave');

    Route::post('/categories/brand/save',
    [BrandController::class,'store'])->name('BrandSave');

    Route::post('/categories/whom/save',
    [WhomeController::class,'store'])->name('WhomSave');



    Route::post('categories/subtype/update',[SubtypeController::class,'update'])->name('update_subtype');
    Route::post('categories/size/update',[SizeController::class,'update'])->name('update_size');

    Route::post('categories/subtype/delete',[SubtypeController::class,'destroy_sub_char'])->name('delete_subtype');
    Route::post('categories/size/delete',[SizeController::class,'destroy_sub_char'])->name('delete_size');

    Route::post('categories/subtype/add',[SubtypeController::class,'store'])->name('store_subtype');
    Route::post('categories/size/add',[SizeController::class,'store'])->name('store_size');

    Route::get('categories/delete/{id?}/{type?}',[TypeController::class,'destroy'])->name('destroyGlobal');
    Route::post('categories/edit/{id?}/{type?}',[TypeController::class,'edit'])->name('editGlobal');


    // Route::get('filials/specials/get/{product?}',[ProductFilialSizeController::class,'index'])->name('getSpecFilials');
    Route::post('filials/store',[FilialController::class,'store'])->name('storeFilial');
    Route::post('filials/edit',[FilialController::class,'edit'])->name('editFilial');
    Route::get('filial/delete/{id?}',[FilialController::class,'destroy'])->name('destroyFilial');

    Route::post('products/add/store',[ProductController::class,'store'])->name('storeProduct');
    Route::post('products/edit',[ProductController::class,'update'])->name('editProduct');

    Route::get('products/product/get', [ProductController::class,'show'])->name('getProducts');
    Route::get('products/filial_size/get', [ProductFilialSizeController::class,'show'])->name('getProductFilial');
    Route::get('products/delete/{id?}',[ProductController::class,'destroy'])->name('destroyProduct');

    Route::get('orders/',[AdminPageController::class,'show_orders'])->name('show_orders');
    Route::put('orders/confirm/{order?}',[OrderController::class,'admin_confirm'])->name('admin_confirm');
    Route::put('orders/cancel/{order?}',[OrderController::class,'admin_cancel'])->name('admin_cancel');
    Route::get('orders/done/{order?}',[OrderController::class,'admin_done'])->name('admin_done');
});

Route::get('page/registration',
[PageController::class,'show_reg'])->name('show_reg');

Route::get('page/auth',
[PageController::class,'show_auth'])->name('login');
Route::post('page/auth/log',
[UserController::class,'LogUser'])->name('log_user');


Route::post('page/registration/save',
[UserController::class,'Registration'])->name('Registration');

Route::get('logout',
[UserController::class,'logout'])->name('logout');

Route::get('catalog',[PageController::class,'catalog'])->name('catalog');
Route::get('catalog/index',[ProductController::class,'show'])->name('get_catalog');

Route::get('catalog/cart/add/{id?}',[CartController::class,'store_one'])->name('add_cart_link');
Route::post('catalog/cart/{id?}',[CartController::class,'store'])->name('add_cart');
Route::get('catalog/cart/decrease/{id?}',[CartController::class,'decrease'])->name('decrease_cart');
Route::get('catalog/cart/delete/{id?}',[CartController::class,'destroy'])->name('delete_cart');

Route::put('catalog/order/confirm/{id?}',[OrderController::class,'update'])->name('confirm_order');

Route::get('catalog/favorite/{id?}',[FavoriteController::class,'store'])->name('add_fav');
Route::get('catalog/favs/get', [FavoriteController::class,'show'])->name('getFavs');


Route::get('catalog/detail/{id?}',[PageController::class,'detail'])->name('detail');

Route::post('detail/review/store/{id?}',[ReviewController::class,'store'])->name('store_review');
Route::get('detail/review/delete/{id?}',[ReviewController::class,'destroy'])->name('delete_review');

// Route::get('user/cart',[PageController::class,'cart'])->name('show_cart');
Route::get('user/cart/get',[CartController::class,'index'])->name('cart');
Route::post('user/cart/update',[CartController::class,'update'])->name('cart_update');


Route::post('catalog/detail/stock',[ProductFilialSizeController::class,'get_stock'])->name('get_stock');

Route::get('user/favorites/get',[PageController::class,'favs'])->name('fav_page');

Route::get('user/orders/get',[OrderController::class,'index'])->name('my_orders');

Route::post('user/orders/goods/get',[CartController::class,'show_order'])->name('show_order');
Route::get('user/orders/cancel/{order?}',[OrderController::class,'destroy'])->name('cancel_order');

Route::get('user/profile',[PageController::class,'user_profile'])->name('user_profile');
Route::post('user/profile/edit',[UserController::class,'update'])->name('user_profile_edit');
Route::get('user/profile/delete',[UserController::class,'destroy'])->name('user_profile_destroy');
