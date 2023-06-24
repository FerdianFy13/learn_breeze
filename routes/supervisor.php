<?php

use App\Http\Controllers\Backend\AuctionPostController;
use App\Http\Controllers\Backend\FishermanController;
use Illuminate\Support\Facades\Route;

// @Supervisor roles
Route::group(['middleware' => ['role:Supervisor']], function () {
    Route::resource('/fisherman', FishermanController::class);
    Route::resource('/post', AuctionPostController::class);
});
// end @Supervisor roles
