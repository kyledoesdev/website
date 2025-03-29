<?php

namespace App\Models;

use App\Models\MediaType;
use App\Models\Model;
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
            'in_backlog' => 'boolean',
            'is_completed' => 'boolean',
            'data' => 'array'
        ];
    }

    public function type(): HasOne
    {
        return $this->hasOne(MediaType::class, 'id', 'type_id');
    }

    public function scopeForSpotify($query)
    {
        $query->whereIn('type_id', [
            MediaType::ARTIST,
            MediaType::TRACK
        ]);
    }
}
