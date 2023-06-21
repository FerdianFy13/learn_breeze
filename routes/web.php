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

Route::group(['middleware' => ['role:Administrator|Contributor|Member|Super Administrator|Partner|Agency']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/super_admin.php';
