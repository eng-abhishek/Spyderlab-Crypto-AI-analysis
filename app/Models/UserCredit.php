<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCredit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_credits';

    protected $guarded = [];

    // Carbon instance fields
    protected $dates = ['expired_at'];

    /**
     * The user that belong to the credits.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * The plan that belong to the credits.
     */
    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id', 'id');
    }

    /**
     * The created by user that belong to the credits.
     */
    public function created_by_user()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }
}
