<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockchainSearchHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blockchain_search_histories';

    protected $guarded = [];

    /**
     * The user that belong to the history.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * The result that belong to the history.
     */
    public function search()
    {
        return $this->belongsTo('App\Models\BlockchainSearch', 'search_id', 'id');
    }
}
