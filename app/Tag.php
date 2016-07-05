<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];

    public function groups(){
        return $this->belongsToMany('App\Group');
    }
}
