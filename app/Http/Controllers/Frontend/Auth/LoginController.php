<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginRequest;
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
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = 'workspace';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // return view('frontend.auth.login');
        return view('frontend.auth.login');
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

        if ($user && $user->isUser()){

            /* Login if user is active */
            if ($user->is_active == 'Y') {

                if (method_exists($this, 'hasTooManyLoginAttempts') && $this->hasTooManyLoginAttempts($request)) {
                    $this->fireLockoutEvent($request);
                    return $this->sendLockoutResponse($request);
                }

                if(session()->get('user_login_attemts')){
                
                session()->put('user_login_attemts',session()->get('user_login_attemts')+1);
                }else{
                
                session()->put('user_login_attemts',1);
                }

                $data = LoginLog::Create([
                'ip_address'=>$request->ip(),
                'login_at'=>date('Y-m-d H:i:s'),
                'login_attemts'=>session()->get('user_login_attemts'),
                'status'=>'fail',
                'user_id'=>$user->id,
                ]);

               $login_id = $data->id;

                if ($this->attemptLogin($request)) {

                    /* Update user's last login */
                    $user->last_login_at = date('Y-m-d H:i:s');
                    $user->last_login_ip = $request->ip();
                    $user->save();
                    LoginLog::where('id',$login_id)->update(['status'=>'success']);

                    /* Remove captcha from session after validate */
                    if (\Session::has('captcha')) {
                        \Session::remove('captcha');
                    }

                    return $this->sendLoginResponse($request);
                }

                $this->incrementLoginAttempts($request);

                return $this->sendFailedLoginResponse($request);

            }else {
                return redirect()->route('login')->with(['status' => 'danger', 'message' => 'Your account is in-active, please contact to administrator.']);
            }

        } else {
            return redirect()->route('login')->with(['status' => 'danger', 'message' => 'These credentials do not match our records.']);
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath())->with(['status' => 'success', 'message' => 'Login successfully.']);
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

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/')->with(['status' => 'success', 'message' => 'Logout successfully.']);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /* Refresh captcha */
    public function refreshCaptcha()
    {
        return captcha_src('flat');
    }

    /* Check if user is logged in or not */
    public function isAuthenticated(){
        return response()->json(['auth_check' => \Auth::check(), 'auth_user' => \Auth::user()]);
    }
}
