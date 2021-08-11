<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserChange extends Model
{
    protected $fillable = [
        'name', 'value', 'user_id', 'type', 'percentage',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
