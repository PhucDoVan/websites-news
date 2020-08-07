<h1>Hello {{$user->name}}</h1>
<p>
    Please click the password reset button to reset your password
    <a href="{{route('admin.reset_password', ['email' => $user->email, 'code' => $code])}}">Reset Password</a>
</p>
