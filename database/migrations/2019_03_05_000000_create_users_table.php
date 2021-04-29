<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 25);
            $table->string('email', 50)->unique();
            $table->string('phone', 50)->unique();
            $table->string('country', 25)->nullable();
            $table->string('class', 25)->nullable();
            $table->boolean('prefect')->nullable();
            $table->string('prefect_title', 25)->nullable();
            $table->string('house', 25)->nullable();
            $table->string('password')->nullable();
            $table->boolean('member')->default(false);
            $table->string('photo_path', 100)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
