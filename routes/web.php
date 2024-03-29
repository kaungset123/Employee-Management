<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Employee;
use App\Http\Controllers\Manager;
use App\Http\Controllers\HR\SalaryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\HR\HrController;
use App\Http\Controllers\Manager\RequestController;
use App\Http\Controllers\PdfGenerationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalaryCriteriaController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
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

Route::get('/',[loginController::class, 'index']);

Route::get('/dashboard',[DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/users/login',[UserValidationController::class, 'login']);
Route::post('/users/login',[UserValidationController::class, 'authenticate'])->name('login');
Route::post('/users/logout',[UserValidationController::class, 'logout'])->name('logout');

Route::get('/superAdmin/dashboard',[SuperAdminController::class, 'index'])->name('superAdmin.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile/{id}',[ProfileController::class, 'index'])->name('profile.index');
    Route::get('/user/profile/edit/{id}',[ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/user/profile/edit/{id}',[ProfileController::class, 'update'])->name('profile.update');

    Route::match(['get', 'post'], '/employee/dashboard', [Employee\EmployeeController::class, 'index'])->name('employee.dashboard');

    Route::get('/rating/create/{id}',[Employee\RatingController::class, 'create'])->name('rating.create');
    Route::resource('/rating',Employee\RatingController::class)->only('store');

    Route::resource('/task',Employee\TaskController::class)->only('store','edit','update','destroy');
    Route::get('/task/index/{id}',[Employee\TaskController::class, 'index'])->name('task.index');
    Route::get('/task/create/{id}',[Employee\TaskController::class, 'create'])->name('task.create');
    Route::put('/task/start/{id}',[Employee\TaskController::class, 'start'])->name('task.start');
    Route::put('/task/complete/{id}',[Employee\TaskController::class, 'complete'])->name('task.complete');
    Route::get('/task/deleteList/{id}',[Employee\TaskController::class, 'deleteList'])->name('task.deleteList');
    Route::get('/task/{id}/restore',[Employee\TaskController::class, 'restore'])->name('task.restore');
    Route::delete('/task/{id}/forceDelete',[Employee\TaskController::class, 'force_delete'])->name('task.force_delete');
    
    Route::get('/task/{id}',[App\Http\Controllers\employee\ProjectController::class, 'task'])->name('project.myTask');
    Route::get('/myProject', [App\Http\Controllers\employee\ProjectController::class, 'index'])->name('project.myProject');
    Route::get('/complete', [App\Http\Controllers\employee\ProjectController::class, 'complete'])->name('project.completed');

    Route::get('/project/detail/{id}',[App\Http\Controllers\employee\ProjectController::class, 'show'])->name('project.detail');
    Route::get('/project/start/{id}',[App\Http\Controllers\employee\ProjectController::class, 'start'])->name('project.start');
    Route::get('/attendance/index',[App\Http\Controllers\employee\AttendanceController::class, 'index'])->name('employee.attendance.index');
    Route::get('/salary/index',[App\Http\Controllers\employee\SalaryController::class, 'index'])->name('employee.salary.index');
    Route::get('/salary/index',[App\Http\Controllers\employee\SalaryController::class, 'index'])->name('employee.salary.index');

    Route::get('/users/leave/index',[Employee\LeaveController::class, 'index'])->name('user.leave.index');
    Route::get('/users/leave/create',[Employee\LeaveController::class, 'create'])->name('leave.create');
    Route::post('/users/leave/create',[Employee\LeaveController::class, 'store'])->name('leave.store');
    Route::post('/users/leave/balance/{id}',[Employee\LeaveController::class, 'balance'])->name('user.leave.balance');
});

Route::middleware('auth')->group(function () {
    Route::resource('/salaryCriteria',SalaryCriteriaController::class)->except('destroy');
    Route::get('/department/request',[RequestController::class, 'index'])->name('request.index');
    Route::get('/pdf/index',[PdfGenerationController::class, 'index'])->name('pdf_generate.index');
    Route::post('/attendance/pdfGenerate/{id}',[App\Http\Controllers\hr\AttendanceController::class, 'pdfGenerate'])->name('attendance.pdfGenerate');
   
    Route::post('/leave/pdfGenerate/{id}',[Employee\LeaveController::class, 'pdfGenerate'])->name('leave.pdfGenerate');
});

Route::middleware(['role:manager','auth'])->group(function () {
    Route::get('/manager/dashboard',[Manager\ManagerController::class, 'index'])->name('manager.dashboard');
    
    Route::put('/manager/leave/accept/{id}',[Manager\RequestController::class, 'accept'])->name('request.accept');
    Route::put('/manager/leave/reject/{id}',[Manager\RequestController::class, 'reject'])->name('request.reject');
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

Route::middleware(['role:admin|super admin','auth'])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('/admin/user',UserController::class);

    Route::resource('admin/department',DepartmentController::class);
    Route::get('/admin/department/{id}/restore',[DepartmentController::class,  'restore'])->name('department.restore');
    Route::delete('/admin/department/{id}/forceDelete',[DepartmentController::class,  'force_delete'])->name('department.force_delete');

    Route::get(   '/admin/users/{id}/restore',[UserController::class, 'restore'])->name('user.restore');
    Route::delete('/admin/users/{id}/forceDelete',[UserController::class, 'force_delete'])->name('user.forceDelete');

    Route::resource('/admin/project',Admin\ProjectController::class)->except('show');
    Route::get('/admin/project/running', [Admin\ProjectController::class, 'progress'])->name('project.progress');
    Route::get('/admin/project/complete', [Admin\ProjectController::class, 'complete'])->name('project.complete');
    Route::get('/admin/project/{id}/restore',[Admin\ProjectController::class, 'restore'])->name('project.restore');
    Route::get('/admin/project/deleteList',[Admin\ProjectController::class, 'deleteList'])->name('project.delete_list');
    Route::delete('/admin/project/{id}/forceDelete',[Admin\ProjectController::class, 'force_delete'])->name('project.force_delete');

    Route::get('/admin/attendance/index',[Admin\AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::delete('/admin/attendance/{id}',[Admin\AttendanceController::class, 'destroy'])->name('attendance.destroy');
    Route::get('/admin/attendance/deleteList',[Admin\AttendanceController::class, 'deleteList'])->name('attendance.deleteList');
    Route::get('/admin/attendance/{id}/restore',[Admin\AttendanceController::class, 'restore'])->name('attendance.restore');

    Route::get('/admin/leave/index',[Admin\LeaveRequestController::class, 'index'])->name('leave.index');
    Route::get('/admin/leave/balance',[Admin\LeaveRequestController::class, 'balance'])->name('leave.balance');
    Route::get('/admin/leave/request',[Admin\LeaveRequestController::class, 'show'])->name('leave.manager');
    Route::put('/admin/leave/accept/{id}',[Admin\LeaveRequestController::class, 'accept'])->name('leave.accept');
    Route::put('/admin/leave/reject/{id}',[Admin\LeaveRequestController::class, 'reject'])->name('leave.reject');
    Route::delete('/admin/leave/{id}',[Admin\LeaveRequestController::class, 'destroy'])->name('leave.destroy');
    Route::get('/admin/leave/deleteList',[Admin\LeaveRequestController::class, 'deleteList'])->name('leave.deleteList');
    Route::get('/admin/leave/{id}/restore',[Admin\LeaveRequestController::class, 'restore'])->name('leave.restore');

    Route::resource('/admin/salary',App\Http\Controllers\admin\SalaryController::class)->only('index','destroy');
    Route::get('/admin/salary/{id}/restore',[App\Http\Controllers\admin\SalaryController::class, 'restore'])->name('salary.restore');
    Route::get('/admin/salary/deleteList',[App\Http\Controllers\admin\SalaryController::class, 'deleteList'])->name('salary.deleteList');

    Route::get('/admin/role/index',[Admin\RoleController::class, 'index'])->name('role.index');
    Route::get('/admin/role/{role}/setPermission',[Admin\RoleController::class, 'permission'])->name('role.permission');
    Route::put('/admin/role/{role}/setPermission',[Admin\RoleController::class, 'set_permission'])->name('role.set_permission');
});

