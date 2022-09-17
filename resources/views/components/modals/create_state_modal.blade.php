<div class="modal fade" id="create-state-modal" data-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create State</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/master-data/states" method="post">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="name_state">Name State</label>
                            <input type="text" name="name_state" class="form-control" id="name_state"
                                placeholder="Name State">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger text-white" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
