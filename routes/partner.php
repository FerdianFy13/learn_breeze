<?php

use App\Http\Controllers\Backend\AuctionDailyController;
use Illuminate\Support\Facades\Route;

// @partner roles
Route::group(['middleware' => ['role:Partner']], function () {
    Route::resource('/auctioneer', AuctionDailyController::class);
});
// end @partner roles
