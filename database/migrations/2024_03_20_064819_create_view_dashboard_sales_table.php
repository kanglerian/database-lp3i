<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewDashboardSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE VIEW `dashboard_sales` AS
        SELECT
            users.identity AS identity,
            target_volume.pmb AS pmb_volume,
            target_revenue.pmb AS pmb_revenue,
            users.name AS name,
            COALESCE(target_volume.total, 0) AS target_volume,
            COALESCE(COUNT(status_applicants_registration.id), 0) AS realization_volume,
            COALESCE(target_revenue.total, 0) AS target_revenue,
            COALESCE(SUM(status_applicants_registration.deal), 0) AS realization_revenue
        FROM
            users
            LEFT JOIN target_volume ON target_volume.identity_user = users.identity
            LEFT JOIN applicants ON applicants.identity_user = users.identity
            LEFT JOIN status_applicants_registration ON status_applicants_registration.identity_user = applicants.identity
            LEFT JOIN target_revenue ON target_revenue.identity_user = users.identity
        WHERE
            users.role = "P"
        GROUP BY
            identity,
            pmb_volume,
            pmb_revenue;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `dashboard_sales`;');
    }
}
