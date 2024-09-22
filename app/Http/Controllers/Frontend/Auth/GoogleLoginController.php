<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback(Request $request)
    {

        try {

            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();
            if(!$user)
            {
                $user = User::create([
                   'name' => $googleUser->name,
                   'email' => $googleUser->email,
                   'email_verified_at'=>date('Y-m-d H:i:s'),
                   'last_login_at' => date('Y-m-d H:i:s'),
                   'last_login_ip' => $request->ip(),
                   'is_active' => 'Y'
               ]);
            }else{

                $data = array(
                   'last_login_at' => date('Y-m-d H:i:s'),
                   'last_login_ip' => $request->ip()
               );

                User::where('email',$user->email)->update($data);

            }

            Auth::login($user);

            return redirect()->route('workspace')->with(['status' => 'success', 'message' => 'Login successfully.']);

        }catch (Exception $e) {

            return redirect()->route('login')->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }

    }

    public function redirectToGithub()
     {
        return Socialite::driver('github')->redirect();
     }


    public function handleGithubCallback(Request $request)
    {
        try {

            $user = Socialite::driver('github')->user();
            $finduser = User::where('github_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                $data = array(
                   'last_login_at' => date('Y-m-d H:i:s'),
                   'last_login_ip' => $request->ip()
               );

                User::where('email',$user->email)->update($data);

                return redirect()->route('workspace')->with(['status' => 'success', 'message' => 'Login successfully.']);

            }else{
                
                 if(!empty($user->name)){
                 $name = $user->name;
                 }elseif(!empty($user->nickname)){
                 $name = $user->nickname;
                 }else{
                 $name = '';
                 }

                $newUser = User::updateOrCreate(['email' => $user->email],[
                   'name' => $name,
                   'github_id'=> $user->id,
                   'email' => $user->email,
                   'email_verified_at'=>date('Y-m-d H:i:s'),
                   'last_login_at' => date('Y-m-d H:i:s'),
                   'last_login_ip' => $request->ip(),
                   'is_active' => 'Y'
                ]);

                Auth::login($newUser);

                return redirect()->route('workspace')->with(['status' => 'success', 'message' => 'Login successfully.']);
            }

        } catch (Exception $e) {

            return redirect()->route('login')->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }


    // public function facebookRedirect()
    // {
    //     return Socialite::driver('facebook')->redirect();
    // }

    // public function loginWithFacebook()
    // {
    //     try {

    //         $user = Socialite::driver('facebook')->user();

    //         $isUser = User::where('fb_id', $user->id)->first();

    //         if($isUser){
    //             Auth::login($isUser);
    //             return redirect('/dashboard');
    //         }else{
    //             $createUser = User::create([
    //                 'name' => $user->name,
    //                 'email' => $user->email,
    //                 'fb_id' => $user->id,
    //                 'password' => encrypt('admin@123')
    //             ]);

    //             Auth::login($createUser);
    //             return redirect('/dashboard');
    //         }

    //     } catch (Exception $exception) {

    //         return redirect()->route('login')->with(['status' => 'danger', 'message' => $e->getMessage()]);
    //     }
    // }

}