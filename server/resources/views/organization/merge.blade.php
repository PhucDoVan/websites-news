@php
    $navOrganization = 'active';
@endphp

@extends('index')

{{--Set title for page--}}
@section('title', trans('tool/organization.label.merge.title'))

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
                        <h2>{{ trans('tool/organization.label.merge.title') }}</h2>
                    </div>

                    @include('elements.flash-message')

                    <div class="form-row m-0 mb-4">
                        <div class="js_left_box col-md-5 border rounded p-2 bg-light">
                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.id_label') }}
                                    :</label>
                                <label class="col-8">{{ $organization->corporation_id }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.name_label') }}
                                    :</label>
                                <label class="col-8 js_name">{{ $organization->name }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.kana_label') }}
                                    :</label>
                                <label class="col-8 js_kana">{{ $organization->kana }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.postal_code_label') }}
                                    :</label>
                                <label class="col-8 js_postal_code">{{ $organization->postal_code }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.address_label') }}
                                    :</label>
                                <label class="col-8 js_address">{{ $organization->address_pref . $organization->address_city . $organization->address_town . $organization->address_building }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.tel_label') }}
                                    :</label>
                                <label class="col-8 js_tel">{{ $organization->tel }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.email_label') }}
                                    :</label>
                                <label class="col-8 js_email">{{ $organization->email }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.fax_label') }}
                                    :</label>
                                <label class="col-8 js_fax">{{ $organization->fax }}</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <form method="post"
                                  action="{{ route('organization.merge-duplicate', $organization->corporation_id) }}">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="corporation_id_merge">
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
                                                {{ trans('tool/organization.label.merge.merge_button') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="js_right_box col-md-5 border rounded p-2 bg-light">
                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.id_label') }}
                                    :</label>
                                <label class="col-8 js_id"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.name_label') }}
                                    :</label>
                                <label class="col-8 js_name"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.kana_label') }}
                                    :</label>
                                <label class="col-8 js_kana"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.postal_code_label') }}
                                    :</label>
                                <label class="col-8 js_postal_code"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.address_label') }}
                                    :</label>
                                <label class="col-8 js_address"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.tel_label') }}
                                    :</label>
                                <label class="col-8 js_tel"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.email_label') }}
                                    :</label>
                                <label class="col-8 js_email"></label>
                            </div>

                            <div class="form-row">
                                <label class="col-4 text-right">{{ trans('tool/organization.label.merge.fax_label') }}
                                    :</label>
                                <label class="col-8 js_fax"></label>
                            </div>
                        </div>
                    </div>

                    <form class="form-inline mb-2" method="get"
                          action="{{ route('organization.merge-duplicate', $organization->corporation_id) }}">
                        <label class="mr-md-3"
                               for="inputKeyword">{{ trans('tool/organization.label.merge.keyword_label') }}:</label>
                        <input class="form-control mr-md-3 col-md-4" type="text" class="form-control" id="inputKeyword"
                               name="keyword"
                               value="{{ $keyword }}"
                               placeholder="{{ trans('tool/organization.label.merge.keyword_placeholder') }}">

                        <button type="submit" class="btn btn-primary mr-2">
                            <span data-feather="search"></span> {{ trans('tool/organization.label.merge.search_button') }}
                        </button>

                        <a href="{{ session(SESSION_ORGANIZATION_INDEX_URL) ?? route('organization.index') }}"
                           class="btn btn-secondary mt-0">
                            <span data-feather="arrow-left"></span> {{ trans('tool/organization.label.form.CANCEL') }}
                        </a>
                    </form>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>
                                    {{ trans('tool/organization.label.merge.id_label') }}
                                </th>
                                <th>
                                    {{ trans('tool/organization.label.merge.name_label') }}
                                </th>
                                <th>
                                    {{ trans('tool/organization.label.merge.kana_label') }}
                                </th>
                                <th>
                                    {{ trans('tool/organization.label.merge.postal_code_label') }}
                                </th>
                                <th>
                                    {{ trans('tool/organization.label.merge.address_label') }}
                                </th>
                                <th>
                                    {{ trans('tool/organization.label.merge.tel_label') }}
                                </th>
                                <th>
                                    {{ trans('tool/organization.label.merge.email_label') }}
                                </th>
                                <th>
                                    {{ trans('tool/organization.label.merge.fax_label') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!$organizations)
                                <tr>
                                    <td colspan="5" class="text-center">
                                        {{ trans('tool/organization.label.list.table_empty_data') }}
                                    </td>
                                </tr>
                            @else
                                @foreach($organizations as $org)
                                    <tr data-content='@json($org)' class="pointer">
                                        <td>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" id="compare_{{ $org->corporation_id }}"
                                                           name="compare" value="{{ $org->corporation_id }}">
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $org->corporation_id }}
                                            </label>
                                        <td>
                                            <label>
                                                {{ $org->name }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $org->kana }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $org->postal_code }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $org->address_pref . $org->address_city . $org->address_town . $org->address_building }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $org->tel }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $org->email }}
                                            </label>
                                        </td>
                                        <td>
                                            <label>
                                                {{ $org->fax }}
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
    <!--Javascript organization merge-->
    <script src="{{ asset('js/organization/merge.js')}} "></script>
@endpush
