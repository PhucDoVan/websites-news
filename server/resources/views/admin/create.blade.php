@php
    $navAdmin = 'active';
@endphp
@extends('index')
{{--Set title for page--}}
@if(empty($manager))
    @section('title', trans('tool/admins.label.edit.title_create'))
@else
    @section('title', trans('tool/admins.label.edit.title_edit'))
@endif
{{--Content for page--}}
@section('content')
    <body>
        @include('elements.header-admin')
        <div class="container-fluid">
            <div class="row">
                {{--Side bar--}}
                @include('elements.sidebar-admin')
                <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
                    <form method="post"
                          action="{{ empty($manager ?? []) ? route('admin.store') : route('admin.update', $manager['manager_id'])  }}">
                        @csrf
                        @if( ! empty($manager ?? []))
                            @method('PUT')
                        @endif
                        <div class="pb-2 mt-4 mb-2 border-bottom">
                            @if(empty($manager))
                                <h2>{{ trans('tool/admins.label.edit.title_create') }}</h2>
                            @else
                                <h2>{{ trans('tool/admins.label.edit.title_edit') }}</h2>
                            @endif
                        </div>
                        @include('elements.flash-message')
                        <div class="form-row">
                            <div class="col-md-4 offset-md-3 mb-3">
                                <label for="inputDisplayName">{{ trans('tool/admins.label.edit.name') }}<span
                                            class="text-danger">{{ trans('tool/admins.label.edit.require') }}</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name"
                                           value="{{ old('name', $manager['name'] ?? '') }}"
                                           placeholder="{{ trans('tool/admins.label.edit.name_placeholder') }}">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 offset-md-3 mb-3">
                                <label for="inputUserName">{{ trans('tool/admins.label.edit.username') }}<span
                                            class="text-danger">{{ trans('tool/admins.label.edit.require') }}</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="username"
                                           value="{{ old('username', $manager['username'] ?? '') }}"
                                           placeholder="{{ trans('tool/admins.label.edit.username_placeholder') }}">
                                </div>
                                @if ($errors->has('username'))
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 offset-md-3 mb-4">
                                <label for="inputPassword">{{ trans('tool/admins.label.edit.password') }}
                                    @if(empty($manager))
                                        <span class="text-danger">{{ trans('tool/admins.label.edit.require') }}</span>
                                    @endif
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="password"
                                           placeholder="{{ trans('tool/admins.label.edit.password_placeholder') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary generate_password" type="button"><span
                                                    data-feather="refresh-cw"></span> {{ trans('tool/admins.label.edit.button_generate_password') }}
                                        </button>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 offset-md-3 mb-3">
                                <div class="input-group">
                                    <a href="{{ session(SESSION_ADMIN_INDEX_URL) ?? route('admin.index') }}"
                                       class="btn btn-secondary btn-block mb-2">
                                        <span data-feather="arrow-left"></span> {{ trans('tool/admins.label.form.CANCEL') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-success btn-block mb-2">
                                        <span data-feather="save"></span> {{ trans('tool/admins.label.form.SAVE') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </body>
@endsection

@push('scripts')
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/password.js') }}"></script>
    <script src="{{ asset('js/admin/edit.js') }}"></script>
@endpush
