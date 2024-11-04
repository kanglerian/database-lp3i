<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \Illuminate\Support\Facades\DB;

class CreateViewTargetByPresenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS `target_volume_by_presenter`;');
        DB::statement('
        CREATE OR REPLACE VIEW `target_volume_by_presenter` AS
        SELECT
            target_volume.pmb AS pmb,
            target_volume.identity_user AS identity_user,
            users.name AS name,
            SUM(target_volume.total) AS total
        FROM
            users
        LEFT JOIN target_volume ON target_volume.identity_user = users.identity
        WHERE
            users.role = "P"
        GROUP BY
            users.identity, target_volume.pmb;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS `target_volume_by_presenter`;');
    }
}
