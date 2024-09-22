<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ads';

    protected $guarded = ['image_url'];

    /**
     * Get the image url.
     *
     * @return string
     */
    
    public function getImageUrlAttribute()
    {
        $document_path = 'ads';
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
