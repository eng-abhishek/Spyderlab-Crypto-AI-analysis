<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WalletAddress;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\WalletAddressRequest;
use DataTables;
use Illuminate\Support\Str;

class WalletAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WalletAddress::select('*');
            
            return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('image', function($row){
                return "<img src='".$row->image."' height='50' weight='50'/>";
            })
            ->addColumn('address', function($row){
             return Str::limit($row->address, 150, $end='...');
         })
            ->addColumn('created_at', function($row){
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="'.route("backend.wallet-addresses.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
                $btn .= '<a href="javascript:;" data-url="'.route('backend.wallet-addresses.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
        }

        return view('backend.wallet-address.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.wallet-address.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  WalletAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WalletAddressRequest $request)
    {
        try{

            $exists = WalletAddress::where('address', $request->get('address'))->where('token', $request->get('token'))->first();
            if($exists){
                return redirect()->route('backend.wallet-addresses.create')->with(['status' => 'danger', 'message' => 'The '.strtoupper($request->get('token')).' address has already been taken.']);
            }

            $data = [
                'name' => $request->get('name'),
                'token' => $request->get('token'),
                'address' => $request->get('address')
            ];

            //Upload image
            if($request->hasFile('image')){

                $document_path = 'wallet-addresses';
                if (!\Storage::exists($document_path)) {
                    \Storage::makeDirectory($document_path, 0777);
                }

                $file_name = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs($document_path, $file_name);

                $data['image'] = $file_name;
            }

            WalletAddress::create($data);

            return redirect()->route('backend.wallet-addresses.index')->with(['status' => 'success', 'message' => 'Record created successfully.']);
        }catch(\Exception $e){
            return redirect()->route('backend.wallet-addresses.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = WalletAddress::find($id);
        if(!$record){
            return redirect()->route('backend.wallet-addresses.index')->with(['status' => 'danger', 'message' => 'Record not found.']);
        }

        return view('backend.wallet-address.edit', ['record' => $record]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  WalletAddressRequest  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WalletAddressRequest $request, $id)
    {
        try{

            $exists = WalletAddress::where('id', '<>', $id)->where('address', $request->get('address'))->where('token', $request->get('token'))->first();
            if($exists){
                return redirect()->route('backend.wallet-addresses.edit', $id)->with(['status' => 'danger', 'message' => 'The '.strtoupper($request->get('token')).' address has already been taken.']);
            }

            $record = WalletAddress::find($id);

            $data = [
                'name' => $request->get('name'),
                'token' => $request->get('token'),
                'address' => $request->get('address')
            ];

            //Update image
            if($request->hasFile('image')){

                $document_path = 'wallet-addresses';
                if (!\Storage::exists($document_path)) {
                    \Storage::makeDirectory($document_path, 0777);
                }

                //Remove old image
                if ($record->getRawOriginal('image') != '' && \Storage::exists($document_path.'/'.$record->getRawOriginal('image'))) {
                    \Storage::delete($document_path.'/'.$record->getRawOriginal('image'));
                }

                $file_name = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs($document_path, $file_name);

                $data['image'] = $file_name;
            }

            $record->update($data);

            return redirect()->route('backend.wallet-addresses.index')->with(['status' => 'success', 'message' => 'Record updated successfully.']);
        }catch(\Exception $e){
            return redirect()->route('backend.wallet-addresses.edit', $id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
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

            $record = WalletAddress::where('id', $id)->first();

            //Remove image
            $document_path = 'wallet-addresses';
            if ($record->getRawOriginal('image') != '' && \Storage::exists($document_path.'/'.$record->getRawOriginal('image'))) {
                \Storage::delete($document_path.'/'.$record->getRawOriginal('image'));
            }

            $record->delete();

            return response()->json(['status' => 'success', 'message' => 'Record deleted successfully.']);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

}
