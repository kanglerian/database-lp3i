<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ViewApplicantsBySource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `applicants_by_source_id`;');

        DB::statement('
            CREATE VIEW `applicants_by_source_id` AS
            SELECT
                source_id,
            COUNT(*) AS total
            FROM
                applicants
            GROUP BY
                source_id;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `applicants_by_source_id`;');
    }
}
