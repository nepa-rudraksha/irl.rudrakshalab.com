<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnnameToIrlReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('irl_reports', function (Blueprint $table) {
            $table->string('SKU_no')->nullable(); // or integer, date, etc.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('irl_reports', function (Blueprint $table) {
            //
        });
    }
}
