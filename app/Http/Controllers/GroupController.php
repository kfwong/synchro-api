<?php

namespace App\Http\Controllers;

use App\Group;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

class GroupController extends Controller
{
    public function index(){
        return Group::with("tags")->get();
    }

    public function store(){

        try {
            DB::beginTransaction();

            $group = new Group();
            $group->name =Input::get('name');
            $group->type = Input::get('type');
            $group->description = Input::get('description');
            $group->date_happening = Carbon::parse(Input::get('date_happening'));
            $group->venue = Input::get('venue');

            $group->save();

            $tags_raw = explode(" ", Input::get('tags')); // client send in string format, seperated by spaces

            $tags = [];

            foreach ($tags_raw as $tag_raw) {
                // check if tag with the same name already exists
                $tag = Tag::firstOrNew(['name' => $tag_raw]);

                array_push($tags, $tag);
            }

            $group->tags()->saveMany($tags);
            DB::commit();

        }catch (\Exception $ex){
            DB::rollBack();
            throw $ex;
        }

        return \Response::json([
            'message' => 'Group created.',
            'id' => $group->id
        ], Response::HTTP_CREATED, []);

    }

    public function show($group_id){
        return Group::with("tags")->where('id', $group_id)->first();
    }

    public function update($group_id){
        try {
            DB::beginTransaction();
            $group = Group::findOrFail($group_id);

            $group->name = Input::get('name');

            $group->save();

            $tags_raw = explode(" ", Input::get('tags')); // client send in string format, seperated by spaces

            $tags = [];

            foreach ($tags_raw as $tag_raw) {
                // check if tag with the same name already exists
                $tag = Tag::firstOrNew(['name' => $tag_raw]);

                array_push($tags, $tag);
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

    public function search(){

        // name, tags
        // combination logic: OR, AND?
        $name = explode(' ', Input::get('name'));

        return Group::with(array('tags' => function($query){
            $tags = explode(' ', Input::get('tags'));

            foreach($tags as $tag){
                $query->orWhere('name', '=', $tag);
            }

        }))
            ->orWhere('name', 'LIKE', $name)
            ->get();

    }

    public function users($group_id){
        return Group::find($group_id)->users;
    }

    public function tags($group_id){
        return Group::find($group_id)->tags;
    }

}
