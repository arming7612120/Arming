<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'condicion'];
    public $timestamps = false;


}
