<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserKey;
use App\Models\User;
use App\Models\CryptoPlanSubscription;
use Auth;

class UserKeyController extends Controller
{

    public function __construct() {
        $this->middleware(['auth','verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['records'] = UserKey::where('user_id',Auth::user()->id)->get();
       return view('frontend.account.private-key',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUserKey()
    {
        try{

           $is_active =  CryptoPlanSubscription::where(['is_active'=>'Y','user_id'=>Auth::user()->id])->where('expired_date', '>', now())->count();
           if($is_active < 1){

               return redirect()->route('account.private-key')->with(['status' => 'danger', 'message' => 'Oop`s you have not any active subscription.']);
               
           }
           
           $uid = CryptoPlanSubscription::whereHas('plans',function($query){
              $query->where('is_free','N');
          })->where('user_id',Auth::user()->id)->count();
           
           if($uid < 1){

               return redirect()->route('account.private-key')->with(['status' => 'danger', 'message' => 'Oop`s this feature is only for the paid plan.']);
           }

           UserKey::create([
            'user_id' => Auth::user()->id,
        ]);

           return redirect()->route('account.private-key')->with(['status' => 'success', 'message' => 'Your key generated successfully.']);
           
       }catch(\Exception $e){

        return redirect()->route('account.private-key')->with(['status' => 'danger', 'message' => 'Oop`s something wents wrong.']);

    }
}


public function destroy($id)
{
    try{
        $del = UserKey::find($id);

        if($del){
            if($del->is_active == 'Y'){

                return redirect()->route('account.private-key')->with(['status' => 'danger', 'message' => 'You can`t delete, because key is active.']);
            }
        }

        $delID = UserKey::findOrFail($id);
        $delID->delete();

        return redirect()->route('account.private-key')->with(['status' => 'success', 'message' => 'Key has deleted successfully.']);

    }catch(\Exception $e){

        return redirect()->route('account.private-key')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);

    }
}

   public function status(Request $request){
    try{

       $cryptoData=UserKey::find($request->id);
       $cryptoData->is_active=$request->is_active;
       $cryptoData->save();
       if($request->is_active=='Y'){

         return response()->json(['status'=>'success','message'=>'Key has activated successfully..']);    
     }elseif($request->is_active=='N'){
         
         return response()->json(['status'=>'success','message'=>'Key has Inactivated successfully.']);
     }
     
 }catch(\Exception $e){
   
  return response()->json(['status'=>'danger','message'=>'Oop`s something wents worng.']);
}
}

}
