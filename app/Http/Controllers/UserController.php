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

    public function store()
    {

    }

    public function show($user_id)
    {
        return User::find($user_id);
    }

    public function update($user_id)
    {

    }

    public function destroy($user_id)
    {

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

        // being local db transaction
        DB::beginTransaction();
        try {
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

                $module = Module::firstOrCreate([
                    'module_code' => $module_code,
                    'module_title' => $module_title
                ]);

                $module_taken = ModuleTaken::firstOrCreate([
                    'user_id' => $user->id,
                    'module_id' => $module->id,
                    'year_taken' => $year_taken,
                    'semester_taken' => $semester_taken
                ]);
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        DB::commit();

        //dd(json_decode(User::with('modulesTaken')->where('ivle_id', $ivle_id)->first()->toJson())->modules_taken);

        return \Response::json([
            'message' => 'User ' . $ivle_id . ' synchronized.',
            'last_sync_at' => $user->last_sync_at
        ], Response::HTTP_OK, []);
    }
}
