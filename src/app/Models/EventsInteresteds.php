<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventsInteresteds extends Model{
    public $fillable = [
        'event_id',
        'username'
    ];
}
