<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostView;
use App\Models\Post;
use DB;
use DataTables;

class PostViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
      // // PostView::truncate();
      //  dd(PostView::take(50)->get());

     if($request->ajax()){

            $row = Post::withCount(array('postviews'=>function($query){                                                           
                $query->select(DB::raw('count(distinct(ip))'));
            }));

            return DataTables::of($row)

            ->addIndexColumn()

            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="javascript:;" data-url="'.route('backend.posts.view.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="set number of view as zero">Click Here To Set Zero</a>';
                return $btn;
            })

            ->addColumn('post_view', function($row){
                return $row->postviews_count;
            })         

            ->rawColumns(['created_at','action'])
            ->make(true);
        }
        return view('backend.post-view.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PostView  $postView
     * @return \Illuminate\Http\Response
     */
    public function show(PostView $postView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostView  $postView
     * @return \Illuminate\Http\Response
     */
    public function edit(PostView $postView)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostView  $postView
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostView $postView)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostView  $postView
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         try{

            $post = Post::find($id);

            if($post OR isset($post->id)){
                 $post = PostView::where('post_id',$post->id)->delete();
                return response()->json(['status' => 'success', 'message' => 'Blog Views make as zero  successfully.']);
            }         
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
