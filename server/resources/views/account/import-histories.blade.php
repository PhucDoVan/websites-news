@php
    $navAccount = 'active';
@endphp

@extends('index')

{{--Set title for page--}}
@section('title', trans('tool/accounts.label.import_histories.title'))

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
                        <h2>{{ trans('tool/accounts.label.import_histories.title') }}</h2>
                    </div>

                    @include('elements.flash-message')

                    <div class="form-row m-0 mb-3">
                        <div class="col-md-6 border rounded p-2 bg-light">
                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.import_histories.id_label') }}
                                    :</label>
                                <label class="col-9">{{ $account->account_id }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.import_histories.corporation_name_label') }}
                                    :</label>
                                <label class="col-9">{{ $account->corporation_name }}</label>
                            </div>

                            <div class="form-row">
                                <label class="col-3 text-right">{{ trans('tool/accounts.label.import_histories.username_label') }}
                                    :</label>
                                <label class="col-9">{{ $account->name_last . $account->name_first }}</label>
                            </div>
                        </div>
                    </div>

                    @php
                        if(session('file_content')) {
                            $fileContent = session('file_content');
                            $contentErrors = session('content_errors');
                            $contentSuccess = array_values(array_diff_key($fileContent, $contentErrors));
                        }
                    @endphp

                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        {{--File uploading--}}
                        <div class="col-md-12 p-2">
                            <div class="form-group row">
                                <label class="col-2 col-form-label text-right">{{ trans('tool/accounts.label.import_histories.service_label') }}
                                    :</label>
                                <div class="col-6">
                                    <select class="form-control" name="service_id">
                                        <option value="">{{ trans('tool/accounts.label.import_histories.service_placeholder') }}</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->service_id }}" {{ old('service_id')  == $service->service_id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('service_id'))
                                        <span class="text-danger">{{ $errors->first('service_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-2 col-form-label text-right">{{ trans('tool/accounts.label.import_histories.history_file_label') }}
                                    :</label>
                                <div class="col-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file_history"
                                               name="file_history">
                                        <label class="custom-file-label"
                                               for="customFile">{{ trans('tool/accounts.label.import_histories.file_placeholder') }}</label>
                                    </div>
                                    @if ($errors->has('file_history'))
                                        <span class="text-danger">{{ $errors->first('file_history') }}</span>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary"
                                            data-action="{{ route('account.upload-file-histories', $account->account_id) }}">
                                        {{ trans('tool/accounts.label.import_histories.upload_button') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{--Information file checking--}}
                        @if( ! empty($fileContent))
                            <div class="pb-2 mt-4 mb-3 border-bottom">
                                <h2>{{ trans('tool/accounts.label.import_histories.file_checking_title') }}</h2>
                            </div>
                            <div class="container">
                                <pre class="code-block">
                                    @foreach($fileContent as $index => $line)
                                        @if(array_key_exists($index, $contentErrors))
                                            <span class="text-danger"><i data-feather="x-circle"></i> {{ $line }}（{{ $contentErrors[$index] }}）</span>
                                        @else
                                            <span><i class="text-success"
                                                     data-feather="check-circle"></i> {{ $line }}</span>
                                        @endif
                                    @endforeach
                                </pre>
                            </div>
                        @endif

                        <div class="form-row mt-5">
                            <div class="col-md-3 offset-md-3 mb-3">
                                <div class="input-group">
                                    <a href="{{ session(SESSION_ACCOUNT_INDEX_URL) ?? route('account.index') }}"
                                       class="btn btn-secondary btn-block mb-2">
                                        <span data-feather="arrow-left"></span> {{ trans('tool/accounts.label.form.CANCEL') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    @if(!empty($contentSuccess))
                                        @foreach($contentSuccess as $contentId)
                                            <input type="hidden" name="content_ids[]" value="{{ $contentId }}">
                                        @endforeach
                                    @endif

                                    <button type="submit"
                                            class="btn btn-success btn-block mb-2"
                                            {{ (empty($fileContent) || empty($contentSuccess)) ? 'disabled' : '' }}
                                            data-action="{{ route('account.import-histories', $account->account_id) }}">
                                        <span data-feather="save"></span> {{ trans('tool/accounts.label.form.SAVE') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </main>
            </div>
        </div>

        @include('elements.loader')
    </body>
@endsection

@push('scripts')
    <script src="{{ asset('js/account/import-histories.js') }}"></script>
@endpush
