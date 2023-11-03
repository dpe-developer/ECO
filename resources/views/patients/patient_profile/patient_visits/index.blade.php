@if(!$patient->hasActiveVisit())
@can('patient_visits.create')
<button class="btn btn-default btn-sm text-primary float-right" type="button" data-toggle="modal-ajax" data-target="#addVisit" data-href="{{ route('patient_visits.create') }}" data-form="patient_id:{{ $patient->id }}"><i class="fa fa-plus"></i> Add</button>
@endcan
@endif
<div class="table-responsive scrollbar-primary" style="height: 250px">
	<table class="table table-sm table-hover table-bordered">
		<thead>
			<tr>
				<th>Session Date</th>
				<th>Status</th>
				<th>Doctor</th>
				<th>Service</th>
				<th>Complaints</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($patient->visits as $visit)
			<tr @can('patient_visits.show') data-toggle="modal-ajax" data-href="{{ route('patient_visits.show', $visit->id) }}" data-target="#showPatientVisit" @endcan>
				<td>{{ Carbon::parse($visit->session_date)->format('M d,Y h:ia') }} </td>
				<td>{{ $visit->status }}</td>
				<td>{{ $visit->doctor->fullname('f-m-l') }}</td>
				<td>{{ $visit->service->name ?? "" }}</td>
				{{-- <th>
					@if($patient->hasActiveVisit())
						@if ($visit->status == 'active')
						<a href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('patient_diagnosis.create') }}" data-target="#addPatientDiagnosis" data-form="patient_id: {{ $patient->id }}; type: admitting diagnosis"><i class="fa fa-plus"></i> Add</a>
						@endif
					@else
					{{ $visit->admitting_diagnosis->diagnosis }}
					@endif
				</th> --}}
				<td>{{ $visit->compaints }}</td>
			</tr>
			@empty
			<tr>
				<td colspan="10" class="text-center text-danger">*** EMPTY ***</td>
			</tr>
			@endforelse
		</tbody>
	</table>
</div>