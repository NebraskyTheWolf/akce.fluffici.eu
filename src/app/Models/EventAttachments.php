<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAttachments extends Model
{
    public $table = 'event_attachments';

    public $fillable = [
        'user_id',
        'event_id',
        'published',
        'attachment_id',
    ];
}
