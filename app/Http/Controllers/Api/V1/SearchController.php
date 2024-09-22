<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchByPhoneRequest;
use App\Models\UserKey;

class SearchController extends Controller
{
	public function __construct() {
        //
	}

    /**
     * Search by phone.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchByPhone(SearchByPhoneRequest $request)
    {
    	/* Manage daily search limit */
        // $search_limit = $this->daily_search_limit($request);
        // if($search_limit->exceeded){
        //     return response()->json(['message' => $search_limit->message], 403);
        // }

        $headers = $request->header('x-api-key');

        $user_keys = UserKey::with('users')->where(['key'=>$headers,'is_active'=>'Y'])->first();
        
        $user_info = $user_keys->users;

    	$available_credits = available_credits($user_info->id);
    	if($available_credits == 0){
    		return response()->json(['message' => 'You doesn\'t have enough credit, please buy it from "Pricing".'], 403);
    	}

    	$search_data = $this->search_by_phone($request);
    	$search_data = json_decode($search_data);
    	if($search_data->status_code == 404){
    		return response()->json(['message' => 'Record not found.'], 404);
    	}

    	return response()->json(['data' => $search_data->data], 200);

    }

    /**
     * Get register domains by email.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegisterDomainsByEmail(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'email' => 'required|string|email|max:255'
    	]);

    	if ($validator->fails()) {
    		return response()->json(['messages' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
    	}

    	$email = $request->get('email');

    	$search_data = $this->search_by_email($email);

    	return response()->json(['data' => (array) json_decode($search_data)], 200);
    }

}
