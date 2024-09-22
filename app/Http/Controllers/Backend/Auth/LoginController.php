<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\LoginRequest;
use App\Models\User;
use App\Models\LoginLog;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/backend';


    protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 1; // Default is 1

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:backend')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->get('email'))->first();
        
        if ($user && $user->isSuperAdmin()){

                if(session()->get('login_attemts')){
                
                session()->put('login_attemts',session()->get('login_attemts')+1);
                }else{
                
                session()->put('login_attemts',1);
                }

                $data = LoginLog::Create([
                'ip_address'=>$request->ip(),
                'login_at'=>date('Y-m-d H:i:s'),
                'login_attemts'=>session()->get('login_attemts'),
                'status'=>'fail',
                'user_id'=>$user->id,
                ]);

               $login_id = $data->id;
               

            if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
                                
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }

           

            if ($this->attemptLogin($request)) {
                
                /* Update user's last login */
                $user->last_login_at = date('Y-m-d H:i:s');
                $user->last_login_ip = $request->ip();
                $user->save();
                session()->forget('login_attemts');
                LoginLog::where('id',$login_id)->update(['status'=>'success']);
                 
                return $this->sendLoginResponse($request);
            }

            $this->incrementLoginAttempts($request);

           return $this->sendFailedLoginResponse($request);

        } else {
            return redirect()->route('backend.login')->with(['status' => 'danger', 'message' => 'These credentials do not match our records.']);
        }
    }



    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        $login_user = LoginLog::take(1)->orderBy('id','desc')->first();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }
        
        if($login_user){
        $data = [
                'ip_address'=>$request->ip(),
                'login_at'=>$login_user->login_at,
                'logout_at'=>date('Y-m-d H:i:s'),
                'user_id'=>$login_user->user_id,
                'status'=>'logout',
                ];
        
        LoginLog::Create($data);
        }

        return $request->wantsJson()
        ? new JsonResponse([], 204)
        : redirect()->route('backend.login');
    }
    
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('backend');
    }

    protected function redirectTo()
    {
        return admin_url();
    }

    /* Refresh captcha */
    public function refreshCaptcha()
    {
        return captcha_src('flat');
    }
}
