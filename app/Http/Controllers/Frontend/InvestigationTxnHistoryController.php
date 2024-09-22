<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Investigation;
use App\Models\InvestigationTxnHistory;
use DataTables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Str;

class InvestigationTxnHistoryController extends Controller
{

    public function __construct() {
        $this->middleware(['auth','verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     $start_date = InvestigationTxnHistory::take(1)->orderBy('txn_time')->first();
     $start_date = date('Y-m-d',strtotime($start_date->txn_time ?? ''));
     $end_date = InvestigationTxnHistory::take(1)->orderBy('txn_time','desc')->first();
     $end_date = date('Y-m-d',strtotime($end_date->txn_time ?? ''));
     
     return view('frontend.account.alert',['start_date'=>$start_date,'end_date'=>$end_date]);
    }

   public function getTableData(Request  $request){
      
      $query = InvestigationTxnHistory::whereHas('investigation_address',function($q){
          $q->where('user_id',Auth()->user()->id);
        });

    if(!is_null($request->get('token')) || !is_null($request->get('date_from')) || !is_null($request->get('date_to'))){

        $token = $request->get('token');
        $date_from = $request->get('date_from');
        $date_to = $request->get('date_to');

        $result = $query->where(function($qr) use ($token,$date_from,$date_to){

        if(!empty($token)){
        $qr->where('token',$token);
        }

        if(!empty($date_from) && !empty($date_to)){

        $qr->where(function ($query) use ($date_from, $date_to) {
         
              $query->whereDate('txn_time', '>=', $date_from)
                    ->whereDate('txn_time', '<=', $date_to);
          });
        }elseif(!empty($date_from) && empty($date_to)){
 
        $qr->where(function ($query) use ($date_from) {
              $query->whereDate('txn_time', '>=', $date_from);
          });

        }else{
        $qr->where(function ($query) use ($date_from) {
              $query->whereDate('txn_time', '<=', $date_to);
          });
        }
        })->paginate(10);
        
        $data['result'] = $result;

    }else{
       
        $data['result'] = $query->paginate(10);
       
    }

    return view('frontend.partials.alerts-table',$data);
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
     * @param  \App\InvestigationTxnHistory  $investigationTxnHistory
     * @return \Illuminate\Http\Response
     */
    public function show(InvestigationTxnHistory $investigationTxnHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InvestigationTxnHistory  $investigationTxnHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(InvestigationTxnHistory $investigationTxnHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InvestigationTxnHistory  $investigationTxnHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvestigationTxnHistory $investigationTxnHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InvestigationTxnHistory  $investigationTxnHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvestigationTxnHistory $investigationTxnHistory)
    {
        //
    }
}
