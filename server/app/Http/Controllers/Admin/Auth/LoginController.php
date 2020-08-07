<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use function Deployer\has;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getLogin()
    {
        return view('admin.auth.login');
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

    public function postLogin(Request $request)
    {
        if ($request->isMethod('post')) {
            $username = $request->input("username");
            $password = $request->input("password");
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                return redirect()->route('admin.login')->withInput()->withErrors($validator);
            }
            if (Auth::attempt(['username' => $username, 'password' => $password])) {
                return redirect($this->redirectTo($request));
            } else {
                return redirect()->route('admin.login')->withInput()->withErrors('UserName Or Password InCorrect !');
            }
        }
        return view('admin.auth.login');
    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:25',
            'password' => 'required|string|min:5|max:20',
        ]);
    }

    /**
     * The user has logged out of the application.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function logout()
    {
        if (Auth::logout()) {
            return redirect(route('admin.login'));
        }
        return redirect(route('admin.menu'));
    }
}
