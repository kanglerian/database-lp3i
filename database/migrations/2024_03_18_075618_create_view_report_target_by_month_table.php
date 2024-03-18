<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewReportTargetByMonthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
        CREATE VIEW `view_report_target_by_month` AS
        SELECT
            date_volume,
            date_revenue,
            SUM(pmb_volume) AS pmb_volume,
            SUM(pmb_revenue) AS pmb_revenue,
            SUM(session_volume) AS session_volume,
            SUM(session_revenue) AS session_revenue,
            SUM(target_volume) AS target_volume,
            SUM(realization_volume) AS realization_volume,
            SUM(target_revenue) AS target_revenue,
            SUM(realization_revenue) AS realization_revenue
        FROM
            (
                SELECT
                    target_volume.pmb AS pmb_volume,
                    target_revenue.pmb AS pmb_revenue,
                    target_volume.session AS session_volume,
                    target_revenue.session AS session_revenue,
                    EXTRACT(
                        MONTH
                        FROM
                            target_volume.date
                    ) AS date_volume,
                    EXTRACT(
                        MONTH
                        FROM
                            target_revenue.date
                    ) AS date_revenue,
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
                    pmb_volume,
                    pmb_revenue,
                    date_volume,
                    date_revenue,
                    session_volume,
                    session_revenue,
                    target_volume.total,
                    target_revenue.total
                ) AS subquery
            GROUP BY
                pmb_volume,
                pmb_revenue,
                date_volume,
                date_revenue,
                session_volume,
                session_revenue;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_report_target_by_month');
    }
}
