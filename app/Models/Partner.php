<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partners';

    protected $guarded = ['image_url'];

    public function getImageUrlAttribute()
    {
        $document_path = 'partner';
        if($this->image != '' && \Storage::exists($document_path.'/'.$this->image)){
            if(app()->environment() == 'local'){
                return asset('storage/'.$document_path.'/'.$this->image);
            }else{
                return secure_asset('storage/'.$document_path.'/'.$this->image);
            }
        }else{
            return "";
        }
    }
}
