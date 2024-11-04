<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateViewDashboardDatabaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `dashboard_database`;');
        DB::statement('
        CREATE OR REPLACE VIEW `dashboard_database` AS
        SELECT
            target_database_by_presenter.pmb AS pmb,
            target_database_by_presenter.identity_user AS identity_user,
            target_database_by_presenter.name AS name,
            target_database_by_presenter.total AS target,
            COALESCE(COUNT(applicants.identity_user), 0) AS realization
        FROM
            target_database_by_presenter
        LEFT JOIN applicants
            ON applicants.identity_user = target_database_by_presenter.identity_user
            AND applicants.pmb = target_database_by_presenter.pmb
        GROUP BY
            target_database_by_presenter.pmb,
            target_database_by_presenter.identity_user,
            target_database_by_presenter.name,
            target_database_by_presenter.total;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `dashboard_database`;');
    }
}
