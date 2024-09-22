<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'search_results';

    protected $guarded = [];

    /**
     * The updated by user that belong to the result.
     */
    public function updated_by_user()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    /**
     * The country that belong to the result.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_code', 'code');
    }
}
