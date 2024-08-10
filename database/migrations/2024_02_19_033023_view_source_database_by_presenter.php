<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ViewSourceDatabaseByPresenter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `source_database_by_presenter`;');
        DB::statement('
            CREATE VIEW `source_database_by_presenter` AS
            SELECT
                applicants.pmb AS pmb,
                applicants.identity_user AS identity_user,
                users.name AS presenter,
                SUM(CASE WHEN applicants.source_id = 7 THEN 1 ELSE 0 END) AS presentasi,
                SUM(CASE WHEN applicants.source_id = 9 THEN 1 ELSE 0 END) AS grab,
                SUM(CASE WHEN applicants.source_id = 1 THEN 1 ELSE 0 END) AS website,
                SUM(CASE WHEN applicants.source_id = 2 THEN 1 ELSE 0 END) AS mgm,
                SUM(CASE WHEN applicants.source_id = 3 THEN 1 ELSE 0 END) AS sosmed,
                SUM(CASE WHEN applicants.source_id = 4 THEN 1 ELSE 0 END) AS sekolah,
                SUM(CASE WHEN applicants.source_id = 5 THEN 1 ELSE 0 END) AS jadwaldatang,
                SUM(CASE WHEN applicants.source_id = 6 THEN 1 ELSE 0 END) AS gurubk,
                SUM(CASE WHEN applicants.source_id = 8 THEN 1 ELSE 0 END) AS daftaronline,
                SUM(CASE WHEN applicants.source_id = 10 THEN 1 ELSE 0 END) AS beasiswa,
                SUM(CASE WHEN applicants.phone IS NOT NULL THEN 1 ELSE 0 END) AS valid,
                SUM(CASE WHEN applicants.phone IS NULL THEN 1 ELSE 0 END) AS nonvalid,
                COUNT(applicants.identity) AS jumlah
            FROM
                applicants
            LEFT JOIN
                users ON users.identity = applicants.identity_user
            GROUP BY
                identity_user, pmb, presenter;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `source_database_by_presenter`;');
    }
}
