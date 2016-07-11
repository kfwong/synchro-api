<?php

use App\Group;
use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GroupUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Faker::create();

        $groupIds = DB::table('groups')->pluck('id');
        $userIds = DB::table('users')->pluck('id');

        foreach(range(1, 60) as $index){
            $groupId = $fake->randomElement($groupIds);
            $userId = $fake->randomElement($userIds);
            $isAdmin = $fake->boolean();

            // http://stackoverflow.com/questions/31624473/laravel-5-1-create-or-update-on-duplicate
            DB::table('group_user')->updateOrInsert([
                'group_id' => $groupId,
                'user_id' => $userId,
            ],[
                'group_id' => $groupId,
                'user_id' => $userId,
                'is_admin' => $isAdmin
            ]);
        }
    }
}
