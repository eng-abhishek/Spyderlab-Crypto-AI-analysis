<?php

namespace App\Http\Controllers\Backend;

use App\Models\TelegramUser;
use App\Models\TelegramSubscription;
use App\Models\TelegramTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;

class TelegramSubscriptionController extends Controller{
	
	public function subscription(Request $request){

		if ($request->ajax()) {
			$data = TelegramSubscription::with('tg_user','tg_package'); 
			return Datatables::of($data)
			->addIndexColumn()

			->addColumn('username', function($row){
				return $row->tg_user->name;
			})

			->addColumn('sub_type', function($row){
				return ucfirst($row->sub_type);
			})

			->addColumn('action', function($row){
				$btn = '';
				$btn .= '<a href="'.route("backend.telegram.transaction.details",[$row->id,'for'=>'subscription']).'">View Txn Details</a>';

				return $btn;
			})

			->addColumn('package_name', function($row){
				
				if(!is_null($row->tg_package)){
					
					return $row->tg_package->name;

				}else{

					return 'NULL';
					
				}
			})

			->addColumn('created_at', function($row){
				return $row->created_at->format('Y-m-d H:i:s');
			})
			
			->order(function ($query) {
				$query->orderBy('created_at', 'desc');
			})

			->rawColumns(['package_name','username','action','sub_type','created_at'])
			->make(true);
		}
		return view('backend.telegram.subscription.index');
	}

	public function transaction(Request $request){
		
		if ($request->ajax()) {
			$data = TelegramTransaction::with('tg_user','tg_package');
			return Datatables::of($data)
			->addIndexColumn()

			->addColumn('username', function($row){
				return $row->tg_user->name;
			})

			->addColumn('sub_type', function($row){
				return ucfirst($row->sub_type);
			})

			->addColumn('payment_amount_in_usd', function($row){
				return '$'.$row->payment_amount_in_usd;
			})

			->addColumn('package_name', function($row){
				
				if(!is_null($row->tg_package)){
					
					return $row->tg_package->name;

				}else{

					return 'NULL';
					
				}
			})

			->addColumn('txn_status', function($row){
				return ucfirst($row->txn_status);
			})

			->addColumn('created_at', function($row){
				return $row->created_at->format('Y-m-d H:i:s');
			})

			->addColumn('action', function($row){
				$btn = '';
				$btn .= '<a href="'.route("backend.telegram.transaction.details", $row->id).'">View Txn Details</a>';
				return $btn;
			})

			->filter(function ($instance) use ($request) {
				if ($request->get('status') != '') {
					$instance->where('txn_status', $request->get('status'));
				}
				if (!empty($request->get('search'))) {
					$instance->where(function($w) use($request){
						$search = $request->get('search');
						
						$w->orWhere('txn_id', 'LIKE', "%$search%")
						->orWhere('txn_status', 'LIKE', "%$search%")
						->orWhere('payment_amount_in_usd', 'LIKE', "%$search%")
						->orWhere('sub_type', 'LIKE', "%$search%")
						->orWhere('no_of_request', 'LIKE', "%$search%")
						->orWhereHas('tg_user',function($q) use($search) {
							$q->where('name','LIKE',"%$search%");
						})
						->orWhereHas('tg_package',function($q) use($search) {
							$q->where('name','LIKE',"%$search%");
						});
						
					});
				}
			})

			->order(function ($query) {
				$query->orderBy('created_at', 'desc');
			})

			->rawColumns(['txn_status','payment_amount_in_usd','action','package_name','username','sub_type','created_at'])
			->make(true);
		}
		return view('backend.telegram.transaction.index');
	}

	public function trsnsactionDetails(Request $request,$id){

		if(!empty($request->get('for')) && ($request->get('for') == 'subscription')){
			
			$data['record'] = TelegramTransaction::with('tg_user','tg_package')->where('sub_id',$id)->first();
			
		}else{
			
			$data['record'] = TelegramTransaction::with('tg_user','tg_package')->where('id',$id)->first();
		}

		return view('backend.telegram.transaction.show',$data);
	}

}

?>