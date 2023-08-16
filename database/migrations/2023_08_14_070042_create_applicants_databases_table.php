<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateApplicantsDatabasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE VIEW applicants_databases AS
            SELECT
                source_setting.id AS id,
                source_setting.name AS name,
                COUNT(applicants.source) AS count
            FROM
                source_setting
            LEFT JOIN
                applicants
            ON
                source_setting.id = applicants.source
            GROUP BY
                source_setting.id,
                source_setting.name;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP VIEW IF EXISTS applicants_databases;');
    }
}
