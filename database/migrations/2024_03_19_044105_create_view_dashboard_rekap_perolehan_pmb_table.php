<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewDashboardRekapPerolehanPmbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `dashboard_rekap_perolehan_pmb`;');
        DB::statement('
        CREATE OR REPLACE VIEW `dashboard_rekap_perolehan_pmb` AS
        SELECT
            users.identity COLLATE utf8mb4_general_ci AS identity,
            users.name COLLATE utf8mb4_general_ci AS name,
            status_applicants_applicant.pmb COLLATE utf8mb4_general_ci AS pmb_applicant,
            status_applicants_enrollment.pmb COLLATE utf8mb4_general_ci AS pmb_enrollment,
            status_applicants_registration.pmb COLLATE utf8mb4_general_ci AS pmb_registration,
            COALESCE(COUNT(status_applicants_applicant.id), 0) AS applicant,
            COALESCE(COUNT(status_applicants_enrollment.id), 0) AS enrollment,
            COALESCE(COUNT(status_applicants_registration.id), 0) AS registration,
            COALESCE(SUM(status_applicants_registration.deal), 0) AS omzet
        FROM
            users
            LEFT JOIN applicants ON applicants.identity_user = users.identity
            LEFT JOIN status_applicants_applicant ON status_applicants_applicant.identity_user = applicants.identity
            LEFT JOIN status_applicants_enrollment ON status_applicants_enrollment.identity_user = applicants.identity
            LEFT JOIN status_applicants_registration ON status_applicants_registration.identity_user = applicants.identity
        WHERE
            users.role = "P"
        GROUP BY
            identity,
            name,
            pmb_applicant,
            pmb_enrollment,
            pmb_registration;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `dashboard_rekap_perolehan_pmb`;');
    }
}
