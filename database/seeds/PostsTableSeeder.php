<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker::create();

        $userIds = DB::table('users')->pluck('id');
        $groupIds = DB::table('groups')->pluck('id');

        foreach (range(1, 100) as $index) {
            $userId = $fake->randomElement($userIds);
            $groupId = $fake->randomElement($groupIds);

            DB::table('posts')->insert([
                'user_id' => $userId,
                'group_id' => $groupId,
                'content' => $fake->paragraph,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ]);
        }
    }
}
