<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'intro',
        'ivle_id',
        'email',
        'gender',
        'faculty',
        'first_major',
        'second_major',
        'matriculation_year',
        'modules_taken',
        'time_table',
        'last_seen_at',
        'last_sync_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function groups(){
        return $this->belongsToMany('App\Group')->withPivot('is_admin');
    }

    public function modulesTaken(){
        return $this->hasMany('App\ModuleTaken');
    }

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function getNameAttribute($value){
        return ucwords(strtolower($value));
    }

}
