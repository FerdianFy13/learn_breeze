<?php

use App\Http\Controllers\Backend\AuctionController;
use App\Http\Controllers\Backend\AuctionPostController;
use App\Http\Controllers\Backend\FishermanController;
use App\Http\Controllers\Backend\InformationManagementController;
use App\Http\Controllers\Backend\ProductManagementController;
use App\Http\Controllers\Backend\TransactionAgencyController;
use Illuminate\Support\Facades\Route;

// @Supervisor roles
Route::group(['middleware' => ['role:Supervisor']], function () {
    Route::resource('/auction', AuctionController::class);
    Route::resource('/products', ProductManagementController::class);
});
// end @Supervisor roles
