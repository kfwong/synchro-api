<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleTaken extends Model
{
    public $timestamps = false;

    protected $table = 'modules_taken';

    protected $fillable= [
        'user_id',
        'module_id',
        'year_taken',
        'semester_taken'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function module(){
        return $this->belongsTo('App\Module');
    }
}
