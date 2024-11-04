<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateViewTargetDatabaseByPresenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `target_database_by_presenter`;');
        DB::statement('
        CREATE OR REPLACE VIEW `target_database_by_presenter` AS
        SELECT
            target_database.pmb AS pmb,
            target_database.identity_user AS identity_user,
            users.name AS name,
            SUM(target_database.total) AS total
        FROM
            users
        LEFT JOIN target_database ON target_database.identity_user = users.identity
        WHERE
            users.role = "P"
        GROUP BY
            users.identity, target_database.pmb;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `target_database_by_presenter`;');
    }
}
