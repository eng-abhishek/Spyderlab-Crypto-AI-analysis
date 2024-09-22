<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockchainUserNote extends Model
{
   protected $table = "blockchain_user_notes";
   protected $guarded = [];

   
   public function users(){
   	return $this->belongsTo(User::class,'user_id','id');
   }
}
