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

Route::group(['middleware' => ['role:Administrator|Member|Super Administrator|Partner|Agency|Supervisor']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

Route::group(['middleware' => ['role:Administrator|Super Administrator']], function () {
    Route::resource('/user', UserManagemenController::class);
    Route::get('/user/{id}/edituser', [UserManagemenController::class, 'edituser'])->name('user.edituser');
    Route::put('/user/{id}/edituser', [UserManagemenController::class, 'updateuser'])->name('user.updateuser');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/super_admin.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/supervisor.php';
