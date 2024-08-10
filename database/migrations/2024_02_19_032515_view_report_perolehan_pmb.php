<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ViewReportPerolehanPmb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `report_students_admission`;');
        DB::statement('
            CREATE VIEW `report_students_admission` AS
            SELECT
                applicants.pmb,
                EXTRACT(MONTH FROM status_applicants_applicant.date) AS month_number,
                DATE_FORMAT(status_applicants_applicant.date, "%Y-%m") AS tanggal_aplikan,
                status_applicants_applicant.session AS session_aplikan,
                DATE_FORMAT(status_applicants_enrollment.date, "%Y-%m") AS tanggal_daftar,
                status_applicants_enrollment.session AS session_daftar,
                applicants.identity_user,
                applicants.programtype_id,
                users.name AS presenter,
                SUM(applicants.is_applicant) AS aplikan,
                SUM(applicants.is_daftar) AS daftar,
                SUM(applicants.is_register AND applicants.programtype_id = 1) AS register_regular,
                SUM(applicants.is_register AND applicants.programtype_id = 2) AS register_nonreguler,
                SUM(CASE WHEN applicants.programtype_id = 1 THEN status_applicants_registration.deal ELSE 0 END) AS omset_reguler,
                SUM(CASE WHEN applicants.programtype_id = 2 THEN status_applicants_registration.deal ELSE 0 END) AS omset_nonreguler,
                COUNT(applicants.identity) AS total
            FROM applicants
            LEFT JOIN users ON users.identity = applicants.identity_user
            LEFT JOIN status_applicants_applicant ON status_applicants_applicant.identity_user = applicants.identity
            LEFT JOIN status_applicants_enrollment ON status_applicants_enrollment.identity_user = applicants.identity
            LEFT JOIN status_applicants_registration ON status_applicants_registration.identity_user = applicants.identity
            WHERE
                status_applicants_applicant.date IS NOT NULL
                AND EXTRACT(MONTH FROM status_applicants_applicant.date) IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10)
            GROUP BY
                applicants.pmb, month_number, tanggal_aplikan, session_aplikan, tanggal_daftar, session_daftar, applicants.identity_user, applicants.programtype_id, presenter
            ORDER BY
                applicants.pmb, month_number
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `report_students_admission`;');
    }
}
