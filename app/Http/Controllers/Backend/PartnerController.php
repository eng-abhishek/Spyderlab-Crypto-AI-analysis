<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\PartnersRequest;
use App\Models\Partner;
use DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            $row = Partner::OrderBy('id','desc')->latest()->get();

            return DataTables::of($row)

            ->addIndexColumn()

            ->addColumn('image_url', function($row){
                $img = '';
                $img.='<img src="'.$row->image_url.'" class="img-thumbnail" width="50%"></img>';
                return $img;
            })     

            ->addColumn('created_at',function($row){
                return Carbon::parse($row->updated_at)->format('d-m-Y h:i A');
            })

            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="'.route("backend.partners.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
                $btn .= '<a href="javascript:;" data-url="'.route('backend.partners.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })

            ->rawColumns(['created_at','action','image_url'])
            ->make(true);
        }
        return view('backend.partner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('backend.partner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PartnersRequest $request)
    {
        try {

            $data = ['url' =>$request->url];

            //Upload image
            if($request->hasFile('image')){

                $document_path = 'partner';
                if (!\Storage::exists($document_path)) {
                    \Storage::makeDirectory($document_path, 0777);
                }

                $filename = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME).'-'.time().'.'.$request->file('image')->getClientOriginalExtension();
                $request->file('image')->storeAs($document_path, $filename);

                $data['image'] = $filename;
            }

            Partner::create($data);

            return redirect()->route('backend.partners.index')->with(['status' => 'success', 'message' => 'Partner created successfully.']);


        }catch(\Exception $e){


            return redirect()->route('backend.partners.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{

        $data['record'] = Partner::find($id);
        if(isset($data['record']->id)){
        return view('backend.partner.edit',$data);
          }
        }catch(\Exception $e){
        return redirect()->route('backend.partners.edit', $id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
           }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(PartnersRequest $request, $id)
    {
        try{

            $record = Partner::find($id);

            $data = ['url' =>$request->url];

            if($request->hasFile('image')){

                $document_path = 'partner';
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

            return redirect()->route('backend.partners.index')->with(['status' => 'success', 'message' => 'Partner updated successfully.']);


        }catch(\Exception $e){

            return redirect()->route('backend.partners.edit', $id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    try{
            Partner::find($id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Partner deleted successfully.']);

        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
