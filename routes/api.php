<?php

use App\Domains\Authentication\Controllers\AuthenticationController;
use App\Domains\Department\Controllers\DepartmentController;
use App\Domains\Employee\Controllers\EmployeeController;
use App\Domains\Finance\Controllers\ExpenseController;
use App\Domains\Finance\Controllers\InvoiceController;
use App\Domains\Leave\Controllers\LeaveController;
use App\Domains\Project\Controllers\ProjectController;
use App\Domains\Project\Controllers\TaskController;
use App\Domains\Tenant\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

Route::post('/base/register', [AuthenticationController::class, 'register'])->name('register.base');
Route::post('/base/login', [AuthenticationController::class, 'login'])->name('login.base');

Route::middleware(['auth:landlord-api'])->group(function () {
    // routes
    Route::apiResource('tenants', TenantController::class)->except('show');

});

Route::middleware('tenant')->group(function () {
    Route::get('/', function () {
        dd(app('currentTenant')->name);

        return view('welcome');
    });
    Route::post('/register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login');

});

Route::middleware(['tenant', 'auth:tenant-api'])->group(function () {

    // departments
    Route::apiResource('departments', DepartmentController::class)->except('show');

    // employees
    Route::apiResource('employees', EmployeeController::class)->parameters(['employees' => 'user'])->except('show');

    // leaves
    Route::get('/leaves/employee/list', [LeaveController::class, 'employeeLeaveRequestsList'])->name('leaves.employee.list');
    Route::get('/leaves/admin/list', [LeaveController::class, 'adminLeaveRequestsList'])->name('leaves.admin.list');
    Route::put('/leaves/{leave}/status/change', [LeaveController::class, 'changeStatus'])->name('leaves.status.change');
    Route::apiResource('leaves', LeaveController::class)->parameters(['leaves' => 'leave'])->except('show', 'index');

    // invoices
    Route::put('/invoices/{invoice}/status/change', [InvoiceController::class, 'changeStatus'])->name('.status.change');
    Route::apiResource('invoices', InvoiceController::class)->except('show');

    // expenses
    Route::apiResource('expenses', ExpenseController::class)->except('show');

    Route::apiResource('projects', ProjectController::class)->except('show');
    Route::apiResource('projects.tasks', TaskController::class)->except('show');

});
