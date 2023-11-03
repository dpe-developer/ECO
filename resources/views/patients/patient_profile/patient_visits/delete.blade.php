<div class="modal fade" id="deletePatientVisit_{{ $visit->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
	          <h4 class="modal-title">Delete</h4>
	          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    	</div>
			<div class="modal-body">
				<p class="text-left">
					Are you sure do you want to delete this data?
				</p>
				<hr>
				<div class="form-group text-right">
					<a class="btn btn-danger btn-sm" href="{{ route('patient_visits.delete', ['physicalExamination' => $visit->id]) }}">@fa('far fa-trash-alt fa-lg') Delete</a>
					<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div> {{-- end of modal delete --}}