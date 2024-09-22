<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoPlanTransaction extends Model
{
	protected $table = 'crypto_plan_transactions';
	protected $guarded = [];

    public function users(){
    	return $this->belongsTo(User::class,'user_id','id');
    }

    public function plans(){
    	return $this->belongsTo(CryptoPlan::class,'plan_id','id');
    }

    public function subscription(){
    	return $this->belongsTo(CryptoPlanSubscription::class,'sub_id','id');
    }
    
	// public static function boot()
	// {
	// 	parent::boot();
	// 	self::created(function ($model) {
	// 		$model->transaction_id = 'NMB-BOO-' . str_pad($model->id, 7, "0", STR_PAD_LEFT);
	// 		$model->save();
	// 	});
	// }
}
