<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlockchainSearchHistory;

class BlockchainSearchHistoryController extends Controller
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

        $records = BlockchainSearchHistory::where('user_id', $user->id)
        ->with('user', 'search')
        ->orderBy('updated_at', 'desc')
        ->paginate(10);

        $seoData = \App\Models\Seo::where('slug','blockchain-search-history')->first();

        return view('frontend.account.blockchain-search-history.index', ['records' => $records,'seoData'=>$seoData]);
    
    }
}
