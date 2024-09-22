<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\BlockchainSearch;
use App\Models\BlockchainSearchResult;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlockchainSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BlockchainSearch::with('updated_by_user')->select('*');
            return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('updated_by', function($row){
                return !is_null($row->updated_by) ? $row->updated_by_user->name : '';
            })

            ->addColumn('keyword', function($row){
                return Str::limit($row->keyword,55,'..');
            })
            ->addColumn('updated_at', function($row){
                return !is_null($row->updated_at) ? $row->updated_at->format('Y-m-d H:i:s') : '';
            })
            ->addColumn('updated_by', function($row){
                return !is_null($row->updated_by) ? $row->updated_by_user->name : '';
            })

            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="'.route("backend.blockchain-searches.show", $row->id).'" target="_blank" class="btn btn-outline-primary btn-sm" title="View"><i class="fa-light fa-eye"></i></a>';
                return $btn;
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                        $w->where('keyword', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('backend.blockchain-search.index');
    }

    /**
     * Display search list for keywords.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $blockchain_search = BlockchainSearch::where('id', $id)->first();
        if(!$blockchain_search){
            return redirect()->route('blockchain-searches')->with(['status' => 'danger', 'message' => 'Record not found for this keyword.']);
        }

        if(is_null($request->get('result_no'))){
            $blockchain_search_result = BlockchainSearchResult::where('search_id', $blockchain_search->id)
            ->get();

            return view('frontend.account.blockchain-search-list', ['keyword' => $blockchain_search->keyword, 'blockchain_search_id' => $blockchain_search->id, 'status_code' => $blockchain_search->status_code, 'results' => $blockchain_search_result]);
        }else{

            $blockchain_search_result = BlockchainSearchResult::where('search_id', $blockchain_search->id)
            ->where('unique_id', $request->get('result_no'))
            ->first();

            if(!$blockchain_search_result){
                return redirect()->route('blockchain-searches')->with(['status' => 'danger', 'message' => 'Record not found.']);    
            }

            if(!$blockchain_search_result->address){
                return redirect()->route('blockchain-searches')->with(['status' => 'danger', 'message' => 'Record not found.']);
            }

            return view('frontend.account.blockchain-search-detail', ['keyword' => $blockchain_search->keyword, 'result' => $blockchain_search_result]);
        }

    }
}
