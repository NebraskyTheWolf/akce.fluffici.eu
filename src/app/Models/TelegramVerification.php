<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramVerification extends Model
{

    public $table = 'telegram_verification';
    public $connection = 'fluffbot';

    public $fillable = [
        'status',
        'updated_at'
    ];
}
