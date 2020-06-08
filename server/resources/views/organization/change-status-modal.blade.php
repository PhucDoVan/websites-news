<form action="{{ route('organization.update-service-status', $organization->corporation_id) }}" method="POST" id="changeStatusModalForm">
    @method('PUT')
    @csrf
    <div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeStatusModalLabel">
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="changeStatusModalMessage">
                    </div>

                    <input type="hidden" name="service_id">
                    <input type="hidden" name="status">
                </div>
                <div class="modal-footer">
                    <button type="submit"
                            class="btn btn-danger">{{ trans('tool/organization.label.form.OK') }}</button>
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('tool/organization.label.form.CANCEL') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
