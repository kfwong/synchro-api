<?php

use Illuminate\Database\Seeder;
use \Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

        DB::table('users')->truncate();
        DB::table('groups')->truncate();
        DB::table('group_user')->truncate();
        DB::table('tags')->truncate();
        DB::table('group_tag')->truncate();
        DB::table('modules')->truncate();
        DB::table('modules_taken')->truncate();

        $this->call(UsersTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(GroupUserTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(GroupTagTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        $this->call(ModulesTakenTableSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints

        Model::reguard();
    }
}
