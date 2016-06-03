<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('group_tag', function(Blueprint $table){
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('tag_id');

            $table->foreign('group_id')
                ->references('id')
                ->on('groups');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags');

            $table->unique(['group_id', 'tag_id']);
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
        Schema::drop('group_tag');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints
    }
}
