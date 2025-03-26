<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Panel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'display_name',
        'content'
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('default_order', fn (Builder $query) => $query->orderBy('name', 'asc'));
    }
}