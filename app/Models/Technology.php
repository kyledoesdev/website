<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Technology extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'icon'
    ];
}
