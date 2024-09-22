<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramTmpChat extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'telegram_tmp_chats';
    protected $guarded = [];
}
