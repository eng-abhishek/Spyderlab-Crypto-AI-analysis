<?php

namespace App\Http\Controllers\Backend;

use App\Models\Faq;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\FaqRequest;
use DataTables;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Faq::select('*');
            return Datatables::of($data)
            ->addIndexColumn()

            ->addColumn('action', function($row){
                $btn = '';
                
                $btn .= '<a href="'.route("backend.faq.show", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-eye"></i></a>';
                $btn .= '<a href="'.route("backend.faq.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
                $btn .= '<a href="javascript:;" data-url="'.route('backend.faq.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })

            ->addColumn('description', function($row){
                return Str::limit($row->description, 150, $end='...');
            })

            ->rawColumns(['action','description'])
            ->make(true);
        }

        return view('backend.faq.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('backend.faq.create');
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqRequest $request)
    {
        try{

            Faq::create([
              'title' => $request->title,
              'description' => $request->description,
          ]);

            return redirect()->route('backend.faq.index')->with(['status' => 'success', 'message' => 'Faq created successfully.']);

        }catch(\Exception $e){

            return redirect()->route('backend.faq.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          try{

            $data['record'] = Faq::find($id);
            return view('backend.faq.show',$data);

        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       try{

        $data['record'] = Faq::find($id);
        return view('backend.faq.edit',$data);

    }catch(\Exception $e){

       return redirect()->route('backend.faq.index')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);

   }
}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(FaqRequest $request, $id)
    {

        try{

            $record = Faq::find($id);

            $data = array(
              'title' => $request->title,
              'description' => $request->description,
          );

            $record->update($data);

            return redirect()->route('backend.faq.index')->with(['status' => 'success', 'message' => 'Faq created successfully.']);

        }catch(\Exception $e){

         return redirect()->route('backend.faq.edit', $id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);

     }
 }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\faq  $faq
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        try{

            Faq::find($id)->delete();
            return response()->json(['status' => 'success', 'message' => 'Faq deleted successfully.']);

        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

}
