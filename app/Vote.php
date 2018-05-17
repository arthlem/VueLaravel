<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(required={"id_user", "id_idea", "value"})
 */
class Vote extends Model
{
    protected $fillable = [
        'id_user', 'id_idea', 'value',
    ];

    /**
     * @SWG\Property(type="integer")
     * @var id l'id du vote
     */
    private $id;

    /**
     * @SWG\Property(type="string")
     * @var value +1 pour un vote positif ou -1 pour un vote négatif
     */
    private $value;

    /**
     * @SWG\Property(type="integer")
     * @var id_user l'id du voteur
     */
    private $id_user;

    /**
     * @SWG\Property(type="integer")
     * @var id_idea l'id de l'idée
     */
    private $id_idea;

    public function user(){
        return $this->belongsTo('App\User', 'id_user');
    }
}
