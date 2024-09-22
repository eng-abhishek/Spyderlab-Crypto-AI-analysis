<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Carbon instance fields
    protected $dates = ['last_login_at'];
    
    /**
     * Get credits of users.
     */
    public function user_credits()
    {
        return $this->hasMany('App\Models\UserCredit', 'user_id', 'id');
    }

    public function isSuperAdmin()
    {
        return ($this->is_admin == 'Y') ? true : false;
    }

    public function isUser()
    {
        return ($this->is_admin == 'N') ? true : false;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 'Y');
    }
    
    public function subscription(){
     return $this->hasOne(CryptoPlanSubscription::class);
 }

 public function transactions(){
     return $this->hasMany(CryptoPlanTransaction::class,'user_id','id');
 }

 public function notes(){
    return $this->hasMany(BlockchainUserNote::class,'user_id','id');
}

public function flags(){
    return $this->hasMany(BlockchainAddressReport::class,'user_id','id');
}

public function search_histories(){
    return $this->hasMany(SearchHistory::class,'user_id','id');
}

public function blockchain_search_histories(){
    return $this->hasMany(BlockchainSearchHistory::class,'user_id','id');
}

public function monitoring(){
    return $this->hasMany(Monitorig::class,'user_id','id');
}

public function user_keys(){
    return $this->hasMany(PrivateKey::class,'user_id','id');
}

    /**
     * Get the user's avatar.
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        $document_path = 'avatars';
        if($this->avatar != '' && \Storage::exists($document_path.'/'.$this->avatar)){
            return asset('storage/'.$document_path.'/'.$this->avatar);
        }else{
            return asset('assets/backend/images/default-avatar.jpg');
        }
    }

    /**
     * Get the username.
     *
     * @return string
     */
    public function getUsernameAttribute($value)
    {
        return ($value == '') ? $this->eth_address : $value;
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($user) {

           $user->user_credits()->delete();
           $user->subscription()->delete();
           $user->transactions()->delete();
           $user->notes()->delete();
           $user->flags()->delete();
           $user->search_histories()->delete();
           $user->blockchain_search_histories()->delete();

       });
    }

    public function isWeb3User()
    {
        return ($this->eth_address != '' && is_null($this->email)) ? true : false;
    }

    public function isGmailUser(){
        return ($this->password == '') ? true : false;
    }
}
