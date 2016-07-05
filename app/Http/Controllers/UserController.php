<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Module;
use App\ModuleTaken;
use App\User;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show($user_id)
    {
        return User::find($user_id);
    }

    public function groups($user_id)
    {
        return User::find($user_id)->groups;
    }

    // return current authenticated user profile
    public function me(Request $request)
    {
        $ivle_id = $request->session()->get("ivle_id");

        return User::where('ivle_id', $ivle_id)->first();
    }

    // return groups that belong to the current authenticated user
    public function meGroups(Request $request)
    {
        $ivle_id = $request->session()->get("ivle_id");

        return User::where('ivle_id', $ivle_id)->first()->groups;
    }

    public function meJoinGroup($group_id, Request $request){
        $ivle_id = $request->session()->get("ivle_id");

        $me = User::where('ivle_id', $ivle_id)->first();

        $me->groups()->attach($group_id);

        return \Response::json([
            'message' => 'User ' . $ivle_id . ' joined group ' . $group_id
        ], Response::HTTP_OK, []);
    }

    public function meLeaveGroup($group_id, Request $request){
        $ivle_id = $request->session()->get("ivle_id");

        $me = User::where('ivle_id', $ivle_id)->first();

        $me->groups()->detach($group_id);

        return \Response::json([
            'message' => 'User ' . $ivle_id . ' left group ' . $group_id
        ], Response::HTTP_OK, []);
    }

    public function meModulesTaken(Request $request){
        $ivle_id = $request->session()->get("ivle_id");

        // Laravel Eloquent Eager Loading
        // the relation model will be embedded into the result with a single call
        // https://laravel.com/docs/5.0/eloquent#eager-loading
        return User::with('modulesTaken.module')->where('ivle_id', $ivle_id)->first()->modulesTaken;
    }

    // resync User profile from IVLE
    public function meResync(Request $request)
    {
        // setting up http request options
        $token = $request->header('Authorization');
        $ivle_id = $request->session()->get('ivle_id');

        $client = new Client();

        $options = [
            'query' => [
                'APIKey' => getenv('IVLE_API_KEY'),
                'AuthToken' => $token,
                'StudentID' => $ivle_id
            ]
        ];

        // retrieve info from ivle
        $response = $client->get('https://ivle.nus.edu.sg/api/Lapi.svc/Profile_View', $options);

        $profiles = json_decode($response->getBody())->Results[0];

        $response = $client->get('https://ivle.nus.edu.sg/api/Lapi.svc/Modules_Taken', $options);

        $modules_taken = json_decode($response->getBody())->Results;

        // begin local db transaction

        try {
            DB::beginTransaction();

            $user = User::updateOrCreate([
                'ivle_id' => $ivle_id
            ], [
                'name' => $profiles->Name,
                'ivle_id' => $profiles->UserID,
                'email' => $profiles->Email,
                'gender' => $profiles->Gender,
                'faculty' => $profiles->Faculty,
                'first_major' => $profiles->FirstMajor,
                'second_major' => $profiles->SecondMajor,
                'matriculation_year' => $profiles->MatriculationYear,
                'last_seen_at' => Carbon::now()->toDateTimeString(),
                'last_sync_at' => Carbon::now()->toDateTimeString(),
            ]);

            foreach ($modules_taken as $module_taken) {
                $module_code = $module_taken->ModuleCode;
                $module_title = $module_taken->ModuleTitle;
                $year_taken = $module_taken->AcadYear;
                $semester_taken = $module_taken->Semester;

                // the following must be executed in order:
                // 1. attempt to retrieve, else create the module info if not exist, persist the data in DB
                $module = Module::firstOrCreate([
                    'module_code' => $module_code,
                    'module_title' => $module_title
                ]);

                // 2. attempt to retrieve, else create the moduletaken info if not exist, persist data in DB
                $module_taken = ModuleTaken::firstOrCreate([
                    'user_id' => $user->id,
                    'module_id' => $module->id,
                    'year_taken' => $year_taken,
                    'semester_taken' => $semester_taken
                ]);
            }
            // persist transaction if everything is fine
            DB::commit();
        } catch (\Exception $ex) {
            // something horrible happened, rollback transaction
            DB::rollBack();
            throw $ex;
        }

        //dd(json_decode(User::with('modulesTaken')->where('ivle_id', $ivle_id)->first()->toJson())->modules_taken);

        return \Response::json([
            'message' => 'User ' . $ivle_id . ' synchronized.',
            'last_sync_at' => $user->last_sync_at
        ], Response::HTTP_OK, []);
    }
}
