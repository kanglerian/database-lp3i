<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateViewTargetRevenueByPresenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `target_revenue_by_presenter`;');
        DB::statement('
        CREATE OR REPLACE VIEW `target_revenue_by_presenter` AS
        SELECT
            target_revenue.pmb AS pmb,
            target_revenue.identity_user AS identity_user,
            users.name AS name,
            SUM(target_revenue.total) AS total
        FROM
            users
        LEFT JOIN target_revenue ON target_revenue.identity_user = users.identity
        WHERE
            users.role = "P"
        GROUP BY
            users.identity, target_revenue.pmb;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `target_revenue_by_presenter`;');
    }
}
