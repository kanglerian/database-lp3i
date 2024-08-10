<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ViewReportRegisterBySchoolYear extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `report_register_by_school_year`;');
        DB::statement('
            CREATE VIEW `report_register_by_school_year` AS
            SELECT
                applicants.pmb AS pmb,
                applicants.year AS year,
                applicants.identity_user AS identity_user,
                SUM(CASE WHEN applicants.is_register = 1 THEN 1 ELSE 0 END) as register,
                schools.name AS name,
                schools.lat AS lat,
                schools.lng AS lng
            FROM
                applicants
            LEFT JOIN
                schools ON schools.id = applicants.school
            WHERE
                schools.region IS NOT NULL AND schools.status IS NOT NULL AND schools.type IS NOT NULL AND applicants.is_register = 1
            GROUP BY
                pmb, year, identity_user, name
            ORDER BY
                pmb DESC, year DESC;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `report_register_by_school_year`;');
    }
}
