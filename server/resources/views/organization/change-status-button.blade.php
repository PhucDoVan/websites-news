@php
    $buttonsShowable = [];

    switch (true) {
        case $status === \App\Enums\CorporationServiceStatus::ACTIVE:
            $buttonsShowable = ['stop', 'terminate'];
            break;
        case $status === \App\Enums\CorporationServiceStatus::INACTIVE:
            $buttonsShowable = ['re_active', 'terminate'];
            break;
        case $status === \App\Enums\CorporationServiceStatus::RESTRICTED:
            $buttonsShowable = ['remove_restriction', 'stop', 'terminate'];
            break;
    }
@endphp

@if (in_array('re_active', $buttonsShowable))
    <button type="button"
            class="btn btn-primary btn-sm js-change-status"
            data-toggle="modal"
            data-target="changeStatusModal"
            data-service_id="{{ $service->id }}"
            data-status="{{ \App\Enums\CorporationServiceStatus::ACTIVE }}"
            data-modal_title="{{ trans('tool/organization.label.modal.change_service_status_title') }}"
            data-modal_message="{{ trans('tool/organization.label.modal.change_service_status_message') }}">
        <span data-feather="refresh-cw"></span>
        {{ trans('tool/organization.label.edit.services.button_re_active') }}
    </button>
@endif

@if (in_array('remove_restriction', $buttonsShowable))
    <button type="button"
            class="btn btn-primary btn-sm js-change-status"
            data-toggle="modal"
            data-target="changeStatusModal"
            data-service_id="{{ $service->id }}"
            data-status="{{ \App\Enums\CorporationServiceStatus::ACTIVE }}"
            data-modal_title="{{ trans('tool/organization.label.modal.change_service_status_title') }}"
            data-modal_message="{{ trans('tool/organization.label.modal.change_service_status_message') }}">
        <span data-feather="check"></span>
        {{ trans('tool/organization.label.edit.services.button_remove_restriction') }}
    </button>
@endif

@if (in_array('stop', $buttonsShowable))
    <button type="button"
            class="btn btn-warning btn-sm js-change-status"
            data-toggle="modal"
            data-target="changeStatusModal"
            data-service_id="{{ $service->id }}"
            data-status="{{ \App\Enums\CorporationServiceStatus::INACTIVE }}"
            data-modal_title="{{ trans('tool/organization.label.modal.change_service_status_title') }}"
            data-modal_message="{{ trans('tool/organization.label.modal.change_service_status_message') }}">
        <span data-feather="alert-triangle"></span>
        {{ trans('tool/organization.label.edit.services.button_stop') }}
    </button>
@endif

@if (in_array('terminate', $buttonsShowable))
    <button type="button"
            class="btn btn-danger btn-sm js-change-status"
            data-toggle="modal"
            data-target="changeStatusModal"
            data-service_id="{{ $service->id }}"
            data-service_name="{{ $service->name }}"
            data-status="{{ \App\Enums\CorporationServiceStatus::TERMINATED }}"
            data-modal_title="{{ trans('tool/organization.label.modal.terminate_service_title') }}"
            data-modal_message="{{ trans('tool/organization.label.modal.terminate_service_message') }}">
        <span data-feather="delete"></span>
        {{ trans('tool/organization.label.edit.services.button_terminate') }}
    </button>
@endif
