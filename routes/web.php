<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Journey\HomeController;

Route::get('/', function () {
    // dd('https://wn.in.th');

    dd(get_current_user(), exec('whoami'));
});

Route::get('journey/summary_tp', [HomeController::class, 'summary_tp']);
Route::get('journey/summary_tp1/{exclude_asia}/{exclude_london}/{exclude_london_ny}/{exclude_ny}', [HomeController::class, 'summary_tp1']);
Route::get('journey/summary_tp2/{exclude_asia}/{exclude_london}/{exclude_london_ny}/{exclude_ny}', [HomeController::class, 'summary_tp2']);
Route::get('journey/image/{journey_id}/{journey_item_id}', [HomeController::class, 'image']);
Route::get('journey/download/{journey_id}', [HomeController::class, 'download']);
Route::get('journey/chart/{journey_id}/{exclude_asia?}', [HomeController::class, 'chart']);
Route::get('journey/chart1/{journey_id}/{exclude_asia?}', [HomeController::class, 'chart1']);
Route::get('journey/chart2/{journey_id}/{exclude_asia?}', [HomeController::class, 'chart2']);
Route::get('journey/chart3/{journey_id}/{exclude_asia?}', [HomeController::class, 'chart3']);
Route::get('journey/chart4/{journey_id}/{exclude_asia?}', [HomeController::class, 'chart4']);
Route::get('journey/chart5/{journey_id}', [HomeController::class, 'chart5']);
Route::get('journey/summary', [HomeController::class, 'summary']);
Route::post('journey/note', [HomeController::class, 'note']);
Route::get('journey/delete/{journey_id}/{edit_journey_item_id}', [HomeController::class, 'delete']);
Route::get('journey/{select_journey_id?}/{edit_journey_item_id?}/{sort_column?}/{sort_direction?}', [HomeController::class, 'index']);
Route::post('journey', [HomeController::class, 'storeOrUpdate']);
