<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    protected $fillable = ['url', 'nom', 'type'];
}
