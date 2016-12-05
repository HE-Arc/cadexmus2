<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = array('body');

    protected $with = array('user');

    public function scopeByProjet($query, $projet)
    {
    	return $query->where('id', $projet->id);
    }

    public function scopeAfterId($query,$lastId)
    {
    	return $query->where('id','>',$lastId);
    }

    public function Projet()
    {
    	return $this->belongsTo('App\Projet', 'id');
    }

    public function User()
    {
    	return $this->belongsTo('App\User','id');
    }
}
