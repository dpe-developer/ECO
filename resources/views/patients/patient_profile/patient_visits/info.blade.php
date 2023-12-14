<div class="row">
	<div class="col-md-12">
		<div class="card card-outline card-primary active-patient-profile">
			<div class="card-header">
				<h3 class="card-title">
					<span class="badge badge-info">OLD SESSION</span>
                    {{ Carbon::parse($patientVisit->visit_date)->format('M d,Y h:ia') }}
				</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-widget="collapse"><i class="fas fa-minus"></i></button>
				</div>
			</div>
			<div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="callout callout-info">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <b>Service:</b><br>
                                    {{ $patientVisit->service->name ?? "" }}
                                </div>
								<div class="form-group col-md-9">
									<div class="callout callout-warning">
										<label for="findings">Findings:</label>
										<div class="row">
											@foreach ($findings as $finding)
												<div class="col-md-3">
													<div class="icheck-primary d-inline">
														<input type="checkbox" name="findings[]" @if(!is_null($patientVisit->findings)) @if(in_array($finding->name, json_decode($patientVisit->findings))) checked @endif @endif value="{{ $finding->name }}" id="finding_{{ $finding->id }}">
														<label for="finding_{{ $finding->id }}">
														{{ $finding->name }}
														</label>
													</div>
												</div>
											@endforeach
										</div>
									</div>
								</div>
                                {{-- <div class="form-group col-md-3">
                                    <label for="admittingDiagnosis">Admiting Diagnosis:</label>
                                    <textarea name="admitting_diagnosis" id="admittingDiagnosis" rows="3" class="form-control"></textarea>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="finalDiagnosis">Final Diagnosis:</label>
                                    <textarea name="final_diagnosis" id="finalDiagnosis" rows="3" class="form-control"></textarea>
                                </div> --}}
								<div class="form-group col-md-4">
                                    <b>Session End:</b><br>
                                    {{ Carbon::parse($patientVisit->session_end)->format('M d,Y h:ia') }}
                                </div>
                                <div class="form-group col-md-4">
                                    <b>Complaints:</b><br>
                                    {{ $patientVisit->complaints }}
                                </div>
                                <div class="form-group col-md-4">
                                    <b>Recommendation:</b><br>
                                    {{ $patientVisit->recommendations }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<div class="callout callout-info">
							<legend>
								{{ trans('terminologies.medical_history') }}
							</legend>
							<ul class="text-lg">
								@forelse ($patientVisit->medicalHistories()->orderBy('created_at', 'DESC')->get() as $medicalHistory)
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
							</legend>
							<ul class="text-lg">
								@forelse ($patientVisit->complaints()->orderBy('created_at', 'DESC')->get() as $complaint)
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
							</legend>
							<ul class="text-lg">
								@forelse ($patientVisit->eyePrescriptions()->orderBy('created_at', 'DESC')->get() as $eyePrescription)
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
			<div class="card-footer text-right">
				@can('medical_histories.destroy')
				<a class="btn bg-gradient-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('patient_visits.destroy', $patientVisit->id) }}"><i class="fa fa-trash"></i> Delete</a>
				@endcan
				@can('medical_histories.edit')
				<a class="btn bg-gradient-info" href="{{ route('patient_visits.edit', $patientVisit->id) }}"><i class="fa fa-edit"></i> Edit</a>
				@endcan
				<a class="btn bg-gradient-secondary" href="{{ route('patients.show', $patient->id) }}"><i class="fa fa-times"></i> Close</a>
			</div>
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

		});
	</script>
@endsection
