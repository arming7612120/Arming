<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['paterno', ' materno', 'nombre', 'ci', 'expedido', 'idtipo'];

    public function tipos(){
        return $this->belongsTo('App\Tipo');
    }
}
