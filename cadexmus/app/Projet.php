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
    public function messages()
    {
    	return $this->hasMany('App\Message','projet_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

}
