<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests;
use App\Tag;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $ivle_id = $request->session()->get("ivle_id");

        $groups = Group::with(["tags", "users"])
            ->get()
            ->map(function ($group, $group_key) use ($ivle_id) {
                $users = $group->users;
                foreach ($users as $user) {
                    if ($user->ivle_id == $ivle_id) {
                        $group->is_member = true;
                        return $group;
                    }
                }
                $group->is_member = false;
                return $group;
            })
            ->transform(function ($group, $group_key) {
                $group->tags->transform(function ($tag, $tag_key) {
                    return $tag->name;
                });

                return $group;
            })
            ->values()
            ->makeHidden('users')
            ->all();

        return $groups;

    }

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $group = new Group();
            $group->name = Input::get('name');
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

            // auto make creator join the group as admin

            $ivle_id = $request->session()->get("ivle_id");

            $me = User::where('ivle_id', $ivle_id)->first();

            $me->groups()->attach($group->id, [
                'is_admin' => true
            ]);

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        return \Response::json([
            'message' => 'Group created.',
            'id' => $group->id
        ], Response::HTTP_CREATED, []);

    }

    public function show(Request $request, $group_id)
    {
        $ivle_id = $request->session()->get("ivle_id");

        return Group::with("tags", "users")
            ->where('id', $group_id)
            ->get()
            ->map(function($group) use ($ivle_id){
                $users = $group->users;
                foreach($users as $user){
                    if($user->ivle_id == $ivle_id){
                        $group->is_admin = $user->pivot->is_admin;
                        return $group;
                    }
                }

                $group->is_admin = 0;
                return $group;
            })
            ->map(function ($group, $group_key) use ($ivle_id) {
                $users = $group->users;
                foreach ($users as $user) {
                    if ($user->ivle_id == $ivle_id) {
                        $group->is_member = true;
                        return $group;
                    }
                }
                $group->is_member = false;
                return $group;
            })
            ->transform(function ($group, $group_key) {
                $group->tags->transform(function ($tag, $tag_key) {
                    return $tag->name;
                });

                return $group;
            })
            ->makeHidden('users')
            ->first();
    }

    public function update($group_id)
    {
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
        } catch (\Exception $ex) {
            DB::rollBack();
            throw $ex;
        }

        return \Response::json([
            'message' => 'Group updated.'
        ], Response::HTTP_OK, []);

    }

    public function destroy($group_id)
    {
        Group::destroy($group_id);

        return \Response::json([
            'message' => 'Group ' . $group_id . ' has been deleted.'
        ], Response::HTTP_OK, []);
    }

    public function search()
    {

        $name = Input::get('name');
        $tags = Input::get('tags');

        $q = Group::with('tags');


        $q = !empty($name) ? $q->orWhere(function ($subQuery) use ($name) {
            foreach (explode(' ', $name) as $n) {
                $subQuery->orWhere('groups.name', 'LIKE', '%' . $n . '%');
            }
        }) : $q;
        $q = !empty($tags) ? $q->orWhere(function ($subQuery) {
            $subQuery->whereHas('tags', function ($query) {
                $query->whereIn('name', explode(' ', Input::get('tags')));
            });
        }) : $q;
        return $q
            ->get()
            ->transform(function ($group, $group_key) {
                $group->tags->transform(function ($tag, $tag_key) {
                    return $tag->name;
                });

                return $group;
            });

    }

    public function users($group_id)
    {
        return Group::find($group_id)->users;
    }

    public function tags($group_id)
    {
        return Group::find($group_id)->tags;
    }

    public function posts($group_id){
        return Group::find($group_id)->posts;
    }

}
