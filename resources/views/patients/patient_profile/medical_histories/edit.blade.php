@section('modal_open_script')
	<script type="application/javascript">
		$(document).ready(function() {
			$('#editVitalInformation').modal('show');
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
<form action="{{ route('vital_information.update', $vitalInformation_edit->id) }}" method="POST">
@csrf
@method('PUT')
	<div class="modal fade" id="editVitalInformation" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-lg" style="max-width: 1200px">
			<div class="modal-content">
				<div class="modal-header">
		        	<h4 class="modal-title">Edit Vital Information - {{ date('F d, Y h:ia', strtotime($vitalInformation_edit->updated_at)) }}</h4>
		        	<button class="close" type="button" data-toggle="modal" data-target="#closeEditVitalInformation">&times;</button>
		        	{{-- <a class="close" href="{{ route('patients.show', $vitalInformation_edit->patient_id) }}">&times;</a> --}}
		    	</div>
				<div class="modal-body text-left scrollbar-primary">
					<div class="row patient-profile-form grid">
						@foreach ($vitalInformation_edit->result as $result)
							@if ($result->reference->type == 'parent')
								<div class="col-md-4 grid-item">
									<div class="callout callout-light">
										<legend>{{ $result->reference->name }}:</legend>
										<fieldset class="form-group">
											<ul class="children-references">
											@foreach ($result->children as $children)
												@if($children->child->count() == 0 && $children->child_id == null)
													@if($children->reference->type == 'text')
														<li>
															<div class="form-group">
																<label>{{ $children->reference->name }}:</label>
																<input value="{{ $children->result }}" class="form-control" type="text" name="{{ $children->id }}">
															</div>
														</li>
													@elseif($children->reference->type == 'checkbox')
														<li>
															<div class="checkbox">
															    <div class="custom-control custom-checkbox">
																	<input @if($children->result != null){{'checked'}}@endif type="checkbox" class="custom-control-input" name="{{ $children->id }}" value="{{ $children->reference->name }}" id="editVitalInformation_{{ $children->id }}">
																	<label class="custom-control-label" for="editVitalInformation_{{ $children->id }}">{{ $children->reference->name }}</label>
																</div>
															</div>
														</li>
													@elseif($children->reference->type == 'check_textbox')
														<li>
															<div class="form-group">
																<div class="custom-control custom-checkbox">
																	<input @if($children->result != null){{'checked'}}@endif type="checkbox" class="custom-control-input check-textbox" data-id="{{ $children->id }}" name="{{ $children->id }}" value="{{ $children->reference->name }}" id="editVitalInformation_{{ $children->id }}">
																	<label class="custom-control-label" for="editVitalInformation_{{ $children->id }}">{{ $children->reference->name }}</label>
																</div>
																<div class="input-group input-group-sm">
																	<span class="input-group-prepend">
																		<div class="input-group-text">
																			{{ $children->reference->description }}
																		</div>	
																	</span>
																	<input value="{{ $children->sub_result }}" class="form-control form-control-sm check-textbox-input" data-id="{{ $children->id }}" name="input_{{$children->id}}" id="editVitalInformation_input{{ $children->id }}" @if($children->result == null) disabled="" @endif>
																</div>
															</div>
														</li>
													@elseif($children->reference->type == 'textarea')
														<li>
															<div class="form-group">
																<label>{{ $children->reference->name }}:</label>
																<textarea class="form-control" name="{{ $children->id }}">{{ $children->result }}</textarea>
															</div>
														</li>
													@endif
												@elseif($children->child->count())
													<li><label style="font-weight: bold">{{ $children->reference->name }}:</label></li>
													<ul class="child-references" style="list-style-type: circle;">
														@foreach ($children->child as $child)
															@if($child->reference->type == 'text')
																<li>
																	<div class="form-group">
																		<label>{{ $child->reference->name }}:</label>
																		<input value="{{ $child->result }}" class="form-control form-control-sm" type="text" name="{{ $child->id }}">
																	</div>
																</li>
															@elseif($child->reference->type == 'checkbox')
																<li>
																	<div class="checkbox">
																	    <div class="custom-control custom-checkbox">
																			<input @if($child->result != null){{'checked'}}@endif type="checkbox" class="custom-control-input" name="{{ $child->id }}" value="{{ $child->reference->name }}" id="editVitalInformation_{{ $child->id }}">
																			<label class="custom-control-label" for="editVitalInformation_{{ $child->id }}">{{ $child->reference->name }}</label>
																		</div>
																	</div>
																</li>
															@elseif($child->reference->type == 'check_textbox')
																<li>
																	<div class="form-group">
																		<div class="custom-control custom-checkbox">
																			<input @if($child->result != null){{'checked'}}@endif type="checkbox" class="custom-control-input check-textbox" data-id="{{ $child->id }}" name="{{ $child->id }}" value="{{ $child->reference->name }}" id="editVitalInformation_{{ $child->id }}">
																			<label class="custom-control-label" for="editVitalInformation_{{ $child->id }}">{{ $child->reference->name }}</label>
																		</div>
																		<div class="input-group input-group-sm">
																			<span class="input-group-prepend">
																				<div class="input-group-text">
																					{{ $child->reference->description }}
																				</div>	
																			</span>
																			<input value="{{ $child->sub_result }}" class="form-control form-control-sm check-textbox-input" data-id="{{ $child->id }}" name="input_{{$child->id}}" id="editVitalInformation_input{{ $child->id }}" @if($child->result == null) disabled="" @endif>
																		</div>
																	</div>
																</li>
															@elseif($child->reference->type == 'textarea')
																<li>
																	<div class="form-group">
																		<label>{{ $child->reference->name }}:</label>
																		<textarea class="form-control" name="{{ $child->id }}">{{ $child->result }}</textarea>
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
								</div> {{-- ./col-md-4 End of Reference with Children|Child --}}
								{{-- <hr> --}}
							@elseif($result->parent_id == null)
								<div class="col-md-4 grid-item">
									<div class="callout callout-light">
										@if($result->reference->type == 'text')
											<div class="form-group">
												<label>{{ $result->reference->name }}:</label>
												<input value="{{ $result->result }}" class="form-control" type="text" name="{{ $result->id }}">
											</div>
										@elseif($result->reference->type == 'checkbox')
											<div class="form-group">
												<div class="checkbox">
												    <div class="custom-control custom-checkbox">
														<input @if($result->result != null){{'checked'}}@endif type="checkbox" class="custom-control-input" name="{{ $result->id }}" value="{{ $result->reference->name }}" id="editVitalInformation_{{ $result->id }}">
														<label class="custom-control-label" for="editVitalInformation_{{ $result->id }}">{{ $result->reference->name }}</label>
													</div>
												</div>
											</div>
										@elseif($result->reference->type == 'check_textbox')
											<div class="form-group">
												<div class="custom-control custom-checkbox">
													<input @if($result->result != null){{'checked'}}@endif type="checkbox" class="custom-control-input check-textbox" data-id="{{ $result->id }}" name="{{ $result->id }}" value="{{ $result->reference->name }}" id="editVitalInformation_{{ $result->id }}">
													<label class="custom-control-label" for="editVitalInformation_{{ $result->id }}">{{ $result->reference->name }}</label>
												</div>
												<div class="input-group input-group-sm">
													<span class="input-group-prepend">
														<div class="input-group-text">
															{{ $result->reference->description }}
														</div>	
													</span>
													<input value="{{ $result->sub_result }}" class="form-control form-control-sm check-textbox-input" data-id="{{ $result->id }}" name="input_{{$result->id}}" id="editVitalInformation_input{{ $result->id }}" @if($result->result == null) disabled="" @endif>
												</div>
											</div>
										@elseif($result->reference->type == 'textarea')
											<div class="form-group">
												<label>{{ $result->reference->name }}:</label>
												<textarea class="form-control" name="{{ $result->id }}">{{ $result->result }}</textarea>
											</div>
										@endif
									</div>
								</div>
							@endif
						@endforeach
					</div> {{-- End of grid --}}
					<div class="col-md-4">
						<div class="form-group">
							<label>Doctor:</label>
							<select class="form-control select2" name="doctor" style="width: 100%">
								<option></option>
								@foreach ($doctors as $doctor)
									<option @if($vitalInformation_edit->doctor_id == $doctor->id){{'selected'}}@endif value="{{ $doctor->id }}">
										{{ $doctor->employeeName() }}
									</option>
								@endforeach
							</select>
						</div>
					</div>
				</div> {{-- ./modal-body --}}
				<div class="modal-footer">
					<div class="col">
						@if ($vitalInformation_edit->trashed())
	                		@can('vital_information.restore')
						    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('vital_information.restore', $vitalInformation_edit->id) }}"><i class="fad fa-download"></i> Restore</a>
							@endcan
						@else
							@can('vital_information.destroy')
						    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('vital_information.destroy', $vitalInformation_edit->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
							@endcan
						@endif
					</div>
					<div class="col text-right">
						<button class="btn btn-default" type="button" data-toggle="modal" data-target="#closeEditVitalInformation">Cancel</button>
						<button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save</button>
					</div>
				</div> {{-- ./modal-footer --}}
			</div> {{-- ./modal-content --}}
		</div> {{-- ./modal-dialog --}}
	</div> {{-- ./modal --}}
	<div class="modal fade" id="closeEditVitalInformation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						{{-- <a class="btn btn-default" href="{{ route('patients.show', $vitalInformation_edit->patient_id) }}">Discard</a> --}}
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
