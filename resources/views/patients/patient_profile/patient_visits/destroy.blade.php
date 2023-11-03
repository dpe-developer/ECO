<div class="modal fade" id="destroyPatientVisit_{{ $visit->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
	          <h4 class="modal-title text-danger">@fa('fa fa-exclamation-triangle fa-lg') Destroy</h4>
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    	</div>
			<div class="modal-body">
    			<form action="{{ route('patient_visits.destroy', $visit->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <p class="text-left">
                    	Are you sure do you want to <strong class="text-danger"><u>DESTROY</u></strong> this data?
                    </p>
                        {{-- <ul class="text-left">
                            <li><label>Hospital ID:</label> {{ $patient->hospital_id }}</li>
                            <li><label>Name:</label> {{ $patient_name }}</li>
                        </ul> --}}
                    <p class="text-left">
                        After destroying, you will not be able to retrieve this data.
                    </p>
                    <hr>
                    <div class="form-group text-right">
    					<button type="submit" class="btn btn-danger btn-sm">Destroy</button>
    					<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div> {{-- end of modal destroy --}}