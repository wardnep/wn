<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_alert_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled')->default(false);
        });

        DB::table('time_alert_settings')->insert(['id' => 1, 'enabled' => false]);
    }

    public function down(): void
    {
        Schema::dropIfExists('time_alert_settings');
    }
};
