@section('modal_open_script')
	<script type="application/javascript">
		$(document).ready(function() {
			$('#showMedicalHistory').modal('show');
		});
	</script>
@endsection
{{-- modal-Show Eye Prescription --}}
<div class="modal fade" id="showMedicalHistory" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-scrollable modal-md">
		<div class="modal-content">
			<div class="modal-header">
	          <h4 class="modal-title">Eye Prescription - {{ date('M d, Y h:ia', strtotime($medicalHistory_show->updated_at)) }}</h4>
	          {{-- <a class="close" href="{{ route('patients.show', $patient->id) }}">&times;</a> --}}
	          <button class="close" data-dismiss="modal-ajax"  type="button">&times;</button>
	    	</div>
			<div class="modal-body text-left scrollbar-primary">
				<div class="callout callout-info">
                	<label>Doctor:</label> {{ $medicalHistory_show->doctor->fullname()}}<br>
                	{{-- <label>Patient:</label> {{ $medicalHistory_show->patient->patient_name($medicalHistory_show->patient_id) }} --}}
                </div>
				{{-- <div class="row patient-profile-form grid"> --}}
					@foreach ($medicalHistory_show->result as $result)
						@if ($result->type == 'parent')
							{{-- <div class="col-md-4 grid-item"> --}}
								<div class="callout callout-light">
									<legend>{{ $result->name }}:</legend>
									<fieldset class="form-group">
										<ul class="children-references">
										@foreach ($result->children as $children)
											@if($children->child->count() == 0 && $children->child_id == null)
												@if($children->type == 'text')
													<li>
														<div class="form-group">
															<label>{{ $children->name }}:</label>
															<p>{{ $children->value }}</p>
														</div>
													</li>
												@elseif($children->type == 'checkbox')
													<li>
														@if($children->value != null)
															@fa('far fa-check-square fa-lg text-success')
														@else
															@fa('far fa-square fa-lg text-secondary')
														@endif
														{{ $children->name }}
													</li>
												@elseif($children->type == 'check_textbox')
													<li>
														<p>
															@if($children->value != null)
																@fa('far fa-check-square fa-lg text-success')
															@else
																@fa('far fa-square fa-lg text-secondary')
															@endif
															{{ $children->name }}<br>
															{{ $children->description }}: {{ $children->sub_value }}
														</p>
													</li>
												@elseif($children->type == 'textarea')
													<li>
														<div class="form-group">
															<label>{{ $children->name }}:</label>
															<p>{{ $children->value }}</p>
														</div>
													</li>
												@endif
											@elseif($children->child->count())
												<li>
													<label style="font-weight: bold">{{ $children->name }}:</label>
													<ul class="child-references" style="list-style-type: circle;">
														@foreach ($children->child as $child)
															@if($child->type == 'text')
																<li>
																	<div class="form-group">
																		<label>{{ $child->name }}:</label>
																		<p>{{ $child->value }}</p>
																	</div>
																</li>
															@elseif($child->type == 'checkbox')
																<li>
																	<p>
																		@if($child->value != null)
																			@fa('far fa-check-square fa-lg text-success')
																		@else
																			@fa('far fa-square fa-lg text-secondary')
																		@endif
																		{{ $child->name }}
																	</p>
																</li>
															@elseif($child->type == 'check_textbox')
																<li>
																	<p>
																		@if($child->value != null)
																			@fa('far fa-check-square fa-lg text-success')
																		@else
																			@fa('far fa-square fa-lg text-secondary')
																		@endif
																		{{ $child->name }} <br>
																		{{ $child->description }}: {{ $child->sub_value }}
																	</p>
																</li>
															@elseif($child->type == 'textarea')
																<li>
																	<div class="form-group">
																		<label>{{ $child->name }}:</label>
																		<p>{{ $child->value }}</p>
																	</div>
																</li>
															@endif
														@endforeach
													</ul>
												</li>
											@endif
										@endforeach
										</ul>
									</fieldset>
								</div>
							{{-- </div> --}}
							{{-- ./col-md-4 End of Reference with Children|Child --}}
						@elseif($result->parent_id == null)
							{{-- <div class="col-md-4 grid-item"> --}}
								<div class="callout callout-light">
									@if($result->type == 'text')
										<div class="form-group">
											<label>{{ $result->name }}:</label>
											<p>{{ $result->value }}</p>
										</div>
									@elseif($result->type == 'checkbox')
										<p>
											@if($result->value != null)
												@fa('far fa-check-square fa-lg text-success')
											@else
												@fa('far fa-square fa-lg text-secondary')
											@endif
											{{ $result->name }}
										</p>
									@elseif($result->type == 'check_textbox')
										<p>
											@if($result->value != null)
												@fa('far fa-check-square fa-lg text-success')
											@else
												@fa('far fa-square fa-lg text-secondary')
											@endif
											{{ $result->name }} <br>
											{{ $result->description }}: {{ $result->sub_value }}
										</p>
									@elseif($result->type == 'textarea')
										<div class="form-group">
											<label>{{ $result->name }}:</label>
											<p>{{ $result->value }}</p>
										</div>
									@endif
								</div>
							{{-- </div> --}}
							{{-- ./col-md-4 --}}
						@endif
					@endforeach
				{{-- </div> --}}
			</div>
			<div class="modal-footer">
				<div class="col">
					@can('eye_prescriptions.destroy')
					<a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('eye_prescriptions.destroy', $medicalHistory_show->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
					@endcan
					@can('eye_prescriptions.edit')
					   <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('eye_prescriptions.edit', $medicalHistory_show->id) }}" data-target="#editMedicalHistory"><i class="fad fa-edit"></i> Edit</a>
					@endcan
				</div>
				<div class="col text-right">
					<button class="btn btn-default" type="button" data-dismiss="modal-ajax"> Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
{{-- /modal Show-Eye Prescription --}}