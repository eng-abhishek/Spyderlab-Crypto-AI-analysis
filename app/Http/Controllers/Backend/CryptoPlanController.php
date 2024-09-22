<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CryptoPlanRequest;
use DataTables;
use App\Models\CryptoPlan;

class CryptoPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
          //  echo $request->get('search');
            $data = CryptoPlan::select('*');
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('monthly_price', function($row){
                return '$ '.$row->monthly_price;
            })
            // ->addColumn('yearly_price', function($row){
            //     return '$ '.$row->yearly_price;
            // })
            ->addColumn('created_at', function($row){
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('is_free',function($row){
                if($row->is_free == 'Y'){
                    $is_free = 'Yes';
                }else{
                    $is_free = 'No';
                }
                
                return $is_free;
            })
            ->addColumn('is_active',function($row){
                if($row->is_active == 'Y'){
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $is_active='<div class="form-check form-switch">
                <input type="checkbox" '.$checked.' class="is_active'.$row->id.' form-check-input" id="customSwitch1" data-id="'.$row->id.'">
                <label class="form-check-label" for="customSwitch1"></label>
                </div>';
                return $is_active;
            })
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="'.route("backend.crypto-plans.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
                $btn .= '<a href="javascript:;" data-url="'.route('backend.crypto-plans.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
                return $btn;
            })
            ->filter(function ($instance) use ($request) {
                if ($request->get('status') != '') {
                    $instance->where('is_active', $request->get('status'));
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                        $w->where('name', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['is_free','created_at','monthly_price','is_active','action'])
            ->make(true);
        }
        return view('backend.plan.crypto.index');
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.plan.crypto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CryptoPlanRequest $request)
    {

     try {
         
        if($request->get('is_free') == 'Y'){
         
          $is_free = CryptoPlan::where('is_free','Y')->count();
          
          if($is_free > 0){

             return redirect()->route('backend.crypto-plans.create')->with(['status' => 'danger', 'message' => 'Oop`s you can not create multiple free plan, you have alreday one free plan.']);
             
         }

         $arr =  [
            'name' => $request->get('name'),
            'slug' => \Str::slug($request->get('slug')),
            'is_featured_plan' => 'Y',
            'is_free' => $request->get('is_free'),
            'duration' => $request->get('duration'),
            'feature' => json_encode($request->get('feature')),
            'description' => $request->get('description'),
        ];

    }else{

      $arr = [
        'name' => $request->get('name'),
        'slug' => \Str::slug($request->get('slug')),
        'is_featured_plan' => 'Y',
        'is_free' => $request->get('is_free'),
        'feature' => json_encode($request->get('feature')),
        'description' => $request->get('description'),
        'monthly_price' => $request->get('monthly_price'),
        // 'yearly_price' => $request->get('yearly_price'),
    ];
}

CryptoPlan::create($arr);
return redirect()->route('backend.crypto-plans.index')->with(['status' => 'success', 'message' => 'Crypto Plan created successfully.']);

}catch (\Exception $e) {
    return redirect()->route('backend.crypto-plans.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
}
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['record'] = CryptoPlan::find($id);
        $data['feature']= json_decode($data['record']->feature);
        ///dd($data);
        return view('backend.plan.crypto.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CryptoPlanRequest $request, $id)
    {
        try {

          if($request->get('is_free') == 'Yes'){

              $is_free = CryptoPlan::where('is_free','Y')->where('id','!=',$id)->count();
              
              if($is_free > 0){

                 return redirect()->route('backend.crypto-plans.edit',$id)->with(['status' => 'danger', 'message' => 'Oop`s you can not create multiple free plan, you have alreday one free plan.']);
             }

             $arr =  [
                'name' => $request->get('name'),
                'slug' => \Str::slug($request->get('slug')),
                'is_featured_plan' => 'Y',
                'is_free' => ($request->get('is_free') == 'Yes') ? 'Y' : 'N',
                'duration' => $request->get('duration'),
                'feature' => json_encode($request->get('feature')),
                'description' => $request->get('description'),
                'monthly_price' => 0,
                // 'yearly_price' => 0,
            ];

        }else{

          $arr = [
            'name' => $request->get('name'),
            'slug' => \Str::slug($request->get('slug')),
            'is_featured_plan' => 'Y',
            'is_free' => ($request->get('is_free') == 'Yes') ? 'Y' : 'N',
            'feature' => json_encode($request->get('feature')),
            'description' => $request->get('description'),
            'monthly_price' => $request->get('monthly_price'),
            // 'yearly_price' => $request->get('yearly_price'),
        ];
    }

    CryptoPlan::where('id', $id)->update($arr);

    return redirect()->route('backend.crypto-plans.index')->with(['status' => 'success', 'message' => 'Plan updated successfully.']);

} catch (\Exception $e) {
    return redirect()->route('backend.crypto-plans.edit', $id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
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
        try{
            $plan = CryptoPlan::with('users')->find($id);

            if($plan->users->count()){
                return response()->json(['status' => 'danger', 'message' => 'You can`t delete, because users already subscribed this plan.']);    
            }

            CryptoPlan::where('id',$id)->delete();

            return response()->json(['status' => 'success', 'message' => 'Crypto Plan deleted successfully.']);
        }catch(\Exception $e){
           return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
       }
   }

   public function changeStatus(Request $request){

    try{
       $cryptoData=CryptoPlan::find($request->id);
       $cryptoData->is_active=$request->is_active;
       $cryptoData->save();
       if($request->is_active=='Y'){

         return response()->json(['status'=>'success','message'=>'Crypto Plan has activated successfully..']);    
     }elseif($request->is_active=='N'){
         
         return response()->json(['status'=>'success','message'=>'Crypto Plan has Inactivated successfully.']);
     }
     
 }catch(\Exception $e){
   
  return response()->json(['status'=>'danger','message'=>'Oop`s something wents worng.']);
}
}
}
