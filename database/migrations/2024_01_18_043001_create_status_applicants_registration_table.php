<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusApplicantsRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_applicants_registration', function (Blueprint $table) {
            $table->id();
            $table->year('pmb');
            $table->string('identity_user', 50);
            $table->date('date');
            $table->integer('nominal');
            $table->integer('deal');
            $table->integer('discount')->nullable();
            $table->string('desc_discount')->nullable();
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
        Schema::dropIfExists('status_applicants_registration');
    }
}
