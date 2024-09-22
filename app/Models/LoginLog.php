<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_logs';

    protected $guarded = [];

    public function login_user(){
    	return $this->belongsTo(User::class,'user_id','id');
    }
}
