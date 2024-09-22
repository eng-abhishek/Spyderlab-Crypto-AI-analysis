<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockchainSearch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blockchain_searches';

    protected $guarded = [];

    /**
     * The updated by user that belong to the result.
     */
    public function updated_by_user()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    /**
     * Get results of search.
     */
    public function results()
    {
        return $this->hasMany('App\Models\BlockchainSearchResult', 'search_id', 'id');
    }
}
