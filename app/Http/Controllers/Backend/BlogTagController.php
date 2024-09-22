<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\BlogTagRequest;
use App\Models\BlogTag;
use DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $row = BlogTag::OrderBy('id','desc')->latest()->get();

            return DataTables::of($row)

            ->addIndexColumn()

            ->addColumn('created_at',function($row){
                return Carbon::parse($row->updated_at)->format('d-m-Y h:i A');
            })

            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="'.route("backend.posts.tag.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
                $btn .= '<a href="javascript:;" data-url="'.route('backend.posts.tag.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })

            ->rawColumns(['created_at','action'])
            ->make(true);
        }
        return view('backend.post_tag.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.post_tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogTagRequest $request)
    {
      try{
            $data = ['name'=> $request->get('name'),'slug' => Str::slug($request->name)];
            BlogTag::Create($data);

            return redirect()->route('backend.posts.tag.index')->with(['status' => 'success', 'message' => 'Blog Tag added successfully.']);

        }catch(\Exception $e){
            return redirect()->route('backend.posts.tag.edit',$id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BlogTag  $blogTag
     * @return \Illuminate\Http\Response
     */
    public function show(BlogTag $blogTag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlogTag  $blogTag
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['record'] = BlogTag::find($id);
        return view('backend.post_tag.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlogTag  $blogTag
     * @return \Illuminate\Http\Response
     */
    public function update(BlogTagRequest $request, $id)
    {
        try{

            $data = [ 'name'=> $request->get('name'),'slug' => Str::slug($request->name)];

            BlogTag::where('id',$id)->update($data);

            return redirect()->route('backend.posts.tag.index')->with(['status' => 'success', 'message' => 'Blog Tag updated successfully.']);

        }catch(\Exception $e){
            return redirect()->route('backend.posts.tag.edit',$id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogTag  $blogTag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            
            $post = BlogTag::find($id)->posts;
           
            if(isset($post)){

                return response()->json(['status' => 'danger', 'message' => 'Oop`s this tag used in post.']);
                
            }else{
                BlogTag::find($id)->delete();
                return response()->json(['status' => 'success', 'message' => 'Blog Tag deleted successfully.']);
            }
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
