<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockchainSearchResult extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blockchain_search_results';

    protected $guarded = [];

    /**
     * The result that belong to the history.
     */
    public function search()
    {
        return $this->belongsTo('App\Models\BlockchainSearch', 'search_id', 'id');
    }

    /**
     * Get anti fraud object.
     *
     * @param  string  $value
     * @return string
     */
    public function getAntiFraudAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get chain object.
     *
     * @param  string  $value
     * @return string
     */
    public function getChainAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Get labels object.
     *
     * @param  string  $value
     * @return string
     */
    public function getLabelsAttribute($value)
    {
        return json_decode($value);
    }

}
