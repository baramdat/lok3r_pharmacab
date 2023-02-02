<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\userController;
use App\Http\Controllers\formController;
use App\Http\Controllers\serviceController;
use App\Http\Controllers\transactionController;
use App\Http\Middleware\CheckLogin;

 
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
    Route::view('/dashboard', 'templates.dashboard')->name('dashboard')->middleware('isLogin');

    Route::view('/404', 'templates.404')->name('404')->middleware('isLogin');

    // user
    Route::view('user/add', 'templates.users.user_add')->name('add-user')->middleware('isLogin');
    Route::view('user/list', 'templates.users.user_list')->name('user/list')->middleware('isLogin');
    Route::view('user/role', 'templates.users.user_role')->name('role/list')->middleware('isLogin');
    Route::get('/user/edit/{id}', [userController::class,'editUser'])->middleware('isLogin');
    Route::get('/user/detail/{id}',[UserController::class,'userDetail'])->middleware('isLogin');

    // profile
    Route::get('/profile', [userController::class,'profile'])->middleware('isLogin');
    Route::view('/profile/edit','templates.profile.profile_edit')->name('profile-edit')->middleware('isLogin');

    Route::view('/contact', 'templates.contact')->name('contact')->middleware('isLogin');

    // form
    Route::view('form/list', 'templates.forms.form_list')->name('form-list')->middleware('isLogin');
    Route::view('form/add', 'templates.forms.form_add')->name('form-add')->middleware('isLogin');
    Route::get('/form/edit/{id}', [formController::class,'editForm'])->middleware('isLogin');

    // serviece
    Route::view('service/list', 'templates.services.service_list')->name('service-list')->middleware('isLogin');
    Route::view('service/add', 'templates.services.service_add')->name('service-add')->middleware('isLogin');
    Route::get('/service/edit/{id}', [serviceController::class,'editService'])->middleware('isLogin');

    Route::get('/transaction/edit/{id}', [transactionController::class,'editTransaction'])->middleware('isLogin');



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

