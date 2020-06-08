@php
    $navOrganization = 'active';
    $isAddMode = empty($organization);
@endphp
@extends('index')
{{--Set title for page--}}
@if($isAddMode)
    @section('title', trans('tool/organization.label.edit.title_create'))
@else
    @section('title', trans('tool/organization.label.edit.title_edit'))
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
                        @if($isAddMode)
                            <h2>{{ trans('tool/organization.label.edit.title_create') }}</h2>
                        @else
                            <h2>{{ trans('tool/organization.label.edit.title_edit') }}</h2>
                        @endif
                    </div>
                    @include('elements.flash-message')
                    <form method="post"
                          action="{{ $isAddMode ? route('organization.store') : route('organization.update', $organization->corporation_id) }}">
                        @csrf
                        @if( ! $isAddMode)
                            @method('PUT')
                        @endif
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label>{{ trans('tool/organization.label.edit.name_label') }}<span
                                            class="text-danger">{{ trans('tool/organization.label.edit.require') }}</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name"
                                           value="{{ old('name', $organization->name ?? '') }}"
                                           placeholder="{{ trans('tool/organization.label.edit.name_placeholder') }}">
                                </div>
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>{{ trans('tool/organization.label.edit.kana_label') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="kana"
                                           value="{{ old('kana', $organization->kana ?? '') }}"
                                           placeholder="{{ trans('tool/organization.label.edit.kana_placeholder') }}">
                                </div>
                                @if ($errors->has('kana'))
                                    <span class="text-danger">{{ $errors->first('kana') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label>{{ trans('tool/organization.label.edit.uid') }}
                                    <span class="text-danger"> {{ trans('tool/accounts.label.edit.require') }}</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="uid" readonly
                                           value="{{ old('uid', $organization->uid ?? '') }}"
                                           placeholder="{{ trans('tool/organization.label.edit.uid_placeholder') }}">
                                    @if(empty($organization))
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary generate_uid" type="button">
                                                <span data-feather="refresh-cw"></span> {{ trans('tool/organization.label.edit.button_generate') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                @if ($errors->has('uid'))
                                    <span class="text-danger">{{ $errors->first('uid') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label>{{ trans('tool/organization.label.edit.postal_label') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control js_postal_code" name="postal"
                                           value="{{ old('postal', $organization->postal ?? '') }}"
                                           placeholder="{{ trans('tool/organization.label.edit.postal_placeholder') }}">
                                </div>
                                @if ($errors->has('postal'))
                                    <span class="text-danger">{{ $errors->first('postal') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label>{{ trans('tool/organization.label.edit.address_pref_label') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="address_pref"
                                           value="{{ old('address_pref', $organization->address_pref ?? '') }}"
                                           placeholder="{{ trans('tool/organization.label.edit.address_pref_placeholder') }}">
                                </div>
                                @if ($errors->has('address_pref'))
                                    <span class="text-danger">{{ $errors->first('address_pref') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>{{ trans('tool/organization.label.edit.address_city_label') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="address_city"
                                           value="{{ old('address_city', $organization->address_city ?? '') }}"
                                           placeholder="{{ trans('tool/organization.label.edit.address_city_placeholder') }}">
                                </div>
                                @if ($errors->has('address_city'))
                                    <span class="text-danger">{{ $errors->first('address_city') }}</span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>{{ trans('tool/organization.label.edit.address_town_label') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="address_town"
                                           value="{{ old('address_town', $organization->address_town ?? '') }}"
                                           placeholder="{{ trans('tool/organization.label.edit.address_town_placeholder') }}">
                                </div>
                                @if ($errors->has('address_town'))
                                    <span class="text-danger">{{ $errors->first('address_town') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label>{{ trans('tool/organization.label.edit.address_etc_label') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="address_etc"
                                           value="{{ old('address_etc', $organization->address_etc ?? '') }}"
                                           placeholder="{{ trans('tool/organization.label.edit.address_etc_placeholder') }}">
                                </div>
                                @if ($errors->has('address_etc'))
                                    <span class="text-danger">{{ $errors->first('address_etc') }}</span>
                                @endif
                            </div>
                        </div>

                        @php
                            $contacts = isset($organization) ? $organization->contacts->toArray() : [];

                            if (old()) {
                                $contacts = [];
                                foreach (old('contact_name') as $index => $name) {
                                    $contacts[] = [
                                        'name'  => $name,
                                        'tel'   => old('contact_tel')[$index],
                                        'fax'   => old('contact_fax')[$index],
                                        'email' => old('contact_email')[$index]
                                    ];
                                }
                            }
                        @endphp

                        @if(!empty($contacts))
                            @foreach($contacts as $index => $contact)
                                <div class="form-group js_block_contact border rounded p-md-3 bg-light">
                                    <div class="form-row pb-2 mt-3">
                                        <div class="col-md-3">
                                            <label class="h2">{{ trans('tool/organization.label.edit.form_contact') }}</label>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="form-inline form-row">
                                                <label class="col-md-2">{{ trans('tool/organization.label.edit.contact_name_label') }}</label>
                                                <input type="text" class="col-md-6 form-control" name="contact_name[]"
                                                       value="{{ $contact['name'] }}">

                                                <div class="input-group-append ml-auto">
                                                    <button class="btn btn-outline-secondary js_button_delete_contact mr-3"
                                                            onclick="deleteBlockContact(this)"
                                                            type="button"><span data-feather="minus"></span>
                                                    </button>
                                                    <button class="btn btn-outline-secondary js_button_add_contact"
                                                            type="button"><span data-feather="plus"></span>
                                                    </button>
                                                </div>

                                                @if ($errors->has('contact_name.' . $index))
                                                    <span class="offset-md-2 text-danger">{{ $errors->first('contact_name.' . $index) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-2 border-bottom"></div>

                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label>{{ trans('tool/organization.label.edit.tel_label') }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="contact_tel[]"
                                                       value="{{ $contact['tel'] }}"
                                                       placeholder="{{ trans('tool/organization.label.edit.tel_placeholder') }}">
                                            </div>
                                            @if ($errors->has('contact_tel.' . $index))
                                                <span class="text-danger">{{ $errors->first('contact_tel.' . $index) }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>{{ trans('tool/organization.label.edit.fax_label') }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="contact_fax[]"
                                                       value="{{ $contact['fax'] }}"
                                                       placeholder="{{ trans('tool/organization.label.edit.fax_placeholder') }}">
                                            </div>
                                            @if ($errors->has('contact_fax.' . $index))
                                                <span class="text-danger">{{ $errors->first('contact_fax.' . $index) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label>{{ trans('tool/organization.label.edit.email_label') }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="contact_email[]"
                                                       value="{{ $contact['email'] }}"
                                                       placeholder="{{ trans('tool/organization.label.edit.email_placeholder') }}">
                                            </div>
                                            @if ($errors->has('contact_email.' . $index))
                                                <span class="text-danger">{{ $errors->first('contact_email.' . $index) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="form-group js_block_contact border rounded p-md-3 bg-light">
                                <div class="form-row pb-2 mt-3">
                                    <div class="col-md-3">
                                        <label class="h2">{{ trans('tool/organization.label.edit.form_contact') }}</label>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="form-inline">
                                            <label class="col-md-2">{{ trans('tool/organization.label.edit.contact_name_label') }}</label>
                                            <input type="text" class="col-md-6 form-control" name="contact_name[]"
                                                   value="">

                                            <div class="input-group-append ml-auto">
                                                <button class="btn btn-outline-secondary js_button_delete_contact"
                                                        onclick="deleteBlockContact(this)"
                                                        type="button"><span data-feather="minus"></span>
                                                </button>
                                                <button class="btn btn-outline-secondary js_button_add_contact ml-3"
                                                        type="button"><span data-feather="plus"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pb-2 mb-2 border-bottom"></div>

                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label>{{ trans('tool/organization.label.edit.tel_label') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="contact_tel[]"
                                                   value=""
                                                   placeholder="{{ trans('tool/organization.label.edit.tel_placeholder') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label>{{ trans('tool/organization.label.edit.fax_label') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="contact_fax[]"
                                                   value=""
                                                   placeholder="{{ trans('tool/organization.label.edit.fax_placeholder') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label>{{ trans('tool/organization.label.edit.email_label') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="contact_email[]"
                                                   value=""
                                                   placeholder="{{ trans('tool/organization.label.edit.email_placeholder') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if( ! $isAddMode)
                            <div class="form-group border rounded p-md-3 bg-light">
                                <div class="form-row pb-2 mt-3">
                                    <label class="h2">{{ trans('tool/organization.label.edit.services.title') }}</label>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>
                                                    {{ trans('tool/organization.label.edit.services.name') }}
                                                </th>
                                                <th>
                                                    {{ trans('tool/organization.label.edit.services.status') }}
                                                </th>
                                                <th>
                                                    {{ trans('tool/organization.label.edit.services.action') }}
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($organization->services as $index => $service)
                                                @php
                                                    $status = $service->pivot->terminated_at ? \App\Enums\CorporationServiceStatus::TERMINATED : $service->pivot->status;
                                                @endphp
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $service->name }}</td>
                                                    <td>{{ \App\Enums\CorporationServiceStatus::LABEL[$status] }}</td>
                                                    <td>
                                                        @include('organization.change-status-button')
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-row">
                            <div class="col-md-3 offset-md-3 mb-3">
                                <div class="input-group">
                                    <a href="{{ session(SESSION_ORGANIZATION_INDEX_URL) ?? route('organization.index') }}"
                                       class="btn btn-secondary btn-block mb-2">
                                        <span data-feather="arrow-left"></span> {{ trans('tool/organization.label.form.CANCEL') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <button type="submit" class="btn btn-success btn-block mb-2">
                                        <span data-feather="save"></span> {{ trans('tool/organization.label.form.SAVE') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </main>
            </div>
        </div>

        @includeWhen( ! $isAddMode, 'organization.change-status-modal')
    </body>
@endsection

@push('scripts')
    <!--Javascript organization create -->
    <script src="{{ asset('js/password.js') }}"></script>
    <script src="{{ asset('js/organization/create.js')}} "></script>
@endpush
