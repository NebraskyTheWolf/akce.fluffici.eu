<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportedAttachments extends Model
{
    public $casts = [
        'messages' => 'string'
    ];
}
