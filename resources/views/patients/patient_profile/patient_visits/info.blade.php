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
                            <legend>VTFP Session</legend>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="service">Service:</label>
                                    {{ $patientVisit->service->name ?? "" }}
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
                                    {{ $patientVisit->complaints }}
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="findings">Findings:</label>
                                    {{ $patientVisit->findings }}
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="recommendation">Recommendation:</label>
                                    {{ $patientVisit->recommendation }}
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
			<div class="card-footer">
				<a class="btn btn-default" href="{{ route('patients.show', $patient->id) }}">Close</a>
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
