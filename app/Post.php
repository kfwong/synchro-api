<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user(){
        return $this->belongsTo('users');
    }

    public function group(){
        return $this->belongsTo('group');
    }

    public function getCreatedAtAtrribute($value){
        return $value->timezone('Asia/Singapore')->toDateTimeString();
    }

    public function getUpdatedAtAtrribute($value){
        return $value->timezone('Asia/Singapore')->toDateTimeString();
    }
}