<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogRelatedComment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'blog_related_comments';

    protected $guarded = [];

    public function post(){
    	return $this->belongsTo(Post::class);
    }
}
