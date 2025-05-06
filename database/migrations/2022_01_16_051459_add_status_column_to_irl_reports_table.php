<?php

use App\Models\IrlReport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnToIrlReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('irl_reports', function (Blueprint $table) {
            $table->tinyInteger('status')->after('reference_no')->default(IrlReport::DRAFT);
            //
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
            $table->dropColumn('status');
        });
    }
}
