<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipos extends Model
{
    protected $fillable = ['registrado'];

    public function tipos(){
        return $this->hasMany('App\Persona');
    }
}
