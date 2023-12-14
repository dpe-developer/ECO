<form action="{{ route('eye_prescriptions.store') }}" method="POST" autocomplete="off">
	@csrf
	<div class="modal fade" id="addEyePrescription" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-md">
			<div class="modal-content">
				<div class="modal-header">
		        	<h4 class="modal-title">Add {{ trans('terminologies.eye_prescription') }}</h4>
		        	<button type="button" class="close" data-dismiss="modal-ajax" aria-hidden="true">&times;</button>
		    	</div>
				<div class="modal-body text-left scrollbar-primary">
					<input type="hidden" name="patient" value="{{ $patient->id }}">
					<input type="hidden" name="visit" value="{{ $patientVisit->id }}">
					{{-- <div class="row patient-profile-form grid"> --}}
						@foreach ($eye_prescription_references as $reference)
							@if ($reference->type == 'parent')
								{{-- <div class="col-md-4 grid-item"> --}}
									<div class="callout callout-light">
										<legend>{{ $reference->name }}:</legend>
										<fieldset class="form-group">
											<ul class="children-references">
											@foreach ($reference->children as $children)
												@if($children->child->count() == 0 && $children->child_id == null)
													@if($children->type == 'text')
														<li>
															<div class="form-group">
																<label>{{ $children->name }}:</label>
																<input value="{{ old($children->id) }}" class="form-control" type="text" name="{{ $children->id }}">
															</div>
														</li>
													@elseif($children->type == 'checkbox')
														<li>
															<div class="checkbox">
															    <div class="custom-control custom-checkbox">
																	<input @if(old($children->id) == $children->name){{'checked'}}@endif type="checkbox" class="custom-control-input" name="{{ $children->id }}" value="{{ $children->name }}" id="EyePrescription_{{ $children->id }}">
																	<label class="custom-control-label" for="EyePrescription_{{ $children->id }}">{{ $children->name }}</label>
																</div>
															</div>
														</li>
													@elseif($children->type == 'check_textbox')
														<li>
															<div class="form-group">
																<div class="custom-control custom-checkbox">
																	<input @if(old($children->id) == $children->name){{'checked'}}@endif type="checkbox" class="custom-control-input check-textbox" data-id="{{ $children->id }}" name="{{ $children->id }}" value="{{ $children->name }}" id="EyePrescription_{{ $children->id }}">
																	<label class="custom-control-label" for="EyePrescription_{{ $children->id }}">{{ $children->name }}</label>
																</div>
																<div class="input-group input-group-sm">
																	<span class="input-group-prepend">
																		<span class="input-group-text">{{ $children->description }}</span>
																	</span>
																	<input value="{{ old('input_'.$children->id) }}" class="form-control form-control-sm check-textbox-input" data-id="{{ $children->id }}" name="input_{{$children->id}}" id="EyePrescription_input{{ $children->id }}" @if(old($children->id) == $children->name) @else disabled="" @endif>
																</div>
															</div>
														</li>
													@elseif($children->type == 'textarea')
														<li>
															<div class="form-group">
																<label>{{ $children->name }}:</label>
																<textarea class="form-control" name="{{ $children->id }}">{{ old($children->id) }}</textarea>
															</div>
														</li>
													@endif
												@elseif($children->child->count())
													<li><label style="font-weight: bold">{{ $children->name }}:</label></li>
													<div class="form-group">
														<ul class="child-references" style="list-style-type: circle;">
														@foreach ($children->child as $child)
															@if($child->type == 'text')
																<li>
																	<div class="form-group">
																		<label>{{ $child->name }}:</label>
																		<input value="{{ old($child->id) }}" class="form-control form-control-sm" type="text" name="{{ $child->id }}">
																	</div>
																</li>
															@elseif($child->type == 'checkbox')
																<li>
																	<div class="checkbox">
																	    <div class="custom-control custom-checkbox">
																			<input @if(old($child->id) == $child->name){{'checked'}}@endif type="checkbox" class="custom-control-input" name="{{ $child->id }}" value="{{ $child->name }}" id="EyePrescription_{{ $child->id }}">
																			<label class="custom-control-label" for="EyePrescription_{{ $child->id }}">{{ $child->name }}</label>
																		</div>
																	</div>
																</li>
															@elseif($child->type == 'check_textbox')
																<li>
																	<div class="form-group">
																		<div class="custom-control custom-checkbox">
																			<input @if(old($child->id) == $child->name){{'checked'}}@endif type="checkbox" class="custom-control-input check-textbox" data-id="{{ $child->id }}" name="{{ $child->id }}" value="{{ $child->name }}" id="EyePrescription_{{ $child->id }}">
																			<label class="custom-control-label" for="EyePrescription_{{ $child->id }}">{{ $child->name }}</label>
																		</div>
																		<div class="input-group input-group-sm">
																			<span class="input-group-prepend">
																				<span class="input-group-text">{{ $child->description }}</span>
																			</span>
																			<input value="{{ old('input_'.$child->id) }}" class="form-control form-control-sm check-textbox-input" data-id="{{ $child->id }}" name="input_{{$child->id}}" id="EyePrescription_input{{ $child->id }}" @if(old($child->id) == $child->name) @else disabled="" @endif>
																		</div>
																	</div>
																</li>
															@elseif($child->type == 'textarea')
																<li>
																	<div class="form-group">
																		<label>{{ $child->name }}:</label>
																		<textarea class="form-control" name="{{ $child->id }}">{{ old($child->id) }}</textarea>
																	</div>
																</li>
															@endif
														@endforeach
														</ul>
													</div>
												@endif
											@endforeach
											</ul>
										</fieldset>
									</div>
								{{-- </div> --}}
								{{-- End of Reference with Children|Child --}}
								{{-- <hr> --}}
							@elseif($reference->parent_id == null)
							{{-- <div class="col-md-4 grid-item"> --}}
								<div class="callout callout-light">
									@if($reference->type == 'text')
										<div class="form-group">
											<label>{{ $reference->name }}:</label>
											<input value="{{ old($reference->id) }}" class="form-control" type="text" name="{{ $reference->id }}">
										</div>
									@elseif($reference->type == 'checkbox')
										<div class="form-group">
											<div class="checkbox">
											    <div class="custom-control custom-checkbox">
													<input type="checkbox" class="custom-control-input" name="{{ $reference->id }}" value="{{ $reference->name }}" id="EyePrescription_{{ $reference->id }}">
													<label @if(old($reference->id) == $reference->name){{'checked'}}@endif class="custom-control-label" for="EyePrescription_{{ $reference->id }}">{{ $reference->name }}</label>
												</div>
											</div>
										</div>
									@elseif($reference->type == 'check_textbox')
										<div class="form-group">
											<div class="custom-control custom-checkbox">
												<input @if(old($reference->id) == $reference->name){{'checked'}}@endif type="checkbox" class="custom-control-input check-textbox" data-id="{{ $reference->id }}" name="{{ $reference->id }}" value="{{ $reference->name }}" id="EyePrescription_{{ $reference->id }}">
												<label class="custom-control-label" for="EyePrescription_{{ $reference->id }}">{{ $reference->name }}</label>
											</div>
											<div class="input-group input-group-sm">
												<span class="input-group-prepend">
													<span class="input-group-text">{{ $reference->description }}</span>
												</span>
												<input value="{{ old('input_'.$reference->id) }}" class="form-control form-control-sm check-textbox-input" data-id="{{ $reference->id }}" name="input_{{$reference->id}}" id="EyePrescription_input{{ $reference->id }}" @if(old($reference->id) == $reference->name) @else disabled="" @endif>
											</div>
										</div>
									@elseif($reference->type == 'textarea')
										<div class="form-group">
											<label>{{ $reference->name }}:</label>
											<textarea class="form-control" name="{{ $reference->id }}">{{ old($reference->id) }}</textarea>
										</div>
									@endif
								</div>
							{{-- </div> --}}
							@endif
						@endforeach
						{{-- <div class="col-md-4 grid-item"> --}}
							<div class="callout callout-light">
								<div class="form-group">
									<label>Doctor:</label>
									<select class="form-control select2{{ $errors->has('doctor') ? ' is-invalid' : '' }}" name="doctor" style="width: 100%">
										<option></option>
										@foreach ($doctors as $doctor)
											<option @if($patientVisit->doctor_id == $doctor->id){{'selected'}}@endif value="{{ $doctor->id }}">
												{{ $doctor->fullname() }}
											</option>
										@endforeach
									</select>
									@if ($errors->has('doctor'))
									    <span class="invalid-feedback" role="alert">
									        <strong>{{ $errors->first('doctor') }}</strong>
									    </span>
									@endif
								</div>
							</div>
						{{-- </div> --}}
					{{-- </div> --}}
					{{-- end of grid --}}
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal-ajax"><i class="fa fa-times"></i> Cancel</button>
					<button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div> 
</form>

<script type="application/javascript">
	$(function(){
		$(document).on('change', '.check-textbox', function(){
			var data_id = $(this).data('id');
			console.log('click');
			if(this.checked){
				$('.check-textbox-input[data-id="'+data_id+'"]').prop('disabled', false)
			}else{
				$('.check-textbox-input[data-id="'+data_id+'"]').prop('disabled', true)
			}
		})
	})
</script>