<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\ApiServiceRequest;
use DataTables;
use App\Models\ApiService;

class ApiServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ApiService::select('*');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="'.route("backend.api-services.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
                return $btn;
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                        $w->where('name', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
        }

        return view('backend.api-service.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = ApiService::find($id);
        $record->credentials = json_decode($record->credentials, true);

        return view('backend.api-service.edit', ['record' => $record]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApiServiceRequest $request, $id)
    {
        try {
            $api_service = ApiService::find($id);

            $credentials = $request->get('credentials');

            if($api_service->slug == 'truecaller'){

                if($request->hasFile('credentials.authkey')){

                    $document_path = 'api-services';

                    //Remove old authkey
                    $old_credentials = json_decode($api_service->credentials);
                    if (isset($old_credentials->authkey) && $old_credentials->authkey != '' && \Storage::disk('local')->exists($document_path.'/'.$old_credentials->authkey)) {
                        \Storage::disk('local')->delete($document_path.'/'.$old_credentials->authkey);
                    }

                    $input_file = $request->file('credentials.authkey');

                    $filename = pathinfo($input_file->getClientOriginalName(), PATHINFO_FILENAME).'.'.$input_file->getClientOriginalExtension();
                    $input_file->storeAs($document_path, $filename, 'local');

                    $credentials = ['authkey' => $filename];
                }
            }

            $api_service->credentials = json_encode($credentials);
            $api_service->error_code = null;
            $api_service->error_message = null;
            $api_service->save();

            return redirect()->route('backend.api-services.index')->with(['status' => 'success', 'message' => 'Service details updated successfully.']);

        } catch (\Exception $e) {
            return redirect()->route('backend.api-services.edit', $id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
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
        abort(404);
    }
}
