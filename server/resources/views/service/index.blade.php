@php
    $navService = 'active';
@endphp
@extends('index')
{{--Set title for page--}}
@section('title', trans('tool/service.label.list.title'))
{{--Content for page--}}
@section('content')
    <body>
        @include('elements.header-admin')
        @include('elements.delete-modal', ['screen' => 'service'])

        <div class="container-fluid">
            <div class="row">
                {{--Side bar--}}
                @include('elements.sidebar-admin')

                <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
                    <div class="pb-2 mt-4 mb-2 border-bottom">
                        <h2>{{ trans('tool/service.label.list.title_filter') }}</h2>
                    </div>
                    @include('elements.flash-message')
                    <form method="get" action="{{ route('service.index') }}">
                        <input type="hidden" name="sort_column" value="{{ $formData['sort_column'] }}">
                        <input type="hidden" name="sort_direction" value="{{ $formData['sort_direction'] }}">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="inputKeyword">{{ trans('tool/service.label.list.keyword_label') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inputKeyword" name="keyword"
                                           value="{{ $formData['keyword'] }}"
                                           placeholder="{{ trans('tool/service.label.list.keyword_placeholder') }}">
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>{{ trans('tool/service.label.list.search_label') }}</label>
                                <div class="input-group">
                                    <button type="submit" class="btn btn-primary mb-2">
                                        <span data-feather="search"></span> {{ trans('tool/service.label.list.search_button') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="pb-2 mt-4 mb-2 border-bottom">
                        <h2>{{ trans('tool/service.label.list.title') }}</h2>
                    </div>
                    <div class="table-responsive">
                        <nav>
                            {{ $services->appends($formData)->links() }}
                        </nav>
                        <input type="hidden" value="{{ route('service.index', ['keyword' => $formData['keyword']]) }}"
                               name="current_url">
                        <table class="table dataTable">
                            <thead>
                            <tr>
                                <th {{ sort_info('id', $formData['sort_column'], $formData['sort_direction']) }}>
                                    {{ trans('tool/service.label.list.column_no') }}
                                </th>
                                <th {{ sort_info('name', $formData['sort_column'], $formData['sort_direction']) }}>
                                    {{ trans('tool/service.label.list.column_name') }}
                                </th>
                                <th {{ sort_info('updated_at', $formData['sort_column'], $formData['sort_direction']) }}>
                                    {{ trans('tool/service.label.list.column_update') }}
                                </th>
                                <th>
                                    <button type="button" class="btn btn-success btn-sm"
                                            onclick="location.href='/manage/service/create';">
                                        <span data-feather="file-text"></span> {{ trans('tool/service.label.list.button_create') }}
                                    </button>
                                </th>
                            </tr>
                            <col width="15%">
                            <col width="40%">
                            <col width="20%">
                            <col width="15%">
                            </thead>
                            <tbody>
                            @if($services->count() === 0)
                                <tr>
                                    <td colspan="6" class="text-center">
                                        {{ trans('tool/service.label.list.table_empty_data') }}
                                    </td>
                                </tr>
                            @else
                                @foreach($services as $service)
                                    <tr>
                                        <td>{{ $service->id }}</td>
                                        <td>{{ $service->name }}</td>
                                        <td>{{ format_date($service->updated_at) }}</td>
                                        <td>
                                            <a href="{{ route('service.edit', $service->id) }}"
                                               class="btn btn-primary btn-sm">
                                                <span data-feather="edit"></span> {{ trans('tool/service.label.list.button_edit') }}
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                    data-toggle="modal"
                                                    data-url="{!! route('service.destroy', $service->id) !!}"
                                                    data-target="deleteModal">
                                                <span data-feather="delete"></span> {{ trans('tool/service.label.list.button_delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <nav>
                            {{ $services->appends($formData)->links() }}
                        </nav>
                    </div>

                </main>
            </div>
        </div>
    </body>
@endsection

@push('scripts')
<!--Javascript service list-->
<script src="{{ asset('js/custom.js') }} "></script>
<script src="{{ asset('js/service/list.js') }}"></script>
@endpush
