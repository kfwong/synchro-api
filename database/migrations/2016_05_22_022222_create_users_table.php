<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->increments('id');
            $table->string('ivle_id');
            $table->string('name');
            $table->text('intro');
            $table->string('email')->unique();
            $table->string('gender');
            $table->string('faculty');
            $table->string('first_major');
            $table->string('second_major');
            $table->string('matriculation_year');
            $table->dateTime('last_seen_at');
            $table->dateTime('last_sync_at');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints
        Schema::drop('users');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
    }
}
