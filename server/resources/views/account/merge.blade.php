@php
    $navAccount = 'active';
@endphp

@extends('index')

{{--Set title for page--}}
@section('title', trans('tool/accounts.label.merge.title'))

{{--Content for page--}}
@section('content')
    <body>
        @include('elements.header-admin')

        <div class="container-fluid">
            <div class="row">
                {{--Side bar--}}
                @include('elements.sidebar-admin')

                <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
                    <div class="pb-2 mt-4 mb-2 border-bottom">
                        <h2>{{ trans('tool/accounts.label.merge.title') }}</h2>
                    </div>

                    @include('elements.flash-message')

                    <div class="form-row m-0 mb-4">
                        <div class="js_left_box col-md-5 border rounded p-2 bg-light">
                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.id_label') }}:</label>
                                <label class="col-9">{{ $account->account_id }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.corporation_name_label') }}:</label>
                                <label class="col-9 js_corporation_name">{{ $account->corporation_name }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.login_id_label') }}:</label>
                                <label class="col-9 js_username">{{ $account->username }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.name_last_label') }}:</label>
                                <label class="col-9 js_name_last">{{ $account->name_last }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.name_first_label') }}:</label>
                                <label class="col-9 js_name_first">{{ $account->name_first }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.kana_last_label') }}:</label>
                                <label class="col-9 js_kana_last">{{ $account->kana_last }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.kana_first_label') }}:</label>
                                <label class="col-9 js_kana_first">{{ $account->kana_first }}</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <form method="post" action="{{ route('account.merge-duplicate', $account->account_id) }}">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="account_id_merge">
                                <input type="hidden" name="keyword" value="{{ Request::input('keyword') }}">

                                <div class="wrapper text-center">
                                    <div class="btn-group-vertical align-items-center">
                                        <div class="mb-3 btn-group-toggle merge_to" data-toggle="buttons">
                                            <label class="btn btn-outline-primary mb-3">
                                                <input name="merge_to" type="radio" autocomplete="off" value="right">
                                                <span data-feather="arrow-right"></span>
                                            </label>
                                            <label class="btn btn-outline-primary">
                                                <input name="merge_to" type="radio" autocomplete="off" value="left">
                                                <span data-feather="arrow-left"></span>
                                            </label>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-success js_button_merge">
                                                {{ trans('tool/accounts.label.merge.merge_button') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="js_right_box col-md-5 border rounded p-2 bg-light">
                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.id_label') }}:</label>
                                <label class="col-9 js_id"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.corporation_name_label') }}:</label>
                                <label class="col-9 js_corporation_name"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.login_id_label') }}:</label>
                                <label class="col-9 js_username"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.name_last_label') }}:</label>
                                <label class="col-9 js_name_last"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.name_first_label') }}:</label>
                                <label class="col-9 js_name_first"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.kana_last_label') }}:</label>
                                <label class="col-9 js_kana_last"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.merge.kana_first_label') }}:</label>
                                <label class="col-9 js_kana_first"></label>
                            </div>
                        </div>
                    </div>

                    <form class="form-inline mb-2" method="get" action="{{ route('account.merge-duplicate', $account->account_id) }}">
                        <label class="mr-md-3" for="inputKeyword">{{ trans('tool/accounts.label.merge.keyword_label') }}:</label>
                        <input class="form-control mr-md-3 col-md-4" type="text" class="form-control" id="inputKeyword" name="keyword"
                               value="{{ $keyword }}"
                               placeholder="{{ trans('tool/accounts.label.merge.keyword_placeholder') }}">

                        <button type="submit" class="btn btn-primary mr-2">
                            <span data-feather="search"></span> {{ trans('tool/accounts.label.merge.search_button') }}
                        </button>

                        <a href="{{ session(SESSION_ACCOUNT_INDEX_URL) ?? route('account.index') }}"
                           class="btn btn-secondary mt-0">
                            <span data-feather="arrow-left"></span> {{ trans('tool/accounts.label.form.CANCEL') }}
                        </a>
                    </form>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        {{ trans('tool/accounts.label.merge.id_label') }}
                                    </th>
                                    <th>
                                        {{ trans('tool/accounts.label.merge.corporation_name_label') }}
                                    </th>
                                    <th>
                                        {{ trans('tool/accounts.label.merge.login_id_label') }}
                                    </th>
                                    <th>
                                        {{ trans('tool/accounts.label.merge.name_last_label') }}
                                    </th>
                                    <th>
                                        {{ trans('tool/accounts.label.merge.name_first_label') }}
                                    </th>
                                    <th>
                                        {{ trans('tool/accounts.label.merge.kana_last_label') }}
                                    </th>
                                    <th>
                                        {{ trans('tool/accounts.label.merge.kana_first_label') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!$accounts)
                                <tr>
                                    <td colspan="5" class="text-center">
                                        {{ trans('tool/accounts.label.index.table_empty_data') }}
                                    </td>
                                </tr>
                            @else
                                @foreach($accounts as $account)
                                    <tr data-content='@json($account)' class="pointer">
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" id="compare_{{ $account->account_id }}" name="compare" value="{{ $account->account_id }}">
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $account->account_id }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $account->corporation_name }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $account->username }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $account->name_last }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $account->name_first }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $account->kana_last }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $account->kana_first }}
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>

        @include('elements.loader')
    </body>
@endsection

@push('scripts')
    <!--Javascript account merge-->
    <script src="{{ asset('js/account/merge.js')}} "></script>
@endpush
