<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsFamilyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants_family', function (Blueprint $table) {
            $table->id();
            $table->string('identity_user', 50)->nullable();
            $table->string('name', 150)->nullable();
            $table->string('job', 150)->nullable();
            $table->string('phone', 20)->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('education', 20)->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('applicants_family');
    }
}
