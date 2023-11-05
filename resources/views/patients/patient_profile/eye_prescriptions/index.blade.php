<div class="row">
	<div class="col">
		<h5>{{ trans('terminologies.eye_prescription') }}
			@can('eye_prescription_references.index')
			<a href="{{ route('eye_prescription_references.index') }}" title="Edit References"><i class="fad fa-edit"></i></a>
			@endcan
	    </h5>
	</div>
	<div class="col text-right">
		@if(isset($patient->activeVisit()->id))
			@can('eye_prescriptions.create')
			<button class="btn btn-default text-primary btn-sm" type="button" data-toggle="modal-ajax" data-href="{{ route('eye_prescriptions.create') }}" data-target="#addEyePrescription" data-form="patient_id: {{ $patient->id }}"><i class="fa fa-plus"></i> Add</button>
			@endcan
    	@endif
	</div>
</div>
<div class="row">
	<div class="col">
		<div class="table-responsive p-0 table-scrollable">
		    <table class="table table-sm table-bordered table-hover table-head-fixed">
				<thead>
					<tr>
						<th>Date</th>
						<th>Doctor</th>
						@role('System Administrator')
						<th class="text-center">Action</th>
						@endrole
					</tr>
				</thead>
				<tbody>
					@foreach ($patient->eyePrescriptions()->orderBy('created_at', 'DESC')->get() as $eyePrescription)
					<tr @unlessrole('System Administrator') @can('eye_prescriptions.show') data-toggle="modal-ajax" data-href="{{ route('eye_prescriptions.show', $eyePrescription->id) }}" data-target="#showEyePrescription" @endcan @endif>
						<td style="min-width: 118px">{{ date('M d, Y h:ia', strtotime($eyePrescription->updated_at)) }}</td>
						<td>
							{{ $eyePrescription->doctor->fullname() }}
						</td>
						@role('System Administrator')
		        		<td class="text-center">
							<a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showEyePrescription" data-href="{{ route('eye_prescriptions.show',$eyePrescription->id) }}"><i class="fad fa-file fa-lg"></i></a>
							<a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editEyePrescription" data-href="{{ route('eye_prescriptions.edit',$eyePrescription->id) }}"><i class="fad fa-edit fa-lg"></i></a>
							<a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('eye_prescriptions.destroy', $eyePrescription->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
		              	</td>
		              	@endrole
					</tr>
					@endforeach
					@if(count($patient->eyePrescriptions) == 0)
					<tr>
						<td class="text-danger text-center" colspan="10">*** EMPTY ***</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>

@section('eye_prescription_script')

@endsection
