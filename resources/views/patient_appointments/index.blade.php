@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-daygrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-timegrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-bootstrap/main.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <style type="text/css">
        /* html, body {
            overflow: hidden;
        } */
        label {
            font-weight: bold;
        }
        .fc-content:hover {
            cursor: pointer;
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
        .fc-header-toolbar {
            /*
            the calendar will be butting up against the edges,
            but let's scoot in the header's buttons
            */
            padding-top: 1em;
            padding-left: 1em;
            padding-right: 1em;
        }
        /*.fc-toolbar.fc-header-toolbar {
            margin-bottom: 0;
        }*/
        /* .calendar-container {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
          } */

    </style>
@endsection

@section('content')
<div class="container mt-3">
    <h1 class="heading">&nbsp;Appointment</h1>
    <div class="row justify-content-center mb-5">
        <div class="col-md-12">
            <div id="calendar"></div>
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
                    right : 'prev,next today'
                },
                eventLimit: true, // allow "more" link when too many events
                views: {
                    timeGrid: {
                        eventLimit: 6 // adjust to 6 only for timeGridWeek/timeGridDay
                    },
                },
                selectable: true,
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
                    
                    // alert('Clicked ' + eventObj.extendedProps.toggle);
                },
                /*eventRender: function(info) {
                    var tooltip = new Tooltip(info.el, {
                      title: info.event.extendedProps.description,
                      placement: 'top',
                      trigger: 'hover',
                      container: 'body'
                    });
                },*/
                /*eventRender: function (event, element) {
                    var tooltip = event.Description;
                    $(element).attr("data-original-title", tooltip);
                    $(element).tooltip({
                         container: "body"
                     })
                },*/
                /* eventTimeFormat: {
                    hour           : 'numeric',
                    minute         : '2-digit',
                    meridiem       : 'short',
                }, */
                displayEventTime: false,
                events: [
                @foreach ($appointments as $appointment)
                    {
                        @if($appointment->user_id == Auth::user()->id)
                        title          : '{{ $appointment->patient->last_name }}, {{ $appointment->patient->first_name }}',
                        @else
                        title          : '{{ Carbon::parse($appointment->appointment_date)->format("h-i-a") }}',
                        @endif
                        description    : 'description for All Day Event',
                        start          : '{{ $appointment->appointment_date }}',
                        // end            : '{{ date("Y-m-d", strtotime($appointment->booking_date_to)) }} 24:00:00',
                        dataTarget     : '#showAppointmentModal',
                        dataHref       : '{{ route("appointments.show", $appointment->id) }}',
                        formAction     : '{{ route("appointments.update", $appointment->id) }}',
                        allDay         : true,
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
@endsection