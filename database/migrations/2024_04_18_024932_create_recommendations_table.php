<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('identity_user', 50);
            $table->string('name');
            $table->string('phone', 20)->nullable();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->string('class', 100)->nullable();
            $table->year('year')->nullable();
            $table->text('plan')->nullable();
            $table->string('income_parent')->nullable();
            $table->text('address')->nullable();
            $table->string('parent_phone', 20)->nullable();
            $table->string('parent_job')->nullable();
            $table->text('reference')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('recommendations');
    }
}
