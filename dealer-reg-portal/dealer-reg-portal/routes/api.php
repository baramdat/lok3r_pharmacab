<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\roleController;
use App\Http\Controllers\authController;
use App\Http\Controllers\userController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\formController;
use App\Http\Controllers\serviceController;
use App\Http\Controllers\transactionController;


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
Route::post('update/profile',[userController::class,'updateProfile']);
Route::post('change/password', [userController::class, 'ChangePassword'])->name('change-password');
Route::post('change/photo', [userController::class, 'changePhoto']);

// Role 
Route::post('/role/add', [roleController::class,'addRole']); 
Route::get('/role/edit', [roleController::class, 'editRole']);
Route::post('/role/update', [roleController::class, 'updateRole']);
Route::get('/role/delete', [roleController::class, 'deleteRole']);

// user
Route::post('/add/user', [userController::class,'addUser']);
Route::get('/user/count', [userController::class,'userCount']); 
Route::get('/users', [userController::class,'users']);
Route::post('/update/user', [userController::class,'updateUser']);
Route::delete('/delete/user/{id}', [userController::class,'deleteUser']);

// Generals
Route::post('/contact', [contactController::class,'contact']);
// General contact
Route::post('/add/general/contact', [contactController::class,'addGeneral']); 
Route::get('/edit/general/contact', [contactController::class, 'editGeneral']);
Route::post('/update/general/contact', [contactController::class, 'updateGeneral']);
Route::get('/delete/general/contact', [contactController::class, 'deleteGeneral']);
// Mailing information
Route::post('/add/mailing/information', [contactController::class,'addMailing']); 
Route::get('/edit/mailing/information', [contactController::class, 'editMailing']);
Route::post('/update/mailing/information', [contactController::class, 'updateMailing']);
Route::get('/delete/mailing/information', [contactController::class, 'deleteMailing']);

// dropzone
Route::post('upload-file',[formController::class, 'uploadFile']);
Route::delete('delete-file',[formController::class, 'deleteFile']);

// forms
Route::post('/add/form',[formController::class,'addForm']);
Route::get('/form/count', [formController::class,'formCount']); 
Route::get('/forms', [formController::class,'forms']);
Route::post('/update/form', [formController::class,'updateForm']);
Route::delete('/delete/form/{id}', [formController::class,'deleteForm']);

// service
Route::post('/add/service', [serviceController::class,'addService']);
Route::get('/service/count', [serviceController::class,'serviceCount']); 
Route::get('/services', [serviceController::class,'services']);
Route::post('/update/service', [serviceController::class,'updateService']);
Route::delete('/delete/service/{id}', [serviceController::class,'deleteService']);

// transaction
Route::post('/add/transaction', [transactionController::class,'addTransaction']);
// pending transactions
Route::get('/pending/count', [transactionController::class,'pendingCount']); 
Route::get('/pendings', [transactionController::class,'pendings']);
 