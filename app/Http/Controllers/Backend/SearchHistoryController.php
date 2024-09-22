<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\SearchHistory;

class SearchHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SearchHistory::with('user', 'result.country')->select('*');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function($row){
                return !is_null($row->user) ? $row->user->name : null;
            })
            ->addColumn('search_key', function($row){
                return $row->result->search_key;
            })
            ->addColumn('search_value', function($row){
                if($row->result->search_key == 'phone'){
                    return $row->result->country->phone_code.$row->result->search_value;
                }else{
                    return $row->result->search_value;
                }
            })
            ->addColumn('status_code', function($row){
                return $row->result->status_code;
            })
            ->addColumn('message', function($row){
                return $row->result->message;
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
                $btn .= '<a target="_blank" href="'.route("backend.search-results.show", $row->search_result_id).'" class="btn btn-outline-primary btn-sm" title="View"><i class="fa-light fa-eye"></i></a>';
                $btn .= '<a href="javascript:;" data-url="'.route('backend.search-histories.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                        $w->where('ip_address', 'LIKE', "%$search%");
                        $w->orWhere('search_key', 'LIKE', "%$search%");
                        $w->orWhere('search_value', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['location', 'action'])
            ->make(true);
        }

        return view('backend.search-history.index');
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

            $record = SearchHistory::find($id);
            $record->delete();

            return response()->json(['status' => 'success', 'message' => 'History deleted successfully.']);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
