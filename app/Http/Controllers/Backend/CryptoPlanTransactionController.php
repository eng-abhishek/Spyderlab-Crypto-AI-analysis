<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CryptoPlanSubscription;
use App\Models\User;
use App\Models\Plan;
use App\Models\CryptoPlan;
use App\Models\CryptoPlanTransaction;
use DataTables;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Str;

class CryptoPlanTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       if($request->ajax()) {
        $data = CryptoPlanTransaction::with('users','plans','subscription');
        return Datatables::of($data)
        ->addIndexColumn()
        
        ->addColumn('tran_id', function($row){
        
         $txn_id = Str::limit($row->transaction_id, 25, '..');

        return '<a href="'.route('backend.transaction.show',$row->id).'"><p class="text-truncate" data-bs-toggle="tooltip" data-bs-original-title="'.$row->transaction_id.'">'.$txn_id.'</p></a>';
        })

        ->addColumn('tran_date', function($row){
            return $row->created_at->format('Y-m-d H:i:s');
        })

        ->addColumn('status', function($row){
            return $row->status;
        })

        ->addColumn('tran_amount', function($row){
               
                if($row->currency_type == 'fiat'){
                    $purchese_price = ($row->final_price) ? "$ ".$row->final_price : '';
                }else{
                    $purchese_price = ($row->final_price) ? $row->final_price." BTC" : '';
                }
                return $purchese_price;
            })

        ->addColumn('plan', function($row){
            $plan = (!is_null($row->plans) ? $row->plans->name : '');
            return $plan;
        })

        ->addColumn('user', function($row){
            return $row->users->username;
        })

        ->addColumn('exchange_type', function($row){
            $changeType='';

            if($row->plan_change_type=='N'){

                $changeType .= 'New';

            }elseif($row->plan_change_type=='U'){

                $changeType .= 'Upgrade';

            }elseif($row->plan_change_type=='D'){

                $changeType .= 'Downgrad';

            }elseif($row->plan_change_type=='R'){

             $changeType .= 'Renew';

         }else{
            $changeType .= 'Other';

        }
        return $changeType;
    })
        ->addColumn('action', function($row){
            $btn = '';
            $btn .= '<a href="'.route("backend.transaction.show", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-eye"></i></a>';
            return $btn;
        })

        ->filter(function ($instance) use ($request) {
            if (!empty($request->get('search'))) {
                $instance->where(function($w) use($request){
                    $search = $request->get('search');
                    $w->where('name', 'LIKE', "%$search%");
                });
            }
        })

        ->filter(function ($instance) use ($request) {
            if (!empty($request->get('status'))) {
                $instance->where(function($w) use($request){
                    $status = $request->get('status');
                    $w->where('status',$status);
                });
            }
        })

        ->rawColumns(['tran_id','tran_date','tran_amount','plan','user','exchange_type','action'])
        ->make(true);
    }
    return view('backend.transaction.index');
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
     * @param  \App\CryptoPlanTransaction  $cryptoPlanTransaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     $data['record'] = CryptoPlanTransaction::with('users','plans','subscription')->where('id',$id)->get();
     return view('backend.transaction.show',$data);
 }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CryptoPlanTransaction  $cryptoPlanTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(CryptoPlanTransaction $cryptoPlanTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CryptoPlanTransaction  $cryptoPlanTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CryptoPlanTransaction $cryptoPlanTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CryptoPlanTransaction  $cryptoPlanTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(CryptoPlanTransaction $cryptoPlanTransaction)
    {
        //
    }
}
