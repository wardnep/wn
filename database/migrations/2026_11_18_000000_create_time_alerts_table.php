<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeAlertsTable extends Migration
{
    public function up()
    {
        Schema::create('time_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('alert_time', 5);
            $table->string('message')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('time_alerts');
    }
}
