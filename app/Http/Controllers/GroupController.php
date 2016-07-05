<?php

namespace App\Http\Controllers;

use App\Group;
use App\Tag;
use Illuminate\Http\Request;
use DB;

use App\Http\Requests;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    public function index(){
        return Group::with("tags")->get();
    }

    public function store(Request $request){

        try {
            DB::beginTransaction();

            $group = new Group();

            $group->name = $request->name;

            $group->save();

            $tags = [];

            foreach ($request->tags as $tag_name) {
                // check if tag with the same name already exists
                $tag_obj = Tag::firstOrNew(['name' => $tag_name]);

                $tag_obj->name = $tag_name;

                array_push($tags, $tag_obj);
            }

            $group->tags()->saveMany($tags);
            DB::commit();

        }catch (\Exception $ex){
            DB::rollBack();
            throw $ex;
        }

        return \Response::json([
            'message' => 'Group created.'
        ], Response::HTTP_CREATED, []);

    }

    public function show($group_id){
        return Group::with("tags")->where('id', $group_id)->first();
    }

    public function update($group_id, Request $request){
        try {
            DB::beginTransaction();
            $group = Group::findOrFail($group_id);

            $group->name = $request->name;

            $group->save();

            $tags = [];

            foreach ($request->tags as $tag_name) {
                // check if tag with the same name already exists
                $tag_obj = Tag::firstOrNew(['name' => $tag_name]);

                $tag_obj->name = $tag_name;

                array_push($tags, $tag_obj);
            }

            // detach all children from many to many relationship
            // note: does not delete the tag entry even if there's no reference to it.
            $group->tags()->detach();

            // reattach new tags submitted by client
            $group->tags()->saveMany($tags);

            DB::commit();
        }catch( \Exception $ex){
            DB::rollBack();
            throw $ex;
        }

        return \Response::json([
            'message' => 'Group updated.'
        ], Response::HTTP_OK, []);

    }

    public function users($group_id){
        return Group::find($group_id)->users;
    }

    public function tags($group_id){
        return Group::find($group_id)->tags;
    }

}
