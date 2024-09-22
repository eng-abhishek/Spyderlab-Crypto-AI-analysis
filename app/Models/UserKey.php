<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserKey extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_keys';

    protected $guarded = [];

    public static function boot()
	{
		parent::boot();
		self::created(function ($model) {
         $num = random_int(100000, 999999).$model->id;
         $model->key = hash('sha256',$num);
         $model->save();
		});
	}

    public function users(){
     return $this->belongsTo(User::class,'user_id','id');
    }
}
