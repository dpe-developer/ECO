@section('active_visit_styles')
	<link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endsection
<div class="row">
	<div class="col-md-12">
		<div class="card card-outline card-primary active-patient-profile">
			<div class="card-header">
				<h3 class="card-title">
					<span class="badge badge-success badge-lg">ACTIVE SESSION</span>
				</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
				{{-- <div class="row">
					<div class="col-md-12">
						<div class="callout callout-warning">
							<legend>Findings:</legend>
							<ul>
							@foreach(json_decode($patient->activeVisit()->findings) as $finding)
								<li>{{ $finding }}</li>
							@endforeach
							</ul>
						</div>
					</div>
				</div> --}}
				<form action="{{ route('patient_visits.update', $patient->activeVisit()->id) }}" method="POST" id="patientVisitForm">
					@csrf
					@method('PUT')
					<div class="row">
						<div class="col-md-12">
							<div class="callout callout-info">
								<div class="row">
									<div class="form-group col-md-3">
										<label for="service">Service:</label>
										<select name="service" id="" class="form-control select2">
											<option></option>
											@foreach ($services as $service)
												<option @if($patient->activeVisit()->service_id == $service->id) selected @endif value="{{ $service->id }}">{{ $service->name }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group col-md-9">
										<div class="callout callout-warning">
											<label for="findings">Findings:</label>
											<div class="row">
												@foreach ($findings as $finding)
													<div class="col-md-3">
														<div class="icheck-primary d-inline">
															<input type="checkbox" name="findings[]" @if(!is_null($patient->activeVisit()->findings)) @if(in_array($finding->name, json_decode($patient->activeVisit()->findings))) checked @endif @endif value="{{ $finding->name }}" id="finding_{{ $finding->id }}">
															<label for="finding_{{ $finding->id }}">
															{{ $finding->name }}
															</label>
														</div>
													</div>
												@endforeach
											</div>
										</div>
									</div>
									<div class="form-group col-md-6">
										<label for="complaints">Complaints:</label>
										<textarea name="complaints" id="complaints" rows="3" class="form-control">{{ $patient->activeVisit()->complaints }}</textarea>
									</div>
									<div class="form-group col-md-6">
										<label for="recommendations">Recommendation:</label>
										<textarea name="recommendations" id="recommendations" rows="3" class="form-control">{{ $patient->activeVisit()->recommendations }}</textarea>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<button class="btn bg-gradient-success float-right" type="submit"><i class="fa fa-save"></i> Save</button>
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
								<a class="btn btn-primary btn-sm text-light" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('medical_histories.create') }}" data-target="#addMedicalHistory" data-form="patient_id: {{ $patient->id }}; patient_visit_id: {{ $patient->activeVisit()->id }}">Add <i class="fa fa-plus"></i></a>
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
				<a class="btn btn-success float-right" href="javascript:void(0)" data-toggle="confirm-link" data-href="{{ route('patient_visits.end_visit', $patient->activeVisit()->id) }}" data-message='Do you want to end this Visit?'>End Session</a>
			</div>
			@endcan
		</div>
	</div>
</div>

@section('active_visit_scripts')
	{{-- Scripts Here --}}
@endsection
