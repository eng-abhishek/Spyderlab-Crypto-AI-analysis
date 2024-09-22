<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;

class ContactController extends Controller{

/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
{
	if ($request->ajax()) {
		$data = Contact::select('*');
		return Datatables::of($data)
		->addIndexColumn()
		
		->addColumn('description', function($row){
			return Str::limit($row->description, 150, $end='...');
		})

        ->addColumn('query_type', function($row){
            if($row->query_type == 'registering_authorising'){

                return 'Registering/Authorising';
            }elseif ($row->query_type == 'using_application') {
                # code...
                return 'Using Application';
            }elseif ($row->query_type == 'troubleshooting') {
                # code...
                return 'Troubleshooting';
            }elseif ($row->query_type == 'backup_restore') {
                # code...
                return 'Backup/Restore';
            }else{
                return 'Other';
            }
        })

		->addColumn('created_at', function($row){
			return $row->created_at->format('Y-m-d H:i:s');
		})

		->addColumn('action', function($row){
			$btn = '';
			$btn .= '<a href="'.route("backend.contact.show", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-eye"></i></a>';
			$btn .= '<a href="javascript:;" data-url="'.route('backend.contact.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
			return $btn;
		})

		->addColumn('delCheckbox',function($row){

			$delCheckbox = '<div class="form-check"><input type="checkbox" class="form-check-input order_checkbox" name="order_checkbox[]"" value="'.$row->id.'"></div>';
			return $delCheckbox;
		})

		->rawColumns(['query_type','description', 'action','delCheckbox'])
		->make(true);
	}

	return view('backend.contact.index');
}

public function show($id){
	$data['record']= Contact::find($id);
	return view('backend.contact.show',$data);
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
    		
    		Contact::where('id',$id)->delete();

    		return response()->json(['status' => 'success', 'message' => 'Inquiry deleted successfully.']);
    	}catch(\Exception $e){
    		return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
    	}
    }

    public function removeall(Request $request){

    	try{

    		Contact::whereIn('id',$request->id)->delete();
    		return response()->json(['status'=>'success','message'=>'Inquries has deleted successfully.']);

    	}catch(\Exception $e){

    		return response()->json(['status'=>'error','message'=>'Oop`s! something wents worng.']);
    	}
    }
}
?>