@section('modal_open_script')
	<script type="application/javascript">
		$(document).ready(function() {
			$('#editEyePrescription').modal('show');
		});
	</script>
	<script type="application/javascript">
		$(document).on('show.bs.modal', '.modal', function () {
		    var zIndex = 1040 + (10 * $('.modal:visible').length);
		    $(this).css('z-index', zIndex);
		    setTimeout(function() {
		        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
		    }, 0);
		});
	</script>
@endsection
{{-- modal-Edit Vital Information --}}
<form action="{{ route('eye_prescriptions.update', $eyePrescription_edit->id) }}" method="POST">
@csrf
@method('PUT')
	<div class="modal fade" id="editEyePrescription" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-md">
			<div class="modal-content">
				<div class="modal-header">
		        	<h4 class="modal-title">Edit {{ trans('terminologies.eye_prescription') }} - {{ date('M d, Y h:ia', strtotime($eyePrescription_edit->created_at)) }}</h4>
		        	<button class="close" type="button" data-toggle="modal" data-target="#closeEditEyePrescription">&times;</button>
		        	{{-- <a class="close" href="{{ route('patients.show', $eyePrescription_edit->patient_id) }}">&times;</a> --}}
		    	</div>
				<div class="modal-body text-left scrollbar-primary">
					@foreach ($eyePrescription_edit->result as $result)
						@if ($result->type == 'parent')
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
														<input value="{{ $children->value}}" class="form-control" type="text" name="{{ $children->id }}">
													</div>
												</li>
											@elseif($children->type == 'checkbox')
												<li>
													<div class="checkbox">
														<div class="custom-control custom-checkbox">
															<input @if($children->value != null){{'checked'}}@endif type="checkbox" class="custom-control-input" name="{{ $children->id }}" value="{{ $children->name }}" id="editEyePrescription_{{ $children->id }}">
															<label class="custom-control-label" for="editEyePrescription_{{ $children->id }}">{{ $children->name }}</label>
														</div>
													</div>
												</li>
											@elseif($children->type == 'check_textbox')
												<li>
													<div class="form-group">
														<div class="custom-control custom-checkbox">
															<input @if($children->value != null){{'checked'}}@endif type="checkbox" class="custom-control-input check-textbox" data-id="{{ $children->id }}" name="{{ $children->id }}" value="{{ $children->name }}" id="editEyePrescription_{{ $children->id }}">
															<label class="custom-control-label" for="editEyePrescription_{{ $children->id }}">{{ $children->name }}</label>
														</div>
														<div class="input-group input-group-sm">
															<span class="input-group-prepend">
																<div class="input-group-text">
																	{{ $children->description }}
																</div>	
															</span>
															<input value="{{ $children->sub_value}}" class="form-control form-control-sm check-textbox-input" data-id="{{ $children->id }}" name="input_{{$children->id}}" id="editEyePrescription_input{{ $children->id }}" @if($children->value == null) disabled="" @endif>
														</div>
													</div>
												</li>
											@elseif($children->type == 'textarea')
												<li>
													<div class="form-group">
														<label>{{ $children->name }}:</label>
														<textarea class="form-control" name="{{ $children->id }}">{{ $children->value}}</textarea>
													</div>
												</li>
											@endif
										@elseif($children->child->count())
											<li><label style="font-weight: bold">{{ $children->name }}:</label></li>
											<ul class="child-references" style="list-style-type: circle;">
												@foreach ($children->child as $child)
													@if($child->type == 'text')
														<li>
															<div class="form-group">
																<label>{{ $child->name }}:</label>
																<input value="{{ $child->value}}" class="form-control form-control-sm" type="text" name="{{ $child->id }}">
															</div>
														</li>
													@elseif($child->type == 'checkbox')
														<li>
															<div class="checkbox">
																<div class="custom-control custom-checkbox">
																	<input @if($child->value != null){{'checked'}}@endif type="checkbox" class="custom-control-input" name="{{ $child->id }}" value="{{ $child->name }}" id="editEyePrescription_{{ $child->id }}">
																	<label class="custom-control-label" for="editEyePrescription_{{ $child->id }}">{{ $child->name }}</label>
																</div>
															</div>
														</li>
													@elseif($child->type == 'check_textbox')
														<li>
															<div class="form-group">
																<div class="custom-control custom-checkbox">
																	<input @if($child->value != null){{'checked'}}@endif type="checkbox" class="custom-control-input check-textbox" data-id="{{ $child->id }}" name="{{ $child->id }}" value="{{ $child->name }}" id="editEyePrescription_{{ $child->id }}">
																	<label class="custom-control-label" for="editEyePrescription_{{ $child->id }}">{{ $child->name }}</label>
																</div>
																<div class="input-group input-group-sm">
																	<span class="input-group-prepend">
																		<div class="input-group-text">
																			{{ $child->description }}
																		</div>	
																	</span>
																	<input value="{{ $child->sub_value}}" class="form-control form-control-sm check-textbox-input" data-id="{{ $child->id }}" name="input_{{$child->id}}" id="editEyePrescription_input{{ $child->id }}" @if($child->value == null) disabled="" @endif>
																</div>
															</div>
														</li>
													@elseif($child->type == 'textarea')
														<li>
															<div class="form-group">
																<label>{{ $child->name }}:</label>
																<textarea class="form-control" name="{{ $child->id }}">{{ $child->value}}</textarea>
															</div>
														</li>
													@endif
												@endforeach
											</ul>
										@endif
									@endforeach
									</ul>
								</fieldset>
							</div>
						@elseif($result->parent_id == null)
							<div class="callout callout-light">
								@if($result->type == 'text')
									<div class="form-group">
										<label>{{ $result->name }}:</label>
										<input value="{{ $result->value}}" class="form-control" type="text" name="{{ $result->id }}">
									</div>
								@elseif($result->type == 'checkbox')
									<div class="form-group">
										<div class="checkbox">
											<div class="custom-control custom-checkbox">
												<input @if($result->value != null){{'checked'}}@endif type="checkbox" class="custom-control-input" name="{{ $result->id }}" value="{{ $result->name }}" id="editEyePrescription_{{ $result->id }}">
												<label class="custom-control-label" for="editEyePrescription_{{ $result->id }}">{{ $result->name }}</label>
											</div>
										</div>
									</div>
								@elseif($result->type == 'check_textbox')
									<div class="form-group">
										<div class="custom-control custom-checkbox">
											<input @if($result->value != null){{'checked'}}@endif type="checkbox" class="custom-control-input check-textbox" data-id="{{ $result->id }}" name="{{ $result->id }}" value="{{ $result->name }}" id="editEyePrescription_{{ $result->id }}">
											<label class="custom-control-label" for="editEyePrescription_{{ $result->id }}">{{ $result->name }}</label>
										</div>
										<div class="input-group input-group-sm">
											<span class="input-group-prepend">
												<div class="input-group-text">
													{{ $result->description }}
												</div>	
											</span>
											<input value="{{ $result->sub_value}}" class="form-control form-control-sm check-textbox-input" data-id="{{ $result->id }}" name="input_{{$result->id}}" id="editEyePrescription_input{{ $result->id }}" @if($result->value == null) disabled="" @endif>
										</div>
									</div>
								@elseif($result->type == 'textarea')
									<div class="form-group">
										<label>{{ $result->name }}:</label>
										<textarea class="form-control" name="{{ $result->id }}">{{ $result->value}}</textarea>
									</div>
								@endif
							</div>
						@endif
					@endforeach
					<div class="form-group">
						<label>Doctor:</label>
						<select class="form-control select2" name="doctor" style="width: 100%">
							<option></option>
							@foreach ($doctors as $doctor)
								<option @if($eyePrescription_edit->doctor_id == $doctor->id){{'selected'}}@endif value="{{ $doctor->id }}">
									{{ $doctor->fullname() }}
								</option>
							@endforeach
						</select>
					</div>
				</div> {{-- ./modal-body --}}
				<div class="modal-footer">
					<div class="col">
						@can('eye_prescriptions.destroy')
						<a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('eye_prescriptions.destroy', $eyePrescription_edit->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
						@endcan
					</div>
					<div class="col text-right">
						<button class="btn btn-default" type="button" data-toggle="modal" data-target="#closeEditEyePrescription">Cancel</button>
						<button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save</button>
					</div>
				</div> {{-- ./modal-footer --}}
			</div> {{-- ./modal-content --}}
		</div> {{-- ./modal-dialog --}}
	</div> {{-- ./modal --}}
	<div class="modal fade" id="closeEditEyePrescription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header text-center">
		          <h3 class="modal-title">You have unsaved changes.</h3>
		    	</div>
				<div class="modal-body">
					<p>Are you sure you want to leave this screen and discard your changes?</p>
				</div>
				<div class="modal-footer">
					<div class="col text-left">
						<button class="btn btn-default" type="button" data-dismiss="modal" aria-label="Close">Cancel</button>
					</div>
					<div class="col text-right">
						<button class="btn btn-default" type="button" data-dismiss="modal-ajax"><i class="fa fa-times"></i> Discard</button>
						{{-- <a class="btn btn-default" href="{{ route('patients.show', $eyePrescription_edit->patient_id) }}">Discard</a> --}}
						<button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save</button>
					</div>
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
