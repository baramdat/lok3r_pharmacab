<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\userController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\RequestedController;
use App\Http\Controllers\CategoriesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentications
Route::post('/register/user', [authController::class,'registerUser']);
Route::post('login',[authController::class,'login']);
Route::post('forget/password',[authController::class,'submitForgetPasswordForm'])->name('forget.password.post');
Route::post('reset-password', [authController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// profile
Route::post('profile/update',[userController::class,'updateProfile']);
Route::post('change/password', [userController::class, 'ChangePassword'])->name('change-password');
Route::post('change/photo', [userController::class, 'changePhoto']);

// Role 
Route::post('/role/add', [roleController::class,'addRole']); 
Route::get('/role/edit', [roleController::class, 'editRole']);
Route::post('/role/update', [roleController::class, 'updateRole']);
Route::get('/role/delete', [roleController::class, 'deleteRole']);

// user
Route::post('/user/add', [userController::class,'add']);
Route::get('/user/count', [userController::class,'userCount']); 
Route::get('/users', [userController::class,'users']);
Route::post('/user/update', [userController::class,'updateUser']);
Route::delete('/delete/user/{id}', [userController::class,'deleteUser']);

//site
Route::post('/site/add', [SiteController::class,'add']);
Route::get('/site/count', [SiteController::class,'count']); 
Route::get('/site/list', [SiteController::class,'list']);
Route::get('/sites', [SiteController::class,'list']);
Route::post('/site/update', [SiteController::class,'update']);
Route::delete('/site/delete/{id}', [SiteController::class,'delete']);

// locker
Route::post('/locker/add',[LockerController::class,'add']);
Route::post('/locker/available',[LockerController::class,'isAvailable']);
Route::get('/locker/count', [LockerController::class,'count']); 
Route::get('/locker/history/count', [LockerController::class,'historyCount']); 

Route::get('/locker/list', [LockerController::class,'list']);
Route::get('/locker/history/list', [LockerController::class,'historyList']);
Route::post('/locker/pricing', [LockerController::class,'pricing']);
Route::post('/locker/update', [LockerController::class,'update']);
Route::delete('/locker/delete/{id}', [LockerController::class,'delete']);
Route::post('/locker_histor/add',[LockerController::class,'add_history']);


// pricing
Route::post('/pricing/update', [LockerController::class,'pricingUpdate']);
Route::get('/pricing/history', [LockerController::class,'pricingHistory']);
Route::delete('/pricing/history/delete/{id}', [LockerController::class,'pricingHistoryDelete']);

//relay
Route::get('/relay/state',[LockerController::class,'relayState'])->name('relay/state');
Route::post('/relay/state/update', [LockerController::class,'relayStateUpdate']);
Route::get('/relay/state/{$id}',[LockerController::class,'relayStateById'])->name('relay/state/by/id');

// booking
Route::get('/booking/count',[BookingController::class,'count']);
Route::get('/booking/list',[BookingController::class,'list']);
Route::get('/booking/locker/count',[BookingController::class,'countLocker']);
Route::get('/booking/locker/list',[BookingController::class,'listLocker']);
Route::post('/booking/update', [BookingController::class,'update']);
Route::delete('/booking/delete/{id}', [BookingController::class,'delete']);
Route::get('/booking/cron',[BookingController::class,'cron']);

// stripe 
Route::post('/payment/create',[BookingController::class,'paymentCreate'])->name('payment/create');
Route::post('/payment/intent',[BookingController::class,'paymentIntent'])->name('payment/intent');
Route::post('/payment/refund',[BookingController::class,'paymentRefund'])->name('payment/refund');
Route::get('/payment/details/{id}',[BookingController::class,'paymentDetails'])->name('payment/details');
Route::delete('/payment/delete/{id}', [BookingController::class,'paymentDelete']);
Route::get('/payment/count',[BookingController::class,'paymentCount']);
Route::get('/payment/list',[BookingController::class,'paymentList']);

// categories
Route::post('/category/add',[CategoriesController::class,'categoryAdd'])->name('category/add');
Route::get('/category/count',[CategoriesController::class,'categoryCount'])->name('category/count');
Route::get('/category/list',[CategoriesController::class,'categoryList'])->name('category/list');
Route::delete('/category/delete/{id}',[CategoriesController::class,'deleteCategory'])->name('category/delete');
Route::post('/category/update',[CategoriesController::class,'updateCategory'])->name('category/update');

// add products
Route::post('/product/add',[InventoryController::class,'productAdd'])->name('products/add');
Route::get('/product/count',[InventoryController::class,'productCount'])->name('product/count');
Route::get('/product/list',[InventoryController::class,'productList'])->name('product/list');
Route::delete('/product/delete/{id}',[InventoryController::class,'deleteProduct'])->name('product/delete');
Route::post('/products/update',[InventoryController::class,'updateProduct'])->name('product/update');
Route::post('/update/product/quantity',[InventoryController::class,'updateProductQuantity']);


// add request of product
Route::post('/request/add',[RequestedController::class,'add'])->name('request/add');
Route::post('/product/request/add',[RequestedController::class,'addRequest']);
Route::get('/product/request/count',[RequestedController::class,'requestCount'])->name('product/request/count');
Route::get('/request/product/list',[RequestedController::class,'requestProductList'])->name('request/product/list');
Route::post('/update/request/status',[RequestedController::class,'updateRequestStaus'])->name('update/request/status');
Route::delete('/request/product/delete/{id}',[RequestedController::class,'deleteRequestedProduct']);





