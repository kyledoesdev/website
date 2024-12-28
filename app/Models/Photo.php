<?php

namespace App\Models;

use App\Models\Model;

class Photo extends Model
{
    protected $fillable = [
        'name',
        'captured_at',
        'path',
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('default_order', fn ($query) => $query->orderBy('captured_at', 'desc')->orderBy('id', 'desc'));
    }

    public function casts(): array
    {
        return [
            'captured_at' => 'date'
        ];
    }

    public function getPathAttribute()
    {
        return asset('storage/' . $this->attributes['path']);
    }
}
