<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewTargetDatabaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `view_target_database`;');
        DB::statement('
            CREATE OR REPLACE VIEW `view_target_database` AS
            SELECT
                target_database.pmb COLLATE utf8mb4_general_ci AS pmb,
                target_database.identity_user COLLATE utf8mb4_general_ci AS identity_user,
                target_database.total AS total,
                COUNT(applicants.identity_user COLLATE utf8mb4_general_ci) AS realization
            FROM
                target_database
            LEFT JOIN
                applicants ON target_database.identity_user COLLATE utf8mb4_general_ci = applicants.identity_user COLLATE utf8mb4_general_ci
            GROUP BY
                target_database.pmb,
                target_database.identity_user,
                target_database.total;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `view_target_database`;');
    }
}
