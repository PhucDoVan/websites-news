@php
    $navAccount = 'active';
@endphp
@extends('index')
{{--Set title for page--}}
@if(empty($account))
    @section('title', trans('tool/accounts.label.edit.title_create'))
@else
    @section('title', trans('tool/accounts.label.edit.title_edit'))
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
                          action="{{ empty($account ?? []) ? route('account.store') : route('account.update', $account['account_id'])  }}">
                        @csrf
                        @if( ! empty($account ?? []))
                            @method('PUT')
                        @endif
                        <div class="pb-2 mt-4 mb-2 border-bottom">
                            @if(empty($account))
                                <h2>{{ trans('tool/accounts.label.edit.title_create') }}</h2>
                            @else
                                <h2>{{ trans('tool/accounts.label.edit.title_edit') }}</h2>
                            @endif
                        </div>
                        @include('elements.flash-message')
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="">{{ trans('tool/accounts.label.edit.corporation') }}
                                    <span class="text-danger">{{ trans('tool/accounts.label.edit.require') }}</span></label>
                                <div class="input-group">
                                    <select class="form-control selectpicker" data-live-search="true" {{ !empty($account) ? 'disabled' : 'name=corporation_id' }}>
                                        <option value="">{{ trans('tool/accounts.label.edit.select_default') }}</option>
                                        @foreach($corporations as $corporation)
                                            <option value="{{ $corporation->corporation_id }}" data-uid="{{ $corporation->uid }}"
                                                    {{ old('corporation_id', $account['corporation_id'] ?? '') == $corporation->corporation_id ? 'selected' : '' }}
                                            >{{ $corporation->name }}</option>
                                        @endforeach
                                    </select>
                                    @if(!empty($account))
                                        <input type="hidden" name="corporation_id" value="{{ $account['corporation_id'] }}">
                                    @endif
                                </div>
                                @if ($errors->has('corporation_id'))
                                    <span class="text-danger">{{ $errors->first('corporation_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="inputUserName">{{ trans('tool/accounts.label.edit.username') }}<span
                                            class="text-danger">{{ trans('tool/accounts.label.edit.require') }}</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="username" readonly
                                           value="{{ old('username', $account['username'] ?? '') }}"
                                           placeholder="{{ trans('tool/accounts.label.edit.username_placeholder') }}">
                                    @if(empty($account))
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary generate_username" type="button">
                                                <span data-feather="refresh-cw"></span> {{ trans('tool/accounts.label.edit.button_generate_password') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                @if ($errors->has('username'))
                                    <span class="text-danger">{{ $errors->first('username') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="inputPassword">{{ trans('tool/accounts.label.edit.password') }}
                                    @if(empty($account))
                                        <span class="text-danger">{{ trans('tool/accounts.label.edit.require') }}</span>
                                    @endif
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="password"
                                           placeholder="{{ trans('tool/accounts.label.edit.password_placeholder') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary generate_password" type="button"><span
                                                    data-feather="refresh-cw"></span> {{ trans('tool/accounts.label.edit.button_generate_password') }}
                                        </button>
                                    </div>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label>{{ trans('tool/accounts.label.edit.name') }}<span
                                            class="text-danger">{{ trans('tool/accounts.label.edit.require') }}</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name_last"
                                           value="{{ old('name_last', $account['name_last'] ?? '') }}"
                                           placeholder="{{ trans('tool/accounts.label.edit.name_last_placeholder') }}">
                                </div>
                                @if ($errors->has('name_last'))
                                    <span class="text-danger">{{ $errors->first('name_last') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>&nbsp;</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name_first"
                                           value="{{ old('name_first', $account['name_first'] ?? '') }}"
                                           placeholder="{{ trans('tool/accounts.label.edit.name_first_placeholder') }}">
                                </div>
                                @if ($errors->has('name_first'))
                                    <span class="text-danger">{{ $errors->first('name_first') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label>{{ trans('tool/accounts.label.edit.kana') }}<span
                                            class="text-danger">{{ trans('tool/accounts.label.edit.require') }}</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="kana_last"
                                           value="{{ old('kana_last', $account['kana_last'] ?? '') }}"
                                           placeholder="{{ trans('tool/accounts.label.edit.kana_last_placeholder') }}">
                                </div>
                                @if ($errors->has('kana_last'))
                                    <span class="text-danger">{{ $errors->first('kana_last') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>&nbsp;</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="kana_first"
                                           value="{{ old('kana_first', $account['kana_first'] ?? '') }}"
                                           placeholder="{{ trans('tool/accounts.label.edit.kana_first_placeholder') }}">
                                </div>
                                @if ($errors->has('kana_first'))
                                    <span class="text-danger">{{ $errors->first('kana_first') }}</span>
                                @endif
                            </div>
                        </div>
                        {{--Add limit--}}
                        <div class="pb-2 mt-4 mb-2 border-bottom">
                            <h2>{{ trans('tool/accounts.label.edit.form_ip_title') }}</h2>
                        </div>
                        @if ($errors->has('restrict_ips'))
                            <div class="form-row">
                                <div class="col-md-12">
                                    <span class="text-danger">{{ $errors->first('restrict_ips') }}</span>
                                </div>
                            </div>
                        @endif
                        @if(!empty(old('restrict_ips', $account['restrict_ips'] ?? [])))
                            @foreach(old('restrict_ips', $account['restrict_ips'] ?? []) as $restrictIpIndex => $restrictIp)
                                <div class="form-row mb-3">
                                    <div class="col-md-4 input-group">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="restrict_ips[]"
                                                   value="{{ $restrictIp }}"
                                                   placeholder="{{ trans('tool/accounts.label.edit.restrict_ip_placeholder') }}">
                                            @if ($errors->has('restrict_ips.' . $restrictIpIndex))
                                                <span class="text-danger">{{ $errors->first('restrict_ips.' . $restrictIpIndex) }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-secondary"
                                                    onclick="deleteRestrictIpRow(this)"><span
                                                        data-feather="minus"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="form-row mb-3">
                                <div class="col-md-4 input-group">
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="restrict_ips[]" value=""
                                               placeholder="{{ trans('tool/accounts.label.edit.restrict_ip_placeholder') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-secondary"
                                                onclick="deleteRestrictIpRow(this)"><span data-feather="minus"></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-row mb-3 restrict_ip_last_row">
                            <div class="col-md-4 input-group">
                                <div class="offset-md-10 col-md-2">
                                    <button class="btn btn-outline-secondary add_restrict_ip" type="button">
                                        <span data-feather="plus"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-row justify-content-center">
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <a href="{{ session(SESSION_ACCOUNT_INDEX_URL) ?? route('account.index') }}"
                                       class="btn btn-secondary btn-block mb-2">
                                        <span data-feather="arrow-left"></span> {{ trans('tool/accounts.label.form.CANCEL') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-success btn-block mb-2">
                                        <span data-feather="save"></span> {{ trans('tool/accounts.label.form.SAVE') }}
                                    </button>
                                </div>
                            </div>
                            @if(empty($account))
                                <div class="col-md-3 mb-3">
                                    <div class="input-group">
                                        <button type="submit" name="continue_register" class="btn btn-primary btn-block mb-2" value="true">
                                            <span data-feather="save"></span> {{ trans('tool/accounts.label.form.CONTINUE_REGISTER') }}
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </form>
                </main>
            </div>
        </div>
        <div class="sr-only restrict_ip_row">
            <div class="form-row mb-3">
                <div class="col-md-4 input-group">
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="restrict_ips[]" value=""
                               placeholder="{{ trans('tool/accounts.label.edit.restrict_ip_placeholder') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-secondary"
                                onclick="deleteRestrictIpRow(this)"><span data-feather="minus"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection

@push('scripts')
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/password.js') }}"></script>
    <script src="{{ asset('js/account/edit.js') }}"></script>
@endpush
