<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Existing alerts inherited the former 5-minute default; switch those to 4.
        DB::table('time_alerts')
            ->where('interval_minutes', 5)
            ->update(['interval_minutes' => 4]);
    }

    public function down(): void
    {
        // Do not overwrite per-alert interval choices when rolling back.
    }
};
