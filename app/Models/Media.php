<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Media extends Model
{
    protected $fillable = [
        'type_id',
        'media_id',
        'name',
        'cover',
        'is_favorite',
        'is_active',
        'in_backlog',
        'is_completed',
        'data',
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('default_order', fn (Builder $query) => $query->orderBy('name', 'asc'));
    }

    public function casts(): array
    {
        return [
            'is_favorite' => 'boolean',
            'is_active' => 'boolean',
            'in_backlog' => 'boolean',
            'is_completed' => 'boolean',
            'data' => 'array',
        ];
    }

    public function type(): HasOne
    {
        return $this->hasOne(MediaType::class, 'id', 'type_id');
    }
}
