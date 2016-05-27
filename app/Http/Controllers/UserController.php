<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;


class UserController extends Controller
{
    public function index(){
        return User::all();
    }

    public function store(){

    }

    public function show($user_id){
        return User::find($user_id);
    }

    public function update($user_id){

    }

    public function destroy($user_id){

    }

    public function groups($user_id){
        return User::find($user_id)->groups;
    }

    // return current authenticated user profile
    public function me(Request $request){
        $ivle_id = $request->session()->get("ivle_id");

        return User::where('ivle_id', $ivle_id)->first();
    }

    // return groups that belong to the current authenticated user
    public function meGroups(Request $request){
        $ivle_id = $request->session()->get("ivle_id");

        return User::where('ivle_id', $ivle_id)->first()->groups;
    }

    // resync User profile from IVLE
    public function meResync(Request $request){
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

        $response = $client->get('https://ivle.nus.edu.sg/api/Lapi.svc/Profile_View', $options);

        $profiles = \GuzzleHttp\json_decode($response->getBody())->Results[0];

        $response = $client->get('https://ivle.nus.edu.sg/api/Lapi.svc/Modules_Taken', $options);

        $modules_taken = $response->getBody();

        $user = User::updateOrCreate([
            'ivle_id' => $ivle_id
        ],[
            'name' => $profiles->Name,
            'ivle_id' => $profiles->UserID,
            'email' => $profiles->Email,
            'gender' => $profiles->Gender,
            'faculty' => $profiles->Faculty,
            'first_major' => $profiles->FirstMajor,
            'second_major' => $profiles->SecondMajor,
            'matriculation_year' => $profiles->MatriculationYear,
            'modules_taken' => $modules_taken,
            'timetable' => '',
            'last_seen_at' => Carbon::now()->toDateTimeString(),
            'last_sync_at' => Carbon::now()->toDateTimeString(),
        ]);

        return \Response::json([
            'message' => 'User ' . $ivle_id . ' synchronized.',
            'last_sync_at' => $user->last_sync_at
        ], Response::HTTP_OK, []);
    }
}
