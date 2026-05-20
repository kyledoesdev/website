<?php

namespace App\Models;

use App\Enums\AssetType;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Asset extends Model
{
    protected $fillable = [
        'type_id',
        'name',
        'slug',
        'path',
        'mime_type',
        'data',
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('default_order', fn (Builder $query) => $query->orderBy('created_at', 'desc')->orderBy('id', 'desc'));
    }

    public function casts(): array
    {
        return [
            'type_id' => AssetType::class,
            'data' => 'array',
        ];
    }

    public function getCapturedAtAttribute()
    {
        if (isset($this->data['captured_at'])) {
            return Carbon::parse($this->data['captured_at'])->format('F d, Y');
        }

        return null;
    }

    public function getDescriptionAttribute()
    {
        return $this->data['description'] ?? null;
    }
}
