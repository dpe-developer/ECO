<form action="{{ route($baseUrl.'.update', $patientProfileReference_edit->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editPatientProfileReference" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit {{ $modalTitle }} Reference</h5>
                    {{-- <a href="{{ route('vital_information_references.index') }}" class="close"> --}}
                    <a href="#" data-toggle="modal" data-target="#closeEditReference" class="close">
                    <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
						<label>Type:</label>
						<select class="form-control" name="type">
							<option value=""> --- SELECT ---</option>
							<option @if($patientProfileReference_edit->type == "text") selected @endif value="text">Text Input</option>
							<option @if($patientProfileReference_edit->type == "checkbox") selected @endif value="checkbox">Check Box</option>
							<option @if($patientProfileReference_edit->type == "checkbox_selection") selected @endif value="checkbox_selection">Check Box with selection</option>
							<option @if($patientProfileReference_edit->type == "textarea") selected @endif value="textarea">Paragraph</option>
							<option @if($patientProfileReference_edit->type == "check_textbox") selected @endif value="check_textbox">Check Box with Text Input</option>
							<option @if($patientProfileReference_edit->type == "parent") selected @endif value="parent" value="parent">Parent</option>
							<option @if($patientProfileReference_edit->type == "child_parent") selected @endif value="child_parent" value="child_parent">Child Parent</option>
						</select>
					</div>
					<div class="form-group">
						<label>Name:</label>
						<input class="form-control" type="text" name="name" value="{{ $patientProfileReference_edit->name }}">
					</div>
					<div class="form-group">
						<label>Description:</label>
						<input class="form-control" type="text" name="description" value="{{ $patientProfileReference_edit->description }}">
					</div>
					<div class="form-group">
						<label>Parent:</label>
						<select class="form-control select2" name="parent_id" style="width: 100%">
							<option></option>
							@foreach ($parent_references as $reference)
							<option @if($patientProfileReference_edit->parent_id == $reference->id) selected @endif value="{{ $reference->id }}">{{ $reference->name }} @if($reference->description!=null){{ '['.$reference->description.']' }}@endif</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Child Reference:</label>
						<select class="form-control select2" name="child_id" style="width: 100%">
							<option></option>
							@foreach ($child_references as $reference)
								<option @if($patientProfileReference_edit->child_id == $reference->id) selected @endif value="{{ $reference->id }}">{{ $reference->name }} @if($reference->description!=null){{ '['.$reference->description.']' }}@endif</option>
							@endforeach
						</select>
					</div>
                </div>
                <div class="modal-footer">
					<div class="col">
						@can('pathology_reports.destroy')
						<a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route($baseUrl.'.destroy', $patientProfileReference_edit->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
						@endcan
					</div>
					<div class="col text-right">
						{{-- <a class="btn btn-default" href="{{ route('outpatients.show', $outpatient->id) }}">Cancel</a> --}}
						<button class="btn btn-default" type="button" data-toggle="modal" data-target="#closeEditReference">Cancel</button>
						<button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="closeEditReference" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header text-center">
		          <h3 class="modal-title">You have unsaved changes.</h3>
		    	</div>
				<div class="modal-body">
					<p>Are you sure you want to leave this screen and discard your changes?</p>
				</div>
				<div class="modal-footer">
					<div class="col text-left">
						<button class="btn btn-default" type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
					</div>
					<div class="col text-right">
						<a class="btn btn-default" href="{{ route($baseUrl.'.index') }}">Discard</a>
						<button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>