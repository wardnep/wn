<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
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
        $journey_item->grade = $journey_item2->grade ?: '';
        $journey_item->image = $journey_item2->image ?: '';
        $journey_item->image2 = $journey_item2->image2 ?: '';
        $journey_item->note = $journey_item2->note ?: '';
        $journey_item->save();
    }

    dd('done');
});
