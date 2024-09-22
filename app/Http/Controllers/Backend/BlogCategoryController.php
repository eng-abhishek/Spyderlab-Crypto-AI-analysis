<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\BlogCategoryRequest;
use DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    	if($request->ajax()){

    		$row = BlogCategory::OrderBy('id','desc')->latest()->get();

    		return DataTables::of($row)

    		->addIndexColumn()

    		->addColumn('created_at',function($row){
    			return Carbon::parse($row->updated_at)->format('d-m-Y h:i A');
    		})

    		->addColumn('action', function($row){
    			$btn = '';
    			$btn .= '<a href="'.route("backend.posts.category.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
    			$btn .= '<a href="javascript:;" data-url="'.route('backend.posts.category.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
    			return $btn;
    		})

    		->rawColumns(['created_at','action'])
    		->make(true);
    	}
    	return view('backend.post_category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('backend.post_category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryRequest $request)
    {
    	try{
    		$data = ['name'=> $request->get('name'),'slug' => Str::slug($request->name)];
    		BlogCategory::Create($data);

    		return redirect()->route('backend.posts.category.index')->with(['status' => 'success', 'message' => 'Blog Category added successfully.']);

    	}catch(\Exception $e){
    		return redirect()->route('backend.posts.category.edit',$id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function show(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$data['record'] = BlogCategory::find($id);
    	return view('backend.post_category.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryRequest $request,$id)
    {
    	try{

    		$data = [ 'name'=> $request->get('name'),'slug' => Str::slug($request->name)];

    		BlogCategory::where('id',$id)->update($data);

    		return redirect()->route('backend.posts.category.index')->with(['status' => 'success', 'message' => 'Blog Category updated successfully.']);

    	}catch(\Exception $e){
    		return redirect()->route('backend.posts.category.edit',$id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	try{
    		
    		$post = BlogCategory::find($id)->posts;

    		if(isset($post)){

    			return response()->json(['status' => 'danger', 'message' => 'Oop`s this category used in post.']);
    			
    		}else{
    			BlogCategory::find($id)->delete();
    			return response()->json(['status' => 'success', 'message' => 'Blog Category deleted successfully.']);
    		}
    	}catch(\Exception $e){
    		return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }
}
