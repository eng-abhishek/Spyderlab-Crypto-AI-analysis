<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
   use SoftDeletes;

   protected $table = "posts";
   protected $guarded = [];

   protected $appends = ['image_url'];


    /**
     * Get the image url.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        $document_path = 'posts';
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

    /*-------- Relationship -------*/

    public function tags(){
       return $this->belongsToMany(BlogTag::class,'blog_related_tags');
    }

    public function category(){
        return $this->hasOne(BlogCategory::class,'id','blog_category_id');
    }

    public function postviews(){
        return $this->hasMany(PostView::class);
    }

    public function post_comment(){
       return $this->hasMany(BlogRelatedComment::class,'post_id','id')->where('is_active','Y');
    }
}
