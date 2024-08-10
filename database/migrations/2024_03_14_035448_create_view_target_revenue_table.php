<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewTargetRevenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `view_target_revenue`;');
        DB::statement('
            CREATE VIEW `view_target_revenue` AS
            SELECT
                target_revenue.id,
                target_revenue.pmb,
                target_revenue.identity_user,
                target_revenue.date,
                target_revenue.session,
                target_revenue.total,
                COUNT(status_applicants_registration.identity_user) AS realization,
                target_revenue.created_at,
                target_revenue.updated_at
            FROM
                target_revenue
            LEFT JOIN
                status_applicants_registration ON MONTH(status_applicants_registration.date) = MONTH(target_revenue.date)
            GROUP BY
                target_revenue.id,
                target_revenue.pmb,
                target_revenue.identity_user,
                target_revenue.date,
                target_revenue.session,
                target_revenue.total,
                target_revenue.created_at,
                target_revenue.updated_at;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `view_target_revenue`;');
    }
}
