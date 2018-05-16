<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'image_link', 'id_creator'];

    protected $table = 'projects';
    
    public $primaryKey = 'id';

    public function ideas()
    {
        return $this->hasMany('App\Idea', 'id_project');
    }

    public function user(){
        return $this->belongsTo('App\User', 'id_creator');
    }

}
