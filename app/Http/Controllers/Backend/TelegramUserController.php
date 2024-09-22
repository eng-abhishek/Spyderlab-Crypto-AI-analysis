<?php

namespace App\Http\Controllers\Backend;

use App\Models\TelegramUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

class TelegramUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if ($request->ajax()) {
    		$data = TelegramUser::select('*');
    		return Datatables::of($data)
    		->addIndexColumn()

    		->addColumn('action', function($row){
    			$btn = '';
    			$btn .= '<a href="javascript:;" data-url="'.route('backend.telegram.users.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
    			return $btn;
    		})

            ->filter(function ($instance) use ($request) {
               
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                        
                        $w->orWhere('name', 'LIKE', "%$search%")
                        ->orWhere('username', 'LIKE', "%$search%")
                        ->orWhere('telegram_id', 'LIKE', "%$search%");
                    });
                }
            })

            ->order(function ($query) {
                $query->orderBy('created_at', 'desc');
            })

            ->addColumn('created_at', function($row){
                return ($row->created_at) ? $row->created_at->format('Y-m-d H:i:s') : '';
            })

            ->rawColumns(['action','created_at'])
            ->make(true);
        }
        return view('backend.telegram.user.index');
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        echo $id;
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

    		TelegramUser::find($id)->delete();
    		return response()->json(['status' => 'success', 'message' => 'Telegram user deleted successfully.']);

    	}catch(\Exception $e){
    		return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }
}
