<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" class="ajax" id="confirmForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>This action cannot be reversed.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger"
                            data-dismiss="modal">Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
