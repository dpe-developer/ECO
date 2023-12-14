<form action="{{ route('findings.store') }}" method="POST" autocomplete="off">
    @csrf
        <div class="modal fade" id="addFindingModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Findings</h4>
                        <button type="button" class="close" data-dismiss="modal-ajax" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-left">
                        <div class="form-group">
                            <label>Name: <strong class="text-danger text-lg"> *</strong></label>
                            <input type="text" class="form-control" name="finding_name" required>
                        </div>
                        <div class="form-group">
                            <label>Description:</label>
                            <textarea name="finding_description" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal-ajax"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn bg-gradient-success" type="submit"><i class="fad fa-save"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    