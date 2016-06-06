<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ModulesTakenTableSeeder extends Seeder
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
        $moduleIds = DB::table('modules')->pluck('id');

        foreach(range(1, 100) as $index){
            $userId = $fake->randomElement($userIds);
            $moduleId = $fake->randomElement($moduleIds);

            DB::table('modules_taken')->updateOrInsert([
                'user_id' => $userId,
                'module_id' => $moduleId
            ],[
                'user_id' =>$userId,
                'module_id' => $moduleId,
                'year_taken' => $fake->year,
                'semester_taken' => $fake->randomElement([1,2])
            ]);
        }
    }
}
