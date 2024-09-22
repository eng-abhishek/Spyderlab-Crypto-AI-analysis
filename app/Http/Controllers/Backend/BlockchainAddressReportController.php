<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlockchainAddressReport;
use App\Models\User;
use DataTables;
use Illuminate\Support\Str;

class BlockchainAddressReportController extends Controller
{
	public function index(Request $request)
	{

		if ($request->ajax()) {
			$data = BlockchainAddressReport::with('flagUser')->select('*');
			return Datatables::of($data)
			->addIndexColumn()

			->addColumn('description', function($row){
				return Str::limit($row->description, 150, $end='...');
			})

			->addColumn('username', function($row){
				return $row->flagUser->name;
			})

			->addColumn('created_at', function($row){
				return $row->created_at->format('Y-m-d H:i:s');
			})
			->addColumn('action', function($row){
				$btn = '';
				$btn .= '<a href="'.route("backend.flag.show", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-eye"></i></a>';
				return $btn;
			})
			->rawColumns(['description', 'action','created_at','username'])
			->make(true);
		}
		return view('backend.flag.index');
	}

	public function show($id){
		$flag = BlockchainAddressReport::with('flagUser')->where(['id'=>$id])->get();
		$data['record']= $flag[0];
		return view('backend.flag.show',$data);
	}
}
