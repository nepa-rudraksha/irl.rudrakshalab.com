<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueFromSkuNoColumnInIrlReportsTable extends Migration
{
    public function up()
    {
        Schema::table('irl_reports', function (Blueprint $table) {
            $table->dropUnique(['SKU_no']); // remove unique index
        });
    }

    public function down()
    {
        Schema::table('irl_reports', function (Blueprint $table) {
            $table->unique('SKU_no'); // add it back in rollback
        });
    }
}

