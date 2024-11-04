<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateViewDashboardSalesRevenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `dashboard_sales_revenue`;');
        DB::statement('
        CREATE OR REPLACE VIEW `dashboard_sales_revenue` AS
        SELECT
            target_revenue_by_presenter.pmb AS pmb,
            target_revenue_by_presenter.identity_user AS identity_user,
            target_revenue_by_presenter.name AS name,
            target_revenue_by_presenter.total AS target,
            COALESCE(registration_revenue_by_presenter.total, 0) AS realization
        FROM
            target_revenue_by_presenter
        LEFT JOIN registration_revenue_by_presenter
            ON registration_revenue_by_presenter.identity_user = target_revenue_by_presenter.identity_user
            AND registration_revenue_by_presenter.pmb = target_revenue_by_presenter.pmb
        GROUP BY
            target_revenue_by_presenter.pmb,
            target_revenue_by_presenter.identity_user,
            target_revenue_by_presenter.name,
            target_revenue_by_presenter.total;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `dashboard_sales_revenue`;');
    }
}
