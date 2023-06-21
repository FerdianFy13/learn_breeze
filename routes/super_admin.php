<?php


use App\Http\Controllers\Backend\RoleManagementController;
use Illuminate\Support\Facades\Route;

// @super administrator roles
Route::group(['middleware' => ['role:Super Administrator']], function () {
    Route::resource('/role', RoleManagementController::class);
});
// end @super administrator roles
