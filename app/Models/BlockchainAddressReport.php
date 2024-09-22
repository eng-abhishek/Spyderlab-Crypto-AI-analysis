<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockchainAddressReport extends Model
{
    protected $table = "blockchain_address_reports";
    protected $guarded = [];

    public function flagUser(){
    return $this->belongsTo(User::class,'user_id','id');
    }

}
