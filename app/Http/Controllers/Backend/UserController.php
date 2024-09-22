<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use App\Models\CryptoPlan;
use App\Models\CryptoPlanSubscription;
use App\Models\CryptoPlanTransaction;
use App\Models\BlockchainSearchHistory;
use App\Models\BlockchainUserNote;
use App\Models\BlockchainAddressReport;
use App\Models\UserCredit;
use App\Models\SearchHistory;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = \Auth::guard('backend')->user();

        if ($request->ajax()) {
            $data = User::with(['user_credits' => function($qry){
                $qry->where('expired_at', '>', now());
            }])->where('is_admin', 'N');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('last_login_at', function($row){
                if(!is_null($row->last_login_at)){
                    return $row->last_login_at->diffForHumans();
                }else{
                    return 'Never signed in';
                }
            })
            ->addColumn('created_at', function($row){
                return $row->created_at->format("Y-m-d H:i:s");
            })
            ->addColumn('status', function($row){
                if(!$row->isSuperAdmin()){
                    // if($row->is_active == 'Y'){
                    //     return '<span class="btn btn-success change-status" data-value="Y" data-url="'.route('backend.users.change-status', $row->id).'">Active</span>';
                    // }else{
                    //     return '<span class="btn btn-danger change-status" data-value="N" data-url="'.route('backend.users.change-status', $row->id).'">In-Active</span>';
                    // }
                    if($row->is_active == 'Y'){
                        return '<div class="form-check form-switch"><input type="checkbox" data-value="Y" data-url="'.route('backend.users.change-status', $row->id).'" class="form-check-input change-status" checked></div>';
                    }else{
                        return '<div class="form-check form-switch"><input type="checkbox" data-value="N" data-url="'.route('backend.users.change-status', $row->id).'" class="form-check-input change-status"></div>';
                    }
                }
            })
            ->addColumn('credits', function($row){
                return $row->user_credits->sum('available_credits');
            })
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="javascript:;" data-url="'.route('backend.users.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })
            ->addColumn('kyc', function($row){
                $kyc = 'Verified';
                if(is_null($row->kyc_verified_at)){
                    $kyc = '<button type="button" data-url="'.route('backend.users.verify-kyc', $row->id).'" class="btn btn-light my-3 verify-kyc" title="Click to verify KYC">Verify</button>';
                }
                return $kyc;
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('status') != '') {
                    $instance->where('is_active', $request->get('status'));
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%");
                    });
                }
            })
            ->order(function ($query) {
                $query->orderBy('created_at', 'desc');
            })
            ->rawColumns(['role', 'status', 'action', 'kyc'])
            ->make(true);
        }

        return view('backend.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        abort(404);
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

           $check_sub = CryptoPlanSubscription::where('user_id',$id)->first();
           $check_credit = UserCredit::where('user_id',$id)->first();
           $user_data = User::where('id',$id)->first();

           if(!is_null($user_data)){
               if($user_data->is_active == 'Y'){

                  return response()->json(['status' => 'danger', 'message' => 'You can`t delete, because user status is active.']);
              }
          }

          if(!is_null($check_sub)){

              if($check_sub->is_active == 'Y'){

                  return response()->json(['status' => 'danger', 'message' => 'You can`t delete, because user subscription is active.']);   
              }
          }

          if(!is_null($check_credit)){
              if($check_credit->available_credits > 0){

                  return response()->json(['status' => 'danger', 'message' => 'You can`t delete, because user have credit.']);   

              }
          }

          $del = User::findOrFail($id);
          $del->delete();
          
          return response()->json(['status' => 'success', 'message' => 'User deleted successfully.']);
      }catch(\Exception $e){
          
       return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
   }
}

    /**
     * Verify KYC.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verifyKYC($id)
    {
        try{
            $user = User::find($id);

            if(is_null($user->kyc_verified_at)){
                $user->kyc_verified_at = now();
                $message = 'KYC verified successfully.';
            }else{
                $message = 'KYC already verified.';
            }

            $user->save();

            return response()->json(['status' => 'success', 'message' => $message]);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

    /**
     * Change user status.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus($id)
    {
        try{
            $user = User::find($id);

            if($user->is_active == 'N'){
                $user->is_active = 'Y';
                $message = 'User activated successfully.';
            }else{
                $user->is_active = 'N';
                $message = 'User deactivated successfully.';
            }

            $user->save();

            return response()->json(['status' => 'success', 'message' => $message]);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
