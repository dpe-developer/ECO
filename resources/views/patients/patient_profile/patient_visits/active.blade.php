<div class="row">
	<div class="col-md-12">
		<div class="card card-outline card-primary">
			<div class="card-header">
				<h3 class="card-title">
					<span class="badge badge-success">ACTIVE PATIENT</span>
				</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-4">
						<legend>
							Eye Prescriptions
							@can('eye_prescirptions.create')
							<a class="btn btn-primary btn-sm" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('eye_prescriptions.create') }}" data-target="#addEyePrescription" data-form="patient_id: {{ $patient->id }}">Add <i class="fa fa-plus"></i></a>
							@endcan
						</legend>
						<ul>
							@foreach ($patient->activeVisit()->eyePrescriptions()->orderBy('created_at', 'DESC')->get() as $eyePrescription)
								<li>
									<a
										href="javascript:void(0)"
										data-toggle="modal-ajax"
										data-href="{{ route('eye_prescriptions.show', $eyePrescription->id) }}"
										data-target="#showEyePrescription"
									>{{ Carbon::parse($eyePrescription->created_at)->format('M d,Y h:ia') }}
									</a>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
				<hr>
				{{-- <div class="row">
					<div class="col-md-4">
						<label>Doctor's Notes: </label>
						@can('doctors_notes.create')
						<a href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('doctors_notes.create') }}" data-target="#addDoctorsNotes" data-form="patient_id: {{ $patient->id }}"><i class="fa fa-plus"></i> Add</a>
						@endcan
						<ul>
							@foreach ($patient->active_visit()->doctors_notes->groupBy('employee_id') as $key => $doctors_note)
								<li>
									<label style="margin-bottom: 0px">{{ $doctors_note[0]->employee->employeeName() }}</label>
									<ul>
										@foreach ($doctors_note as $note)
										<li>
											<a
												href="javascript:void(0)"
												data-toggle="modal-ajax"
												data-href="{{ route('doctors_notes.show', $note->id) }}"
												data-target="#showDoctorsNotes"
											>
											{{ $note->subject }}
											</a>
										</li>
										@endforeach
									</ul>
								</li>
							@endforeach
						</ul>
					</div>
					<div class="col-md-4">
						<label>Nurse's Notes: </label>
						@can('nurses_notes.create')
						<a href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('nurses_notes.create') }}" data-target="#addNursesNotes" data-form="patient_id: {{ $patient->id }}"><i class="fa fa-plus"></i> Add</a>
						@endcan
						<ul>
							@foreach ($patient->active_visit()->nurses_notes->groupBy('employee_id') as $key => $nurses_note)
								<li>
									<label style="margin-bottom: 0px">{{ $nurses_note[0]->employee->employeeName() }}</label>
									<ul>
										@foreach ($nurses_note as $note)
										<li>
											<a
												href="javascript:void(0)"
												data-toggle="modal-ajax"
												data-href="{{ route('nurses_notes.show', $note->id) }}"
												data-target="#showNursesNotes"
											>
											{{ $note->subject }}
											</a>
										</li>
										@endforeach
									</ul>
								</li>
							@endforeach
						</ul>
					</div>
					<div class="col-md-4">
						<label>Other Notes: </label>
						@can('other_notes.create')
						<a href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('other_notes.create') }}" data-target="#addOtherNotes" data-form="patient_id: {{ $patient->id }}"><i class="fa fa-plus"></i> Add</a>
						@endcan
						<ul>
							@foreach ($patient->active_visit()->other_notes->groupBy('employee_id') as $key => $other_note)
								<li>
									<label style="margin-bottom: 0px">{{ $other_note[0]->employee->employeeName() }}</label>
									<ul>
										@foreach ($other_note as $note)
										<li>
											<a
												href="javascript:void(0)"
												data-toggle="modal-ajax"
												data-href="{{ route('other_notes.show', $note->id) }}"
												data-target="#showOtherNotes"
											>
											{{ $note->subject }}
											</a>
										</li>
										@endforeach
									</ul>
								</li>
							@endforeach
						</ul>
					</div>
				</div> --}}
			</div>
			@can('patient_visits.end_visit')
			<div class="card-footer">
				<a class="btn btn-success" href="patient_visits.end_visit">End Visit</a>
			</div>
			@endcan
		</div>
	</div>
</div>

@section('active_visit_script')
	<script type="text/javascript">
		$(function() {
            /*$('[data-toggle="popover-hover"]').popover({
                html: true,
                sanitize: false
            })*/
			// Show bootstrap popover on hover
			$('[data-toggle="popover-hover"]').popover({
					trigger: "manual",
					html: true,
					sanitize: false,
					// animation: false
				})
				.on("mouseenter", function () {
					var _this = this;
					$(this).popover("show");
					$(".popover").on("mouseleave", function () {
						$(_this).popover('hide');
					});
				}).on("mouseleave", function () {
					var _this = this;
					setTimeout(function () {
						if (!$(".popover:hover").length) {
							$(_this).popover("hide");
						}
					}, 100);
			});

			$('#dischargeDate').datetimepicker({
				date: new Date(),
				debug: true,
				icons: {
					time: 'far fa-clock',
					date: 'far fa-calendar-alt',
					up: 'fas fa-arrow-up',
					down: 'fas fa-arrow-down',
					previous: 'fas fa-chevron-left',
					next: 'fas fa-chevron-right',
					today: 'far fa-calendar-check',
					clear: 'far fa-trash-alt',
					close: 'fas fa-times'
				},
				buttons: {
					showToday: true,
					showClose: true,
					showClear: true
				}
			});

		});
	</script>
@endsection
