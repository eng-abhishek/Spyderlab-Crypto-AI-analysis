<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class NewsLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
      if($request->ajax()){

            $row = NewsLetter::OrderBy('id','desc')->latest()->get();

            return DataTables::of($row)

            ->addIndexColumn()

            ->addColumn('created_at',function($row){
                return Carbon::parse($row->updated_at)->format('d-m-Y h:i A');
            })

            ->addColumn('action', function($row){
                $btn = '';
                
                $btn .= '<a href="javascript:;" data-url="'.route('backend.posts.newsletter-email.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })

            ->addColumn('delCheckbox',function($row){

            $delCheckbox = '<div class="form-check"><input type="checkbox" class="form-check-input order_checkbox" name="order_checkbox[]"" value="'.$row->id.'"></div>';
            return $delCheckbox;
            })

            ->rawColumns(['created_at','action','delCheckbox'])
            ->make(true);
        }
        return view('backend.news_letter.index');

    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            
            NewsLetter::where('id',$id)->delete();

            return response()->json(['status' => 'success', 'message' => 'NewsLatter email deleted successfully.']);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

    public function removeall(Request $request){

        try{

            NewsLetter::whereIn('id',$request->id)->delete();
            return response()->json(['status'=>'success','message'=>'NewsLatter emails has deleted successfully.']);

        }catch(\Exception $e){

            return response()->json(['status'=>'error','message'=>'Oop`s! something wents worng.']);
        }
    }
}
