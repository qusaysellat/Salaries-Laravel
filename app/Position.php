<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name', 'salary', 'organization_id',
    ];

    public function organization(){
        return $this->belongsTo('App\Organization');
    }

    public function changes(){
        return $this->hasMany('App\PosChange');
    }

    public function users(){
        return $this->hasMany('App\User');
    }
}
