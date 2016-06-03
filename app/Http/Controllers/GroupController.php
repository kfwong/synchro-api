<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    public function index(){
        return Group::all();
    }

    public function store(Request $request){
        $group = new Group();

        $input = $request->json()->all();

        $group->fill($input)->save();

        return \Response::json([
            'message' => 'Group created.'
        ], Response::HTTP_CREATED, []);
    }

    public function show($group_id){
        return Group::find($group_id);
    }

    public function update($group_id){

    }

    public function destroy($group_id){

    }

    public function users($group_id){
        return Group::find($group_id)->users;
    }

    public function tags($group_id){
        return Group::find($group_id)->tags;
    }

}
