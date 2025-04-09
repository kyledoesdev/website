<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;

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

        static::addGlobalScope('default_order', fn (Builder $query) => $query->orderBy('captured_at', 'desc')->orderBy('id', 'desc'));
    }

    public function casts(): array
    {
        return [
            'captured_at' => 'date'
        ];
    }

    public function getFullPathAttribute()
    {
        return config('filesystems.disks.s3.url') . $this->attributes['path'];
    }
}
