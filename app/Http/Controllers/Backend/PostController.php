<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\Backend\PostRequest;
use App\Models\BlogTag;
use App\Models\BlogCategory;
use App\Models\PostView;
use App\Models\BlogRelatedTag;
use App\Models\BlogRelatedComment;
use DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    	if ($request->ajax()) {

    		$data = Post::withTrashed()->withCount(array('postviews'=>function($query){                                                           
    			$query->select(DB::raw('count(distinct(ip))'));
    		}))->with('category');

    		return Datatables::of($data)
    		->addIndexColumn()
    		->addColumn('publish_at', function($row){
    			return ($row->publish_at != '')?Carbon::parse($row->publish_at)->format('Y-m-d h:i:s'):'';
    		})
    		->addColumn('status', function($row){
    			if ($row->trashed()) {
    				return '<span>Trashed</span>';
    			}else if($row->status == 'Publish'){
    				if($row->publish_at <= now()){
    					return '<span>Published</span>';
    				}else{
    					return '<span>Scheduled</span>';
    				}
    			}else if($row->status == 'Draft'){
    				return '<span>Draft</span>';
    			}else{
    				return '<span>Pending</span>';
    			}
    		})
    		->addColumn('category', function($row){
    			return ($row->category) ? $row->category->name : 'N/A';
    		})
    		->addColumn('action', function($row){
    			$btn = '';
    			if ($row->trashed()) {


    				$btn .= '<a href="javascript:;" data-url="'.route('backend.posts.restore', $row->id).'"  class="restore-record btn btn-outline-primary btn-sm" title="Restore"><i class="fa-light fa-undo"></i></a>';


    				$btn .= '<a href="javascript:;" data-url="'.route('backend.posts.destroy', $row->id).'" data-action="permanently-delete" class="delete-record btn btn-outline-danger btn-sm" title="Delete Permanently"><i class="fa-light fa-trash"></i></a>';


    			}else{

    				if($row->status == 'Publish' && $row->publish_at <= Carbon::now()){

    					$btn .= '<a target="_blank" href="'.route("blog.details", $row->slug).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-eye" title="View"></i></a>';

    				}else{

                        $btn .= '<a target="_blank" href="'.route("blog.details", $row->slug).'?preview=true" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-eye" title="View"></i></a>';
    				
    				}
    				
    				$btn .= '<a href="'.route("backend.posts.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
    				$btn .= '<a href="javascript:;" data-url="'.route('backend.posts.destroy', $row->id).'" data-action="trash" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';

    			}
    			return $btn;
    		})
            // ->filter(function ($instance) use ($request) {
            //     if ($request->get('status') != '') {
            //         $instance->where('status', $request->get('status'));
            //     }
            //     if (!empty($request->get('search'))) {
            //         $instance->where(function($w) use($request){
            //             $search = $request->get('search');
            //             $w->where('title', 'LIKE', "%$search%");
            //         });
            //     }
            // })
    		->rawColumns(['status', 'action','category'])
    		->make(true);
    	}
    	return view('backend.post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$post_status = config('constants.post.status');
    	$blogTag = BlogTag::all()->pluck('name','id');
    	$blogCategory = BlogCategory::all()->pluck('name','id');
    	return view('backend.post.create', ['post_status' => $post_status,'blogTag' => $blogTag,'blogCategory' => $blogCategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

    	try {
    		$user = \Auth::guard('backend')->user();

    		$data = [
    			'title' => $request->get('title'),
    			'blog_category_id' => $request->get('blog_category_id'),
    			'slug' => \Str::slug($request->get('slug')),
    			'content' => $request->get('content'),
    			'image_alt' => $request->get('image_alt'),
    			'image_title' => $request->get('image_title'),
    			'status' => $request->get('status'),
    			'publish_at' => ($request->get('status') == 'Publish')?$request->get('publish_at'):null,
    			'meta_title' => $request->get('meta_title'),
    			'meta_description' => $request->get('meta_description'),
    			'created_by' => $user->id,
    		];

            if(!empty($request->is_faq) || isset($request->is_faq)){
            $data['is_faq'] = 'Y';
            $data['faq']=($request->faq) ? json_encode($request->faq) : NULL;
            }

            //Upload image
    		if($request->hasFile('image')){

    			$document_path = 'posts';
    			if (!\Storage::exists($document_path)) {
    				\Storage::makeDirectory($document_path, 0777);
    			}

    			$filename = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$request->file('image')->getClientOriginalExtension();
    			$request->file('image')->storeAs($document_path, $filename);

    			$data['image'] = $filename;
    		}


    		$insertPost = Post::create($data);
    		$insertPost->tags()->attach($request->post('blog_tag_id'));

    		return redirect()->route('backend.posts.index')->with(['status' => 'success', 'message' => 'Post created successfully.']);

    	} catch (\Exception $e) {
    		return redirect()->route('backend.posts.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	if(count(Post::find($id)->tags)>0){
    		$record_tag = Post::find($id)->tags;
    		foreach ($record_tag as $key => $value) {
    			$arr[] = $value->id;

    		}
    	}else{
    		$arr[] = '';
    	}
     
    	$record = Post::find($id);

        $faq=json_decode($record->faq);

    	$blogTag = BlogTag::all()->pluck('name','id');
    	$blogCategory = BlogCategory::all()->pluck('name','id');
    	$post_status = config('constants.post.status');

    	return view('backend.post.edit', ['record' => $record, 'faq' => $faq, 'post_status' => $post_status,'blogTag' => $blogTag,'blogCategory' => $blogCategory,'arr'=>$arr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
    	try {
    		$user = \Auth::guard('backend')->user();

    		$record = Post::find($id);

    		$data = [
    			'title' => $request->get('title'),
    			'blog_category_id' => $request->get('blog_category_id'),
    			'slug' => \Str::slug($request->get('slug')),
    			'content' => $request->get('content'),
    			'image_alt' => $request->get('image_alt'),
    			'image_title' => $request->get('image_title'),
    			'status' => $request->get('status'),
    			'publish_at' => ($request->get('status') == 'Publish')?$request->get('publish_at'):null,
    			'meta_title' => $request->get('meta_title'),
    			'meta_description' => $request->get('meta_description'),
    			'updated_by' => $user->id,
    		];

            if(!empty($request->is_faq) || isset($request->is_faq)){
            $data['is_faq'] = 'Y';
            $data['faq']=($request->faq) ? json_encode($request->faq) : NULL;
            }else{
            $data['is_faq'] = 'N';
            $data['faq'] = NULL;
            }

            //Upload image
    		if($request->hasFile('image')){

    			$document_path = 'posts';
    			if (!\Storage::exists($document_path)) {
    				\Storage::makeDirectory($document_path, 0777);
    			}

                //Remove old image
    			if ($record->image != '' && \Storage::exists($document_path.'/'.$record->image)) {
    				\Storage::delete($document_path.'/'.$record->image);
    			}

    			$filename = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$request->file('image')->getClientOriginalExtension();
    			$request->file('image')->storeAs($document_path, $filename);

    			$data['image'] = $filename;
    		}

    		$record->update($data);
    		$record->tags()->sync($request->post('blog_tag_id'));
    		return redirect()->route('backend.posts.index')->with(['status' => 'success', 'message' => 'Post updated successfully.']);

    	}catch (\Exception $e) {
    		return redirect()->route('backend.posts.edit', $id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	try{

    		$record = Post::withTrashed()->find($id);

    		if($record->trashed()){
                //Permanently deleting record
                BlogRelatedTag::where('post_id',$id)->delete();
                BlogRelatedComment::where('post_id',$id)->delete();
                PostView::where('post_id',$id)->delete();

                //Remove image
    			$document_path = 'posts';
    			if ($record->image != '' && \Storage::exists($document_path.'/'.$record->image)) {
    				\Storage::delete($document_path.'/'.$record->image);
    			}
    			$record->forceDelete();

    			$message = 'Post permanently deleted';                
    		}else{

                //Soft deleting record
    			$record->delete();
    			$message = 'Post moved to the Trash';
    		}

    		return response()->json(['status' => 'success', 'message' => $message]);
    	}catch(\Exception $e){
    		return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }

    /**
     * Restore the specified resource from trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
    	try{

    		Post::withTrashed()->find($id)->restore();

    		return response()->json(['status' => 'success', 'message' => 'Post restored from the Trash']);
    	}catch(\Exception $e){
    		return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }

}
