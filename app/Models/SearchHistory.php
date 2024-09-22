<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'search_histories';

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
    public function result()
    {
        return $this->belongsTo('App\Models\SearchResult', 'search_result_id', 'id');
    }
}
