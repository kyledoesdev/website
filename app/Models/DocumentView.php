<?php

namespace App\Models;

use App\Models\Model;

class DocumentView extends Model
{
    protected $fillable = [
        'document_id',
        'ip_address'
    ];
}
