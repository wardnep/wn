<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePriceLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('price_levels', function (Blueprint $table) {
            $table->boolean('active')->default(true)->change();
            $table->text('message')->after('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_levels', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('message');
        });
    }
}
