<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $fillable = [
        'type', 'name', 'text', 'user_id',
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }
}
