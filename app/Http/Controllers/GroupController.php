<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

use App\Http\Requests;

class GroupController extends Controller
{
    public function index(){
        return Group::all();
    }

    public function store(Request $request){

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

}
