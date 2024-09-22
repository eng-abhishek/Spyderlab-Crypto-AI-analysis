<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use DataTables;

class UserLoginLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
            //  $data = LoginLog::with('login_user')->whereHas('login_user',function($q){
            // $q->where('is_admin','N');
            // })->get();
            //  dd($data);

        if ($request->ajax()) {

            // $data = LoginLog::whereHas('login_user',function($q){
            // $q->where('is_admin','N');
            // });
            $data = LoginLog::with('login_user')->whereHas('login_user',function($q){
            $q->where('is_admin','N');
            });

            return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('action', function($row){
                $btn = '';

                $btn .= '<a href="javascript:;" data-url="'.route('backend.auth-log.user.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })

            ->addColumn('created_at', function($row){
                return $row->created_at->format('Y-m-d H:i:s');
            })

            ->addColumn('user_email', function($row){
                return $row->login_user->email;
            })

            ->addColumn('delCheckbox',function($row){

                $delCheckbox = '<div class="form-check"><input type="checkbox" class="form-check-input order_checkbox" name="order_checkbox[]"" value="'.$row->id.'"></div>';
                return $delCheckbox;
            })

            ->rawColumns(['action','delCheckbox'])
            ->make(true);
        }

        return view('backend.auth_log.user');
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
