<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ViewTargetRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            CREATE VIEW `target_registrations` AS
            SELECT
                target.id,
                target.pmb,
                target.identity_user,
                target.date,
                target.session,
                target.total,
                COUNT(status_applicants_registration.identity_user) AS realization,
                target.created_at,
                target.updated_at
            FROM
                target
            LEFT JOIN
                status_applicants_registration ON MONTH(status_applicants_registration.date) = MONTH(target.date)
            GROUP BY
                target.id,
                target.pmb,
                target.identity_user,
                target.date,
                target.session,
                target.total,
                target.created_at,
                target.updated_at;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS target_registrations');
    }
}
