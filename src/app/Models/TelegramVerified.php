<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramVerified extends Model
{

    public $table = 'telegram_verified_users';
    public $connection = 'fluffbot';

    public $fillable = [
        'user_id',
        'username',
        'fluffici_id',
        'created_at'
    ];
}
