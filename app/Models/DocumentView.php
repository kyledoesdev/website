<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentView extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'document_id',
        'ip_address'
    ];
}
