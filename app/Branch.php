<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name', 'address', 'phone', 'fax', 'email', 'organization_id',
    ];

    public function organization(){
        return $this->belongsTo('App\Organization');
    }

    public function users(){
        return $this->hasMany('App\User');
    }
}
