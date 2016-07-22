<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use SoftDeletes;
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

    protected $dates = ['deleted_at'];

    public function users(){
        return $this->belongsToMany('App\User')->withPivot('is_admin');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function getCreatedAtAtrribute($value){
        return $value->timezone('Asia/Singapore')->toDateTimeString();
    }

    public function getUpdatedAtAtrribute($value){
        return $value->timezone('Asia/Singapore')->toDateTimeString();
    }
}
