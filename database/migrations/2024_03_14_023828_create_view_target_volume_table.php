<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewTargetVolumeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `view_target_volume`;');
        DB::statement('
            CREATE VIEW `view_target_volume` AS
            SELECT
                target_volume.id,
                target_volume.pmb,
                target_volume.identity_user,
                target_volume.date,
                target_volume.session,
                target_volume.total,
                COUNT(status_applicants_registration.identity_user) AS realization,
                target_volume.created_at,
                target_volume.updated_at
            FROM
                target_volume
            LEFT JOIN
                status_applicants_registration ON MONTH(status_applicants_registration.date) = MONTH(target_volume.date)
            GROUP BY
                target_volume.id,
                target_volume.pmb,
                target_volume.identity_user,
                target_volume.date,
                target_volume.session,
                target_volume.total,
                target_volume.created_at,
                target_volume.updated_at;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `view_target_volume`;');
    }
}
