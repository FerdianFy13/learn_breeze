<?php

use App\Http\Controllers\Backend\FishermanController;
use Illuminate\Support\Facades\Route;

// @Supervisor roles
Route::group(['middleware' => ['role:Supervisor']], function () {
    Route::resource('/fisherman', FishermanController::class);
});
// end @Supervisor roles
