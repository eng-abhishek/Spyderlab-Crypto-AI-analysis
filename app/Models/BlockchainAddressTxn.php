<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockchainAddressTxn extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blockchain_address_txn';

    protected $guarded = [];

    /**
     * The result that belong to the address details.
     */
    public function address_detail()
    {
        return $this->belongsTo('App\Models\BlockchainAddressDetail', 'address_detail_id', 'id');
    }

}
