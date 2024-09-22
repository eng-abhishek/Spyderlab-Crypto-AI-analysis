<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Cms;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax()){

            $row = Cms::OrderBy('id','desc')->latest()->get();

            return DataTables::of($row)

            ->addIndexColumn()

            ->addColumn('updated_at',function($row){
                return Carbon::parse($row->updated_at)->format('d-m-Y h:i A');
            })

            ->addColumn('description', function($row){

                if($row->slug == 'about-us'){

                    $record = json_decode($row->description);

                    if(isset($record->about_spyderlab)){

                        return Str::limit($record->about_spyderlab, 150, $end='...');
                    }
                }else{
                    return Str::limit($row->description, 150, $end='...');
                }
            })

            ->addColumn('action', function($row){
                $btn = '';
                
                if($row->slug == 'privacy-policy'){
                    $btn .= '<a target="_blank" href="'.route("privacy-policy").'" class="btn btn-outline-success btn-sm"><i class="fa-light fa-eye"></i></a>';
                }elseif($row->slug == 'terms-condition'){
                    $btn .= '<a target="_blank" href="'.route("terms-of-service").'" class="btn btn-outline-success btn-sm"><i class="fa-light fa-eye"></i></a>';
                }else{
                    $btn .= '<a target="_blank" href="'.route("about-us").'" class="btn btn-outline-success btn-sm"><i class="fa-light fa-eye"></i></a>';
                }

                if($row->slug == 'about-us'){

                    $btn .= '<a href="'.route("backend.cms.edit-about-us", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';

                }else{

                    $btn .= '<a href="'.route("backend.cms.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
                }

                return $btn;
            })

            ->rawColumns(['description','created_at','action'])
            ->make(true);
        }
        return view('backend.cms.index');
    }

    public function edit($id)
    {
        $data['record'] = Cms::find($id);
        return view('backend.cms.edit',$data);
    }

    public function editAboutus($id)
    {
        $data = Cms::find($id);

        if(isset($data->id)){
            
            $about_us = json_decode($data->description);
        }

        return view('backend.cms.edit_abutus',['record'=>$data,'about_us'=>$about_us]);
    }

    public function editPartner($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       try{

           $record = Cms::find($id);

           if($record->slug == 'about-us'){

               $data = ['about_spyderlab'=> $request->get('about_spyderlab'),
               'origins_and_team'=> $request->get('origins_and_team'),
               'developments'=> $request->get('developments'),
           ];
           
           Cms::where('slug',$record->slug)->update(['description'=>json_encode($data)]);

       }elseif($record->slug == 'partner'){


       }else{

           $data = ['description'=> $request->get('description')];
           Cms::where('slug',$record->slug)->update($data);

       }

       return redirect()->route('backend.cms.index')->with(['status' => 'success', 'message' => 'CMS updated successfully.']);

   }catch(\Exception $e){
    return redirect()->route('backend.cms.edit',$id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
}
}

}
