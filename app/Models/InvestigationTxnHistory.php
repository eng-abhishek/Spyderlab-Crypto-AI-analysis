<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvestigationTxnHistory extends Model
{
    protected $table = 'investigation_txn_histories';

    protected $guarded = [];

    public function investigation_address(){
    	return $this->hasOne(Investigation::class,'address','address');
    }
}
