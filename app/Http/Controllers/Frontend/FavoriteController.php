<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlockchainUserNote;
use Auth;

class FavoriteController extends Controller
{

	public function __construct() {
		$this->middleware(['auth','verified']);
	}

	public function index(){
		return view('frontend.account.favourite');
	}

	public function ajaxGetFavorite(Request $request){

		if(!is_null($request->get('search'))){

			$search = $request->get('search');

			$query = BlockchainUserNote::select("*")
			->where('user_id',Auth()->user()->id);

			$result = $query->where(function($q) use($search){
				$q->orWhere('address','LIKE',"%$search%");
				$q->orWhere('address_type','LIKE',"%$search%");
				$q->orWhere('description','LIKE',"%$search%");
			})->paginate(10);

			$data['records'] = $result;

		}else{

			$data['records'] = BlockchainUserNote::where('user_id',Auth()->user()->id)->paginate(10);

		}
		return view('frontend.partials.favorites-table',$data);
	}

}
