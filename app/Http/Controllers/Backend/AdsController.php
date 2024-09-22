<?php

namespace App\Http\Controllers\Backend;

use App\Models\Ads;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\AdsRequest;
use DataTables;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if ($request->ajax()) {
    		$data = Ads::select('*');
    		return Datatables::of($data)
    		->addIndexColumn()

    		->addColumn('action', function($row){
    			$btn = '';
    			$btn .= '<a href="'.route("backend.ads.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
    			$btn .= '<a href="javascript:;" data-url="'.route('backend.ads.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
    			return $btn;
    		})

    		->addColumn('image_url', function($row){
    			$img = '';
    			$img.='<img src="'.$row->image_url.'" class="img-thumbnail" width="50%"></img>';
    			return $img;
    		})

    		->rawColumns(['status', 'action','image_url'])
    		->make(true);
    	}

    	return view('backend.ads.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('backend.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdsRequest $request)
    {

    	try {

    		$data = ['url' =>$request->url];

            //Upload image
    		if($request->hasFile('image')){

    			$document_path = 'ads';
    			if (!\Storage::exists($document_path)) {
    				\Storage::makeDirectory($document_path, 0777);
    			}

    			$filename = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$request->file('image')->getClientOriginalExtension();
    			$request->file('image')->storeAs($document_path, $filename);

    			$data['image'] = $filename;
    		}

    		Ads::create($data);

    		return redirect()->route('backend.ads.index')->with(['status' => 'success', 'message' => 'Ads created successfully.']);


    	}catch(\Exception $e){


    		return redirect()->route('backend.ads.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);

    	}

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function show(ads $ads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$data['record'] = Ads::find($id);
    	return view('backend.ads.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function update(AdsRequest $request,$id)
    {
    	try{

    		$record = Ads::find($id);

    		$data = ['url' =>$request->url];

    		if($request->hasFile('image')){

    			$document_path = 'ads';
    			if (!\Storage::exists($document_path)) {
    				\Storage::makeDirectory($document_path, 0777);
    			}

                 //Remove old image
    			if ($record->image != '' && \Storage::exists($document_path.'/'.$record->image)) {
    				\Storage::delete($document_path.'/'.$record->image);
    			}

    			$filename = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$request->file('image')->getClientOriginalExtension();
    			$request->file('image')->storeAs($document_path, $filename);

    			$data['image'] = $filename;
    		}

    		$record->update($data);

    		return redirect()->route('backend.ads.index')->with(['status' => 'success', 'message' => 'Ads updated successfully.']);


    	}catch(\Exception $e){

    		return redirect()->route('backend.ads.edit', $id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);

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

    		Ads::find($id)->delete();
    		return response()->json(['status' => 'success', 'message' => 'Ads deleted successfully.']);

    	}catch(\Exception $e){
    		return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }
}
