<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(required={"name", "image_link", "id_creator"})
 */
class Project extends Model
{

    protected $fillable = ['name', 'image_link', 'id_creator'];

    protected $table = 'projects';
    
    public $primaryKey = 'id';

    /**
     * @SWG\Property(type="integer")
     * @var id l'id' du projet
     */
    private $id;

    /**
     * @SWG\Property(type="string")
     * @var name le nom du projet
     */
    private $name;

    /**
     * @SWG\Property(type="string")
     * @var image_link le lien vers l'image
     */
    private $image_link;

    /**
     * @SWG\Property(type="integer")
     * @var id_creator l'id du creéateur
     */
    private $id_creator;

    public function ideas()
    {
        return $this->hasMany('App\Idea', 'id_project');
    }

    public function user(){
        return $this->belongsTo('App\User', 'id_creator');
    }

}
