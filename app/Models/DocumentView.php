<?php

namespace App\Models;

use Carbon\Carbon;

class DocumentView extends Model
{
    protected $fillable = [
        'document_id',
        'ip_address',
        'timezone',
        'last_viewed_at',
    ];

    public function casts(): array
    {
        return [
            'last_viewed_at' => 'timestamp',
        ];
    }

    public function getFirstViewedAtAttribute(): string
    {
        return Carbon::parse($this->created_at)->inUserTimezone()->format('M d, Y g:i A T');
    }

    public function getLastViewedAtAttribute(): string
    {
        return Carbon::parse($this->attributes['last_viewed_at'])->inUserTimezone()->format('M d, Y g:i A T');
    }
}
