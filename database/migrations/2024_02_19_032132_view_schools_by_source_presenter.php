<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ViewSchoolsBySourcePresenter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `schools_by_source_presenter`;');
        DB::statement('
            CREATE VIEW `schools_by_source_presenter` AS
            SELECT
                schools.id AS id,
                schools.region AS wilayah,
                schools.name AS nama,
                applicants.identity_user AS identity_user,
                users.name as presenter,
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
                COUNT(DISTINCT applicants.major) AS kelas,
                COUNT(applicants.major) AS jumlah
            FROM
                schools
            LEFT JOIN
                applicants ON schools.id = applicants.school
            LEFT JOIN
                users ON users.identity = applicants.identity_user
            GROUP BY
                schools.id, schools.region, schools.name, applicants.identity_user;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `schools_by_source_presenter`;');
    }
}
