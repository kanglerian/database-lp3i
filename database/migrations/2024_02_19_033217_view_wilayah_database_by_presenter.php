<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ViewWilayahDatabaseByPresenter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `wilayah_database_by_presenter`;');
        DB::statement('
            CREATE VIEW `wilayah_database_by_presenter` AS
            SELECT
                applicants.pmb AS pmb,
                applicants.identity_user AS identity_user,
                users.name AS presenter,
                SUM(CASE WHEN schools.region = "KAB. TASIKMALAYA" THEN 1 ELSE 0 END) AS kabtasikmalaya,
                SUM(CASE WHEN schools.region = "TASIKMALAYA" THEN 1 ELSE 0 END) AS tasikmalaya,
                SUM(CASE WHEN schools.region = "CIAMIS" THEN 1 ELSE 0 END) AS ciamis,
                SUM(CASE WHEN schools.region = "BANJAR" THEN 1 ELSE 0 END) AS banjar,
                SUM(CASE WHEN schools.region = "GARUT" THEN 1 ELSE 0 END) AS garut,
                SUM(CASE WHEN schools.region = "PANGANDARAN" THEN 1 ELSE 0 END) AS pangandaran,
                SUM(CASE WHEN schools.region = "TIDAK DIKETAHUI" THEN 1 ELSE 0 END) AS tidakdiketahui,
                COUNT(applicants.identity) AS jumlah
            FROM
                applicants
            LEFT JOIN
                users ON users.identity = applicants.identity_user
            LEFT JOIN
                schools ON schools.id = applicants.school
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
        DB::statement('DROP VIEW IF EXISTS `wilayah_database_by_presenter`;');
    }
}
