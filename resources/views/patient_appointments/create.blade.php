<form action="{{ route('patient_appointments.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="createAppointment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            {{-- <strong class="text-danger">Business hours is from 8:00AM to 5:00PM</strong> --}}
                            <div class="form-group">
                                <label for="appointmentDate">Appointment Date <strong class="text-danger">*</strong></label>
                                <input type="date" class="form-control" name="appointment_date" id="appointmentDate" value="{{ $appointmentDate }}" required readonly>
                            </div>
                            <div class="form-group">
                                <label for="appointmentTime">Appointment Time <strong class="text-danger">*</strong></label>
                                <select name="appointment_time" id="appointmentTime" class="form-control" required>
                                    <option></option>
                                    <option @if(in_array('09:00', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 09:00:00')) class="text-danger" disabled @endif value="9:00">9:00am</option>
                                    <option @if(in_array('09:30', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 09:30:00')) class="text-danger" disabled @endif value="9:30">9:30am</option>
                                    <option @if(in_array('10:00', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 10:00:00')) class="text-danger" disabled @endif value="10:00">10:00am</option>
                                    <option @if(in_array('10:30', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 10:30:00')) class="text-danger" disabled @endif value="10:30">10:30am</option>
                                    <option @if(in_array('11:00', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 11:00:00')) class="text-danger" disabled @endif value="11:00">11:00am</option>
                                    <option @if(in_array('11:30', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 11:30:00')) class="text-danger" disabled @endif value="11:30">11:30am</option>
                                    <option @if(in_array('12:00', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 12:00:00')) class="text-danger" disabled @endif value="12:00">12:00pm</option>
                                    <option @if(in_array('12:30', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 12:30:00')) class="text-danger" disabled @endif value="12:30">12:30pm</option>
                                    <option @if(in_array('13:00', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 13:00:00')) class="text-danger" disabled @endif value="13:00">1:00pm</option>
                                    <option @if(in_array('13:30', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 13:30:00')) class="text-danger" disabled @endif value="13:30">1:30pm</option>
                                    <option @if(in_array('14:00', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 14:00:00')) class="text-danger" disabled @endif value="14:00">2:00pm</option>
                                    <option @if(in_array('14:30', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 14:30:00')) class="text-danger" disabled @endif value="14:30">2:30pm</option>
                                    <option @if(in_array('15:00', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 15:00:00')) class="text-danger" disabled @endif value="15:00">3:00pm</option>
                                    <option @if(in_array('15:30', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 15:30:00')) class="text-danger" disabled @endif value="15:30">3:30pm</option>
                                    <option @if(in_array('16:00', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 16:00:00')) class="text-danger" disabled @endif value="16:00">4:00pm</option>
                                    <option @if(in_array('16:30', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 16:30:00')) class="text-danger" disabled @endif value="16:30">4:30pm</option>
                                    <option @if(in_array('17:00', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 17:00:00')) class="text-danger" disabled @endif value="17:00">5:00pm</option>
                                    <option @if(in_array('17:30', $timeTaken) || Carbon::now() > Carbon::parse($appointmentDate.' 17:30:00')) class="text-danger" disabled @endif value="17:30">5:30pm</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="doctor">Doctor <strong class="text-danger">*</strong></label>
                                <select name="doctor" id="doctor" class="form-control" required style="width: 100%">
                                    <option></option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->fullname('f-m-l') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="service">Service <strong class="text-danger">*</strong></label>
                                <select name="service" id="service" class="form-control" required style="width: 100%">
                                    <option></option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- <script>
    $(function(){
        $('#appointmentDate').daterangepicker({
            // timePicker: true,
            startDate: '{{ $date_from }}',
            endDate: '{{ $date_to }}',
            minDate: "{{ date('Y/m/d h:i A') }}",
            // endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'Y/M/DD'
            }
        });

        $('.drp-calendar .right').find('.calendar-time').fadeOut();
    })
</script> --}}