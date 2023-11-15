<div id="showAppointmentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="show-appointment-title" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Appointment</h5>
				<button type="button" class="btn-close" data-dismiss="modal-ajax" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="form-group mb-0">
					<label>Refference Code:</label>
					{{ Carbon::parse($appointment->created_at)->timestamp  }}
				</div>
                <div class="form-group mb-0">
					<label>Appointment Date:</label>
					{{ Carbon::parse($appointment->appointment_date)->format('M d,Y h:ia') }}
				</div>
				<div class="form-group mb-0">
					<label>Status:</label>
					@if (in_array($appointment->status, array('pending', 'confirmed')) && $appointment->appointment_date < today())
						<span class="badge badge-danger">Due</span>
					@endif
					{!! $appointment->statusBadge() !!}
					@if($appointment->status == 'declined')
					<br>
					<label>Reason:</label>
					{{ $appointment->reason_of_decline }}
					@endif
					@if($appointment->status == 'canceled')
					<br>
					<label>Reason:</label>
					{{ $appointment->reason_of_cancel }}
					@endif
				</div>
				<div class="form-group mb-0">
					<label>Patient ID:</label>
					{{ $appointment->patient->username }}
				</div>
				<div class="form-group mb-0">
					<label>Patient:</label>
					{{ $appointment->patient->fullname('f-m-l') }}
				</div>
				<div class="form-group mb-0">
					<label>Doctor:</label>
					{{ $appointment->doctor->fullname('f-m-l') }}
				</div>
                <div class="form-group mb-0">
					<label>Service:</label>
					{{ $appointment->service->name }}
				</div>
				<div class="form-group mb-0">
					<label>Description:</label>
					{{ $appointment->description }}
				</div>
			</div>
			<div class="modal-footer">
				@can('appointments.destroy')
				<a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('appointments.destroy', $appointment->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
				@endcan
				@can('appointments.edit')
					<a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editAppointmentModal" data-href="{{ route('appointments.edit', $appointment->id) }}"><i class="fad fa-edit"></i> Edit</a>
				@endcan
				@if($appointment->status != 'declined')
					@switch($appointment->status)
						@case('pending')
							@can('appointments.confirm')
								<a class="btn btn-success" href="{{ route('appointments.confirm', $appointment->id) }}"><i class="fa fa-check"></i> Confirm</a>
							@endcan
							@can('appointments.decline')
								<a class="btn btn-danger" href="javascript:void(0)" data-toggle="modal" data-target="#declineAppointmentModal"><i class="fa fa-times"></i> Decline</a>
							@endcan
							@break
						@case('confirmed')
							@can('appointments.accept_patient')
								@if(Auth::user()->isDoctor() && !$appointment->hasVisit())
									@if(Auth::user()->id == $appointment->doctor_id)
										<a class="btn btn-success" href="{{ route('appointments.accept_patient', $appointment->id) }}"><i class="fa fa-check"></i> Accept Patient</a>
									@endif
								@endif
							@endcan
							@break
						@default
					@endswitch
					@can('appointments.cancel')
						@if(!in_array($appointment->status, ['done', 'canceled', 'declined']) && !$appointment->hasVisit())
							<a class="btn btn-danger" href="javascript:void(0)" id="cancelAppointment" data-toggle="modal" data-target="#cancelAppointmentModal"><i class="fa fa-times"></i> Cancel Appointment</a>
						@endif
					@endcan
				@endif
				<button class="btn btn-default" type="button" data-dismiss="modal-ajax">Close</button>
			</div>
		</div>
	</div>
</div>

@can('appointments.decline')
<form action="{{ route('appointments.decline', $appointment->id) }}" method="POST">
    @csrf
    <div id="declineAppointmentModal" class="modal fade" role="dialog" aria-labelledby="decline-appointment-title" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Decline Appointment</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reasonOfDecline">Reason:</label>
                        <select class="form-control" name="reason_of_decline" id="reasonOfDecline" required>
                            <option></option>
                            <option value="holiday">Holiday</option>
                            <option value="bad weather">Bad weather</option>
                            <option value="booking appointment is full">Booking appointment is full</option>
                            <option value="doctor unavailable at the hour">Doctor unavailable at the hour</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
					<div class="form-group" id="otherReasonOfDecline" style="display: none">
						<label for="otherReasonOfDeclineTextarea">Other Reason:</label>
						<textarea class="form-control" name="other_reason" id="otherReasonOfDeclineTextarea"></textarea>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fad fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-default text-success"><i class="fad fa-save"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endcan
@can('appointments.cancel')
<form action="{{ route('appointments.cancel', $appointment->id) }}" method="POST">
    @csrf
    <div id="cancelAppointmentModal" class="modal fade" role="dialog" aria-labelledby="cancel-appointment-title" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Appointment</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reasonOfDecline">Reason:</label>
						<textarea class="form-control" name="reason" id="reasonOfDecline"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fad fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-default text-success"><i class="fad fa-save"></i> Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endcan
<script>
	$(function(){
		$('#cancelAppointment').on('click', function(){
			$('#cancelAppointmentModal').modal('show');
		});
		$('#reasonOfDecline').on('change', function(){
			if($(this).val() == 'other'){
				$('#otherReasonOfDecline').fadeIn();
			}else{
				$('#otherReasonOfDecline').fadeOut();
			}
		});
	})
</script>