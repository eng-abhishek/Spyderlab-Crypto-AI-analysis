<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttackerIp extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attacker_ips';

    protected $guarded = [];
}
