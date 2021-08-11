<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosChange extends Model
{
    protected $fillable = [
        'name', 'value', 'position_id', 'type', 'percentage',
    ];

    public function position(){
        return $this->belongsTo('App\Position');
    }
}
