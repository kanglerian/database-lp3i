<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusApplicantsApplicantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_applicants_applicant', function (Blueprint $table) {
            $table->id();
            $table->year('pmb');
            $table->string('identity_user', 50);
            $table->date('date');
            $table->tinyInteger('session');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_applicants_applicant');
    }
}
