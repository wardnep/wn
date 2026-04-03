<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJourneyItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journey_items', function (Blueprint $table) {
            $table->id();
            $table->integer('journey_id');
            $table->string('date');
            $table->string('entry_session');
            $table->string('exit_session');
            $table->string('position');
            $table->string('result');
            $table->string('size');
            $table->string('tp1');
            $table->string('tp2');
            $table->string('result_r1');
            $table->string('result_r2');
            $table->string('grade');
            $table->string('image');
            $table->string('image2');
            $table->longText('note');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journey_items');
    }
}
