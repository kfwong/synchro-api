<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
        return $this->belongsTo('users');
    }

    public function group(){
        return $this->belongsTo('group');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timezone('Asia/Singapore')->toDateTimeString();
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timezone('Asia/Singapore')->toDateTimeString();
    }
}