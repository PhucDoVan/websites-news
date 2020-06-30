<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getChangePassword()
    {
        return view('admin.auth.change_password');
    }

    public function redirectTo($request)
    {
        if (session('prev_url')) {
            $next = session('prev_url');
            session()->forget(['prev_url']);
            return $next;
        }
        return url('admin/menu');
    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string',
            'new-password' => 'required|string|min:5|max:20|confirmed',
        ]);
    }

    public function postChangePassword(Request $request)
    {

        if (!(Hash::check($request->get('password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->route('admin.change_password')->withInput()->withErrors($validator);
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success", "Password changed successfully !");

    }
}
