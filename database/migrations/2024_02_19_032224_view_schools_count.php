<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ViewSchoolsCount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `schools_by_region`;');
        DB::statement('
            CREATE VIEW `schools_by_region` AS
                SELECT region,
                COUNT(*) AS jumlah
            FROM
                schools
            GROUP BY
                region;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `schools_by_region`;');
    }
}
