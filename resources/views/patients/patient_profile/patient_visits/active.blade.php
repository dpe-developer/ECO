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
											<label for="findings">Findings: <button class="btn btn-xs bg-gradient-primary" href="javascript:void(0)" type="button" data-toggle="modal-ajax" data-href="{{ route('findings.create') }}" data-target="#addFindingModal"><i class="fa fa-plus"></i> Add</button></label>
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
				<form action="#" id="predictionForm">
					<div class="row">
						<div class="col-lg-12">
							<div class="callout callout-warning">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="os_sph">Left Eye Sphere</label>
											<input id="os_sph" name="os_sph" type="number" step="any" class="form-control">
										</div>
										<div class="form-group">
											<label for="os_cyl">Left Eye Cylinder</label>
											<input id="os_cyl" name="os_cyl" type="number" step="any" class="form-control">
										</div>
										<div class="form-group">
											<label for="os_axis">Left Eye Axis</label>
											<input id="os_axis" name="os_axis" type="number" step="any" class="form-control">
										</div>
										<div class="form-group">
											<label for="va_os_numerator">Visual Aquity Left</label>
											<div class="row justify-content-center">
												<div class="col-4">
													<input id="va_os_numerator" name="va_os_numerator" type="number" step="any" class="text-center form-control">
												</div>
											</div>
											<hr class="col-3 bg-dark mb-1 mt-1">
											<div class="row justify-content-center">
												<div class="col-4">
													<input id="va_os_denominator" name="va_os_denominator" type="number" step="any" class="text-center form-control">
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="od_sph">Right Eye Sphere</label>
											<input id="od_sph" name="od_sph" type="number" step="any" class="form-control">
										</div>
										<div class="form-group">
											<label for="od_cyl">Right Eye Cylinder</label>
											<input id="od_cyl" name="od_cyl" type="number" step="any" class="form-control">
										</div>
										<div class="form-group">
											<label for="od_axis">Right Eye Axis</label>
											<input id="od_axis" name="od_axis" type="number" step="any" class="form-control">
										</div>
										<div class="form-group">
											<label for="va_od_numerator">Visual Aquity Right</label>
											<div class="row justify-content-center">
												<div class="col-4">
													<input id="va_od_numerator" name="va_od_numerator" type="number" step="any" class="text-center form-control">
												</div>
											</div>
											<hr class="col-3 bg-dark mb-1 mt-1">
											<div class="row justify-content-center">
												<div class="col-4">
													<input id="va_od_denominator" name="va_od_denominator" type="number" step="any" class="text-center form-control">
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<p>
												Has the patient never went through an aye examination before?
											</p>
											<div class="icheck-primary d-inline">
												<input type="radio" name="q1" value="1" id="q1_yes">
												<label for="q1_yes">Yes</label>
											</div>
											<div class="icheck-primary d-inline">
												<input type="radio" name="q1" value="0" id="q1_no">
												<label for="q1_no">No</label>
											</div>
										</div>
										<div class="form-group">
											<p>
												Did the patient have any medical histories that could have affected eye condition?
											</p>
											<div class="icheck-primary d-inline">
												<input type="radio" name="q2" value="1" id="q2_yes">
												<label for="q2_yes">Yes</label>
											</div>
											<div class="icheck-primary d-inline">
												<input type="radio" name="q2" value="0" id="q2_no">
												<label for="q2_no">No</label>
											</div>
										</div>
										<br>
										<br>
										<h3 class="text-center">
											<span id="predictionPercentage">0%</span>
											Amblyopia
										</h3>
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
								<a class="btn btn-primary btn-sm text-light" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('medical_histories.create') }}" data-target="#addMedicalHistory" data-form="patient_id: {{ $patient->id }}; visit_id: {{ $patient->activeVisit()->id }}">Add <i class="fa fa-plus"></i></a>
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
								<a class="btn btn-primary btn-sm text-light" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('complaints.create') }}" data-target="#addComplaint" data-form="patient_id: {{ $patient->id }}; visit_id: {{ $patient->activeVisit()->id }}">Add <i class="fa fa-plus"></i></a>
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
								<a class="btn btn-primary btn-sm text-light" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('eye_prescriptions.create') }}" data-target="#addEyePrescription" data-form="patient_id: {{ $patient->id }}; visit_id: {{ $patient->activeVisit()->id }}">Add <i class="fa fa-plus"></i></a>
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
	<script src="{{ asset('js/decimal.js') }}"></script>
	<script>
		$(function(){
			Decimal.set({ precision: 9 });

			$('#predictionForm').on('change', function(){
				let q1 = $(this).find("input[name='q1']:checked").val()
				let q2 = $(this).find("input[name='q2']:checked").val()
				let os_sph = new Decimal(isNaN(parseFloat($('#os_sph').val())) ? 0 : parseFloat($('#os_sph').val()));
				let os_cyl = new Decimal(isNaN(parseFloat($('#os_cyl').val())) ? 0 : parseFloat($('#os_cyl').val()));
				let os_axis = new Decimal(isNaN(parseFloat($('#os_axis').val())) ? 0 : parseFloat($('#os_axis').val()))
				let va_os_numerator = new Decimal(isNaN(parseFloat($('#va_os_numerator').val())) ? 0 : parseFloat($('#va_os_numerator').val()))
				let va_os_denominator = new Decimal(isNaN(parseFloat($('#va_os_denominator').val())) ? 0 : parseFloat($('#va_os_denominator').val()))
				let od_sph = new Decimal(isNaN(parseFloat($('#od_sph').val())) ? 0 : parseFloat($('#od_sph').val()));
				let od_cyl = new Decimal(isNaN(parseFloat($('#od_cyl').val())) ? 0 : parseFloat($('#od_cyl').val()));
				let od_axis = new Decimal(isNaN(parseFloat($('#od_axis').val())) ? 0 : parseFloat($('#od_axis').val()))
				let va_od_numerator = new Decimal(isNaN(parseFloat($('#va_od_numerator').val())) ? 0 : parseFloat($('#va_od_numerator').val()))
				let va_od_denominator = new Decimal(isNaN(parseFloat($('#va_od_denominator').val())) ? 0 : parseFloat($('#va_od_denominator').val()))

				let sphDifference = os_sph.minus(od_sph).absoluteValue();
				let cylDifference = os_cyl.minus(od_cyl).absoluteValue();
				let axisDifference = os_axis.minus(od_axis).absoluteValue();
				let va_os = va_os_numerator.dividedBy(va_os_denominator);
				va_os = (va_os == Infinity ? new Decimal(0) : va_os);
				let va_od = va_od_numerator.dividedBy(va_od_denominator);
				va_od = (va_od == Infinity ? new Decimal(0) : va_od);
				let vaDifference = va_os.minus(va_od).absoluteValue();

				let predictionPercentageDOM = $('#predictionPercentage')
				let predictionPercentage = 0

				if(q1 == 1) {
					console.log("Q1 TRUE");
					predictionPercentage += 1
				}
				if(q2 == 1) {
					console.log("Q2 TRUE");
					predictionPercentage += 1
				}
				if(sphDifference.greaterThanOrEqualTo(2)) {
					console.log("Q3 TRUE");
					predictionPercentage += 1
				}
				if(cylDifference.greaterThanOrEqualTo(0.75) && cylDifference.lessThanOrEqualTo(2)) {
					console.log("Q4 TRUE");
					predictionPercentage += 1
				}
				if(axisDifference.greaterThanOrEqualTo(20)) {
					console.log("Q5 TRUE");
					predictionPercentage += 1
				}
				if(vaDifference.lessThanOrEqualTo(0.5) && vaDifference.greaterThanOrEqualTo(0.02)) {
					console.log("Q6 TRUE");
					predictionPercentage += 1
				}
				if(va_od.greaterThanOrEqualTo(0.4) || va_os.greaterThanOrEqualTo(0.4)) {
					console.log("Q7 TRUE");
					predictionPercentage += 1
				}

				predictionPercentage = (predictionPercentage / 7) * 100;
				predictionPercentageDOM.text(roundNum(predictionPercentage, 0, 2) + '%');
			});

			function roundNum(num, minDecimal, maxDecimal){
				var num = isNaN(num) ? 0 : num;
				const formatter = new Intl.NumberFormat('en-PH', {
					minimumFractionDigits: minDecimal,      
					maximumFractionDigits: (maxDecimal > 16 ? 16 : maxDecimal),
					useGrouping: false
				});
				return formatter.format(num);
}
		});
	</script>
@endsection
