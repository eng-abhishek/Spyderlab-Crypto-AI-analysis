<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\UserCreditRequest;
use DataTables;
use App\Models\User;
use App\Models\UserCredit;
use App\Models\Plan;

class UserCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = UserCredit::with('user', 'plan', 'created_by_user')->select('*');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function($row){
                return $row->user ? $row->user->username : '';
            })
            ->addColumn('plan', function($row){
                return !is_null($row->plan)?$row->plan->name:'---';
            })
            ->addColumn('purchase_price', function($row){
                return '<i class="fas fa-rupee-sign"></i> '.$row->purchase_price;
            })
            ->addColumn('credit_type', function($row){
                return ($row->is_free == 'Y')?'Free':'Paid';
            })
            ->addColumn('created_at', function($row){
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('expired_at', function($row){
                return $row->expired_at->format('Y-m-d H:i:s');
            })
            ->addColumn('created_by', function($row){
                return $row->created_by_user->name;
            })
            ->addColumn('action', function($row){
                $btn = '';
                if($row->is_free == 'Y'){
                    $btn .= '<a href="javascript:;" data-url="'.route('backend.user-credits.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm"><i class="fa-light fa-trash-can"></i></a>';
                }
                return $btn;
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                        $w->whereHas('user', function($user) use($search){
                            $user->where('name', 'LIKE', "%$search%");
                        });
                    });
                }
            })
            ->rawColumns(['purchase_price', 'action'])
            ->make(true);
        }

        return view('backend.user-credit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select('id', \DB::raw('CONCAT(name," (", username,")") as name'))->where('is_admin', 'N')->active()->get()->pluck('name', 'id');
        $plans = Plan::get();

        return view('backend.user-credit.create', ['users' => $users, 'plans' => $plans]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreditRequest $request)
    {
        try {

            $user = \Auth::guard('backend')->user();

            $plan_id = $request->get('plan_id') ?? null;
            if(!is_null($plan_id)){
                $plan = Plan::find($plan_id);
                $credits = $plan->credits;
            }else{
                $credits = $request->get('credits');
            }

            $expired_at = now()->addMonths(6)->format('Y-m-d H:i:s');

            UserCredit::create([
                'user_id' => $request->get('user_id'),
                'plan_id' => $plan_id,
                'received_credits' => $credits,
                'available_credits' => $credits,
                'is_free' => 'Y',
                'expired_at' => $expired_at,
                'created_by' => $user->id
            ]);

            return redirect()->route('backend.user-credits.index')->with(['status' => 'success', 'message' => 'Credit added successfully.']);

        } catch (\Exception $e) {
            return redirect()->route('backend.user-credits.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanRequest $request, $id)
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

            $user_credit = UserCredit::find($id);

            $user_credit->delete();

            return response()->json(['status' => 'success', 'message' => 'Credit removed successfully.']);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
