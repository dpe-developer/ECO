@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-daygrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-timegrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-bootstrap/main.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <style type="text/css">
        /* html, body {
            overflow: hidden;
        } */
        
        label {
            font-weight: bold;
        }
        .fc-dayGrid-view .fc-body .fc-row {
            min-height: 5em;
        }
        .fc-content:hover {
            cursor: pointer;
        }
        .fc-toolbar.fc-header-toolbar {
            margin-bottom: 0px;
            padding-top: 0px;
            padding-left: 0px;
            padding-right: 0px;
        }
        .fc-button {
            padding: .25rem .5rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .2rem;
        }
        .fc-day.fc-widget-content.fc-today {
            background-color: #007bff4a
        }
        .calendar-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

    </style>
@endsection

@section('content')
<div class="container mt-3">
    <h1 class="heading">&nbsp;Appointment</h1>
    <div class="row justify-content-center mb-5">
        <div class="col">
            <!-- Tabs navs -->
            <ul class="nav nav-tabs mb-3" id="ex-with-icons" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="ex-with-icons-tab-1" data-mdb-toggle="tab" href="#ex-with-icons-tabs-1" role="tab"
                    aria-controls="ex-with-icons-tabs-1" aria-selected="true"><i class="fas fa-calendar fa-fw me-2"></i>Calendar</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex-with-icons-tab-2" data-mdb-toggle="tab" href="#ex-with-icons-tabs-2" role="tab"
                    aria-controls="ex-with-icons-tabs-2" aria-selected="false"><i class="fas fa-clock-rotate-left fa-fw me-2"></i>Appointment History</a>
                </li>
            </ul>
            <!-- Tabs navs -->
            
            <!-- Tabs content -->
            <div class="tab-content" id="ex-with-icons-content">
                <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel" aria-labelledby="ex-with-icons-tab-1">
                    <h4 class="text-danger text-center">Click a date on calendar to set an appointment.</h4>
                    <div id="calendar"></div>
                </div>
                <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2">
                    <table class="table table-bordered table-hover" id="appointmentsDatatable">
                        <thead>
                            <tr>
                                <th>Date of Appointment</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Doctor</th>
                                <th>Description</th>
                                @hasrole('System Administrator')
                                <th class="text-center">Action</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($appointments as $appointment)
                            <tr
                                data-toggle="modal-ajax" 
                                data-href="{{ route('patient_appointments.show', $appointment->id) }}" 
                                data-target="#showAppointmentModal" 
                            >
                                <td data-order="{{ Carbon::parse($appointment->appointment_date) }}">
                                    {{ Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                </td>
                                <td>{{ date('h:ia', strtotime($appointment->appointment_date)) }}</td>
                                <td>
                                    @if ($appointment->status != 'done' && $appointment->appointment_date < today())
                                        <span class="badge badge-danger">Due</span>
                                    @endif
                                    {!! $appointment->statusBadge() !!}
                                </td>
                                <td>
                                    {{ $appointment->doctor->fullname('f-m-l') }}
                                </td>
                                <td>{{ $appointment->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Tabs content -->
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- <script src="{{ asset('website/plugins/moment/moment-with-locales.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('website/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js') }}"></script> --}}
    <script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar-daygrid/main.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar-timegrid/main.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar-interaction/main.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar-bootstrap/main.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function () {
            /* $(document).on('click', '[data-dismiss="modal-ajax"]', function() {
                // closeAllModals()
                $('.modal').modal('hide')
                $('.modal-backdrop').fadeOut(250, function() {
                    $('.modal-backdrop').remove()
                })
                $('body').removeClass('modal-open').css('padding-right', '0px');
                $('#modalAjax').html('')
                // removeLocationHash()
            }) */
            /**
             * Initialize calendar
             */
            var Calendar = FullCalendar.Calendar;
            var calendarEl = document.getElementById('calendar');
            var calendar = new Calendar(calendarEl, {
                plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
                defaultView: 'dayGridMonth',
                height: 'parent',
                header    : {
                    left  : 'title',
                    // center: 'dayGridMonth,timeGridWeek,timeGridDay',
                    // right : 'prev,next today'
                    right : 'prev,next today, dayGridMonth,timeGridWeek,timeGridDay'
                },
                eventLimit: true, // allow "more" link when too many events
                views: {
                    dayGrid : {
                        eventLimit: 18
                    },
                    timeGrid: {
                        eventLimit: 18 // adjust to 6 only for timeGridWeek/timeGridDay
                    },
                },
                minTime: '09:00:00',
                maxTime: '17:30:00',
                dateClick: function(info) {
                    var d = new Date();
                    dateNow = d.getFullYear()+'/'+(d.getMonth()+1)+'/'+d.getDate();
                    if(new Date(info.dateStr) >= new Date(dateNow))
                    $.ajax({
                        type: 'GET',
                        url: '{{ route("patient_appointments.create") }}',
                        data: {
                            appointment_date: info.dateStr
                        },
                        success: function(data){
                            $('.modal-backdrop').remove();
                            $('#modalAjax').html(data.modal_content);
                            $('.select2').select2();
                            // reloadStylesheets();
                            // reloadScripts();
                            $('#modalAjax').find('.close').html('').addClass('btn-close');
                            $('#createAppointment').modal('show');
                            // $('#loader').hide();
                        },
                        error: function(xhr, ajaxOptions, thrownError){
                            ajax_error(xhr, ajaxOptions, thrownError)
                            // removeLocationHash()
                            $('#loader').hide();
                        }
                    })
                    // change the day's background color just for fun
                    // info.dayEl.style.backgroundColor = 'red';
                },
                eventClick: function(info) {
                    var eventObj = info.event;
                    // $('#showbooking').modal('show');
                    // $('#bookingDetails').load(eventObj.extendedProps.dataHref);
                    // $('#formAction').attr('action', eventObj.extendedProps.formAction);
                    $('#loader').show();
                    var href = eventObj.extendedProps.dataHref;
                    var target = eventObj.extendedProps.dataTarget;
                    /* var data = {};
                    if($(this).data('form') != null){
                        var form = $(this).data('form').split(';');
                        for (var i = 0; i < form.length; i++) {
                            var form_data = form[i].split(':');
                            for(var j = 1; j < form_data.length; j++){
                                data[form_data[j-1]] = form_data[j];
                            }
                        }
                    } */
                    $.ajax({
                        type: 'GET',
                        url: href,
                        // data: data,
                        success: function(data){
                            $('.modal-backdrop').remove()
                            $('#modalAjax').html(data.modal_content)
                            $(target).modal('show')
                            // $('#loader').hide();
                        },
                        error: function(xhr, ajaxOptions, thrownError){
                            ajax_error(xhr, ajaxOptions, thrownError)
                            removeLocationHash()
                            // $('#loader').hide();
                        }
                    })
                },
                eventTimeFormat: {
                    hour           : 'numeric',
                    minute         : '2-digit',
                    meridiem       : 'short',
                },
                events: [
                @foreach ($appointments as $appointment)
                    {
                        title          : '- {{ $appointment->status }}',
                        description    : 'description for All Day Event',
                        start          : '{{ $appointment->appointment_date }}',
                        end            : '{{ Carbon::parse($appointment->appointment_date)->addMinutes(30) }}',
                        dataTarget     : '#showAppointmentModal',
                        dataHref       : '{{ route("patient_appointments.show", $appointment->id) }}',
                        formAction     : '{{ route("patient_appointments.update", $appointment->id) }}',
                        allDay         : false,
                        @if($appointment->status == 'pending')
                        backgroundColor: '#ffc107', //color: warning
                        borderColor    : '#ffc107', //color: warning
                        @elseif($appointment->status == 'confirmed')
                        backgroundColor: '#007bff', //color: primary
                        borderColor    : '#007bff', //color: primary
                        textColor      : '#fff',
                        @elseif($appointment->status == 'done')
                        backgroundColor: '#28a745', //color: success
                        borderColor    : '#28a745', //color: success
                        textColor      : '#fff',
                        @elseif($appointment->status == 'canceled' || $appointment->status == 'expired' || $appointment->status == 'declined')
                        backgroundColor: '#dc3545', //color: danger
                        borderColor    : '#dc3545', //color: danger
                        textColor      : '#fff',
                        @endif
                    },
                @endforeach
                ]
                // editable  : true,
            });
            calendar.render();
            // $('#calendar').fullCalendar()
        });
    </script>
    {{-- <script type="application/javascript">
        $(document).ready(function () {
            $('#appointmentsDatatable').DataTable({
                order: [[0, 'desc']],
                // columnDefs : [{"targets": 0, "type":"date"}],
            });
        });
    </script> --}}
@endsection
