<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Journey\HomeController;

Route::get('/', function () {
    // dd('https://wn.in.th');

    App\Models\JourneyItem::truncate();
    $journey_item2s = App\Models\JourneyItem2::all();
    foreach ($journey_item2s as $journey_item2) {
        $journey_item = new App\Models\JourneyItem;
        $journey_item->journey_id = $journey_item2->journey_id ?: '';
        $journey_item->date = $journey_item2->date ?: '';
        $journey_item->entry_session = $journey_item2->entry_session ?: '';
        $journey_item->exit_session = $journey_item2->exit_session ?: '';
        $journey_item->position = $journey_item2->position ?: '';
        $journey_item->result = $journey_item2->result ?: '';
        $journey_item->size = $journey_item2->size ?: '';
        $journey_item->tp1 = $journey_item2->tp1 ?: '';
        $journey_item->tp2 = $journey_item2->tp2 ?: '';
        $journey_item->result_r1 = $journey_item2->result_r1 ?: '';
        $journey_item->result_r2 = $journey_item2->result_r2 ?: '';
        $journey_item->result_r2 = $journey_item2->result_r2 ?: '';
        $journey_item->strategy = $journey_item2->strategy ?: '';
        $journey_item->grade = $journey_item2->grade ?: '';
        $journey_item->image = $journey_item2->image ?: '';
        $journey_item->image2 = $journey_item2->image2 ?: '';
        $journey_item->note = $journey_item2->note ?: '';
        $journey_item->save();
    }

    dd('done');
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
