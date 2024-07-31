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
        DB::statement('
            CREATE VIEW `view_target_database` AS
            SELECT
                target_database.pmb,
                target_database.identity_user,
                target_database.total,
                COUNT(applicants.identity_user) AS realization
            FROM
                target_database
            LEFT JOIN
                applicants ON target_database.identity_user = applicants.identity_user
            GROUP BY
                target_database.pmb,
                target_database.identity_user,
                target_database.total
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
