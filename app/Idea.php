<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(required={"text", "id_creator", "id_project"})
 */
class Idea extends Model
{
    protected $fillable = ['text', 'id_creator', 'id_project'];

    protected $table = 'ideas';
    
    public $primaryKey = 'id';

    /**
     * @SWG\Property(type="integer")
     * @var id l'id' de l'idée
     */
    private $id;

    /**
     * @SWG\Property(type="string")
     * @var text le texte de l'idée
     */
    private $text;

    /**
     * @SWG\Property(type="integer")
     * @var id_creator l'id du creéateur
     */
    private $id_creator;

    /**
     * @SWG\Property(type="integer")
     * @var id_project l'id du projet
     */
    private $id_project;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function votes(){
        return $this->hasMany('App\Vote', 'id_idea');
    }
}
