<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\BlockchainSearchHistory;

class BlockchainSearchHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BlockchainSearchHistory::with('user', 'search')->select('*');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function($row){
                return !is_null($row->user) ? $row->user->name : null;
            })
            ->addColumn('keyword', function($row){
                return $row->search->keyword;
            })
            ->addColumn('status_code', function($row){
                return $row->search->status_code;
            })
            ->addColumn('message', function($row){
                return $row->search->message;
            })
            ->addColumn('location', function($row){
                $location = "";
                if(!is_null($row->location)){
                    $location_obj = json_decode($row->location);
                    $location = '<b>City</b>:'.$location_obj->city.', ';
                    $location .= '<b>State</b>:'.$location_obj->state.', ';
                    $location .= '<b>Country</b>:'.$location_obj->country;
                }
                return $location;
            })
            ->addColumn('search_at', function($row){
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="'.route("backend.blockchain-searches.show", $row->search_id).'" target="_blank" class="btn btn-outline-primary btn-sm" title="View"><i class="fa-light fa-eye"></i></a>';
                $btn .= '<a href="javascript:;" data-url="'.route('backend.blockchain-search-histories.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                        $w->where('ip_address', 'LIKE', "%$search%");
                        $w->orWhereHas('search', function($wh) use($search){
                            $w->where('keyword', 'LIKE', "%$search%");
                        });
                    });
                }
            })
            ->rawColumns(['location', 'action'])
            ->make(true);
        }

        return view('backend.blockchain-search-history.index');
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

            $record = BlockchainSearchHistory::find($id);
            $record->delete();

            return response()->json(['status' => 'success', 'message' => 'History deleted successfully.']);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
