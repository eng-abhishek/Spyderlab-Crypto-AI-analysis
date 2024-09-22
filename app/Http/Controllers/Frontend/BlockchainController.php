<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Blockchain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// use GuzzleHttp\Exception\GuzzleException;
// use GuzzleHttp\Client as GuzzleClient;

class BlockchainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['seoData']= \App\Models\Seo::where('slug','crypto-tracking')->first();
    	return view('frontend.blockchain-analysis',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function blockchainSearch(Request $request)
    {
         $data['seoData']= \App\Models\Seo::where('slug','crypto-tracking')->first();

    	if($request->isMethod('get')){
    		return redirect()->route('blockchain-analysis');
    	}

    	$api_url = 'https://api.chainsight.com/api/check?keyword='.$request->get('keyword').'';

    	$headers = [
    		'X-API-KEY' => 'w7goRlONIJKbdbQBpbPX4boPYFOVfDszE1QaT'
    	];

    	try {

    		$response = Http::withHeaders($headers)->get($api_url);

    		$data = ['status_code' => $response->status(), 'breached' => false, 'records' => null];
    		if($response->status() == 200 && !is_null($response->body())){
    			$data['breached'] = true;
    			$data['records'] = $response->body();
    		}
    		
    		$result =  (object) $data;
    		$data['result_response'] = json_decode($result->records);

    		return view('frontend.blockchain-analysis-listing',$data);

    	} catch (\Exception $e) {
    		return redirect()->route()->with(['message'=>'Oop`s something wents wrong','status'=>'danger']);
    	}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function BlockchainKeywordResult($keyword)
    // {       //   echo"<pre>";
    
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blockchain  $blockchain
     * @return \Illuminate\Http\Response
     */
    public function blogChainDetails($keyword,$key)
    {

    	$api_url = 'https://api.chainsight.com/api/check?keyword='.$keyword.'';

    	$headers = [
    		'X-API-KEY' => 'w7goRlONIJKbdbQBpbPX4boPYFOVfDszE1QaT'
    	];

    	try {

    		$response = Http::withHeaders($headers)->get($api_url);

    		$data = ['status_code' => $response->status(), 'breached' => false, 'records' => null];
    		if($response->status() == 200 && !is_null($response->body())){
    			$data['breached'] = true;
    			$data['records'] = $response->body();
    		}
    		
    		$result =  (object) $data;
    		$data['result_response'] = json_decode($result->records);
    		$data['result'] = $data['result_response']->data[$key];

    		if((count($data['result_response']->data[$key]->labels))>0){
    			$data['labels'] = $data['result_response']->data[$key]->labels;
    		}else{
    			$data['labels'] = 0;
    		}

    		return view('frontend.blockchain-analysis-listing-details',$data);

    	} catch (\Exception $e) {
    		return redirect()->route()->with(['message'=>'Oop`s something wents wrong','status'=>'danger']);
    	}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blockchain  $blockchain
     * @return \Illuminate\Http\Response
     */
    public function edit(Blockchain $blockchain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blockchain  $blockchain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blockchain $blockchain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blockchain  $blockchain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blockchain $blockchain)
    {
        //
    }
}
