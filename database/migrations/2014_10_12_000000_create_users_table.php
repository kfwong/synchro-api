<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('email')->unique();
            $table->string('gender');
            $table->string('faculty');
            $table->string('first_major');
            $table->string('second_major');
            $table->string('matriculation_year');
            $table->text('modules_taken'); // json
            $table->text('timetable'); // json
            $table->timestamps();
        });    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
