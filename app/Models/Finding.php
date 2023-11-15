<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finding extends Model
{
    protected $table = 'findings';

    protected $fillable = [
        'name',
        'description',
    ];
}
