@extends('admin.layouts.master')
@section('title', 'Change Password')
@section('content')
    <div class="container">
        <div class="col-md-6 offset-md-3">
            <div class="card card-outline-secondary mt-5">
                <div class="card-header">
                    <h3 class="mb-0">Change Password</h3>
                </div>
                <div class="clearfix"></div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form class="form" method="POST" action="{{ route('admin.change_password') }}">
                        @csrf
                        <div class="form-group">
                            <label for="current-password">Current Password</label>
                            <input id="current-password" type="password" class="form-control" name="password">
                            @if ($errors->has('password'))
                                <span class="alert-danger">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="new-password">New Password</label>
                            <input id="new-password" type="password" class="form-control"
                                   name="new-password">
                            @if ($errors->has('new-password'))
                                <span class="alert-danger">
                                    <strong>{{ $errors->first('new-password') }}</strong>
                                </span>
                            @endif
                            <span class="form-text small text-muted">
                                The password must be 5-20 characters, and must <em>not</em> contain spaces.
                            </span>
                        </div>
                        <div class="form-group">
                            <label for="new-password-confirm">Confirm New Password</label>
                            <input id="new-password-confirm" type="password" class="form-control"
                                   name="new-password_confirmation">
                            <span class="form-text small text-muted">
                                To confirm, type the new password again.
                            </span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-lg float-left">Change Password</button>
                            <button type="reset" class="btn btn-warning btn-lg float-right">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /form card change password -->
        </div>
    </div>
@endsection


