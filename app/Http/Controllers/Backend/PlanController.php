<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\PlanRequest;
use DataTables;
use App\Models\Plan;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Plan::all();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('price', function($row){
                return '<i class="fas fa-rupee-sign"></i> '.$row->price;
            })
            ->addColumn('created_at', function($row){
                return $row->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function($row){
                $btn = '';
                $btn .= '<a href="'.route("backend.plans.edit", $row->id).'" class="btn btn-outline-primary btn-sm"><i class="fa-light fa-pencil"></i></a>';
                $btn .= '<a href="javascript:;" data-url="'.route('backend.plans.destroy', $row->id).'" class="delete-record btn btn-outline-danger btn-sm" title="Delete"><i class="fa-light fa-trash-can"></i></a>';
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
            ->rawColumns(['price', 'action'])
            ->make(true);
        }
        return view('backend.plan.credit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.plan.credit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    {
        try {

            Plan::create([
                'name' => $request->get('name'),
                'slug' => \Str::slug($request->get('slug')),
                'credits' => $request->get('credits'),
                'price' => $request->get('price')
            ]);
            return redirect()->route('backend.plans.index')->with(['status' => 'success', 'message' => 'Credit Plan created successfully.']);

        } catch (\Exception $e) {
            return redirect()->route('backend.plans.create')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
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
        $record = Plan::find($id);

        return view('backend.plan.credit.edit', ['record' => $record]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanRequest $request, $id)
    {
        try {
            $data = [
                'name' => $request->get('name'),
                'slug' => \Str::slug($request->get('slug')),
                'credits' => $request->get('credits'),
                'price' => $request->get('price')
            ];

            if($request->get('is_featured_plan', 'N') == 'Y'){
                $data['is_featured_plan'] = 'Y';
                Plan::update(['is_featured_plan' => 'N']);
            }

            Plan::where('id', $id)->update($data);

            return redirect()->route('backend.plans.index')->with(['status' => 'success', 'message' => 'Credit Plan updated successfully.']);

        } catch (\Exception $e) {
            return redirect()->route('backend.plans.edit', $id)->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
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

            $plan = Plan::with('users')->find($id);
            
            /* Remove plan from user credits */
            // $plan->users->update(['plan_id' => null]);

            if($plan->users->count()){
                return response()->json(['status' => 'danger', 'message' => 'You can`t delete, because users already subscribed this plan.']);    
            }

            $plan->delete();

            return response()->json(['status' => 'success', 'message' => 'Credit Plan deleted successfully.']);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
