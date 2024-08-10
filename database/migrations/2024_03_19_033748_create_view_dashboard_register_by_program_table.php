<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewDashboardRegisterByProgramTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `dashboard_register_by_program`;');
        DB::statement('
            CREATE VIEW `dashboard_register_by_program` AS
            SELECT
            applicants.pmb AS pmb,
            applicants.program AS program,
                SUM(CASE WHEN
                    applicants.is_register = 1 AND
                    applicants.programtype_id = 1
                    THEN 1 ELSE 0 END) as register_reguler,
                SUM(CASE WHEN
                    applicants.is_register = 1 AND
                    applicants.programtype_id = 2
                    THEN 1 ELSE 0 END) as register_nonreguler
            FROM
            applicants
            WHERE
            applicants.program IS NOT NULL
            GROUP BY
            pmb, program;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `dashboard_register_by_program`;');
    }
}
