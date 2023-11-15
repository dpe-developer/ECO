{{-- @extends('layouts.app') --}}
@extends('adminlte.app')
@section('style')
    @if(request()->get('view') == 'calendar')
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-daygrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-timegrid/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar-bootstrap/main.min.css') }}">
    <style>
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
    @endif
@endsection
@section('content')
{{-- @isset ($appointment_edit->id)
    @include('appointments.edit');
@endisset --}}
{{-- Content Wrapper. Contains page content --}}
<div class="content-wrapper">
    {{-- Content Header (Page header) --}}
    <div class="content-header {{ request()->get('filter') ? 'pb-1' : '' }}">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Appointments</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#filterAppointments"><i class="fa fa-search"></i> Search</button>
                    @if(request()->get('view') == 'calendar')
                        <a class="btn btn-default text-primary" href="{{ route('appointments.index', ['view' => 'table']) }}">Table View</a>
                    @else
                        <a class="btn btn-default text-primary" href="{{ route('appointments.index', ['view' => 'calendar']) }}">Calendar View</a>
                    @endif
                    @can('appointments.create')
                        <button class="btn btn-default text-primary" data-toggle="modal-ajax" data-href="{{ route('appointments.create') }}" data-target="#createAppointmentModal"><i class="fa fa-plus"></i> {{ trans('crud.create') }} Appointment</button>
                    @endcan
                </div>
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.container-fluid --}}
    </div>
    {{-- /.content-header --}}
    {{-- Main content --}}
    <div class="content">
        <div class="container-fluid">
            @php
                $isFiltered = false;
                foreach (request()->all() as $name => $value){
                    if($name != 'filter' && $name != 'view' && $value != null){
                        $isFiltered = true;
                    }
                }
            @endphp
            @if($isFiltered)
            <div class="row">
                <div class="col">
                    <div class="callout callout-info pt-1 pb-1">
                        <legend>Filter</legend>
                        {{-- @foreach (request()->all() as $name => $value)
                            @if($name != "filter" && $value != null && $name != "filter_date_option")
                                <label>{{ str_replace("filter appointment ", "", str_replace("_", " ", $name)) }}: </label>
                                @if (is_array($value))
                                    @foreach ($value as $arrayValue)
                                        {{ $arrayValue }}{{ !$loop->last ? ", " : "" }}
                                    @endforeach
                                @else
                                    {{ $value }}
                                @endif                                
                                {!! !$loop->last ? "<br>" : "" !!}
                            @endif
                        @endforeach --}}
                        @if (request()->get('filter_patient'))
                            <label>Patient:</label>
                            @foreach (request()->get('filter_patient') as $patient)
                                {{ User::getName($patient) }}{{ !$loop->last ? ", " : "" }}
                            @endforeach
                            <br>
                        @endif
                        @if (request()->get('filter_doctor'))
                            <label>Doctor:</label>
                            @foreach (request()->get('filter_doctor') as $doctor)
                                {{ User::getName($doctor) }}{{ !$loop->last ? ", " : "" }}
                            @endforeach
                            <br>
                        @endif
                        @if (request()->get('filter_date_option'))
                            <label>Date:</label>
                            @switch(request()->get('filter_date_option'))
                                @case('range')
                                    {{ date('M d, Y h:iA', strtotime(request()->get('filter_appointment_date_from'))) }}-{{ date('M d, Y h:iA', strtotime(request()->get('filter_appointment_date_to'))) }}
                                    @break
                                @default
                                    {{ request()->get('filter_date_option') }}
                                    @if($dateRange['dateFrom'] != null && $dateRange['dateTo'] != null)
                                    ({{ date('M d, Y', strtotime($dateRange['dateFrom'])) }}-
                                    {{ date('M d, Y', strtotime($dateRange['dateTo'])) }})
                                    @endif
                            @endswitch
                            <br>
                        @endif
                        @if (request()->get('filter_appointment_status'))
                            <label>Status:</label>
                            @foreach (request()->get('filter_appointment_status') as $appointmentStatus)
                                {{ Appointment::getStatus($appointmentStatus) }}{{ !$loop->last ? ", " : "" }}
                            @endforeach
                            <br>
                        @endif

                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col">
                    @if(request()->get('view') == 'calendar')
                    <div id="appointmentCalendar"></div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-sm" id="appointmentsDatatable">
                            <thead>
                                <tr>
                                    <th>Date of Appointment</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Patient ID</th>
                                    <th>Patient Name</th>
                                    <th>Doctor</th>
									<th>Description</th>
									<th>Date Added</th>
                                </tr>
                            </thead>
                            <tbody>
								@foreach ($appointments as $appointment)
                                <tr 
                                    @can('appointments.show') 
                                        data-toggle="modal-ajax" 
                                        data-href="{{ route('appointments.show', $appointment->id) }}" 
                                        data-target="#showAppointmentModal" 
                                    @endcan
                                >
									<td data-order="{{ Carbon::parse($appointment->appointment_date) }}">
                                        {{ Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                        @if(UserNotification::isNotSeen('appointment', $appointment->id))
                                        <span class="right badge badge-danger">new</span>
                                        @endif
                                    </td>
									<td>{{ date('h:ia', strtotime($appointment->appointment_date)) }}</td>
									<td>
                                        @if ($appointment->status != 3 && $appointment->appointment_date < today())
                                            <span class="badge badge-danger">Due</span>
                                        @endif
                                        {!! $appointment->statusBadge() !!}
									</td>
									<td>{{ $appointment->patient->username }}</td>
									<td>
										{!! $appointment->patient->fullname() !!}
									</td>
									<td>
										{!! $appointment->doctor->fullname() !!}
									</td>
									<td>{{ $appointment->description }}</td>
                                    <td data-order="{{ Carbon::parse($appointment->created_at) }}">
                                        {{ Carbon::parse($appointment->created_at)->format('M d, Y h:ia') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <span class="justify-content-center row">{!! $appointments->links() !!}</span> --}}
                    @endif
                </div>
            </div>
            {{-- /.row --}}
        </div>
        {{-- /.container-fluid --}}
    </div>
    {{-- @can('appointments.create')
    @include('appointments.create')
    @endcan --}}
    {{-- /.content --}}
</div>
{{-- /.content-wrapper --}}
<div class="modal fade" id="filterAppointments" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('appointments.index') }}" action="GET" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" name="filter" value="1">
                    <div class="form-group">
                        <label>Patient:</label>
                        <select name="filter_patient[]" class="form-control select2" multiple>
                            {{-- <option></option> --}}
                            @foreach ($patients as $patient)
                            <option @if(request()->get('filter_patient')) {{ in_array($patient->id, request()->get('filter_patient')) ? 'selected' : '' }} @endif value="{{ $patient->id }}">
                                {{ $patient->fullname('f-m-l') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Doctor:</label>
                        <select name="filter_doctor[]" class="form-control select2" multiple>
                            {{-- <option></option> --}}
                            @foreach ($doctors as $doctor)
                            <option @if(request()->get('filter_doctor')) {{ in_array($doctor->id, request()->get('filter_doctor')) ? 'selected' : '' }} @endif value="{{ $doctor->id }}">
                                {{ $doctor->fullname('f-m-l') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Appointment Date:</label>
                        <select class="form-control select2" name="filter_date_option" id="dateOption">
                            <option></option>
                            <option {{ request()->get('filter_date_option') ==  'today' ? 'selected' : '' }} value="today">Today</option>
                            <option {{ request()->get('filter_date_option') ==  'yesterday' ? 'selected' : '' }} value="yesterday">Yesterday</option>
                            <option {{ request()->get('filter_date_option') ==  'this week' ? 'selected' : '' }} value="this week">This Week</option>
                            <option {{ request()->get('filter_date_option') ==  'last week' ? 'selected' : '' }} value="last week">Last Week</option>
                            <option {{ request()->get('filter_date_option') ==  'this month' ? 'selected' : '' }} value="this month">This Month</option>
                            <option {{ request()->get('filter_date_option') ==  'last month' ? 'selected' : '' }} value="last month">Last Month</option>
                            <option {{ request()->get('filter_date_option') ==  'range' ? 'selected' : '' }} value="range">Range</option>
                        </select>
                        <div class="row date-range d-none">
                            <div class="col-sm-6">
                                <div class="input-group input-group-compact datetimepicker" id="dateFrom" data-target-input="nearest">
                                    <div class="input-group-prepend" data-target="#dateFrom" data-toggle="datetimepicker">
                                        <span class="input-group-text">
                                            From
                                        </span>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" data-target="#dateFrom" data-toggle="datetimepicker" name="filter_appointment_date_from" value="{{ request()->get('filter_appointment_date_from') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group input-group-compact datetimepicker" id="dateTo" data-target-input="nearest">
                                    <div class="input-group-prepend" data-target="#dateTo" data-toggle="datetimepicker">
                                        <span class="input-group-text">
                                            To
                                        </span>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" data-target="#dateTo" data-toggle="datetimepicker" name="filter_appointment_date_to" value="{{ request()->get('filter_appointment_date_to') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status:</label>
                        <div class="checkbox">
                            <div class="custom-control custom-checkbox">
                                <input @if(request()->get('filter_appointment_status')) {{ in_array('pending', request()->get('filter_appointment_status')) ? 'checked' : '' }} @endif type="checkbox" class="custom-control-input" name="filter_appointment_status[]" value="pending" id="filterInventoryStatusPending">
                                <label class="custom-control-label" for="filterInventoryStatusPending">Pending</label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <div class="custom-control custom-checkbox">
                                <input @if(request()->get('filter_appointment_status')) {{ in_array('confirmed', request()->get('filter_appointment_status')) ? 'checked' : '' }} @endif type="checkbox" class="custom-control-input" name="filter_appointment_status[]" value="confirmed" id="filterInventoryStatusConfirmed">
                                <label class="custom-control-label" for="filterInventoryStatusConfirmed">Confirmed</label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <div class="custom-control custom-checkbox">
                                <input @if(request()->get('filter_appointment_status')) {{ in_array('done', request()->get('filter_appointment_status')) ? 'checked' : '' }} @endif type="checkbox" class="custom-control-input" name="filter_appointment_status[]" value="done" id="filterInventoryStatusDone">
                                <label class="custom-control-label" for="filterInventoryStatusDone">Done</label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <div class="custom-control custom-checkbox">
                                <input @if(request()->get('filter_appointment_status')) {{ in_array('canceled', request()->get('filter_appointment_status')) ? 'checked' : '' }} @endif type="checkbox" class="custom-control-input" name="filter_appointment_status[]" value="canceled" id="filterInventoryStatusCanceled">
                                <label class="custom-control-label" for="filterInventoryStatusCanceled">Canceled</label>
                            </div>
                        </div>
                        <div class="checkbox">
                            <div class="custom-control custom-checkbox">
                                <input @if(request()->get('filter_appointment_status')) {{ in_array('declined', request()->get('filter_appointment_status')) ? 'checked' : '' }} @endif type="checkbox" class="custom-control-input" name="filter_appointment_status[]" value="declined" id="filterInventoryStatusDeclined">
                                <label class="custom-control-label" for="filterInventoryStatusDeclined">Declined</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if (request()->get('filter'))
                    <a href="{{ route('appointments.index') }}" class="btn btn-default">Reset</a>
                    @endif
                    <button type="submit" class="btn btn-default text-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    @yield('modal_open_script')
    <script type="application/javascript">
        $(document).ready(function () {
            $('#appointmentsDatatable').DataTable({
                order: [[0, 'desc']],
                // columnDefs : [{"targets": 0, "type":"date"}],
            });
        });
        $(function () {
            // $('#filterAppointments').modal('show')
            $('#dateOption').on('change', function(){
                changeDateOption($(this));
            });
        });
        changeDateOption($('#dateOption'));
        function changeDateOption(dateOption){
            if($('#dateOption').val() == 'range'){
                $('.date-range').removeClass('d-none');
            }else{
                $('.date-range').addClass('d-none');
            }
        }
    </script>
    @if(request()->get('view') == 'calendar')
    <script src="{{ asset('plugins/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar-daygrid/main.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar-timegrid/main.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar-interaction/main.min.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar-bootstrap/main.min.js') }}"></script>
    {{-- Initialize Calendat --}}
    <script>
        var Calendar = FullCalendar.Calendar;
        var calendarEl = document.getElementById('appointmentCalendar');
        var calendar = new Calendar(calendarEl, {
            plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
            // defaultView: 'dayGridMonth',
            defaultView: 'timeGrid',
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
            eventClick: function(info) {
                var eventObj = info.event;
                $('#loader').show();
                var href = eventObj.extendedProps.dataHref;
                var target = eventObj.extendedProps.dataTarget;
                $.ajax({
                    type: 'GET',
                    url: href,
                    // data: data,
                    success: function(data){
                        $('.modal-backdrop').remove()
                        $('#modalAjax').html(data.modal_content)
                        $(target).modal('show')
                        $('#loader').hide();
                    },
                    error: function(xhr, ajaxOptions, thrownError){
                        ajax_error(xhr, ajaxOptions, thrownError)
                        // removeLocationHash()
                        $('#loader').hide();
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
                    title          : '{{ $appointment->patient->last_name }}, {{ $appointment->patient->first_name }}',
                    description    : 'description for All Day Event',
                    start          : '{{ $appointment->appointment_date }}',
                    end            : '{{ Carbon::parse($appointment->appointment_date)->addMinutes(30) }}',
                    dataTarget     : '#showAppointmentModal',
                    dataHref       : '{{ route('appointments.show', $appointment->id) }}',
                    formAction     : '{{ route('appointments.update', $appointment->id) }}',
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
                    @elseif($appointment->status == 'canceled' || $appointment->status == 'declined')
                    backgroundColor: '#dc3545', //color: danger
                    borderColor    : '#dc3545', //color: danger
                    textColor      : '#fff',
                    @endif
                },
            @endforeach
            ],
            dateClick: function(info) {
                // Handle the date click event
                calendar.changeView('timeGridDay', info.dateStr); // Switch to timeGridDay view
            },
        });
        calendar.render();
        // $('#calendar').fullCalendar()
    </script>
    @endif
@endsection
