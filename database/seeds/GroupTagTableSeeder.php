<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GroupTagTableSeeder extends Seeder
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
        $tagIds = DB::table('tags')->pluck('id');

        foreach(range(1, 30) as $index){
            $groupId = $fake->randomElement($groupIds);
            $tagId = $fake->randomElement($tagIds);

            DB::table('group_tag')->updateOrInsert([
                'group_id' => $groupId,
                'tag_id' => $tagId
            ],[
                'group_id' => $groupId,
                'tag_id' => $tagId
            ]);
        }
    }
}
