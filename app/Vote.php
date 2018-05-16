<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'id_user', 'id_idea', 'value',
    ];

    public function user(){
        return $this->belongsTo('App\User', 'id_user');
    }
}
