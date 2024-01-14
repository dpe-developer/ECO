<div class="row">
	<div class="col">
		<h5>{{ trans('terminologies.complaint') }}
			@can('complaint_references.index')
			<a href="{{ route('complaint_references.index') }}" title="Edit References"><i class="fad fa-edit"></i></a>
			@endcan
	    </h5>
	</div>
	<div class="col text-right">
		@if(isset($patient->activeVisit()->id))
			@can('complaints.create')
			<button class="btn bg-gradient-primary" type="button" data-toggle="modal-ajax" data-href="{{ route('complaints.create') }}" data-target="#addComplaint" data-form="patient_id: {{ $patient->id }}; visit_id: {{ $patient->activeVisit()->id }}""><i class="fa fa-plus"></i> Add</button>
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
					@foreach ($patient->complaints()->orderBy('created_at', 'DESC')->get() as $complaint)
					<tr @unlessrole('System Administrator') @can('complaints.show') data-toggle="modal-ajax" data-href="{{ route('complaints.show', $complaint->id) }}" data-target="#showEyePrescription" @endcan @endif>
						<td style="min-width: 118px">{{ date('M d, Y h:ia', strtotime($complaint->updated_at)) }}</td>
						<td>
							{{ $complaint->doctor->fullname() }}
						</td>
						@role('System Administrator')
		        		<td class="text-center">
							<a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showComplaint" data-href="{{ route('complaints.show',$complaint->id) }}"><i class="fad fa-file fa-lg"></i></a>
							<a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editComplaint" data-href="{{ route('complaints.edit',$complaint->id) }}"><i class="fad fa-edit fa-lg"></i></a>
							<a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('complaints.destroy', $complaint->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
		              	</td>
		              	@endrole
					</tr>
					@endforeach
					@if(count($patient->complaints) == 0)
					<tr>
						<td class="text-danger text-center" colspan="10">*** EMPTY ***</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>