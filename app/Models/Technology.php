<?php

namespace App\Models;

use App\Models\Model;

class Technology extends Model
{
    protected $fillable = [
        'name',
        'description',
        'icon'
    ];
}
