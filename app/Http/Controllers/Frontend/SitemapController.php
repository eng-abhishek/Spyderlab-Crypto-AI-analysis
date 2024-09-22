<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
class SitemapController extends Controller
{

    public function index()
    {
         return response()->view('frontend.sitemap.index')->header('Content-Type', 'text/xml');
    }

    public function blogSitemap(){
      /* Get blog posts for sitemap */
        $posts = \App\Models\Post::where('status', 'Publish')
        ->where('publish_at', '<=', Carbon::now())
        ->orderBy('publish_at', 'desc')
        ->get();

        return response()->view('frontend.sitemap.blog_sitemap',compact('posts'))->header('Content-Type', 'text/xml');
    }

    public function pages(){
      return response()->view('frontend.sitemap.pages_sitemap')->header('Content-Type', 'text/xml');
     }
}
