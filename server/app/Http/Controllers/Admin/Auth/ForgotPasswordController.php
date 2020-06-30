<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use League\CommonMark\Block\Renderer\IndentedCodeRenderer;

class ForgotPasswordController extends Controller
{
    public function getForgotPassword()
    {
        return view('admin.auth.forgot_password');
    }

    public function postForgotPassword(Request $request)
    {
        $user = User::whereEmail($request->email)->first();

        if ($user == null) {
            return redirect()->back()->with(['error' => 'Email not exists']);
        }

        $user = User::findById($user->id);
        $reminder = User::exists($user) ?: Reminder::create($user);
        $this->sendEmail($user, $reminder->code);
        return redirect()->back()->with(['success' => 'Reset code sent to your email.']);

    }

    public function sendEmail($user, $code)
    {
        Mail::send(
            'email.getForgotPassword',
            ['user' => $user, 'code' => $code],
            function ($message) use ($user) {
                $message->to($user->email);
                $message->subject("$user->name, Reset your password.");
            }

        );
    }

}
