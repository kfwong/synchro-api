<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTakenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules_taken', function(Blueprint $table){
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('module_id');
            $table->unsignedInteger('year_taken');
            $table->unsignedInteger('semester_taken');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('module_id')
                ->references('id')
                ->on('modules');
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
        Schema::drop('modules_taken');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
    }
}
