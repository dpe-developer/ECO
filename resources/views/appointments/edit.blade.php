<form action="{{ route('appointments.update', $appointment->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editAppointmentModal" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            {{-- <strong class="text-danger">Business hours is from 8:00AM to 5:00PM</strong> --}}
                            <div class="form-group">
                                <label for="patiient">Patient <strong class="text-danger">*</strong></label>
                                <select class="form-control select2" name="patient" id="patiient" required>
                                    <option></option>
                                    @foreach ($patients as $patient)
                                        <option @if($appointment->patient_id == $patient->id) selected @endif value="{{ $patient->id }}">{{ $patient->fullname() }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="appointmentDate">Appointment Date <strong class="text-danger">*</strong></label>
                                <input type="date" class="form-control" name="appointment_date" id="appointmentDate" min="{{ Carbon::now()->format('Y-m-d') }}" value="{{ Carbon::parse($appointment->appointment_date)->format('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="appointmentTime">Appointment Time <strong class="text-danger">*</strong></label>
                                <select name="appointment_time" id="appointmentTime" class="form-control" required>
                                    <option></option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('09:00')->format('H:i:s')) selected @endif disabled value="09:00">9:00am</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('09:30')->format('H:i:s')) selected @endif disabled value="09:30">9:30am</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('10:00')->format('H:i:s')) selected @endif disabled value="10:00">10:00am</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('10:30')->format('H:i:s')) selected @endif disabled value="10:30">10:30am</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('11:00')->format('H:i:s')) selected @endif disabled value="11:00">11:00am</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('11:30')->format('H:i:s')) selected @endif disabled value="11:30">11:30am</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('12:00')->format('H:i:s')) selected @endif disabled value="12:00">12:00pm</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('12:30')->format('H:i:s')) selected @endif disabled value="12:30">12:30pm</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('13:00')->format('H:i:s')) selected @endif disabled value="13:00">1:00pm</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('13:30')->format('H:i:s')) selected @endif disabled value="13:30">1:30pm</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('14:00')->format('H:i:s')) selected @endif disabled value="14:00">2:00pm</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('14:30')->format('H:i:s')) selected @endif disabled value="14:30">2:30pm</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('15:00')->format('H:i:s')) selected @endif disabled value="15:00">3:00pm</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('15:30')->format('H:i:s')) selected @endif disabled value="15:30">3:30pm</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('16:00')->format('H:i:s')) selected @endif disabled value="16:00">4:00pm</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('16:30')->format('H:i:s')) selected @endif disabled value="16:30">4:30pm</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('17:00')->format('H:i:s')) selected @endif disabled value="17:00">5:00pm</option>
                                    <option class="text-danger" @if(Carbon::parse($appointment->appointment_date)->format('H:i:s') == Carbon::parse('17:30')->format('H:i:s')) selected @endif disabled value="17:30">5:30pm</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="doctor">Doctor <strong class="text-danger">*</strong></label>
                                <select name="doctor" id="doctor" class="form-control select2" required style="width: 100%">
                                    <option></option>
                                    @foreach ($doctors as $doctor)
                                        <option @if($appointment->doctor_id == $doctor->id) selected @endif value="{{ $doctor->id }}">{{ $doctor->fullname('f-m-l') }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="service">Service <strong class="text-danger">*</strong></label>
                                <select name="service" id="service" class="form-control select2" required style="width: 100%">
                                    <option></option>
                                    @foreach ($services as $service)
                                        <option @if($appointment->service_id == $service->id) selected @endif value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="3" class="form-control">{{ $appointment->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-dismiss="modal-ajax"><i class="fa fa-times"></i>Cancel</button>
                    <button class="btn bg-gradient-success" type="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function(){
        getAvailableAppointmentTime($('#appointmentDate'));

        $('#appointmentDate').on('change', function(){
            getAvailableAppointmentTime($(this))
        });

        function getAvailableAppointmentTime(appointmentDateInput)
        {
            let getUrl = window.location;
            let baseUrl = getUrl .protocol + "//" + getUrl.host;
            let dt = new Date();
            let datetimeNow = dt.getFullYear() + '-' + dt.getMonth() + '-' + dt.getDate() + ' ' + dt.getHours() + ":" + dt.getMinutes() + ":00";
            $('#appointmentTime').find('option').each(function(){
                $(this).prop('disabled', false).removeClass('text-danger');
            });
            let appointmentDate = appointmentDateInput.val();
            let appointmentTime = $('#appointmentTime').val();
            $.ajax({
                type: 'GET',
                url: baseUrl + '/appointment/get-time-taken',
                data: {
                    appointment_date: appointmentDate,
                    appointment_time: appointmentTime,
                    request_for: 'edit'
                },
                success: function(response){
                    $('#appointmentTime').find('option').each(function(){
                        var time = $(this).attr('value');
                        var appointmentDateTime = appointmentDate + ' ' + time;
                        if($.inArray(time, response.timeTaken) !== -1 || (new Date(datetimeNow) > new Date(appointmentDateTime))){
                            $(this).prop('disabled', true).addClass('text-danger');
                        }
                    });
                }
            });
        }
    });
</script>