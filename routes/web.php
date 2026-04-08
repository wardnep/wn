<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\SQLController;

Route::get('/', [HomeController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::get('sql', [SQLController::class, 'index']);
    Route::post('execution', [SQLController::class, 'execution']);

    Route::get('journey/summary_tp', [JourneyController::class, 'summary_tp']);
    Route::get('journey/summary_tp1/{exclude_asia}/{exclude_london}/{exclude_london_ny}/{exclude_ny}', [JourneyController::class, 'summary_tp1']);
    Route::get('journey/summary_tp2/{exclude_asia}/{exclude_london}/{exclude_london_ny}/{exclude_ny}', [JourneyController::class, 'summary_tp2']);
    Route::get('journey/image/{journey_id}/{journey_item_id}', [JourneyController::class, 'image']);
    Route::get('journey/download/{journey_id}', [JourneyController::class, 'download']);
    Route::get('journey/chart/{journey_id}/{exclude_asia?}', [JourneyController::class, 'chart']);
    Route::get('journey/chart1/{journey_id}/{exclude_asia?}', [JourneyController::class, 'chart1']);
    Route::get('journey/chart2/{journey_id}/{exclude_asia?}', [JourneyController::class, 'chart2']);
    Route::get('journey/chart3/{journey_id}/{exclude_asia?}', [JourneyController::class, 'chart3']);
    Route::get('journey/chart4/{journey_id}/{exclude_asia?}', [JourneyController::class, 'chart4']);
    Route::get('journey/chart5/{journey_id}', [JourneyController::class, 'chart5']);
    Route::get('journey/summary', [JourneyController::class, 'summary']);
    Route::post('journey/note', [JourneyController::class, 'note']);
    Route::get('journey/delete/{journey_id}/{edit_journey_item_id}', [JourneyController::class, 'delete']);
    Route::get('journey/{select_journey_id?}/{edit_journey_item_id?}/{sort_column?}/{sort_direction?}', [JourneyController::class, 'index']);
    Route::post('journey', [JourneyController::class, 'storeOrUpdate']);
});

Auth::routes(['register' => false]);
