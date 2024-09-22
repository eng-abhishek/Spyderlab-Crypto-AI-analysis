<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\BlogTag;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Seo;
use App\Models\PostView;
use App\Models\Ads;
use App\Models\Faq;
use App\Models\NewsLetter;
use App\Models\BlogRelatedComment;
use App\Http\Requests\BlogCommentRequest;
use App\Http\Requests\NewsLetterRequest;
use fxcjahid\LaravelTableOfContent\table;
use fxcjahid\LaravelTableOfContent\MarkupFixer;

class PostController extends Controller
{

	public function index(Request $request,$slug=''){

		if(isset($slug) AND $request->segment(2) == 'tag'){

			$posts = Post:: whereHas('tags', function ($q) use ($slug) {
				$q->where('slug', $slug);
			})
			->with('tags')
			->paginate(6);
			$category = "tag";

		}else{

			$posts = Post::with('category')->where('status', 'Publish')
			->where('publish_at', '<=', Carbon::now())
			->orderBy('publish_at', 'desc')
			->paginate(6);
			$category = "all";
		}

		$seoData = Seo::where('slug','home')->first();
		if(!empty($request->get('page'))){

			$total_post = Post::count();
			$actual_post = $total_post/6;

			if($actual_post > ($request->get('page')+1)){
				$next = $request->get('page')+1;
			}else{
				$next = '';
			}

			$prev = $request->get('page')-1;

		}else{
			$prev='';
			$next = 2;
		}

		$tags = BlogTag::orderBy('id','desc')->get();

		return view('frontend.post.list',['tags' => $tags,'posts' => $posts,'next'=>$next,'prev'=>$prev,'seoData'=>$seoData,'category'=>$category]);
	}


	public function details(Request $request,$slug,table $toc, MarkupFixer $markup){

		$post = Post::with('category','post_comment')->with('tags')->withCount('postviews','post_comment')->where('slug', $slug)->first();

        if(!isset($post->id)){
         return redirect()->route('blog.index')->with(['status'=>'danger','message'=>'Oop`s this blog do not exist.']);
        }

		$category = BlogCategory::orderBy('id','desc')->take(5)->get();

		$tag = BlogTag::orderBy('id','desc')->take(10)->get();

		$faq = Faq::orderBy('id','desc')->get();

		$postviews_count = $post->postviews_count;
		$post_comment_count = $post->post_comment_count;


		$latest_post = Post::orderBy('id','desc')->where('status', 'Publish')->take(3)->get();
       
		if($request->has('preview') && $request->get('preview') == 'true'){
			$preview = true;

			if(!\Auth::guard('backend')->check()){
				return redirect()->route('blog.index')->with(['status' => 'danger', 'message' => 'Post not found']);
			}

			$post = Post::with('category','post_comment')->with('tags')
            ->withCount('postviews','post_comment')
			->where('slug', $slug)->first();
            

			if(!$post){
				return redirect()->route('blog.index')->with(['status' => 'danger', 'message' => 'Post not found']);
			}

            // Publish post will be show as a normal
			if($post->status == 'Publish' && $post->publish_at <= Carbon::now()){
				return redirect()->route('blog.details', ['slug' => $post->slug]);
			}

		}else{
			$preview = false;

			$post = Post::with('category','post_comment')->with('tags')->withCount('postviews','post_comment')->where('slug', $slug)
			->where('status', 'Publish')
			->where('publish_at', '<=', Carbon::now())
			->first();


			if(!$post){
				return redirect()->route('blog.index')->with(['status' => 'danger', 'message' => 'Post not found']); 
			}
		}

		$count_post_view = PostView::where(['post_id'=>$post->id,'ip'=>$request->ip()])->count();

		if($count_post_view < 1){
			PostView::createViewLog($post);
		}

		$ads = Ads::orderBy('id','desc')->get();

		$getFixContent = '<div class="content">'.$markup->fix($post->content).'</div>';
        $getTableOfContent = '<div class="toc">'.$toc->getTableContent($getFixContent).'</div>';

		return view('frontend.post.details', ['getTableOfContent'=>$getTableOfContent,'getFixContent'=>$getFixContent,'faq' => $faq,'ads' => $ads,'post' => $post, 'post_comment_count'=>$post_comment_count,'postviews_count'=>$postviews_count,'preview' => $preview, 'category' => $category, 'tag' => $tag,'latest_post'=>$latest_post]);
	}


	public function submitUserComments(BlogCommentRequest $request){

		try{

			$post = Post::find($request->post_id);
			if($post->id){

				$slug = $post->slug;

				$created =  BlogRelatedComment::create([
					'post_id'=>$post->id,
					'name'=>$request->name,
					'email'=>$request->email,
					'comment'=>$request->comment,
				]);

				if($created){

					return redirect()->route('blog.details',$slug)->with(['status' => 'success', 'message' => 'Your comment submitted successfully.']);

				}else{

					return redirect()->route('blog.details',$slug)->with(['status' => 'success', 'message' => 'Oop`s something wents wront.']);
				}
			}
		}catch(\Exception $e){

			return redirect()->route('blog.index')->with(['status' => 'success', 'message' => 'Oop`s something wents wront.']);
		}
	}

	public function capture_email(NewsLetterRequest $request){

		try{
			
			if(!empty($request->post_id)){

				$post = Post::find($request->post_id);

				if( $post->id){

					$slug = $post->slug;

					$created = NewsLetter::create([
						'email'=>$request->email
					]);

					return redirect()->route('blog.details',$slug)->with(['status' => 'success', 'message' => 'Thanks your email capture successfully.']);

				}
			}else{

				$created = NewsLetter::create([
					'email'=>$request->email
				]);

				return redirect()->route('blog.index')->with(['status' => 'success', 'message' => 'Thanks your email capture successfully.']);
			}
		}catch(\Exception $e){

			return redirect()->route('blog.index')->with(['status' => 'danger', 'message' => 'Oop`s something wents wront.']);
		}
	}

}
?>