<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    protected $fillable = ['text', 'id_creator', 'id_project'];

    protected $table = 'ideas';
    
    public $primaryKey = 'id';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function votes(){
        return $this->hasMany('App\Vote', 'id_idea');
    }
}
