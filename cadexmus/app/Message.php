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
    	return $this->belongsTo('Projet', 'id');
    }

    public function user()
    {
    	return $this->belongsTo('User','id');
    }
}
