<?php

use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\userController;
use App\Http\Controllers\LockerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoriesController;

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

Route::get('/clear', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('optimize:clear'); 

    return 'DONE'; //Return anything
});

Route::get('reset-password/{token}', [authController::class, 'showResetPasswordForm'])->name('reset.password.get');

Route::group(['middleware' => ['web']], function () {

    Route::post('logout',[authController::class,'logout'])->name('logout')->middleware('isLogin');
    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard')->middleware('isLogin');


    // user
    Route::view('user/add', 'templates.users.add')->name('add-user')->middleware('isLogin');
    Route::view('user/list', 'templates.users.list')->name('user/list')->middleware('isLogin');
    Route::view('user/role', 'templates.users.role')->name('role/list')->middleware('isLogin');
    Route::get('/user/edit/{id}', [userController::class,'editUser'])->middleware('isLogin');
    Route::get('/user/detail/{id}',[UserController::class,'userDetail'])->middleware('isLogin');

    // site
    Route::view('site/add', 'templates.site.add')->name('add-site')->middleware('isLogin');
    Route::view('site/list', 'templates.site.list')->name('site/list')->middleware('isLogin');
    Route::get('/site/edit/{id}', [SiteController::class,'viewEdit'])->middleware('isLogin');
    Route::get('/site/detail/{id}',[SiteController::class,'viewDetails'])->middleware('isLogin');
    
    // profile
    Route::get('/profile', [userController::class,'profile'])->middleware('isLogin');
    Route::view('/profile/edit','templates.profile.profile_edit')->name('profile-edit')->middleware('isLogin');

    Route::view('/contact', 'templates.contact')->name('contact')->middleware('isLogin');

    // locker
    Route::get('locker/list', [LockerController::class,'lockerList'])->name('list')->middleware('isLogin');
    Route::view('locker/open/history', 'templates.locker.opening_history')->name('locker.opening.history')->middleware('isLogin');
    Route::view('locker/add', 'templates.locker.add')->name('add')->middleware('isLogin');
    Route::get('/locker/details/{id}', [LockerController::class,'viewDetails'])->middleware('isLogin');
    Route::get('/locker/edit/{id}', [LockerController::class,'viewEdit'])->middleware('isLogin');
    Route::get('/locker/purchase-history/{id}', [LockerController::class,'viewPurchaseHistory'])->middleware('isLogin');

    // pricing
    Route::view('/pricing/current', 'templates.pricing.current')->name('current')->middleware('isLogin');
    Route::view('/pricing/history', 'templates.pricing.history')->name('history')->middleware('isLogin');
    Route::view('/pricing', 'templates.pricing.pricing')->name('pricing')->middleware('isLogin');
    Route::get('/pricing/history/{id}', [LockerController::class,'pricingHistoryView'])->middleware('isLogin');

    // booking
    Route::get('/booking/list', [BookingController::class,'bookingList'])->name('booking-list')->middleware('isLogin');
    Route::view('/booking/add', 'templates.booking.add')->name('booking/add')->middleware('isLogin');
    Route::view('/booking/add2', 'templates.booking.add2')->name('booking/add2')->middleware('isLogin');
    Route::get('/booking/edit/{id}', [BookingController::class,'viewEdit'])->middleware('isLogin');
    Route::get('/booking/details/{id}', [BookingController::class,'viewDetails'])->middleware('isLogin');

    //payment
    // booking
    Route::view('/payment/list', 'templates.payment.list')->name('payment/list')->middleware('isLogin');
    Route::get('/payment/refund/{id}', [BookingController::class,'viewPaymentRefund'])->middleware('isLogin');

    // add categories
    
    Route::get('/add/categories', [CategoriesController::class,'add'])->name('add.categories')->middleware('isLogin');
    Route::view('category/list', 'templates.categories.list')->name('category.list')->middleware('isLogin');
    Route::get('/category/edit/{id}', [CategoriesController::class,'viewEdit'])->middleware('isLogin');
    Route::get('/get/child/category', [CategoriesController::class,'getCild'])->middleware('isLogin');
    // products
    Route::get('/add/products', [InventoryController::class,'add'])->name('add.products')->middleware('isLogin');
    Route::view('products/list', 'templates.products.list')->name('products.list')->middleware('isLogin');
    Route::get('/products/edit/{id}', [InventoryController::class,'viewEdit'])->middleware('isLogin');
    
});





Route::get('/login', function () {
    return view('templates.auth.login');
})->name('login');
Route::get('/', function () {
    return view('templates.auth.login');
});

Route::get('/register', function () {
    return view('templates.auth.register');
});

Route::get('/forgot/password', function () {
    return view('templates.auth.forgot_password');
});











Route::get('/notification', function () {
    return view('templates.notifications.notification');
});

Route::get('/transaction/pending', function () {
    return view('templates.transactions.pending_transaction');
});

Route::get('/transaction/completed', function () {
    return view('templates.transactions.completed_transaction');
});

Route::get('/transaction/edit', function () {
    return view('templates.transactions.edit_transaction');
});

Route::get('/transaction/detail', function () {
    return view('templates.transactions.transaction_detail');
});

Route::get('/transaction/new', function () {
    return view('templates.transactions.new_transaction');
});

