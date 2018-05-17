<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @SWG\Definition(required={"name", "email", "password"})
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $table = 'users';
    
    public $primaryKey = 'id';

    /**
     * @SWG\Property(type="integer")
     * @var id l'id' du user
     */
    private $id;

    /**
     * @SWG\Property(type="string")
     * @var name le nom du user
     */
    private $name;

    /**
     * @SWG\Property(type="string")
     * @var email l'email du user
     */
    private $email;

    /**
     * @SWG\Property(type="integer")
     * @var password le mot de passe du user
     */
    private $password;
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function projects(){
        return $this->hasMany('App\Project');
    }

    public function ideas(){
        return $this->hasMany('App\Idea');
    }
}
