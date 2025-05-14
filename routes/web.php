<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\ItemReturnController;
use App\Http\Controllers\LocationDetailController;

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
Route::get('/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/register', [AdminController::class, 'register'])->name('submit-register');

// Halaman login (untuk semua role)
Route::get('/', [AuthController::class, 'showLoginForm'])->name('show-login');
Route::post('/login', [AuthController::class, 'login'])->name('submit-login');

Route::middleware(['auth'])->group(function() {
    Route::get('/home/user', [UserController::class, 'index'])->name('show-home-user'); 
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::get('/user/loans/create/{item_id}', [UserController::class, 'createLoan'])->name('user.loans.create');
    Route::get('/loans/{loan}/return', [LoanController::class, 'returnForm'])->name('loans.return.form');
    Route::get('/returns/create/{loan_id}', [ItemReturnController::class, 'create'])->name('returns.create');
    Route::post('/returns/store/{loan_id}', [ItemReturnController::class, 'store'])->name('returns.store');
    Route::post('/loans/{loan}/return', [LoanController::class, 'processReturn'])->name('loans.return');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'isAdmin'])->group(function() {
    Route::get('/admin/dashboard', [AdminController::class, 'showDashboard'])->name('show-dashboard-admin');
    Route::resource('/admin/users', UserAdminController::class);
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/items', ItemController::class);
    Route::get('/admin/items/get-location-details/{locationId}', [ItemController::class, 'getLocationDetails']);
    Route::resource('/admin/locations', LocationController::class);
    Route::resource('/admin/location-details', LocationDetailController::class);
    Route::post('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::post('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('loans.reject');
    Route::get('/admin/returns', [ItemReturnController::class, 'index'])->name('returns.index');
    Route::post('/returns/{id}/approve', [ItemReturnController::class, 'approve'])->name('admin.returns.approve');
    Route::post('/returns/{id}/reject', [ItemReturnController::class, 'reject'])->name('admin.returns.reject');
    Route::get('/admin/returns/create/{loan_id}', [ItemReturnController::class, 'adminCreate'])->name('admin.returns.create');
    Route::post('/admin/returns/store/{loan_id}', [ItemReturnController::class, 'adminStore'])->name('admin.returns.store');

});