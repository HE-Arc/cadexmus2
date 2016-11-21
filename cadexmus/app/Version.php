<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
     protected $fillable = ['project_id', 'numero', 'repr'];

    // https://www.laravel.com/docs/5.3/eloquent-mutators#array-and-json-casting
    protected $casts = [
        'repr' => 'array',
    ];

}
