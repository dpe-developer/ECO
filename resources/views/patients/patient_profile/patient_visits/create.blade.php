<form action="{{ route('patient_visits.store') }}" method="POST" autocomplete="off">
@csrf
	<div class="modal fade" id="addVisit" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
		          <h4 class="modal-title">Add Visit</h4>
		          <button type="button" class="close" data-dismiss="modal-ajax" aria-hidden="true">&times;</button>
		    	</div>
				<div class="modal-body text-left">
					<input type="text" name="patient" hidden value="{{ $patient->id }}">
					<div class="form-group">
						<label>Service:</label>
						<select class="form-control select2" name="service" style="width: 100%">
							<option></option>
							@foreach($services as $service)
							<option value="{{ $service->id }}">{{ $service->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Doctor:</label><strong class="text-danger text-lg"> *</strong>
						<select class="form-control select2" name="doctor" style="width: 100%">
							<option></option>
							@foreach ($doctors as $doctor)
								<option value="{{ $doctor->id }}">
									{{ $doctor->fullname('f-m-l') }}
								</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Complaints:</label>
						<textarea name="complaints" rows="5" class="form-control"></textarea>
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
