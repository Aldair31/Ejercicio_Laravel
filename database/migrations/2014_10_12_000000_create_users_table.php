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
            // $table->id();
            $table->string('codigo');
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->integer('sex')->nullable();
            $table->string('nationality')->nullable();
            $table->string('email');
            $table->string('photo')->nullable();
            $table->boolean('current')->nullable();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            $table->rememberToken();
            // $table->timestamps();
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
