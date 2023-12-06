<?php

use App\Http\Controllers\admin\LeaveRequestController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\SalaryController;
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
    Route::get('/dashboard',[AdminController::class, 'index'])->name('project.index');

    Route::get('users/all',[UserController::class, 'index']);
    Route::get('/users/create',[UserController::class, 'create']);
    Route::post('/users/create',[UserController::class, 'store']);
    Route::get('/users/edit',[UserController::class, 'edit']);
    Route::post('/users/edit',[UserController::class, 'update']);

    Route::get('/project/all',[ProjectController::class, 'index']);
    Route::get('/project/create',[ProjectController::class, 'create']);
    Route::post('/project/create',[ProjectController::class, 'store']);
    Route::get('/project/detail',[ProjectController::class, 'show']);
    Route::get('/project/edit',[ProjectController::class, 'edit']);
    Route::post('/project/edit',[ProjectController::class, 'update']);

    Route::get('/leave/all',[LeaveRequestController::class, 'index']);
    Route::get('/leave/balance',[LeaveRequestController::class, 'balance']);

    Route::get('/salary/detail',[SalaryController::class, 'index']);
});

