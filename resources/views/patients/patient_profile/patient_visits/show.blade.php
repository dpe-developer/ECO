<div class="modal fade" id="showPatientVisit" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
	          <h4 class="modal-title">Visit - {{ $patientVisit_show->visit_type }}</h4>
	          <button type="button" class="close" data-dismiss="modal-ajax">&times;</button>
	    	</div>
			<div class="modal-body">
				<input type="text" name="patient" hidden value="{{ $patient->id }}">
				<div class="row">
					<div class="col-md-6">
						<label>Status:</label>
						{{ $patientVisit_show->status }}
						<br>
						<label>type:</label>
						{{ $patientVisit_show->visit_type }}
						<br>
						<label>Admitting Doctor:</label>
						{{ $patientVisit_show->doctor->employeeName() }}
						<br>
						<label>Reason for visit:</label>
						{!! clean($patientVisit_show->reason_for_visit) !!}
					</div>
					<div class="col-md-6">
						<label>Admission/Check In Date:</label>
						{{ date('F d, Y h:iA', strtotime($patientVisit_show->admission_date)) }}
						<br>
						@if ($patientVisit_show->discharge_date != null)
						<label>Discharge/Check Out Date:</label>
						{{ date('F d, Y h:iA', strtotime($patientVisit_show->discharge_date)) }}
						@endif
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="col">
					@if ($patientVisit_show->trashed())
                		@can('patient_visits.restore')
					    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('patient_visits.restore', $patientVisit_show->id) }}"><i class="fad fa-download"></i> Restore</a>
						@endcan
					@else
						@can('patient_visits.destroy')
					    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('patient_visits.destroy', $patientVisit_show->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
						@endcan
					@endif
					@can('patient_visits.edit')
					<a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editPatientVisit" data-href="{{ route('patient_visits.edit', $patientVisit_show->id) }}"><i class="fad fa-edit"></i> Edit</a>
					@endcan
				</div>
				<div class="col text-right">
					@if ($patientVisit_show->status == 'active')
					<button class="btn btn-success" type="button" data-toggle="modal" data-target="#dischargePatientModal">Discharge</button>					
					@endif
					<button class="btn btn-default" data-dismiss="modal-ajax">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
@if ($patientVisit_show->status == 'active')
<form action="{{ route('patient_visits.update', $patientVisit_show->id) }}" method="POST">
	@csrf
	@method('PUT')
	<div class="modal fade modal-allow-overflow" id="dischargePatientModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-centered {{-- modal-dialog-scrollable --}}">
			<div class="modal-content">
				<div class="modal-header">
		        	<h4 class="modal-title">Discharge Patient</h4>
		        	<a class="close" data-dismiss="modal-ajax">&times;</a>
		    	</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Discharge/Check out Date:</label>
					    <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
					        <input type="text" name="discharge_date" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
					        <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
					            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
					        </div>
					    </div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-success btn-submit" type="submit">Discharge</button>
				</div>
			</div>
		</div>
	</div>
</form>
@endif