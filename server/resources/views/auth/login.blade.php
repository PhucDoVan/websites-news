@extends('index')
{{--Set title for page--}}
@section('title', 'ログイン')
{{--Content for page--}}
@section('content')
    <body class="signin">
        <form class="form-signin" action="{{ route('login') }}" method="POST">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal text-center">契約関連統合管理システム</h1>

            @if ($errors->any())
                <div class="error_message">
                    <div class="alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <input type="text" id="inputUserName" name="username" class="form-control" placeholder="ユーザー名"
                   value="{{ old('username') }}" required autofocus sel>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="パスワード" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>

            <p class="mt-5 mb-3 text-muted text-center">&copy; 2019 - 2019</p>
        </form>
    </body>
@endsection

@push('scripts')
    <script src="{{ asset('js/custom.js') }}"></script>
@endpush
