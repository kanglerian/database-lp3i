<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusApplicantsEnrollmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_applicants_enrollment', function (Blueprint $table) {
            $table->id();
            $table->year('pmb');
            $table->string('identity_user', 50);
            $table->date('date');
            $table->integer('receipt');
            $table->string('register');
            $table->string('register_end');
            $table->integer('nominal');
            $table->date('repayment')->nullable();
            $table->integer('debit')->nullable();
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
        Schema::dropIfExists('status_applicants_enrollment');
    }
}
