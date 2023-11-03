<form action="{{ route($baseUrl.'.store') }}" method="POST" autocomplete="off">
    @csrf
    <div class="modal fade" id="addPatientProfileReference" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add {{ $modalTitle }} Reference</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                	<div class="form-group">
						<label>Type:</label>
						<select class="form-control select2" name="type" style="width: 100%" required>
							<option value=""> --- SELECT ---</option>
							<option value="text">Text Input</option>
							<option value="checkbox">Check Box</option>
							<option value="checkbox_selection">Check Box with selection</option>
							<option value="textarea">Paragraph</option>
							<option value="check_textbox">Check Box with Text Input</option>
							<option value="parent">Parent</option>
							<option value="child_parent">Child Parent</option>
						</select>
					</div>
					<div class="form-group">
						<label>Name:</label>
						<input class="form-control" type="text" name="name" value="{{ old('name') }}" required>
					</div>
					<div class="form-group">
						<label>Description:</label>
						<input class="form-control" type="text" name="description" value="{{ old('description') }}">
					</div>
					<div class="form-group">
						<label>Parent:</label>
						<select class="form-control select2" name="parent_id" id="select" style="width: 100%">
							<option></option>
							@foreach ($parent_references as $reference)
								<option @if(old('parent_id') == $reference->id){{'selected'}}@endif value="{{ $reference->id }}">@if($reference->deleted_at != null) >>DELETED<< @endif {{ $reference->name }} @if($reference->description!=null){{ '['.$reference->description.']' }}@endif</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Child Reference:</label>
						<select class="form-control select2" name="child_id" style="width: 100%">
							<option></option>
							@foreach ($child_references as $reference)
								<option @if(old('child_id') == $reference->id){{'selected'}}@endif value="{{ $reference->id }}">@if($reference->deleted_at != null) >>DELETED<< @endif {{ $reference->name }} @if($reference->description!=null){{ '['.$reference->description.']' }}@endif</option>
							@endforeach
						</select>
					</div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal-ajax" aria-hidden="true"><i class="fa fa-times"></i> Cancel</button>
					<button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>