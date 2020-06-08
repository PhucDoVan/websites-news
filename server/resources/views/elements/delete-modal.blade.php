<form action="" method="POST" id="deleteModalForm">
    @method('DELETE')
    @csrf
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="deleteModalLabel">{{ trans('tool/' . $screen . '.label.modal.delete_title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>{{ trans('tool/' . $screen . '.label.modal.delete_confirm') }}</span>
                </div>
                <div class="modal-footer">
                    <button type="submit"
                            class="btn btn-danger">{{ trans('tool/' . $screen . '.label.form.OK') }}</button>
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ trans('tool/' . $screen . '.label.form.CANCEL') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>
