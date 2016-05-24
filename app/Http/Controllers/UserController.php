<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

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
}
