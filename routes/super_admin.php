<?php


use App\Http\Controllers\Backend\RoleManagementController;
use App\Http\Controllers\Backend\UserManagemenController;
use Illuminate\Support\Facades\Route;

// @super administrator roles
Route::group(['middleware' => ['role:Super Administrator']], function () {
    Route::resource('/role', RoleManagementController::class);
    Route::resource('/user', UserManagemenController::class);
    Route::get('/user/{id}/edituser', [UserManagemenController::class, 'edituser'])->name('user.edituser');
    Route::put('/user/{id}/edituser', [UserManagemenController::class, 'updateuser'])->name('user.updateuser');
});
// end @super administrator roles
