<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ViewReportByProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `report_register_by_program`;');
        DB::statement('
            CREATE VIEW `report_register_by_program` AS
            SELECT
            applicants.pmb AS pmb,
                applicants.identity_user AS identity_user,
            applicants.program AS program,
                SUM(CASE WHEN
                    applicants.is_register = 1 AND
                    applicants.programtype_id = 1 AND
                    applicants.schoolarship = 1
                    THEN 1 ELSE 0 END) as register_reguler_beasiswa,
                SUM(CASE WHEN
                    applicants.is_register = 1 AND
                    applicants.programtype_id = 1 AND
                    applicants.schoolarship = 0
                    THEN 1 ELSE 0 END) as register_reguler_nonbeasiswa,
                SUM(CASE WHEN
                    applicants.is_register = 1 AND
                    applicants.programtype_id = 2
                    THEN 1 ELSE 0 END) as register_nonreguler
            FROM
            applicants
            WHERE
            applicants.program IS NOT NULL
            GROUP BY
            pmb, identity_user, program;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `report_register_by_program`;');
    }
}
