<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockchainAddressTxnInout extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blockchain_address_txn_inouts';

    protected $guarded = [];

    /**
     * The result that belong to the address detail.
     */
    public function address_detail()
    {
        return $this->belongsTo('App\Models\BlockchainAddressDetail', 'address_detail_id', 'id');
    }

    /**
     * The result that belong to the txn.
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\BlockchainAddressTxn', 'txn_id', 'txn_id');
    }

}
