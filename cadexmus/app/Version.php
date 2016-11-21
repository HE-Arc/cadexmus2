<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
     protected $fillable = ['project_id', 'numero', 'repr'];
}
