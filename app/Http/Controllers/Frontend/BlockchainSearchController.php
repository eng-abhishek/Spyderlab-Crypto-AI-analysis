<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlockchainSearch;
use App\Models\BlockchainSearchResult;
use Illuminate\Support\Facades\Http;
use App\Models\BlockchainUserNote;
use App\Models\BlockchainAddressReport;
use App\Http\Requests\FlagRequest;
use App\Models\BlockchainAddressDetail;
use App\Models\BlockchainAddressTxn;
use App\Models\BlockchainAddressTxnInout;
use App\Models\BlockchainAddressLabel;
use Auth;
use PDF;

class BlockchainSearchController extends Controller
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
        // dd($request->all());

        if(is_null($request->get('keyword'))){
            return redirect()->route('blockchain-analysis')->with(['status' => 'danger', 'message' => 'Required paramete missing:keyword']);
        }

        if(is_null($request->get('result_no'))){

            /* START:Temporary solution */
            $has_access = false;
            if(Auth::check()){
                $has_access = true;
                if(is_null(Auth::user()->email_verified_at)){
                    return redirect('email/verify');
                }

                /* Check KYC */
                if(isset(is_kyc_mandatory()->kyc_mandatory)){

                  if(is_kyc_mandatory()->kyc_mandatory == 'Y'){

                    if(is_null(Auth::user()->kyc_verified_at)){
                        return redirect()->route('blockchain-analysis')->with(['status' => 'danger', 'message' => 'Your account is disabled for this service. It will be enabled after ID verification. Please contact us at '.config('mail.kyc_verification_mail').'.']);
                    }
                }
            }
        }

        if(!$has_access){

            return redirect()->route('login');    
        }

            /* Check User Subscription */
          
         $response = $this->check_user_subscription();
         if(!is_null($response)){
             return redirect()->route($response['route'])->with(['status'=>$response['status'],'message'=>$response['message']]);
         }

            /*  End User Subscription */

            /* api call */
            $this->search_blockchain_by_keyword($request,null,null,'web_user');

            $blockchain_search = BlockchainSearch::where('keyword', $request->get('keyword'))->first();
            if(!$blockchain_search){
                return redirect()->route('blockchain-analysis')->with(['status' => 'danger', 'message' => 'Record not found for this keyword.']);
            }

            $blockchain_search_result = BlockchainSearchResult::where('search_id', $blockchain_search->id)
            ->get();

            return view('frontend.account.blockchain-search-list', ['keyword' => $request->get('keyword'), 'status_code' => $blockchain_search->status_code, 'results' => $blockchain_search_result]);

        }else{

            /* START:Temporary solution */
            $has_access = false;
            if(Auth::check() || Auth::guard('backend')->check()){
                $has_access = true;
                if(Auth::check() && is_null(Auth::user()->email_verified_at)){
                    return redirect('email/verify');
                }

                /* Check KYC */
                if(isset(is_kyc_mandatory()->kyc_mandatory)){

                  if(is_kyc_mandatory()->kyc_mandatory == 'Y'){

                    if(is_null(Auth::user()->kyc_verified_at)){
                        return redirect()->route('blockchain-analysis')->with(['status' => 'danger', 'message' => 'Your account is disabled for this service. It will be enabled after ID verification. Please contact us at '.config('mail.kyc_verification_mail').'.']);
                    }
                }
            }
        }

        if(!$has_access){
            return redirect()->route('login');    
        }
        /* END:Temporary solution */

        $blockchain_search = BlockchainSearch::where('keyword', $request->get('keyword'))->first();
        if(!$blockchain_search){
            return redirect()->route('blockchain-analysis')->with(['status' => 'danger', 'message' => 'Record not found for this keyword.']);
        }

        $blockchain_search_result = BlockchainSearchResult::where('search_id', $blockchain_search->id)
        ->where('unique_id', $request->get('result_no'))
        ->first();

        if(!$blockchain_search_result){
            return redirect()->route('blockchain-analysis')->with(['status' => 'danger', 'message' => 'Record not found for this keyword.']);    
        }

        if(!$blockchain_search_result->address){
            return redirect()->route('blockchain-analysis')->with(['status' => 'danger', 'message' => 'Record not found for this keyword.']);
        }

        if(Auth::user()){

            $uid = Auth::user()->id;

        }else{

            $uid = Auth::guard('backend')->user()->id;

        }
        $total_flag = BlockchainAddressReport::where(['user_id'=>$uid,'address'=>$request->get('keyword')])->count();

        $usernotes = BlockchainUserNote::where(['user_id'=>$uid,'address'=>$request->get('keyword')])->first();

        if(is_null($usernotes)){
            $user_notes = '';
        }else{
            $user_notes = $usernotes->description;
        }

        /* START:Blockcypher */
        $blockcypher = [];

        $blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();

        /* START:Temporary Code*/
        if(!$blockcypher_address_detail && $blockchain_search_result->address != ''){
            $this->get_blockcypher_details($blockchain_search_result->address, $blockchain_search->id);

            $blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();
        }
        /* END:Temporary Code*/

        if(!$blockcypher_address_detail){
            $url = route('blockchain-search').'?keyword='.$request->get('keyword');
            return redirect($url)->with(['status' => 'danger', 'message' => 'This Blockchain data available via support.']);
        }

        $blockcypher['address_details'] = $blockcypher_address_detail;

        $monthly_transactions = BlockchainAddressTxn::select(\DB::raw('DATE_FORMAT(confirmed_at, "%b-%y") as name'), \DB::raw('count(*) as y'))
        ->where('address_detail_id', $blockcypher_address_detail->id)
        ->groupBy('name')
        ->orderBy('confirmed_at', 'asc')
        ->take(10)
        ->get();

        $blockcypher['monthly_txn_chart_data'] = json_encode($monthly_transactions->toArray());
        /* END:Blockcypher */

        $labels = BlockchainAddressLabel::where('address',$request->get('keyword'))->pluck('labels');

        $array_labels = [];

        if(count($blockchain_search_result->labels)>0){
            foreach($blockchain_search_result->labels as $key=>$labelsData){
              $array_labels[] =  $labelsData->id;    
          }
      }

      if(!is_null($labels) AND count($labels) > 0){
         $or_array_labels = explode(',',$labels[0]);
         $new_array_labels= array_merge($array_labels,$or_array_labels);
     }else{
        $new_array_labels= $array_labels;
    }


    $array_flip = array_flip($array_labels);  
    unset($array_flip['abuse']);
    unset($array_flip['ransomware']);
    unset($array_flip['ransom']);
    unset($array_flip['theft']);
    $array_flip_count = count($array_flip);

    if($request->get('download-report') == true){

        $pdf = PDF::loadView('frontend.account.alm-risk-report',
             ['chainsight' => $blockchain_search_result,
             'keyword' => $request->get('keyword'),
             'blockcypher' => $blockcypher,
            ]);
        return $pdf->download('risk-score.pdf');
    }

    return view('frontend.account.blockchain-search-detail', [
        'keyword' => $request->get('keyword'),
        'chainsight' => $blockchain_search_result,
        'blockcypher' => $blockcypher,
        'array_labels' => $array_labels,
        'new_array_labels' => (isset($new_array_labels) ? $new_array_labels : array()),
        'total_flag' => $total_flag,
        'user_notes' => $user_notes,
        'result_no' => $request->get('result_no'),
        'array_flip_count' => $array_flip_count,
    ]);
}
}

    /**
     * Display the specified history's result.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $blockchain_search = BlockchainSearch::where('id', $id)->first();

        if(!$blockchain_search){
            return redirect()->route('blockchain-analysis')->with(['status' => 'danger', 'message' => 'Record not found for this keyword.']);
        }

        $blockchain_search_result = BlockchainSearchResult::where('search_id', $blockchain_search->id)
        ->get();

        return view('frontend.account.blockchain-search-list', ['keyword' => $blockchain_search->keyword, 'status_code' => $blockchain_search->status_code, 'results' => $blockchain_search_result]);
    }

    /**
     * Get network graph details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxNetworkGraph(Request $request){
        if(is_null($request->get('keyword'))){
            return response()->json(['status' => 'danger', 'message' => 'Required paramete missing:keyword']);
        }

        $blockchain_search = \App\Models\BlockchainSearch::where('keyword', $request->get('keyword'))->first();
        if(!$blockchain_search){
            return response()->json(['status' => 'danger', 'message' => 'Record not found for this keyword']);
        }

        $blockchain_search_result = \App\Models\BlockchainSearchResult::where('search_id', $blockchain_search->id)
        ->get();

        $network_graph_data = [];
        foreach($blockchain_search_result as $value){
            if(!is_null($value->chain)){
                $network_graph_data[] = ['Account', $value->chain->name];
            }
            if(!is_null($value->labels)){
                foreach($value->labels as $label){
                    $network_graph_data[] = [$value->chain->name, $label->categoryId];
                    $network_graph_data[] = [$label->categoryId, $label->id];
                }
            }
        }
        
        return response()->json(['status' => 'success', 'network_graph_data' => $network_graph_data]);
    }

    /**
     * Get blockchain address senders/recipients.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxGetBlockcypherTxnList(Request $request){
        $blockcypher_txn_data = [];

        $currency = get_currency_from_address($request->get('keyword'));

        if(is_null($request->get('keyword'))){
            return view('frontend.partials.blockcypher-txn-list', [
                'currency' => $currency,
                'list_type' => $request->get('list_type'),
                'blockcypher_txn_data' => $blockcypher_txn_data
            ]);
        }

        $blockchain_search = \App\Models\BlockchainSearch::where('keyword', $request->get('keyword'))->first();
        if(!$blockchain_search){
            return view('frontend.partials.blockcypher-txn-list', [
                'currency' => $currency,
                'list_type' => $request->get('list_type'),
                'blockcypher_txn_data' => $blockcypher_txn_data
            ]);
        }

        $address = $blockchain_search->keyword;

        if(!is_null($request->get('list_type')) && in_array($request->get('list_type'), ['senders', 'recipients'])){

            $from_date = $request->get('from_date');
            $to_date = $request->get('to_date');

            if($request->get('list_type') == 'senders'){
                $blockcypher_txn_data = BlockchainAddressTxnInout::Select('id','from', 'to', \DB::raw('COUNT(DISTINCT txn_id) AS txn'), \DB::raw('SUM(amount) AS amount'))
                ->where('to', $address)
                ->when(!is_null($from_date) && !is_null($to_date), function($when) use($from_date, $to_date){
                    $when->whereHas('transaction', function($txn) use($from_date, $to_date){
                        $txn->whereDate('confirmed_at', '>=', $from_date);
                        $txn->whereDate('confirmed_at', '<=', $to_date);
                    });
                })
                ->groupBy('from')
                ->paginate(3);
            }else{
                $blockcypher_txn_data = BlockchainAddressTxnInout::Select('id','from', 'to', \DB::raw('COUNT(DISTINCT txn_id) AS txn'), \DB::raw('SUM(amount) AS amount'))
                ->where('from', $address)
                ->when(!is_null($from_date) && !is_null($to_date), function($when) use($from_date, $to_date){
                    $when->whereHas('transaction', function($txn) use($from_date, $to_date){
                        $txn->whereDate('confirmed_at', '>=', $from_date);
                        $txn->whereDate('confirmed_at', '<=', $to_date);
                    });
                })
                ->groupBy('to')
                ->paginate(3);            
            }
        }
        return view('frontend.partials.blockcypher-txn-list', [
            'currency' => $currency,
            'list_type' => $request->get('list_type'),
            'blockcypher_txn_data' => $blockcypher_txn_data
        ]);
    }

    /**
     * Get transaction network graph details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxTransactionNetworkGraph(Request $request){
        if(is_null($request->get('keyword'))){
            return response()->json(['status' => 'danger', 'message' => 'Required paramete missing:keyword']);
        }

        $blockchain_search = \App\Models\BlockchainSearch::where('keyword', $request->get('keyword'))->first();
        if(!$blockchain_search){
            return response()->json(['status' => 'danger', 'message' => 'Record not found for this keyword']);
        }

        $blockcypher_address_detail = BlockchainAddressDetail::where('search_id', $blockchain_search->id)->first();
        if(!$blockcypher_address_detail){
            return response()->json(['status' => 'danger', 'message' => 'Record not found for this keyword']);
        }

        $currency = $blockcypher_address_detail->currency;

        $from_date = $request->get('from_date');
        $to_date = $request->get('to_date');

        $blockcypher_txn_senders = BlockchainAddressTxnInout::Select('from', 'to', \DB::raw('COUNT(DISTINCT txn_id) AS txn'), \DB::raw('SUM(amount) AS amount'))
        ->where('to', $request->get('keyword'))
        ->when(!is_null($from_date) && !is_null($to_date), function($when) use($from_date, $to_date){
            $when->whereHas('transaction', function($txn) use($from_date, $to_date){
                $txn->whereDate('confirmed_at', '>=', $from_date);
                $txn->whereDate('confirmed_at', '<=', $to_date);
            });
        })
        ->groupBy('from')
        ->get();

        $blockcypher_txn_recipients = BlockchainAddressTxnInout::Select('from', 'to', \DB::raw('COUNT(DISTINCT txn_id) AS txn'), \DB::raw('SUM(amount) AS amount'))
        ->where('from', $request->get('keyword'))
        ->when(!is_null($from_date) && !is_null($to_date), function($when) use($from_date, $to_date){
            $when->whereHas('transaction', function($txn) use($from_date, $to_date){
                $txn->whereDate('confirmed_at', '>=', $from_date);
                $txn->whereDate('confirmed_at', '<=', $to_date);
            });
        })
        ->groupBy('to')
        ->get();

        /* Get wallet address details */
        // $wallet_addresses = \App\Models\WalletAddress::get()->pluck('image', 'address')->toArray();
        $wallet_addresses = \App\Models\WalletAddress::get()->keyBy('address')->toArray();
        // dd($wallet_addresses);
        // if(isset($wallet_addresses[$request->get('keyword')])){
        //     dd($wallet_addresses[$request->get('keyword')]['image']);
        // }else{
        //     dd('no');
        // }
        /* Generate chart data */
        $nodes = [];
        $edges = [];

        $node_id = 1;

        if(isset($wallet_addresses[$request->get('keyword')]) && $wallet_addresses[$request->get('keyword')]['image'] != ''){
            $nodes[] = [
                'id' => $node_id,
                'label' => $wallet_addresses[$request->get('keyword')]['name'],
                'title' => "Name : ".$wallet_addresses[$request->get('keyword')]['name']."\n Address : ".$wallet_addresses[$request->get('keyword')]['address'],
                'shape' => 'circularImage',
                'image' => $wallet_addresses[$request->get('keyword')]['image'],
                'size' => 25,
                'node_address' => strtolower($request->get('keyword'))
            ];
        }else{
            $nodes[] = [
                'id' => $node_id,
                'label' => 'Account',
                'title' => strtolower($request->get('keyword')),
                'shape' => 'star',
                'color' => '#C2FABC',
                'node_address' => strtolower($request->get('keyword'))
            ];
        }

        foreach($blockcypher_txn_senders as $sender){
            if(!collect($nodes)->where('title', strtolower($sender->from))->first()){
                $node_id++;

                if(isset($wallet_addresses[$sender->from]) && $wallet_addresses[$sender->from]['image'] != ''){
                    $nodes[] = [
                        'id' => $node_id,
                        'label' => $wallet_addresses[$sender->from]['name'],
                        'title' => "Name : ".$wallet_addresses[$sender->from]['name']."\n Address : ".$wallet_addresses[$sender->from]['address'],
                        'shape' => 'circularImage',
                        'image' => $wallet_addresses[$sender->from]['image'],
                        'size' => 25,
                        'node_address' => strtolower($sender->from)
                    ];
                }else{
                    $nodes[] = [
                        'id' => $node_id,
                        'label' => \Str::limit($sender->from, 5),
                        'title' => strtolower($sender->from),
                        'node_address' => strtolower($sender->from)
                    ];
                }
            }

            $amount = round($sender->amount/config('constants.blockcypher.amount.'.$currency), 4).' '.strtoupper($currency);

            $edges[] = [
                'from' => strtolower($sender->from),
                'to' => strtolower($sender->to),
                'arrows' => 'to',
                'label' => $amount,
                'title' => $amount
            ];
        }
        foreach($blockcypher_txn_recipients as $recipient){
            if(!collect($nodes)->where('title', strtolower($recipient->to))->first()){
                $node_id++;

                if(isset($wallet_addresses[$recipient->to]) && $wallet_addresses[$recipient->to]['image'] != ''){
                    $nodes[] = [
                        'id' => $node_id,
                        'label' => $wallet_addresses[$recipient->to]['name'],
                        'title' => "Name : ".$wallet_addresses[$recipient->to]['name']."\n Address : ".$wallet_addresses[$recipient->to]['address'],
                        'shape' => 'circularImage',
                        'image' => $wallet_addresses[$recipient->to]['image'],
                        'size' => 25,
                        'node_address' => strtolower($recipient->to)
                    ];
                }else{
                    $nodes[] = [
                        'id' => $node_id,
                        'label' => \Str::limit($recipient->to, 5),
                        'title' => strtolower($recipient->to),
                        'node_address' => strtolower($recipient->to)
                    ];
                }
            }

            $amount = round($recipient->amount/config('constants.blockcypher.amount.'.$currency), 4).' '.strtoupper($currency);

            $edges[] = [
                'from' => strtolower($recipient->to),
                'to' => strtolower($recipient->from),
                'arrows' => 'from',
                'label' => $amount,
                'title' => $amount
            ];
        }

        //Replace address by node's id
        foreach($edges as $key => $edge){
            $edges[$key]['from'] = collect($nodes)->where('node_address', $edges[$key]['from'])->first()['id'];
            $edges[$key]['to'] = collect($nodes)->where('node_address', $edges[$key]['to'])->first()['id'];
        }

        $data = [
            'nodes' => $nodes,
            'edges' => $edges
        ];

        return response()->json(['status' => 'success', 'data' => $data]);
    }
    
    public function createUserNote(Request $request)
    {
      try{

        $check_exist = BlockchainUserNote::where(['user_id'=>Auth::user()->id,'address'=>$request->post('address')])->count();
        if($check_exist > 0){

            BlockchainUserNote::where(['user_id'=>Auth::user()->id,'address'=>$request->post('address')])->update([
                'description'=>$request->post('user_notes')
            ]);

        }else{
            BlockchainUserNote::create([
                'description' => $request->post('user_notes'),
                'address' => $request->post('address'),
                'address_type' => $request->post('coin'),
                'user_id' => Auth::user()->id
            ]);
        }
        return response()->json(['status'=>'success','message'=>'Your notes has saved successfully..']);

    }catch(\Exception $e){
        return response()->json(['status'=>'danger','message'=>'Oop`s something went wrong..']);
    }
}

