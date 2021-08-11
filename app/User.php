<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'username', 'role', 'address', 'phone', 'email', 'branch_id', 'organization_id', 'position_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function organization(){
        return $this->belongsTo('App\Organization');
    }

    public function branch(){
        return $this->belongsTo('App\Branch');
    }

    public function position(){
        return $this->belongsTo('App\Position');
    }

    public function changes(){
        return $this->hasMany('App\UserChange');
    }

    public function audits(){
        return $this->hasMany('App\Audit');
    }

    public function observed(){
        return $this->belongsToMany('App\Organization','observed');
    }
}
