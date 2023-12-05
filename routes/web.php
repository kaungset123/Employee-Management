<?php

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserValidationController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users/login',[UserValidationController::class, 'login']);
Route::post('/users/login',[UserValidationController::class, 'authenticate']);

Route::group(array('prefix'=>'admin','namespace'=>'admin'),function(){
    Route::get('/dashboard',[AdminController::class, 'index']);

    Route::get('/users/create',[UserController::class, 'create']);
    Route::post('/users/create',[UserController::class, 'store']);
});

