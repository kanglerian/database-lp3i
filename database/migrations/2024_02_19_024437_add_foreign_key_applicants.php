<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyApplicants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->foreign('source_daftar_id')->references('id')->on('source_setting')->onDelete('restrict');
            $table->foreign('school')->references('id')->on('schools')->onDelete('restrict');
            $table->foreign('identity_user')->references('identity')->on('users')->onDelete('restrict');
            $table->foreign('source_id')->references('id')->on('source_setting')->onDelete('restrict');
            $table->foreign('status_id')->references('id')->on('applicants_status')->onDelete('restrict');
            $table->foreign('followup_id')->references('id')->on('followup')->onDelete('restrict');
            $table->foreign('programtype_id')->references('id')->on('program_type')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('applicants', function (Blueprint $table) {
        //     $table->dropForeign('applicants_source_id_foreign');
        //     $table->dropForeign('applicants_status_id_foreign');
        // });
    }
}
