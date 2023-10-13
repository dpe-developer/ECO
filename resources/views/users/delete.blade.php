<div class="modal fade" id="delete_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
				<ul class="text-left">
				    <li><label>Username: </label> {{ $user->name }}</li>
				    <li>
				        <label>Name:</label>
				        {{ $user->employee->last_name }},
				        {{ $user->employee->first_name }}
				        {{ $user->employee->middle_name }}
				    </li>
				    <li>{{ $user->employee->job_title }}</li>
				</ul>
				<hr>
				<div class="form-group text-right">
					<a class="btn btn-danger btn-sm" href="{{ route('users.delete', ['user' => $user->id]) }}">Delete</a>
					<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div> {{-- end of modal delete --}}