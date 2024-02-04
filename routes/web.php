<?php

use App\Http\Controllers\admin\LeaveRequestController;
use App\Http\Controllers\admin\AttendanceController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\hr\SalaryController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\employee\EmployeeController;
use App\Http\Controllers\employee\LeaveController;
use App\Http\Controllers\employee\RatingController;
use App\Http\Controllers\employee\TaskController;
use App\Http\Controllers\hr\HrController;
use App\Http\Controllers\manager\ManagerController;
use App\Http\Controllers\manager\RequestController;
use App\Http\Controllers\PdfGenerationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalaryCriteriaController;
use App\Http\Controllers\superadmin\SuperAdminController;
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

Route::get('/',[IndexController::class, 'index']);

Route::get('/dashboard',[DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/users/login',[UserValidationController::class, 'login']);
Route::post('/users/login',[UserValidationController::class, 'authenticate'])->name('login');
Route::post('/users/logout',[UserValidationController::class, 'logout'])->name('logout');

Route::get('/superadmin/dashboard',[SuperAdminController::class, 'index'])->name('superadmin.dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/user/profile/{id}',[ProfileController::class, 'index'])->name('profile.index');
    Route::get('/user/profile/edit/{id}',[ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/user/profile/edit/{id}',[ProfileController::class, 'update'])->name('profile.update');

    Route::match(['get', 'post'], '/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');

    Route::get('/rating/create/{id}',[RatingController::class, 'create'])->name('rating.create');
    // Route::post('/rating/store',[RatingController::class, 'store'])->name('rating.store');
    Route::resource('/rating',RatingController::class)->only('store');

    Route::resource('/task',TaskController::class)->only('store','edit','update','destroy');
    Route::get('/task/index/{id}',[TaskController::class, 'index'])->name('task.index');
    Route::get('/task/create/{id}',[TaskController::class, 'create'])->name('task.create');
    Route::put('/task/start/{id}',[TaskController::class, 'start'])->name('task.start');
    Route::put('/task/complete/{id}',[TaskController::class, 'complete'])->name('task.complete');
    Route::get('/task/deleteList/{id}',[TaskController::class, 'deleteList'])->name('task.deleteList');
    Route::get('/task/{id}/restore',[TaskController::class, 'restore'])->name('task.restore');
    Route::delete('/task/{id}/forceDelete',[TaskController::class, 'force_delete'])->name('task.force_delete');
    
    Route::get('/task/{id}',[App\Http\Controllers\employee\ProjectController::class, 'task'])->name('project.mytask');
    Route::get('/myproject', [App\Http\Controllers\employee\ProjectController::class, 'index'])->name('project.myproject');
    Route::get('/complete', [App\Http\Controllers\employee\ProjectController::class, 'complete'])->name('project.completed');

    Route::get('/project/detail/{id}',[App\Http\Controllers\employee\ProjectController::class, 'show'])->name('project.detail');
    Route::get('/project/start/{id}',[App\Http\Controllers\employee\ProjectController::class, 'start'])->name('project.start');
    Route::get('/attendance/index',[App\Http\Controllers\employee\AttendanceController::class, 'index'])->name('employee.attendance.index');
    Route::get('/salary/index',[App\Http\Controllers\employee\SalaryController::class, 'index'])->name('employee.salary.index');
    Route::get('/salary/index',[App\Http\Controllers\employee\SalaryController::class, 'index'])->name('employee.salary.index');

    Route::get('/users/leave/index',[LeaveController::class, 'index'])->name('user.leave.index');
    Route::get('/users/leave/create',[LeaveController::class, 'create'])->name('leave.create');
    Route::post('/users/leave/create',[LeaveController::class, 'store'])->name('leave.store');
    Route::post('/users/leave/balance/{id}',[LeaveController::class, 'balance'])->name('user.leave.balance');
});

Route::middleware('auth')->group(function () {
    Route::resource('/salarycriteria',SalaryCriteriaController::class)->except('destroy');
    Route::get('/department/request',[RequestController::class, 'index'])->name('request.index');
    Route::get('/pdfgenerate/index',[PdfGenerationController::class, 'index'])->name('pdfgenerate.index');
    Route::post('/attendance/pdfgenerate/{id}',[App\Http\Controllers\hr\AttendanceController::class, 'pdfGenerate'])->name('attendance.pdfGenerate');
    Route::get('/attendance/pdfView/{id}',[App\Http\Controllers\hr\AttendanceController::class, 'pdfGenerate'])->name('attendance.pdfView');
    
    Route::post('/leave/pdfgenerate/{id}',[LeaveController::class, 'pdfGenerate'])->name('leave.pdfGenerate');
});

Route::middleware(['role:manager','auth'])->group(function () {
    Route::get('/manager/dashboard',[ManagerController::class, 'index'])->name('manager.dashboard');
    
    Route::put('/manager/leave/accept/{id}',[RequestController::class, 'accept'])->name('request.accept');
    Route::put('/manager/leave/reject/{id}',[RequestController::class, 'reject'])->name('request.reject');
});

Route::middleware(['role:HR','auth'])->group(function () {
    Route::get('/hr/dashboard',[HrController::class, 'index'])->name('hr.dashboard');
    Route::get('/attendance/create/{id}',[App\Http\Controllers\hr\AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance/create',[App\Http\Controllers\hr\AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/hr/attendance/index',[App\Http\Controllers\hr\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/edit/{id}',[App\Http\Controllers\hr\AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('/attendance/edit/{id}',[App\Http\Controllers\hr\AttendanceController::class, 'update'])->name('attendance.update');
    Route::get('/salary/create/{id}',[SalaryController::class, 'create'])->name('hr.salary.create');
    Route::post('/salary/create/{id}',[SalaryController::class, 'store'])->name('hr.salary.store');
    Route::get('/hr/salary/index',[SalaryController::class, 'index'])->name('hr.salary.index'); 
    Route::get('/hr/salary/pdf-generate/{id}',[SalaryController::class, 'pdfGenerate'])->name('generate.pdf'); 

});

// Route::group(array('prefix'=>'admin','namespace'=>'admin','middleware'=>'role:admin'),function()
// {
Route::middleware(['role:admin|super admin','auth'])->group(function () {

    Route::get('/admin/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('/admin/user',UserController::class);

    Route::resource('admin/department',DepartmentController::class);
    Route::get('/admin/department/{id}/restore',[DepartmentController::class,  'restore'])->name('department.restore');
    Route::delete('/admin/department/{id}/forcedelete',[DepartmentController::class,  'force_delete'])->name('department.force_delete');

    Route::get('/admin/users/{id}/restore',[UserController::class, 'restore'])->name('user.restore');
    Route::delete('/admin/users/{id}/forceDelete',[UserController::class, 'force_delete'])->name('user.forceDelete');

    Route::resource('/admin/project',ProjectController::class)->except('show');
    Route::get('/admin/project/running', [ProjectController::class, 'progress'])->name('project.progress');
    Route::get('/admin/project/complete', [ProjectController::class, 'complete'])->name('project.complete');
    Route::get('/admin/project/{id}/restore',[ProjectController::class, 'restore'])->name('project.restore');
    Route::get('/admin/project/deleteList',[ProjectController::class, 'deleteList'])->name('project.deletelist');
    Route::delete('/admin/project/{id}/forcedelete',[ProjectController::class, 'force_delete'])->name('project.force_delete');

    Route::get('/admin/attendance/index',[AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::delete('/admin/attendance/{id}',[AttendanceController::class, 'destroy'])->name('attendance.destroy');
    Route::get('/admin/attendance/deleteList',[AttendanceController::class, 'deleteList'])->name('attendance.deleteList');
    Route::get('/admin/attendance/{id}/restore',[AttendanceController::class, 'restore'])->name('attendance.restore');

    Route::get('/admin/leave/index',[LeaveRequestController::class, 'index'])->name('leave.index');
    Route::get('/admin/leave/balance',[LeaveRequestController::class, 'balance'])->name('leave.balance');
    Route::get('/admin/leave/request',[LeaveRequestController::class, 'show'])->name('leave.manager');
    Route::put('/admin/leave/accept/{id}',[LeaveRequestController::class, 'accept'])->name('leave.accept');
    Route::put('/admin/leave/reject/{id}',[LeaveRequestController::class, 'reject'])->name('leave.reject');
    Route::delete('/admin/leave/{id}',[LeaveRequestController::class, 'destroy'])->name('leave.destroy');
    Route::get('/admin/leave/deleteList',[LeaveRequestController::class, 'deleteList'])->name('leave.deleteList');
    Route::get('/admin/leave/{id}/restore',[LeaveRequestController::class, 'restore'])->name('leave.restore');

    Route::resource('/admin/salary',App\Http\Controllers\admin\SalaryController::class)->only('index','destroy');
    Route::get('/admin/salary/{id}/restore',[App\Http\Controllers\admin\SalaryController::class, 'restore'])->name('salary.restore');
    Route::get('/admin/salary/deleteList',[App\Http\Controllers\admin\SalaryController::class, 'deleteList'])->name('salary.deleteList');

    Route::get('/admin/role/index',[RoleController::class, 'index'])->name('role.index');
    Route::get('/admin/role/{role}/setpermission',[RoleController::class, 'permission'])->name('role.permission');
    Route::put('/admin/role/{role}/setpermission',[RoleController::class, 'setpermission'])->name('role.setpermission');

});

