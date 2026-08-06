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

    Route::get('journey/test', [JourneyController::class, 'test']);
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
    Route::get('journey/chart14/{journey_id}', [JourneyController::class, 'chart14']);
    Route::get('journey/summary', [JourneyController::class, 'summary']);
    Route::post('journey/note', [JourneyController::class, 'note']);
    Route::get('journey/delete/{journey_id}/{edit_journey_item_id}', [JourneyController::class, 'delete']);
    Route::get('journey/{select_journey_id?}/{edit_journey_item_id?}/{sort_column?}/{sort_direction?}', [JourneyController::class, 'index']);
    Route::post('journey', [JourneyController::class, 'storeOrUpdate']);

    Route::get('test', [TestController::class, 'index']);
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
});

Route::get('position_sizing', [PositionSizingController::class, 'index']);

Auth::routes(['register' => false]);

// Route::get('cvm', [CvmController::class, 'index']);

