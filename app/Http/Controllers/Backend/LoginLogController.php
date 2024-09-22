<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use DataTables;

class LoginLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {

            $data = LoginLog::whereHas('login_user',function($q){
            $q->where('is_admin','Y');
            });

            return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('action', function($row){
                $btn = '';

                $btn .= '<a href="javascript:;" data-url="'.route('backend.auth-log.admin.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })

            ->addColumn('created_at', function($row){
                return $row->created_at->format('Y-m-d H:i:s');
            })


            ->addColumn('user_type', function($row){
                return 'Admin';
            })

            ->addColumn('delCheckbox',function($row){

                $delCheckbox = '<div class="form-check"><input type="checkbox" class="form-check-input order_checkbox" name="order_checkbox[]"" value="'.$row->id.'"></div>';
                return $delCheckbox;
            })

            ->rawColumns(['action','delCheckbox'])
            ->make(true);
        }

        return view('backend.auth_log.admin');
    }

    
    public function destroy($id)
    {
        try{

            LoginLog::where('id',$id)->delete();

            return response()->json(['status' => 'success', 'message' => 'log deleted successfully.']);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

    public function removeall(Request $request){

        try{

            LoginLog::whereIn('id',$request->id)->delete();
            return response()->json(['status'=>'success','message'=>'log has deleted successfully.']);

        }catch(\Exception $e){

            return response()->json(['status'=>'error','message'=>'Oop`s! something wents worng.']);
        }
    }
}
