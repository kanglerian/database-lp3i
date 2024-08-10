<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ViewApplicantsBySourceDaftar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `applicants_by_source_daftar_id`;');
        DB::statement('
            CREATE VIEW `applicants_by_source_daftar_id` AS
            SELECT
                source_daftar_id,
                COUNT(*) AS total
            FROM
                applicants
            GROUP BY
                source_daftar_id;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `applicants_by_source_daftar_id`;');
    }
}
