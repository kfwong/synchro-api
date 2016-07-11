<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'tags'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('is_admin');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }
}
