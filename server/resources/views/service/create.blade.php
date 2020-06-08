@php
    $navService = 'active';
@endphp
@extends('index')
{{--Set title for page--}}
@if(empty($service))
    @section('title', trans('tool/service.label.edit.title_create'))
@else
    @section('title', trans('tool/service.label.edit.title_edit'))
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
                    <div class="pb-2 mt-4 mb-2 border-bottom">
                        @if(empty($service))
                            <h2>{{ trans('tool/service.label.edit.title_create') }}</h2>
                        @else
                            <h2>{{ trans('tool/service.label.edit.title_edit') }}</h2>
                        @endif
                    </div>
                    @include('elements.flash-message')
                    <form method="post"
                          action="{{ empty($service) ? route('service.store') : route('service.update', $service->id) }}">
                        @csrf
                        @if( ! empty($service))
                            @method('PUT')
                        @endif
                        <div class="form-row">
                            <div class="col-md-4 offset-md-3 mb-3">
                                <label>{{ trans('tool/service.label.edit.input_label') }}<span
                                            class="text-danger">{{ trans('tool/service.label.edit.require') }}</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control"
                                           id="inputDisplayName"
                                           name="name"
                                           value="{{ !empty($service->name) ? old('name', $service->name) : old('name') }}"
                                           placeholder="{{ trans('tool/service.label.edit.input_placeholder') }}">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 offset-md-3 mb-3">
                                <div class="input-group">
                                    <a href="{{ session(SESSION_SERVICE_INDEX_URL) ?? route('service.index') }}"
                                       class="btn btn-secondary btn-block mb-2">
                                        <span data-feather="arrow-left"></span> {{ trans('tool/service.label.form.CANCEL') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-success btn-block mb-2">
                                        <span data-feather="save"></span> {{ trans('tool/service.label.form.SAVE') }}
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
