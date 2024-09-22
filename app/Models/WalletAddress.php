<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletAddress extends Model
{
    protected $table = "wallet_addresses";

    protected $guarded = [];

    /**
     * Get the image.
     *
     * @return string
     */
    public function getImageAttribute($value)
    {
        $document_path = 'wallet-addresses';
        if($value != '' && \Storage::exists($document_path.'/'.$value)){
            return asset('storage/'.$document_path.'/'.$value);
        }else{
            return '';
        }
    }
}