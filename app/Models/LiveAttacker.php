<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveAttacker extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'live_attackers';

    protected $guarded = [];

    public function gettimestampAttribute($value){
    return date('Y-m-d h:i:s');
    }
}
