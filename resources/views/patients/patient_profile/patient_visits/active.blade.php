<div class="row">
	<div class="col-md-12">
		<div class="card card-outline card-primary active-patient-profile">
			<div class="card-header">
				<h3 class="card-title">
					<span class="badge badge-success">ACTIVE SESSION</span>
				</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				<form action="{{ route('patient_visits.update', $patient->activeVisit()->id) }}" method="POST">
					@csrf
					@method('PUT')
					<div class="row">
						<div class="col-md-12">
							<div class="callout callout-info">
								<legend>VTFP Session</legend>
								<div class="row">
									<div class="form-group col-md-3">
										<label for="service">Service:</label>
										<select name="" id="" class="form-control select2">
											<option></option>
											@foreach ($services as $service)
												<option @if($patient->activeVisit()->service_id == $service->id) selected @endif value="{{ $service->id }}">{{ $service->name }}</option>
											@endforeach
										</select>
									</div>
									{{-- <div class="form-group col-md-3">
										<label for="admittingDiagnosis">Admiting Diagnosis:</label>
										<textarea name="admitting_diagnosis" id="admittingDiagnosis" rows="3" class="form-control"></textarea>
									</div>
									<div class="form-group col-md-3">
										<label for="finalDiagnosis">Final Diagnosis:</label>
										<textarea name="final_diagnosis" id="finalDiagnosis" rows="3" class="form-control"></textarea>
									</div> --}}
									<div class="form-group col-md-3">
										<label for="complaints">Complaints:</label>
										<textarea name="complaints" id="complaints" rows="3" class="form-control">{{ $patient->activeVisit()->complaints }}</textarea>
									</div>
									<div class="form-group col-md-3">
										<label for="findings">Findings:</label>
										<textarea name="findings" id="findings" rows="3" class="form-control">{{ $patient->activeVisit()->findings }}</textarea>
									</div>
									<div class="form-group col-md-3">
										<label for="recommendation">Recommendation:</label>
										<textarea name="recommendation" id="recommendation" rows="3" class="form-control">{{ $patient->activeVisit()->recommendation }}</textarea>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<button class="btn btn-success float-right" type="submit"><i class="fa fa-save"></i> Save</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<div class="callout callout-info">
							<legend>
								{{ trans('terminologies.medical_history') }}
								@can('medical_histories.create')
								<a class="btn btn-primary btn-sm text-light" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('medical_histories.create') }}" data-target="#addMedicalHistory" data-form="patient_id: {{ $patient->id }}">Add <i class="fa fa-plus"></i></a>
								@endcan
							</legend>
							<ul class="text-lg">
								@forelse ($patient->activeVisit()->medicalHistories()->orderBy('created_at', 'DESC')->get() as $medicalHistory)
									<li class="list-unstyled">
										<a
											href="javascript:void(0)"
											data-toggle="modal-ajax"
											data-href="{{ route('medical_histories.show', $medicalHistory->id) }}"
											data-target="#showMedicalHistory"
										>
										<i class="fa fa-file-lines"></i>
										{{ Carbon::parse($medicalHistory->created_at)->format('M d,Y h:ia') }}
										</a>
									</li>
								@empty
								<li class="list-unstyled text-danger">
									*** EMPTY ***
								</li>
								@endforelse
							</ul>
						</div>
					</div>
					<div class="col-md-4">
						<div class="callout callout-info">
							<legend>
								{{ trans('terminologies.complaint') }}
								@can('complaints.create')
								<a class="btn btn-primary btn-sm text-light" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('complaints.create') }}" data-target="#addComplaint" data-form="patient_id: {{ $patient->id }}">Add <i class="fa fa-plus"></i></a>
								@endcan
							</legend>
							<ul class="text-lg">
								@forelse ($patient->activeVisit()->complaints()->orderBy('created_at', 'DESC')->get() as $complaint)
									<li class="list-unstyled">
										<a
											href="javascript:void(0)"
											data-toggle="modal-ajax"
											data-href="{{ route('complaints.show', $complaint->id) }}"
											data-target="#showComplaint"
										>
										<i class="fa fa-file-lines"></i>
										{{ Carbon::parse($complaint->created_at)->format('M d,Y h:ia') }}
										</a>
									</li>
								@empty
								<li class="list-unstyled text-danger">
									*** EMPTY ***
								</li>
								@endforelse
							</ul>
						</div>
					</div>
					<div class="col-md-4">
						<div class="callout callout-info">
							<legend>
								{{ trans('terminologies.eye_prescription') }}
								@can('eye_prescriptions.create')
								<a class="btn btn-primary btn-sm text-light" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('eye_prescriptions.create') }}" data-target="#addEyePrescription" data-form="patient_id: {{ $patient->id }}">Add <i class="fa fa-plus"></i></a>
								@endcan
							</legend>
							<ul class="text-lg">
								@forelse ($patient->activeVisit()->eyePrescriptions()->orderBy('created_at', 'DESC')->get() as $eyePrescription)
									<li class="list-unstyled">
										<a
											href="javascript:void(0)"
											data-toggle="modal-ajax"
											data-href="{{ route('eye_prescriptions.show', $eyePrescription->id) }}"
											data-target="#showEyePrescription"
										>
										<i class="fa fa-file-lines"></i>
										{{ Carbon::parse($eyePrescription->created_at)->format('M d,Y h:ia') }}
										</a>
									</li>
								@empty
								<li class="list-unstyled text-danger">
									*** EMPTY ***
								</li>
								@endforelse
							</ul>
						</div>
					</div>
				</div>
			</div>
			@can('patient_visits.end_visit')
			<div class="card-footer">
				<a class="btn btn-success float-right" href="{{ route('patient_visits.end_visit', $patient->activeVisit()->id) }}">End Session</a>
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
