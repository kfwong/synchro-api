<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends Controller
{
    public function a(){
        return User::all()->first();
    }

    public function index(){

    }

    public function store(){

    }

    public function show($user_id){

    }

    public function update($user_id){

    }

    public function destroy($user_id){

    }
}
