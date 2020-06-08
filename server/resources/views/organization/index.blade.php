@php
    $navOrganization = 'active';
@endphp
@extends('index')
{{--Set title for page--}}
@section('title', trans('tool/organization.label.list.title'))
{{--Content for page--}}
@section('content')
    <body>
        @include('elements.header-admin')
        @include('elements.delete-modal', ['screen' => 'organization'])

        <div class="container-fluid">
            <div class="row">
                {{--Side bar--}}
                @include('elements.sidebar-admin')
                <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
                    <div class="pb-2 mt-4 mb-2 border-bottom">
                        <h2>{{ trans('tool/organization.label.list.title_filter') }}</h2>
                    </div>
                    @include('elements.flash-message')
                    <form method="get" action="{{ route('organization.index') }}">
                        <input type="hidden" name="sort_column" value="{{ $formData['sort_column'] }}">
                        <input type="hidden" name="sort_direction" value="{{ $formData['sort_direction'] }}">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="inputKeyword">{{ trans('tool/organization.label.list.keyword_label') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inputKeyword" name="keyword"
                                           value="{{ $formData['keyword'] }}"
                                           placeholder="{{ trans('tool/organization.label.list.keyword_placeholder') }}">
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>{{ trans('tool/organization.label.list.search_label') }}</label>
                                <div class="input-group">
                                    <button type="submit" class="btn btn-primary mb-2">
                                        <span data-feather="search"></span> {{ trans('tool/organization.label.list.search_button') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="pb-2 mt-4 mb-2 border-bottom">
                        <h2>{{ trans('tool/organization.label.list.title') }}</h2>
                    </div>
                    <div class="table-responsive">
                        <nav>
                            {{ $corporations->appends($formData)->links() }}
                        </nav>
                        <input type="hidden"
                               value="{{ route('organization.index', ['keyword' => $formData['keyword']]) }}"
                               name="current_url">
                        <table class="table dataTable">
                            <thead>
                            <tr>
                                <th {{ sort_info('corporation_id', $formData['sort_column'], $formData['sort_direction']) }}>
                                    {{ trans('tool/organization.label.list.column_no') }}
                                </th>
                                <th {{ sort_info('name', $formData['sort_column'], $formData['sort_direction']) }}>
                                    {{ trans('tool/organization.label.list.column_name') }}
                                </th>
                                <th {{ sort_info('address', $formData['sort_column'], $formData['sort_direction']) }}>
                                    {{ trans('tool/organization.label.list.column_address') }}/
                                    {{ trans('tool/organization.label.list.column_contact') }}
                                </th>
                                <th {{ sort_info('updated_at', $formData['sort_column'], $formData['sort_direction']) }}>
                                    {{ trans('tool/organization.label.list.column_update') }}
                                </th>
                                <th>
                                    <button type="button" class="btn btn-success btn-sm"
                                            onclick="location.href='/manage/organization/create';">
                                        <span data-feather="file-text"></span> {{ trans('tool/organization.label.list.button_create') }}
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($corporations->count() === 0)
                                <tr>
                                    <td colspan="6" class="text-center">
                                        {{ trans('tool/organization.label.list.table_empty_data') }}
                                    </td>
                                </tr>
                            @else
                                @foreach($corporations as $corporation)
                                    <tr>
                                        <td rowspan="2">{{ $corporation->corporation_id }}</td>
                                        <td>{{ $corporation->name }}</td>
                                        <td>
                                            {{ get_address($corporation->postal, $corporation->address_pref, $corporation->address_city, $corporation->address_town, $corporation->address_building) }}
                                        </td>
                                        <td rowspan="2">{{ format_date($corporation->updated_at) }}</td>
                                        <td rowspan="2">
                                            <a href="{{ route('organization.merge-duplicate', $corporation->corporation_id) }}"
                                               class="btn btn-warning btn-sm disabled">
                                                <span data-feather="git-merge"></span> {{ trans('tool/organization.label.list.button_merge') }}
                                            </a>
                                            <a href="{{ route('organization.edit', $corporation->corporation_id) }}"
                                               class="btn btn-primary btn-sm">
                                                <span data-feather="edit"></span> {{ trans('tool/organization.label.list.button_edit') }}
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                    data-toggle="modal"
                                                    data-url="{!! route('organization.destroy', $corporation->corporation_id) !!}"
                                                    data-target="deleteModal">
                                                <span data-feather="delete"></span> {{ trans('tool/organization.label.list.button_delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        @php
                                            $contact = $corporation->contacts->first();
                                        @endphp
                                        <td rowspan="1">{{ $corporation->kana }}</td>
                                        <td>
                                            <a href="mailto:{{ optional($contact)->email }}">
                                                {{ optional($contact)->email }}
                                            </a>
                                            {{ get_contact(optional($contact)->tel, optional($contact)->fax) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <nav>
                            {{ $corporations->appends($formData)->links() }}
                        </nav>
                    </div>
                </main>
            </div>
        </div>
    </body>
@endsection

@push('scripts')
    <!--Javascript organization list-->
    <script src="{{ asset('js/custom.js') }} "></script>
    <script src="{{ asset('js/organization/list.js')}} "></script>
@endpush
