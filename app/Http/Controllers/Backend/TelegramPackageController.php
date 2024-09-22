<?php

namespace App\Http\Controllers\Backend;

use App\Models\TelegramUser;
use App\Models\TelegramPackage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

class TelegramPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if ($request->ajax()) {
    		$data = TelegramPackage::select('*');
    		return Datatables::of($data)
    		->addIndexColumn()

    		->addColumn('action', function($row){
    			$btn = '';
    			$btn .= '<a href="'.route("backend.telegram.package.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';

    			$btn .= '<a href="javascript:;" data-url="'.route('backend.telegram.package.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';

    			return $btn;
    		})

    		->addColumn('created_at', function($row){
    			return ($row->created_at) ? $row->created_at->format('Y-m-d H:i:s') : '';
    		})

    		->rawColumns(['action','created_at'])
    		->make(true);
    	}
    	return view('backend.telegram.package.index');
    }


    public function create()
    {
    	return view('backend.telegram.package.create');
    }


    public function store(Request $request)
    {
    	try{

    		$check_package = TelegramPackage::where('slug',$request->no_of_request.'-'.$request->price);

    		if($check_package->count() > 0){

    			return redirect()->route('backend.telegram.package.index')->with(['status' => 'danger', 'message' => 'Oop`s this package already exist please try another.']);
    		}

    		TelegramPackage::create([
    			'slug' => trim($request->no_of_request).'-'.trim($request->price),
    			'name' => $request->name,
    			'no_of_request' => $request->no_of_request,
    			'price' => $request->price,
    		]);

    		return redirect()->route('backend.telegram.package.index')->with(['status' => 'success', 'message' => 'Telegram Package created successfully.']);
    	}catch(\Exception $e){

    		return redirect()->route('backend.telegram.package.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$data['record'] = TelegramPackage::where('id',$id)->first();
    	return view('backend.telegram.package.edit',$data);
    }

    public function update(Request $request,$id)
    {
    	try{
    		
    		$update = [
    			'slug' => trim($request->no_of_request).'-'.trim($request->price),
    			'name' => $request->name,
    			'no_of_request' => $request->no_of_request,
    			'price' => $request->price,
    		];

    		TelegramPackage::where('id',$id)->update($update);

    		return redirect()->route('backend.telegram.package.index')->with(['status' => 'success', 'message' => 'Telegram Package updated successfully.']);
    	}catch(\Exception $e){

    		return redirect()->route('backend.telegram.package.edit',$id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }

    
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	try{

    		TelegramPackage::find($id)->delete();
    		return response()->json(['status' => 'success', 'message' => 'Telegram Package deleted successfully.']);

    	}catch(\Exception $e){
    		return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }
}
