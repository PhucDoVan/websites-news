@php
    $navGroup = 'active';
    $isAddPage = empty($groupEdit);

    if ( ! isset($groupEdit)) {
        $groupEdit = null;
    }

    $pageTitle = $isAddPage ? trans('tool/group.label.edit.title_create') : trans('tool/group.label.edit.title_edit')
@endphp

@extends('index')

{{--Set title for page--}}
@section('title', $pageTitle)

{{--Content for page--}}
@section('content')
    <body>
        @include('elements.header-admin')
        @include('elements.delete-modal', ['screen' => 'group'])

        <div class="container-fluid">
            <div class="row">
                {{--Side bar--}}
                @include('elements.sidebar-admin')

                <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4">
                    <div class="pb-2 mt-4 mb-2 border-bottom">
                        <h2>{{ $pageTitle }}</h2>
                    </div>
                    @include('elements.flash-message')

                    <form method="post"
                          action="{{ $isAddPage ? route('group.store', $corporation->corporation_id) : route('group.update', $groupEdit->id) }}">
                        @if( ! $isAddPage)
                            @method('PUT')
                        @endif

                        @csrf
                        <div class="form-row mb-3">
                            <div class="col-md-6 p-2">
                                <div class="form-row">
                                    <label class="col-4 col-form-label text-right">
                                        {{ trans('tool/group.label.edit.corporation_name') }}:
                                    </label>
                                    <label class="col-8 col-form-label">
                                        {{ $corporation->name }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <label class="col-2 col-form-label text-right">
                                {{ trans('tool/group.label.edit.parent_group') }}:
                            </label>
                            <div class="col-6">
                                <select class="form-control parent-group-select" size="10" name="parent_group_id">
                                    <option class="p-1 child-level" {{ ! old('parent_group_id', optional($groupEdit)->parent_group_id) ? 'selected' : '' }} value="">
                                        {{ $corporation->name }}
                                    </option>

                                    @php
                                        $space = '&nbsp;&nbsp;&nbsp;&nbsp;';
                                    @endphp

                                    @foreach($groups as $group)
                                        <option class="p-1 child-level"
                                                {{ old('parent_group_id', optional($groupEdit)->parent_group_id) == $group->id ? 'selected' : '' }}
                                                value="{{ $group->id }}">
                                            {!! $space !!} {{ $group->name }}
                                        </option>

                                        @if(count($group->childs))
                                            @include('group.child-select', [
                                                'childs' => $group->childs,
                                                'childLevel' => 2
                                            ])
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <label class="col-2 col-form-label text-right">
                                {{ trans('tool/group.label.edit.input_label') }}:
                            </label>
                            <div class="col-6">
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control"
                                           name="name"
                                           value="{{ old('name', optional($groupEdit)->name ) }}"
                                           placeholder="{{ trans('tool/group.label.edit.input_placeholder') }}">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-3 offset-md-3 mb-3">
                                <div class="input-group">
                                    <a href="{{ route('group.index') }}" class="btn btn-secondary btn-block mb-2">
                                        <span data-feather="arrow-left"></span> {{ trans('tool/group.label.form.CANCEL') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-success btn-block mb-2">
                                        <span data-feather="save"></span> {{ trans('tool/group.label.form.SAVE') }}
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
    <script src="{{ asset('js/custom.js') }} "></script>
    <script src="{{ asset('js/group/create.js') }} "></script>
@endpush
