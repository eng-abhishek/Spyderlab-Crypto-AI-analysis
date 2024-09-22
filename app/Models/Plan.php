<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plans';

    protected $guarded = [];
    
    /**
     * Get users of plan.
     */
    public function users()
    {
        return $this->hasMany('App\Models\UserCredit', 'plan_id', 'id');
    }
}