public function createAddressReport(FlagRequest $request)
{
    try{

        if(Auth::user()){

            $uid = Auth::user()->id;
        }else{

            $uid = Auth::guard('backend')->user()->id;
        }

        BlockchainAddressReport::Create([
            'user_id' => $uid,
            'address_type' => $request->get('address_type'),
            'address' => $request->get('address'),
            'report_type' => $request->get('report_type'),
            'description' => $request->get('description'),
        ]);
        return redirect()->back()->with(['status'=>'success','message'=>'Flag has saved successfully..']);
    }catch(\Exception $e){
        return redirect()->back()->with(['status'=>'danger','message'=>'Oop`s something went wrong.']);
    }
}

    /**
    *  Get Txn Details Using Ajax
    */
    public function getTxnDetails(Request $request){

      if($request->get('type') == 'senders'){

       $to = $request->get('keyword');
       $from = $request->get('address');

   }else{

       $from = $request->get('keyword');
       $to = $request->get('address');

   }
   $currency = get_currency_from_address($request->get('keyword'));

   $blockcypher_txn_data = BlockchainAddressTxnInout::with('transaction')->where(['from'=>$from,'to'=>$to])->paginate(10);

   return view('frontend.partials.blockcypher-txn-details',['blockcypher_txn_data'=>$blockcypher_txn_data,'sender'=>$from,'receiver'=>$to,'currency'=>$currency]);
}

// public function check_user_subscription(){
// }

}