<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TelegramTransaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'telegram_transactions';
    protected $guarded = [];


    public function tg_user(){
    return $this->hasOne(TelegramUser::class,'id','user_id');
    }

    public function tg_package(){
    return $this->hasOne(TelegramPackage::class,'id','package_id');
    }

    protected $casts = [
        'payment_amount_in_usd' => 'integer',
    ];

}
