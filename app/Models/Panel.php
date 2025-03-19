<?php

namespace App\Models;

use App\Models\Model;

class Panel extends Model
{
    protected $fillable = [
        'type',
        'name',
        'display_name',
        'content'
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('default_order', fn ($q) => $q->orderBy('name', 'asc'));
    }
}