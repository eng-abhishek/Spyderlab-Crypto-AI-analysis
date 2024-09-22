<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\BlogRelatedComment;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogRelatedCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
    {
       
        if($request->ajax()){

            $row = BlogRelatedComment::with('post')->OrderBy('id','desc')->latest()->get();

            return DataTables::of($row)

            ->addIndexColumn()

            ->addColumn('created_at',function($row){
                return Carbon::parse($row->updated_at)->format('d-m-Y h:i A');
            })
              
            ->addColumn('post_view',function($row){
              if(isset($row->post->slug)){

              return '<a target="_blank" href="'.route('blog.details',$row->post->slug).'">Click here to view post</a>';
              }else{

              return '<a target="_blank" href="#">Click here to view post</a>';

              }
               
            })

            ->addColumn('is_active',function($row){
                if($row->is_active == 'Y'){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $is_active='<div class="form-check form-switch">
                <input type="checkbox" '.$checked.' class="is_active'.$row->id.' form-check-input" id="customSwitch1" data-id="'.$row->id.'">
                <label class="form-check-label" for="customSwitch1"></label>
                </div>';
                return $is_active;
            })

            ->addColumn('description', function($row){
                return Str::limit($row->comment, 150, $end='...');
            })

            ->addColumn('action', function($row){
                $btn = '';
                
                $btn .= '<a href="'.route("backend.posts.comment.show", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-eye"></i></a>';

                $btn .= '<a href="javascript:;" data-url="'.route('backend.posts.comment.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';

                return $btn;
            })

        ->addColumn('delCheckbox',function($row){

            $delCheckbox = '<div class="form-check"><input type="checkbox" class="form-check-input order_checkbox" name="order_checkbox[]"" value="'.$row->id.'"></div>';
            return $delCheckbox;
        })

            ->rawColumns(['is_active','created_at','action','post_view','delCheckbox'])
            ->make(true);
        }
        return view('backend.comment.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\blog_related_comment  $blog_related_comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    try{

    $data['record']=BlogRelatedComment::with('post')->where('id',$id)->first();
 
    return view('backend.comment.show',$data);

    }catch(\Exception $e){
     return redirect()->route('posts.comment.index')->with(['message'=>'Oops something went wrong','status'=>'danger']);
    }
    }


    /*
     * Change the status
    */

    public function changeStatus(Request $request){

        try{
            $cryptoData=BlogRelatedComment::find($request->id);
            $cryptoData->is_active=$request->is_active;
            $cryptoData->save();
            if($request->is_active=='Y'){

                return response()->json(['status'=>'success','message'=>'Comment has activated successfully..']);    
            }elseif($request->is_active=='N'){

                return response()->json(['status'=>'success','message'=>'Comment has Inactivated successfully.']);
            }

        }catch(\Exception $e){

            return response()->json(['status'=>'error','message'=>'Oop`s something wents worng.']);
        }
    }


    public function removeall(Request $request){

     try{

     BlogRelatedComment::whereIn('id',$request->id)->delete();

     return response()->json(['status' => 'success', 'message' => 'All comment remove successfully.']);

     }catch(\Exception $e){

     return response()->json(['status' => 'danger', 'message' => 'Oop`s something went wrong.']);

     }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\blog_related_comment  $blog_related_comment
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
     {
        try{
            
            BlogRelatedComment::where('id',$id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Comment deleted successfully.']);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
