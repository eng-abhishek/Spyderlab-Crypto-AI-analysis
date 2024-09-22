<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Backend\UpdateProfileRequest;
use App\Http\Requests\Backend\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * view profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewProfile()
    {
        $user = \Auth::guard('backend')->user();

        $record = User::find($user->id);

        return view('backend.account.profile', ['record' => $record]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            \DB::beginTransaction();

            $user = \Auth::guard('backend')->user();

            //Upload user avatar (with resize)
            if($request->hasFile('avatar')){

                $document_path = 'avatars';
                if (!\Storage::exists($document_path)) {
                    \Storage::makeDirectory($document_path, 0777);
                }

                //Remove old avatar
                if ($user->avatar != '' && \Storage::exists($document_path.'/'.$user->avatar)) {
                    \Storage::delete($document_path.'/'.$user->avatar);
                }

                $avatar_name = $user->id.'_avatar_'.time().'.'.$request->file('avatar')->getClientOriginalExtension();
                $avatar = \Image::make($request->file('avatar'))->resize(100, 100);
                $avatar->save(storage_path('app/public/'.$document_path.'/').$avatar_name);

                $user->avatar = $avatar_name;
            }

            $user->name = $request->get('name');
            // $user->mobile = $request->get('mobile');
            $user->save();

            \DB::commit();

            return redirect()->route('backend.account.profile.view')->with(['status' => 'success', 'message' => 'Profile updated successfully.']);

        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->route('backend.account.profile.view')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

    /**
     * Remove Image.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeImage($id)
    {
        try{
            $user = User::find($id);

            $document_path = 'avatars';

            //Remove old avatar
            if ($user->avatar != '' && \Storage::exists($document_path.'/'.$user->avatar)) {
                \Storage::delete($document_path.'/'.$user->avatar);
            }

            $user->avatar = null;
            $user->save();

            return response()->json(['status' => 'success', 'message' => 'Image removed successfully.', 'image' => $user->avatar_url]);
        }catch(\Exception $e){
            return response()->json(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }

    /**
     * view change password.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function viewChangePassword()
    {
        return view('backend.account.change-password');
    }

    /**
     * Save change password.
     *
     * @param  \App\Http\Requests\UpdateProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function saveChangePassword(ChangePasswordRequest $request)
    {
        try{
            $user = \Auth::guard('backend')->user();

            User::where('id', $user->id)->update(['password' => Hash::make($request->get('password'))]);

            \Auth::guard('backend')->logoutOtherDevices($request->get('password'));
            
            return redirect()->route('backend.account.change-password.view')->with(['status' => 'success', 'message' => 'Password has changed successfully.']);

        } catch (\Exception $e) {
            return redirect()->route('backend.account.change-password.view')->with(['status' => 'danger', 'message' => 'Something went wrong, please try again.']);
        }
    }
}
