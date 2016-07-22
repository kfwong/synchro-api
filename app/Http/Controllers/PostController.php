<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use DB;

class PostController extends Controller
{
    public function show($post_id){

        return DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->select([
                'posts.id',
                'posts.content',
                'posts.user_id',
                'posts.group_id',
                'posts.created_at',
                'posts.updated_at',
                'users.name'
            ])
            ->where('posts.id', $post_id)
            ->get();

        //return Post::find($post_id);
    }

    public function store(Request $request){

        $ivle_id = $request->session()->get("ivle_id");

        $user = User::where('ivle_id', $ivle_id)->first();

        $post = new Post();

        $post->content = Input::get('content');
        $post->group_id = Input::get('group_id');
        $post->user_id = $user->id;

        $post->save();

        return \Response::json([
            'message' => 'Post for Group ' . $post->group_id .' created.',
            'id' => $post->id
        ], Response::HTTP_CREATED, []);

    }
}
