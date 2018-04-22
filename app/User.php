<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','family',
        'cellphone',
        'telephone',
        'birth_date',
        'register_date',
        'address',
        'capital_city_id',
        'town_city_id',
        'email',
        'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //relation of users and baskets
    public function baskets()
    {
        return $this->hasMany('App\Models\Basket','user_id');
    }

    //relation of user and orders
    public function orders()
    {
        return $this->hasMany('App\Models\Order','user_id');
    }
    public function Role()
    {
        $this->hasMany('App\Models\Role');
    }

}
