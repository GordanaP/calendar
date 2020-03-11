<div class="modal fade" tabindex="-1" role="dialog" id="scheduleAppModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('partials.appointments._schedule_form', [
                    'doctor' => $doctor ?? null,
                    'patient' => $patient ?? null,
                ])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deleteAppButton">
                    Delete
                </button>
                <button type="button" class="btn btn-success app-button"></button>
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>