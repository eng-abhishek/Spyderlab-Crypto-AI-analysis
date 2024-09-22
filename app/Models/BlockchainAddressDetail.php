<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockchainAddressDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blockchain_address_details';

    protected $guarded = [];

    /**
     * The result that belong to the search.
     */
    public function search()
    {
        return $this->belongsTo('App\Models\BlockchainSearch', 'search_id', 'id');
    }

}
