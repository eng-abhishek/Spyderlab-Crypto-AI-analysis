<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Investigation;
use App\Models\BlockchainUserNote;
use App\Models\InvestigationTxnHistory;
use Auth;

class WorkspaceController extends Controller
{

	public function __construct() {
        $this->middleware(['auth','verified']);
    }

    public function index(){

    	$record['investigation']= Investigation::take(2)->orderBy('created_at','desc')->where('user_id',Auth()->user()->id)->get();
    	 $record['alerts'] = InvestigationTxnHistory::whereHas('investigation_address',function($q){
          $q->where('user_id',Auth()->user()->id);
        })->get();
    	$record['fevourits']= BlockchainUserNote::take(2)->orderBy('created_at','desc')->where('user_id',Auth()->user()->id)->get();

           return view('frontend.account.workspace',$record);
    }

    public function cryptoAnalysis(){
    
            $record['investigation']= Investigation::take(2)->orderBy('created_at','desc')->where('user_id',Auth()->user()->id)->get();
         $record['alerts'] = InvestigationTxnHistory::whereHas('investigation_address',function($q){
          $q->where('user_id',Auth()->user()->id);
        })->get();
        $record['fevourits']= BlockchainUserNote::take(2)->orderBy('created_at','desc')->where('user_id',Auth()->user()->id)->get();
        return view('frontend.account.crypto-analysis',$record);
    }

    public function oldCryptoAnalysis(){
       return redirect()->route('crypto-analysis');
    }
}
