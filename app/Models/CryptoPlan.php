<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoPlan extends Model
{
    protected $table = 'crypto_plans';
    protected $guarded = [];
    
    /**
     * Get users of plan.
     */
    public function users()
    {
        return $this->hasMany(CryptoPlanSubscription::class, 'plan_id', 'id');
    }

}
