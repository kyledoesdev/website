<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Builder;

class Resume extends Model
{
    protected $fillable = [
        'name',
        'path'
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('default_order', fn (Builder $query) => $query->orderBy('created_at', 'desc'));
    }

    public function getPathAttribute()
    {
        return asset('storage/' . $this->attributes['path']);
    }
}
