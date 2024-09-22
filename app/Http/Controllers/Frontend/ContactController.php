<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Requests\ContactUsRequest;
use App\Libraries\Blockcypher;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUs;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['seoData']=\App\Models\Seo::where('slug','contact_us')->first();
       return view('frontend.contactus',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactUsRequest $request)
    {
        try {

          if($request->get('name') == "RobertAdame"){
              return redirect()->route('contact-us')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
          }

            Contact::create([
                'query_type' => $request->get('query_type'),
                'name' => $request->get('name'),
                'email' =>  $request->get('email_id'),
                //'phone' => $request->get('phone_no'),
                'description' => $request->get('query'),
                'user_ip' => $request->ip(),
            ]);

            return redirect()->route('contact-us')->with(['status' => 'success', 'message' => 'Your query has submited successfully.']);

        } catch (\Exception $e) {
            return redirect()->route('contact-us')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(contact $contact)
    {
        //
    }
}
