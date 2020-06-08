@php
    $navGroup = 'active';
@endphp
@extends('index')
{{--Set title for page--}}
@section('title', trans('tool/group.label.list.title'))
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
                        <h2>{{ trans('tool/group.label.list.title') }}</h2>
                    </div>
                    @include('elements.flash-message')

                    <div class="form-row m-0 mb-3">
                        <div class="col-md-6 p-2">
                            <div class="form-row">
                                <label class="col-4 col-form-label text-right">
                                    {{ trans('tool/organization.label.list.column_name') }}:
                                </label>
                                <div class="col-8">
                                    <form method="get" action="{{ route('group.index') }}">
                                        <select class="form-control corporation-select" name="corporation_id">
                                            @foreach($corporations as $corporation)
                                                <option value="{{ $corporation->corporation_id }}" {{ $corporation->corporation_id == $corporationSelected->corporation_id ? 'selected' : '' }}>
                                                    {{ $corporation->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row m-0 mb-3">
                        <div class="col-md-12 p-2">
                            <div class="form-row">
                                <label class="col-2 col-form-label text-right">
                                    {{ trans('tool/group.label.list.column_name') }}:
                                </label>
                                <div class="col-10">
                                    <table class="table group-tree">
                                        <tbody>
                                            <tr class="child-level" data-level="0">
                                                <td>{{ $corporationSelected->name }}</td>
                                                <td>
                                                    <a href="{{ route('group.create', $corporationSelected->corporation_id) }}"
                                                       class="btn btn-success btn-sm">
                                                        <span data-feather="file-text"></span> {{ trans('tool/group.label.list.button_create') }}
                                                    </a>
                                                </td>
                                            </tr>
                                            @foreach($groups as $group)
                                                <tr class="child-level" data-level="1">
                                                    <td>{{ $group->name }}</td>
                                                    <td>
                                                        <a href="{{ route('group.edit', $group->id) }}"
                                                           class="btn btn-primary btn-sm">
                                                            <span data-feather="edit"></span> {{ trans('tool/group.label.list.button_edit') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                @if(count($group->childs))
                                                    @include('group.child', [
                                                        'childs' => $group->childs,
                                                        'childLevel' => 2
                                                    ])
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </body>
@endsection

@push('scripts')
<!--Javascript service list-->
<script src="{{ asset('js/custom.js') }} "></script>
<script src="{{ asset('js/group/list.js') }}"></script>
@endpush
