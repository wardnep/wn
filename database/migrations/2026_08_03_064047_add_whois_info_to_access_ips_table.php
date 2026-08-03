<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWhoisInfoToAccessIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('access_ips', function (Blueprint $table) {
            $table->string('isp')->nullable()->after('ip');
            $table->string('org')->nullable()->after('isp');
            $table->string('country')->nullable()->after('org');
            $table->string('city')->nullable()->after('country');
            $table->text('whois_raw')->nullable()->after('city'); // เก็บ JSON เต็มๆ เผื่อใช้ทีหลัง
            $table->timestamp('whois_checked_at')->nullable()->after('whois_raw');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('access_ips', function (Blueprint $table) {
            //
        });
    }
}
