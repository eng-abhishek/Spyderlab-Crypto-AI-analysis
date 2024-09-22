<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
   protected $table = "post_views";
   protected $guarded = [];

   	 public static function createViewLog($post){
		$postsViews= new PostView();
		$postsViews->post_id = $post->id;
		$postsViews->user_id = (\Auth::user()) ? \Auth::user()->id : '';
		$postsViews->ip = \Request::getClientIp();
		$postsViews->agent = \Request::header('User-Agent');
		$postsViews->save();
		}

	  public function postviews(){
        return $this->belongToMany(PostView::class)->distinct('ip');
      }

     public function post(){
      	return $this->belongsTo(Post::class);
      }
}
