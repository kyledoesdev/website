<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Connection extends Model
{
    protected $fillable = [
        'external_id',
        'type_id',
        'name',
        'token',
        'refresh_token'
    ];

    public function type(): HasOne
    {
        return $this->hasOne(ConnectionType::class, 'type_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
