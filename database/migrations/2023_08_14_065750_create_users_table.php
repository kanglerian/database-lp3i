<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('identity', 30)->nullable()->unique();
            $table->string('avatar', 100)->nullable();
            $table->string('name', 150);
            $table->string('email', 100)->nullable()->unique();
            $table->string('phone', 20)->nullable()->unique();
            $table->char('role', 1);
            $table->string('password', 255);
            $table->char('status', 1)->default('1');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
