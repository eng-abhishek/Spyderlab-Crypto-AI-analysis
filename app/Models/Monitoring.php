<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'monitorigs';

    protected $guarded = [];

    protected $appends = ['image_url'];
    
    public function users(){
      return $this->belongsTo(User::class,'user_id','id');
    }

    public function getImageUrlAttribute()
    {
        $document_path = 'address_logo';
        if($this->logo != '' && \Storage::exists($document_path.'/'.$this->logo)){
            if(app()->environment() == 'local'){
                return asset('storage/'.$document_path.'/'.$this->logo);
            }else{
                return secure_asset('storage/'.$document_path.'/'.$this->logo);
            }
        }else{
            return "";
        }
    }
}
