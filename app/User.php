<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','nombre','tipo_documento','num_documento','direccion','telefono','email', 'usuario', 'password','condicion','idrol','imagen'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rol(){

        return $this->belongsTo('App\Rol');
    }
}
