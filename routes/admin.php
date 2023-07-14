<?php

use App\Http\Controllers\Backend\LogoManagementController;
use App\Http\Controllers\Backend\PartnerManagementController;
use Illuminate\Support\Facades\Route;

// @administrator roles
Route::group(['middleware' => ['role:Administrator']], function () {
    Route::resource('/partner', PartnerManagementController::class);
    // Route::resource('/logo', LogoManagementController::class);
});
// end @administrator roles
