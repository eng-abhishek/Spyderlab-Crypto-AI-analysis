<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempSearch;
use App\Models\SearchResult;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = \Auth::guard('backend')->user();
        return view('backend.dashboard');
    }

    /**
     * View/Download file.
     *
     * @param  $path
     * @param  $filename
     * @return \Illuminate\Http\Response
     */
    public function getFile(Request $request, $path, $filename, $disk = 'public')
    {
        if(\Storage::disk($disk)->exists($path.'/'.$filename)){

            /* Download document if download = true */
            if($request->has('download') && $request->get('download') == 'true'){
                $response = \Storage::disk($disk)->download($path.'/'.$filename);
            }else{
                $file_content = \Storage::disk($disk)->get($path.'/'.$filename);
                $mimetype = \Storage::disk($disk)->mimeType($path.'/'.$filename);                
                $response = response()->make($file_content, 200)->header('Content-Type', $mimetype);
            }

            return $response;
        }

        return redirect()->route('backend.dashboard')->with(['status' => 'danger', 'message' => 'File not found.']);
    }
}
