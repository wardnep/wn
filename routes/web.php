<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\SQLController;
use App\Http\Controllers\QuantController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\PositionSizingController;
use App\Http\Controllers\CVM\CvmController;

Route::get('/', [HomeController::class, 'index']);

Route::middleware(['auth'])->group(function () {
    Route::get('alert/{edit_price_level_id?}', [AlertController::class, 'index']);
    Route::post('alert', [AlertController::class, 'storeOrUpdate']);
    Route::get('alert/delete/{alert_id}', [AlertController::class, 'delete']);

    Route::get('quant', [QuantController::class, 'index']);
    Route::get('quant/logs', [QuantController::class, 'logs']);

    Route::get('/calendar/{journey_id}', [CalendarController::class, 'index']);
    Route::get('/calendar/{journey_id}/events', [CalendarController::class, 'events']);
    Route::get('/calendar/{journey_id}/month-summary', [CalendarController::class, 'monthSummary']);

    Route::get('journey/image/{journey_id}/{journey_item_id}', [JourneyController::class, 'image']);
    Route::get('journey/chart/{journey_id}', [JourneyController::class, 'chart']);
    Route::post('journey/note', [JourneyController::class, 'note']);
    Route::post('journey/default', [JourneyController::class, 'default']);
    Route::get('journey/delete/{journey_id}/{edit_journey_item_id}', [JourneyController::class, 'delete']);
    Route::get('journey/{select_journey_id?}/{edit_journey_item_id?}/{sort_column?}/{sort_direction?}', [JourneyController::class, 'index']);
    Route::post('journey', [JourneyController::class, 'storeOrUpdate']);

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
});

Route::get('position_sizing', [PositionSizingController::class, 'index']);

Auth::routes(['register' => false]);
