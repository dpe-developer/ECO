<div class="row">
    <div class="col">
        <h5>Appointments</h5>
    </div>
    <div class="col text-right">
        @can('appointments.create')
			<button class="btn bg-gradient-primary" type="button" data-toggle="modal-ajax" data-href="{{ route('appointments.create') }}" data-target="#createAppointmentModal" data-form="patient_id: {{ $patient->id }}">@fa('fa fa-plus fa-lg') Add Appointment</button>
	    @endcan
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="table-responsive p-0 table-scrollable">
			<table class="table table-sm table-bordered table-hover table-head-fixed">
				<thead>
					<tr>
						<th>Date of Appointment</th>
						<th>Status</th>
						<th>Doctor</th>
						<th>Description</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($patient->appointments()->orderBy('created_at', 'DESC')->get() as $appointment)
					<tr 
                        @can('appointments.show') 
                            data-toggle="modal-ajax" 
                            data-href="{{ route('appointments.show', $appointment->id) }}" 
                            data-target="#showAppointmentModal" 
                        @endcan
                        >
						<td>{{ date('F d, Y h:i A', strtotime($appointment->appointment_date)) }}</td>
						<td>
                            @if ($appointment->status != 3 && $appointment->appointment_date < today())
                                <span class="badge badge-danger">Due</span>
                            @endif
							{!! $appointment->statusBadge() !!}
						</td>
						<td>{{ $appointment->doctor->fullname('f-m-l') }}</td>
						<td>{{ $appointment->description }}</td>
					</tr>
					@empty
					<tr>
						<td colspan="4" class="text-center text-danger">*** EMPTY ***</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
    </div>
</div>
{{-- <form action="{{ route('appointments.store') }}" method="POST" autocomplete="off">
    @csrf
    <div class="modal fade" id="addAppointment" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="patient" value="{{ $patient->id }}">
                            <div class="form-group">
                                <label>Doctor:</label><br>
                                <select class="form-control select2" name="doctor" style="width: 100%">
                                    <option></option>
                                    @foreach ($doctors as $doctor)
                                    <option @if(old('doctor') == $doctor->id){{'selected'}}@endif value="{{ $doctor->id }}">
                                    {{ $doctor->employeeName() }}
                                    </option>
                                    @endforeach
                                </select>
                                <strong class="text-danger">{{ $errors->first('doctor') }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date of Appointment:</label>
                                <div class="input-group date" id="appointmentDate" data-target-input="nearest">
                                    <input value="{{ date('m/d/Y h:i A', strtotime(old('appointment_date'))) }}" type="text" name="appointment_date" class="form-control datetimepicker-input" data-target="#appointmentDate"/>
                                    <div class="input-group-append" data-target="#appointmentDate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                <strong class="text-danger">{{ $errors->first('appointment_date') }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax"><i class="fa fa-times"></i> Cancel</button>
                    <button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form> --}}
