<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToFileUploadOnTableUsersUpload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_upload', function (Blueprint $table) {
            $table->foreign('fileupload_id')->references('id')->on('file_upload')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_upload', function (Blueprint $table) {
            $table->dropForeign('users_upload_fileupload_id_foreign');
        });
    }
}
