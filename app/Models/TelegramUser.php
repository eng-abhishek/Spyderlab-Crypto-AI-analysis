<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{
	/**
	* The table associated with the model.
	*
	* @var string
	*/
	protected $table = 'telegram_users';
	protected $guarded = [];
}
