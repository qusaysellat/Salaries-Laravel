<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'fax', 'email'];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function branches(){
        return $this->hasMany('App\Branch');
    }

    public function positions(){
        return $this->hasMany('App\Position');
    }

    public function observers(){
        return $this->belongsToMany('App\User','observed');
    }
}
