<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportedAttachments extends Model
{
    public $casts = [
        'messages' => 'string'
    ];

    public $fillable = [
        'type',
        'messages',
        'username',
        'email',
        'reason',
        'isLegalPurpose',
        'attachment_id',
        'reviewed_by',
        'reviewed'
    ];
}
