<form action="{{ route('patient_visits.update', $patientVisit_edit->id) }}" method="POST" autocomplete="off">
@csrf
@method('PUT')
	<div class="modal fade" id="editPatientVisit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg{{-- modal-dialog-scrollable --}}">
			<div class="modal-content">
				<div class="modal-header">
		          <h4 class="modal-title">Edit Visit</h4>
		          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		    	</div>
				<div class="modal-body text-left">
					<input type="text" name="patient" hidden value="{{ $patient->id }}">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Visit Type:</label>
								<select class="form-control select2" name="visit_type" id="visitType" style="width: 100%">
									<option></option>
									<option @if($patientVisit_edit->visit_type == 'admission'){{'selected'}}@endif value="admission">Admission</option>
									<option @if($patientVisit_edit->visit_type == 'clinic'){{'selected'}}@endif value="clinic">Clinic</option>
									<option @if($patientVisit_edit->visit_type == 'follow-up'){{'selected'}}@endif value="follow-up">Follow-up</option>
									<option @if($patientVisit_edit->visit_type == 'pathology'){{'selected'}}@endif value="pathology">Pathology</option>
									<option @if($patientVisit_edit->visit_type == 'radiology'){{'selected'}}@endif value="radiology">Radiology</option>
								</select>
							</div>
							<div class="form-group">
								<label>Admitting Doctor:</label>
								<select class="form-control select2" name="admitting_doctor" style="width: 100%">
									<option></option>
									@foreach ($doctors as $doctor)
										<option @if($patientVisit_edit->doctor_id == $doctor->id){{'selected'}}@endif value="{{ $doctor->id }}">
											{{ $doctor->employeeName() }}
										</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
								<label>Reason for Visit:</label>
								<textarea class="form-control" name="reason_for_visit">{{ $patientVisit_edit->reason_for_visit }}</textarea>
							</div>
						</div>
						<div class="col-sm-6">
				            <div class="form-group">
				            	<label>Admission/Visit Date:</label>
				                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
				                    <input type="text" name="admission_date" data-target="#datetimepicker1" data-toggle="datetimepicker" value="{{ date('m/d/Y h:i A', strtotime($patientVisit_edit->admission_date)) }}" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
				                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
				                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
				                    </div>
				                </div>
				            </div>
				            <div id="bedOptions" style="display: none">
					            <div class="form-group">
					            	<label>Bed Group:</label><strong class="text-danger text-lg"> *</strong>
					            	<select class="form-control bed-group-select2" name="bed_group" id="bedGroup" style="width: 100%">
					            		<option></option>
					            	</select>
					            </div>
					            <div class="form-group">
					            	<label>Bed:</label><strong class="text-danger text-lg"> *</strong>
					            	<select class="form-control bed-select2" name="bed" id="bed" style="width: 100%">
					            		<option></option>
					            	</select>
					            </div>
					            <div class="form-group">
					            	<label>Bed Charge:</label>
					            	<input class="form-control" type="text" id="bedCharge" readonly="">
					            </div>
					        </div>
				        </div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#closeEditPatientVisit"><i class="fa fa-times"></i> Cancel</button>
					<button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="closeEditPatientVisit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
						<button type="button" class="btn btn-default" data-dismiss="modal-ajax"><i class="fa fa-times"></i> Cancel</button>
						<button class="btn btn-default text-success" type="submit"><i class="fad fa-save"></i> Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script type="application/javascript">
	$(function () {

	    $('.bed-group-select2').select2({
            placeholder: 'Select',
            ajax: {
                url: '{{ url('bed_group_select2') }}',
                dataType: 'json',
                // delay: 250,
                data: function(params) {
                    var query = {
                        search: params.term,
                        floor_id: $('#bedFloorSelect').val()
                    }
                    return query;
                },
                processResults: function (data) {
                    return {
                        // results: data.name
                        results:  $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });

        $('.bed-select2').select2({
            placeholder: 'Select',
            ajax: {
                url: '{{ url('bed_select2') }}',
                dataType: 'json',
                // delay: 250,
                data: function(params) {
                    var query = {
                        search: params.term,
                        bed_group_id: $('.bed-group-select2').val()
                    }
                    return query;
                },
                processResults: function (data) {
                    return {
                        // results: data.name
                        results:  $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });

        $('.bed-select2').on('change', function(){
        	$.ajax({
	            type: 'GET',
	            url: '{{ url('bed_get_charge_amount') }}',
	            data: {
	            	bed_id : $(this).val()
	            },
	            success: function(data){
	                $('#bedCharge').val(data.bed_charge);
	            },
	            error: function(xhr, ajaxOptions, thrownError){
	                ajax_error(xhr, ajaxOptions, thrownError)
	            }
	        })
        })

	  	$('#datetimepicker1').datetimepicker({
    		// date: new Date(),
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

	  	$('#visitType').on('change', function(){
	  		var visitType = $(this).val();
	  		if(visitType == 'admission'){
	  			$('#bedOptions').show();
	  			// get_bed();
	  		}else{
           	    $('#bedOptions').hide();
           	    // $('#bedGroup').val('').trigger('change');
           	    // $('#bed').val('').trigger('change');
	  		}
	  	});

	  	/*$('#bedGroup').on('change', function(){
	  		$.ajax({
           	    type:'POST',
           	    url:'{{ route('beds.filter_beds') }}',
           	    data: {
           	    	bed_group_id: $(this).val(),
           	    },
           	    success:function(data){
           	        $('#bed').html(data.html);
           	    },
           	    error:function (data){
           	        Swal.fire({
           	            // position: 'top-end',
           	            type: 'error',
           	            title: 'error',
           	            showConfirmButton: false,
           	            timer: 2000,
           	            toast: true
           	        });
           	    }
           	});
	  	});

	  	function get_bed(){
	  		$.ajax({
           	    type:'GET',
           	    url:'{{ route('beds.get_options') }}',
           	    success:function(data){
           	    	$('#bedOptions').show();
           	        $('#bedGroup').html(data.html);
           	    },
           	    error:function (data){
           	        Swal.fire({
           	            // position: 'top-end',
           	            type: 'error',
           	            title: 'error',
           	            showConfirmButton: false,
           	            timer: 2000,
           	            toast: true
           	        });
           	    }
           	});
	  	}*/
	});
</script>
