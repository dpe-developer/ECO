<div class="row">
	<div class="col">
		<h5>Medical History
			@can('medical_history_references.index')
			<a href="{{ route('medical_history_references.index') }}" title="Edit References"><i class="fad fa-edit"></i></a>
			@endcan
	    </h5>
	</div>
	<div class="col text-right">
		@if(isset($patient->activeVisit()->id))
			@can('medical_histories.create')
			<button class="btn bg-gradient-primary" type="button" data-toggle="modal-ajax" data-href="{{ route('medical_histories.create') }}" data-target="#addMedicalHistory" data-form="patient_id: {{ $patient->id }}"><i class="fa fa-plus"></i> Add</button>
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
					@forelse ($patient->medicalHistories()->orderBy('created_at', 'DESC')->get() as $medicalHistory)
					<tr @unlessrole('System Administrator') @can('medical_histories.show') data-toggle="modal-ajax" data-href="{{ route('medical_histories.show', $medicalHistory->id) }}" data-target="#showMedicalHistory" @endcan @endif>
						<td style="min-width: 118px">{{ date('M d, Y h:ia', strtotime($medicalHistory->updated_at)) }}</td>
						<td>
							{{ $medicalHistory->doctor->fullname() }}
						</td>
						@role('System Administrator')
		        		<td class="text-center">
							<a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showMedicalHistory" data-href="{{ route('medical_histories.show',$medicalHistory->id) }}"><i class="fad fa-file fa-lg"></i></a>
							<a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editMedicalHistory" data-href="{{ route('medical_histories.edit',$medicalHistory->id) }}"><i class="fad fa-edit fa-lg"></i></a>
							<a class="text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('medical_histories.destroy', $medicalHistory->id) }}"><i class="fad fa-trash-alt fa-lg"></i></a>
		              	</td>
		              	@endrole
					</tr>
					@empty
					<tr>
						<td class="text-danger text-center" colspan="10">*** EMPTY ***</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>

@section('eye_prescription_script')

@endsection
