<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Connection extends Model
{
    protected $fillable = [
        'external_id',
        'type_id',
        'name',
        'token',
        'refresh_token',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
