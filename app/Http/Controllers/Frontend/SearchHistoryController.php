<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SearchHistory;
use App\Models\SearchResult;

class SearchHistoryController extends Controller
{
    public function __construct() {
        $this->middleware(['auth','verified']);
    }

    /**
     * Search listing.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();

        $records = SearchHistory::where('user_id', $user->id)
        ->with('user', 'result.country')
        ->orderBy('updated_at', 'desc')
        ->paginate(10);
        
        $seoData=\App\Models\Seo::where('slug','search-history')->first();
        return view('frontend.account.search-history.index', ['records' => $records,'seoData'=>$seoData]);

        //return view('frontend.search-history.index', ['records' => $records,'seoData'=>$seoData]);
    }

    /**
     * Display the specified history.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $seoData=\App\Models\Seo::where('slug','search-history')->first();

        $search_history = SearchHistory::find($id);
        if(!$search_history){
            return redirect()->route('history.index')->with(['status' => 'danger', 'message' => 'Record not found.']);
        }

        $search_result = SearchResult::find($search_history->search_result_id);
        if(!$search_result){
            return redirect()->route('history.index')->with(['status' => 'danger', 'message' => 'Record not found.']);
        }

        /* Fetch latest detail by phone  */
        if($request->method() == 'POST'){

            $available_credits = available_credits();
            if($available_credits == 0){
                return redirect()->route('history.show', $id)->with(['status' => 'danger', 'message' => 'You doesn\'t have enough credit, please buy it from &nbsp;<a href="'.route('pricing').'">Pricing</a>']);
            }

            $get_details_by_phone = $this->get_details_by_phone($search_result->country_code, $search_result->search_value);
            $result_obj = json_decode($get_details_by_phone);

            if($result_obj->status_code == 200){
                $search_result->result = json_encode((array)$result_obj->data);
                $search_result->updated_by = auth()->user()->id;
                $search_result->save();

                /* deduct credit for search */
                $this->deduct_credit(auth()->user()->id);
            }

            return redirect()->route('history.show', $id)->with(['status' => 'success', 'message' => 'Latest data fetched successfully.']);
        }

        return view('frontend.account.search-history.show', ['search_history' => $search_history, 'search_result' => $search_result,'seoData' => $seoData]);
    }
}
