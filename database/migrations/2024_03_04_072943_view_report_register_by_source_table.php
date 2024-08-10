<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ViewReportRegisterBySourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `report_register_by_source`;');
        DB::statement('
            CREATE VIEW `report_register_by_source` AS
            SELECT
                applicants.pmb AS pmb,
                applicants.identity_user AS identity_user,
                SUM(CASE WHEN applicants.is_register = 1 THEN 1 ELSE 0 END) as register,
                source_setting.name AS name
            FROM
                applicants
            LEFT JOIN
                users ON users.identity = applicants.identity_user
            LEFT JOIN
                source_setting ON source_setting.id = applicants.source_id
            WHERE
                applicants.is_register = 1
            GROUP BY
                pmb, identity_user, name;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `report_register_by_source`;');
    }
}
