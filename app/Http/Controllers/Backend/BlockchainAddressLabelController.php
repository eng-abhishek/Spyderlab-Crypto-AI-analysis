<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\BlockchainAddressLabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Backend\BlockchainAddressLabelRequest;
use DataTables;
use Illuminate\Support\Str;

class BlockchainAddressLabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BlockchainAddressLabel::select('*');
            return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('address', function($row){
             return Str::limit($row->address, 150, $end='...');
         })

            ->addColumn('created_at', function($row){
                return $row->created_at->format('Y-m-d H:i:s');
            })

            ->addColumn('currency', function($row){
                return strtoupper($row->currency);
            })

            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="'.route("backend.labels.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
                $btn .= '<a href="javascript:;" data-url="'.route('backend.labels.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })
            ->rawColumns(['description', 'action'])
            ->make(true);
        }

        return view('backend.labels.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('backend.labels.create');
 }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockchainAddressLabelRequest $request)
    {
        try{
            BlockchainAddressLabel::create([
                'address' => $request->get('address'),
                'labels' => $request->get('labels'),
                'currency' => $request->get('currency'),
            ]);

            return redirect()->route('backend.labels.index')->with(['status' => 'success', 'message' => 'Labels created successfully.']);
        }catch(\Exception $e){

            return redirect()->route('backend.labels.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\blockchain_address_label  $blockchain_address_label
     * @return \Illuminate\Http\Response
     */
    public function show(BlockchainAddressLabel $blockchain_address_label)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\blockchain_address_label  $blockchain_address_label
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     $data['record'] = BlockchainAddressLabel::find($id);
     return view('backend.labels.edit',$data);
 }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\blockchain_address_label  $blockchain_address_label
     * @return \Illuminate\Http\Response
     */
    public function update(BlockchainAddressLabelRequest $request, $id)
    {
     try{

        BlockchainAddressLabel::where('id',$id)->update([
            'address' => $request->get('address'),
            'labels' => $request->get('labels'),
            'currency' => $request->get('currency'),
        ]);

        return redirect()->route('backend.labels.index')->with(['status' => 'success', 'message' => 'Labels updated successfully.']);
    }catch(\Exception $e){

        return redirect()->route('backend.labels.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    }
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

            $labels = BlockchainAddressLabel::where('id',$id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Labels deleted successfully.']);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

}
