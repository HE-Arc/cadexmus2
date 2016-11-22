<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    protected $fillable = [ 'nom' ];

    public function versions()
    {
        return $this->hasMany('App\Version');
    }
}
