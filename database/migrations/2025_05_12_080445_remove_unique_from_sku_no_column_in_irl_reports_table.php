<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueFromSkuNoColumnInIrlReportsTable extends Migration
{
    public function up()
    {
        Schema::table('irl_reports', function (Blueprint $table) {
            // 🧠 Drop index by actual name
            $table->dropIndex('SKU_no');
        });
    }

    public function down()
    {
        Schema::table('irl_reports', function (Blueprint $table) {
            $table->unique('SKU_no'); // Add it back in rollback
        });
    }
}

