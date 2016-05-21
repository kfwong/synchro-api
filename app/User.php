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
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function getModulesTakenAttribute($value){
        return json_decode($value);
    }

    public function setModulesTakenAttribute($value){
        $this->attributes['modules_taken']=json_encode(json_decode($value)->Results);
    }
}
