<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    public function getFormResetPassword()
    {
        return view('admin.auth.forgot_password');
    }

    public function sendCodeResetPassword(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user == null) {
            return redirect()->back()->with(['error' => 'Email not exists.']);
        }

        $code = bcrypt(md5(time() . $email));
        $user->code = $code;
        $user->time_code = Carbon::now();
        $user->save();

        $this->sendEmail($user, $code);

        return redirect()->back()->with(['success' => 'Reset code sent to your email.']);
    }

    public function sendEmail($user, $code)
    {
        Mail::send(
            'admin.email.reset_password',
            ['user' => $user, 'code' => $code],
            function ($message) use ($user) {
                $message->to($user->email);
                $message->subject("$user->name, Reset your password.");
            }

        );
    }

    public function resetPassword(Request $request)
    {
        $email = $request->email;
        $code = $request->code;

        $user = User::where([
            'email' => $email,
            'code' => $code,
        ])->first();

        if($user == null){
            return redirect('/')->with('error', 'Sorry, The path is not correct. Please try again later !');
        }
        return view('admin.auth.reset_password');
    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            //'password' => 'required|string',
            'password' => 'required|string|min:5|max:20|confirmed',
        ]);
    }
}
