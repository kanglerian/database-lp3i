<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();

            $table->string('identity', 50)->nullable();
            $table->year('pmb')->nullable();

            $table->string('name', 150);
            $table->tinyInteger('gender')->nullable();
            $table->string('religion', 100)->nullable();
            $table->text('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->string('social_media')->nullable();

            $table->string('email', 100)->nullable()->unique();
            $table->string('phone', 20)->nullable()->unique();

            $table->string('education', 255)->nullable();
            $table->integer('school')->nullable();
            $table->string('major', 100)->nullable();
            $table->string('class', 100)->nullable();
            $table->year('year')->nullable();
            $table->text('achievement')->nullable();
            $table->text('kip')->nullable();
            $table->string('nisn')->nullable();
            $table->char('schoolarship', 1)->default('0');

            $table->text('note')->nullable();
            $table->text('relation')->nullable();

            $table->string('identity_user', 30)->nullable();
            $table->string('program', 255)->nullable();
            $table->string('program_second', 255)->nullable();
            $table->char('isread', 1)->default('0');
            $table->char('come', 1)->nullable();

            $table->char('is_applicant', 1)->default('0');
            $table->char('is_daftar', 1)->default('0');
            $table->char('is_register', 1)->default('0');

            $table->char('known', 1)->nullable();
            $table->string('planning')->nullable();
            $table->text('other_campus')->nullable();
            $table->string('income_parent')->nullable();

            $table->unsignedBigInteger('followup_id')->nullable();
            $table->unsignedBigInteger('programtype_id')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->unsignedBigInteger('status_id')->default(1);

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
        Schema::dropIfExists('applicants');
    }
}
