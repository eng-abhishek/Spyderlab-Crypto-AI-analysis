<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoPlanSubscription extends Model
{
   protected $table = 'crypto_plan_subscriptions';
   protected $guarded = [];
   
   public function users(){
   return $this->belongsTo(User::class,'user_id','id');
   }

   public function transations(){
   return $this->hasMany(CryptoPlanTransaction::class,'sub_id','id');
   }

   public function plans(){
   return $this->belongsTo(CryptoPlan::class,'plan_id','id');
   }

   public function paid_plans(){
   return $this->belongsTo(CryptoPlan::class,'plan_id','id')->where('is_free','N');
   }

}
