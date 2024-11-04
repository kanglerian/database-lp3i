<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateViewRegistrationByPresenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `registration_by_presenter`;');
        DB::statement('
        CREATE OR REPLACE VIEW `registration_by_presenter` AS
        SELECT
            status_applicants_registration.pmb AS pmb,
            users.identity AS identity_user,
            users.name AS name,
            COUNT(status_applicants_registration.identity_user) AS total
        FROM
            status_applicants_registration
        LEFT JOIN applicants ON applicants.identity = status_applicants_registration.identity_user
        LEFT JOIN users ON users.identity = applicants.identity_user
        WHERE
            users.role = "P"
        GROUP BY
            pmb, identity_user;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `registration_by_presenter`;');
    }
}
