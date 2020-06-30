@extends('admin.layouts.master')
@section('title', 'Forgot Password')
@section('content')
    <div class="container">
        <div class="col-md-6 offset-md-3">
            <div class="card card-outline-secondary mt-5">
                <div class="card-header">
                    <h3 class="mb-0">Forgot Password</h3>
                </div>
                <div class="card-body">
                    <form class="form" action="{{route('admin.forgot_password')}}" method="post">
                        @csrf
                        @if(session('error'))
                            <div>
                                {{ session('error') }}
                            </div>
                        @endif
                        @if(session('success'))
                            <div>
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control" name="email">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
