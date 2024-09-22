<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\SearchResult;

class SearchResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SearchResult::with('updated_by_user', 'country')->select('*');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('search_key', function($row){
                return $row->search_key ?? '';
            })
            ->addColumn('search_value', function($row){
                if($row->search_key == 'phone'){
                    return $row->country->phone_code ?? '' . $row->search_value ?? '';
                }else{
                    return $row->search_value ?? '';
                }
            })
            ->addColumn('created_at', function($row){
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('updated_at', function($row){
                return !is_null($row->updated_at) ? $row->updated_at->format('Y-m-d H:i:s') : '';
            })
            ->addColumn('updated_by', function($row){
                
                return !is_null($row->updated_by) ? $row->updated_by_user->name??'' : '';

            })
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="'.route("backend.search-results.show", $row->id).'" class="btn btn-outline-primary btn-sm" title="View"><i class="fa-light fa-eye"></i></a>';
                return $btn;
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                        $w->where('search_key', 'LIKE', "%$search%");
                        $w->orWhere('search_value', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('backend.search-result.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $record = SearchResult::with('country')->find($id);
        if(!$record){
            return redirect()->route('backend.search-results.index')->with(['status' => 'danger', 'message' => 'Record not found.']);
        }

        /* Fetch latest detail by phone  */
        if($request->method() == 'POST'){
            $get_details_by_phone = $this->get_details_by_phone($record->country_code, $record->search_value);
            $result_obj = json_decode($get_details_by_phone);

            if($result_obj->status_code == 200){
                $record->result = json_encode((array)$result_obj->data);
                $record->updated_by = auth()->user()->id;
                $record->save();
            }

            return redirect()->route('backend.search-results.show', $id)->with(['status' => 'success', 'message' => 'Latest data fetched successfully.']);
        }

        return view('backend.search-result.show', ['record' => $record]);
    }
}
