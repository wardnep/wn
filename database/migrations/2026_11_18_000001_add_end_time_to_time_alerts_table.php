<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEndTimeToTimeAlertsTable extends Migration
{
    public function up()
    {
        Schema::table('time_alerts', function (Blueprint $table) {
            $table->string('end_time', 5)->nullable()->after('alert_time');
        });
    }

    public function down()
    {
        Schema::table('time_alerts', function (Blueprint $table) {
            $table->dropColumn('end_time');
        });
    }
}
