<?php

use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\PermissionManagementController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\RoleManagementController;
use App\Http\Controllers\Backend\UserManagemenController;
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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::resource('/product', ProductController::class);
    Route::resource('/category', CategoryController::class);
    Route::resource('/permission', PermissionManagementController::class);
    Route::resource('/role', RoleManagementController::class);
    Route::resource('/user', UserManagemenController::class);
    Route::get('/user/{id}/edituser', [UserManagemenController::class, 'edituser'])->name('user.edituser');
    Route::put('/user/{id}/edituser', [UserManagemenController::class, 'updateuser'])->name('user.updateuser');
});

require __DIR__ . '/auth.php';
