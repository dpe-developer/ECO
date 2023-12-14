@extends('adminlte.app')
@section('style')
<link rel="stylesheet" href="{{ asset('plugins/chart.js/Chart.min.css') }}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pendingAppointments }}</h3>
                            <p>Pending Appointments</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-calendar-clock"></i>
                        </div>
                        <a href="{{ route('appointments.index', ['filter' => 1, 'filter_appointment_status' => array('pending')]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $confirmedAppointments }}</h3>
                            <p>Confirmed Appointments</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-calendar-check"></i>
                        </div>
                        <a href="{{ route('appointments.index', ['filter' => 1, 'filter_appointment_status' => array('confirmed')]) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $appointmentsToday }}</h3>
                            <p>Appointments Today</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-calendar-day"></i>
                        </div>
                        <a href="{{ route('appointments.index', ['view' => 'calendar', 'filter' => 1, 'filter_date_option' => 'today']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $patients }}</h3>
                            <p>Total Patients</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="{{ route('patients.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Appointments <span id="appointmentsChartDateFilter">This Week ({{ Carbon::now()->startOfWeek()->format('M d,Y') }} - {{ Carbon::now()->endOfWeek()->format('M d,Y') }})</span></h5>
                            {{-- <div class="card-tools">
                                <button class="btn btn-tool bg-gradient-info" type="button" data-toggle="modal" data-target="#filterAppointmentsChartModal">Filter</button>
                            </div> --}}
                        </div>
                        <div class="card-body" id="appointmentsChartContainer">
                            {!! $appointmentsThisWeekChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Findings <span id="findingsChartDateFilter">({{ Carbon::now()->format('F Y') }})</span></h5>
                            <div class="card-tools">
                                <button class="btn btn-tool bg-gradient-info" type="button" data-toggle="modal" data-target="#filterFindingsChartModal">Filter</button>
                            </div>
                        </div>
                        <div class="card-body" id="findingsChartContainer">
                            {!! $findingsThisMonthChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h5 class="card-title">Findings by Patient Age <span id="findingsByAgeChartDateFilter"></span></h5>
                            <div class="card-tools">
                                <button class="btn btn-tool bg-gradient-info" type="button" data-toggle="modal" data-target="#filterFindingsByAgeModal">Filter</button>
                            </div>
                        </div>
                        <div class="card-body" id="findingsByAgeChartContainer">
                            {!! $findingsByPatientAgeChart->container() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="jumbotron text-center">
                        <h1>{{ config('app.client_name') }}</h1>
                    </div>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
{{-- Modals --}}
<form method="GET" action="{{ route('dashboard') }}" autocomplete="off" id="filterAppointmentsForm">
	<div class="modal fade" id="filterAppointmentsModal" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Filter Appointments Chart</h5>
					<a href="javascript:void(0)" class="close" data-dismiss="modal-ajax">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<div class="form-group">
                        <label>Date:</label>
                        <select class="form-control select2 date-option" name="filter_date_option" data-target="#appointmentsDateRange" required>
                            <option></option>
                            <option {{ request()->get('filter_date_option') ==  'today' ? 'selected' : '' }} value="today">Today</option>
                            <option {{ request()->get('filter_date_option') ==  'yesterday' ? 'selected' : '' }} value="yesterday">Yesterday</option>
                            <option {{ request()->get('filter_date_option') ==  'this week' ? 'selected' : '' }} value="this week">This Week</option>
                            <option {{ request()->get('filter_date_option') ==  'last week' ? 'selected' : '' }} value="last week">Last Week</option>
                            <option {{ request()->get('filter_date_option') ==  'this month' ? 'selected' : '' }} value="this month">This Month</option>
                            <option {{ request()->get('filter_date_option') ==  'last month' ? 'selected' : '' }} value="last month">Last Month</option>
                            <option {{ request()->get('filter_date_option') ==  'this year' ? 'selected' : '' }} value="this year">This Year</option>
                            <option {{ request()->get('filter_date_option') ==  'range' ? 'selected' : '' }} value="range">Range</option>
                        </select>
                        <div class="row date-range d-none" id="appointmentsDateRange">
                            <div class="col-sm-6">
                                <div class="input-group input-group-compact">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            From
                                        </span>
                                    </div>
                                    <input type="date" class="form-control" name="filter_date_from">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group input-group-compact">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            To
                                        </span>
                                    </div>
                                    <input type="date" class="form-control" name="filter_date_to">
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn bg-gradient-success"><i class="fa fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
</form>
<form method="GET" action="{{ route('dashboard') }}" autocomplete="off" id="filterFindingsForm">
	<div class="modal fade" id="filterFindingsChartModal" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Filter Findings Chart</h5>
					<a href="javascript:void(0)" class="close" data-dismiss="modal-ajax">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<div class="form-group">
                        <label>Date:</label>
                        <select class="form-control select2 date-option" name="filter_date_option" data-target="#findingsDateRange" required>
                            <option></option>
                            <option {{ request()->get('filter_date_option') ==  'today' ? 'selected' : '' }} value="today">Today</option>
                            <option {{ request()->get('filter_date_option') ==  'yesterday' ? 'selected' : '' }} value="yesterday">Yesterday</option>
                            <option {{ request()->get('filter_date_option') ==  'this week' ? 'selected' : '' }} value="this week">This Week</option>
                            <option {{ request()->get('filter_date_option') ==  'last week' ? 'selected' : '' }} value="last week">Last Week</option>
                            <option {{ request()->get('filter_date_option') ==  'this month' ? 'selected' : '' }} value="this month">This Month</option>
                            <option {{ request()->get('filter_date_option') ==  'last month' ? 'selected' : '' }} value="last month">Last Month</option>
                            <option {{ request()->get('filter_date_option') ==  'this year' ? 'selected' : '' }} value="this year">This Year</option>
                            <option {{ request()->get('filter_date_option') ==  'range' ? 'selected' : '' }} value="range">Range</option>
                        </select>
                        <div class="row date-range d-none" id="findingsDateRange">
                            <div class="col-sm-6">
                                <div class="input-group input-group-compact">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            From
                                        </span>
                                    </div>
                                    <input type="date" class="form-control" name="filter_date_from">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group input-group-compact">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            To
                                        </span>
                                    </div>
                                    <input type="date" class="form-control" name="filter_date_to">
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn bg-gradient-success"><i class="fa fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
</form>
<form method="GET" action="{{ route('dashboard') }}" autocomplete="off" id="filterFindingsByAgeForm">
	<div class="modal fade" id="filterFindingsByAgeModal" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Filter Findings by Patient Age Chart</h5>
					<a href="javascript:void(0)" class="close" data-dismiss="modal-ajax">
						<span aria-hidden="true">&times;</span>
					</a>
				</div>
				<div class="modal-body">
					<div class="form-group">
                        <label>Date:</label>
                        <select class="form-control select2 date-option" name="filter_date_option" data-target="#findingsByAgeDateRange" required>
                            <option></option>
                            <option {{ request()->get('filter_date_option') ==  'today' ? 'selected' : '' }} value="today">Today</option>
                            <option {{ request()->get('filter_date_option') ==  'yesterday' ? 'selected' : '' }} value="yesterday">Yesterday</option>
                            <option {{ request()->get('filter_date_option') ==  'this week' ? 'selected' : '' }} value="this week">This Week</option>
                            <option {{ request()->get('filter_date_option') ==  'last week' ? 'selected' : '' }} value="last week">Last Week</option>
                            <option {{ request()->get('filter_date_option') ==  'this month' ? 'selected' : '' }} value="this month">This Month</option>
                            <option {{ request()->get('filter_date_option') ==  'last month' ? 'selected' : '' }} value="last month">Last Month</option>
                            <option {{ request()->get('filter_date_option') ==  'this year' ? 'selected' : '' }} value="this year">This Year</option>
                            <option {{ request()->get('filter_date_option') ==  'range' ? 'selected' : '' }} value="range">Range</option>
                        </select>
                        <div class="row date-range d-none" id="findingsByAgeDateRange">
                            <div class="col-sm-6">
                                <div class="input-group input-group-compact">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            From
                                        </span>
                                    </div>
                                    <input type="date" class="form-control" name="filter_date_from">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group input-group-compact">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            To
                                        </span>
                                    </div>
                                    <input type="date" class="form-control" name="filter_date_to">
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn bg-gradient-success"><i class="fa fa-save"></i> Save</button>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection
@section('script')
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
{{-- <script src="{{ asset('plugins/chart.js/Chart.bundle.min.js') }}"></script> --}}
{{-- <script src="{{ asset('plugins/chart.js/Chart.bundle.custom.js') }}"></script> --}}
<script src="{{ asset('plugins/chart.js/chartjs-plugin-datalabels.js') }}"></script>
{!! $findingsByPatientAgeChart->script() !!}
{!! $appointmentsThisWeekChart->script() !!}
{!! $findingsThisMonthChart->script() !!}
{{-- <script type="text/javascript">
    // Custom JavaScript to display labels inside the pie chart
    var ctx = window.{{ $findingsThisMonthChart->id }}
    const data = {
        labels: ['A', 'B', 'C'],
        data: [5,3,4]
    }
    var myChart = new Chart({{ $findingsThisMonthChart->id }}, {
        type: 'pie',
        data,
        options: {

        },
        plugins: [ChartDataLabels]
    });
    myChart.update();
</script> --}}
<div id="findingsChartScript"></div>
<script type="text/javascript">
    $(function(){
        $('#filterAppointmentsForm').on('submit', function(event){
            event.preventDefault()
            let form = $(this);
            $.ajax({
                type: "GET",
                url: form.attr('action') + '/filter-appointments-chart',
                data: form.serialize(),
                beforeSend: function(){
                    // $('#loader').fadeIn();
                },
                success: function(response){
                    generateChart(response.chart, '#appointmentsChartContainer');
                    let dateOption = response.dateOption;
                    let dateFilter = response.dateFilter;
                    let dateFrom = response.dateFrom;
                    let dateTo = response.dateTo;
                    let dateFilterText;

                    if(dateOption == 'today' || dateOption == 'yesterday'){
                        dateFilterText = dateOption + ' ('+ dateFilter + ')';
                    } else if(dateOption == 'range') {
                        dateFilterText = ' ('+ dateFrom + ' - ' + dateTo + ')';
                    } else {
                        dateFilterText = dateOption + ' ('+ dateFrom + ' - ' + dateTo + ')';
                    }

                    $('#appointmentsChartDateFilter').text(dateFilterText);
                    $('#filterAppointmentsModal').modal('hide');
                },
                error: function(xhr, ajaxOptions, thrownError){
                    $('#filterAppointmentsModal').modal('hide');
                    ajax_error(xhr, ajaxOptions, thrownError)
                    // $('#loader').fadeOut();
                }
            }).done( function(){
                $('#filterAppointmentsModal').modal('hide');
                // $('#loader').fadeOut();
                form.find('button[type="submit"]').prop('disabled', false).html('<i class="fa fa-save"></i> Save')
            }).fail(function(){
                $('#filterAppointmentsModal').modal('hide');
                // $('#loader').fadeOut();
                form.find('button[type="submit"]').prop('disabled', false).html('<i class="fa fa-save"></i> Save');
            });
        });

        $('#filterFindingsForm').on('submit', function(event){
            event.preventDefault()
            let form = $(this);
            $.ajax({
                type: "GET",
                url: form.attr('action') + '/filter-findings-chart',
                data: form.serialize(),
                beforeSend: function(){
                    // $('#loader').fadeIn();
                },
                success: function(response){
                    generateChart(response.chart, '#findingsChartContainer');
                    let dateOption = response.dateOption;
                    let dateFilter = response.dateFilter;
                    let dateFrom = response.dateFrom;
                    let dateTo = response.dateTo;
                    let dateFilterText;

                    if(dateOption == 'today' || dateOption == 'yesterday'){
                        dateFilterText = dateOption + ' ('+ dateFilter + ')';
                    } else if(dateOption == 'range') {
                        dateFilterText = ' ('+ dateFrom + ' - ' + dateTo + ')';
                    } else {
                        dateFilterText = dateOption + ' ('+ dateFrom + ' - ' + dateTo + ')';
                    }

                    $('#findingsChartDateFilter').text(dateFilterText);
                    $('#filterFindingsChartModal').modal('hide');
                },
                error: function(xhr, ajaxOptions, thrownError){
                    $('#filterFindingsChartModal').modal('hide');
                    ajax_error(xhr, ajaxOptions, thrownError)
                    // $('#loader').fadeOut();
                }
            }).done( function(){
                $('#filterFindingsChartModal').modal('hide');
                // $('#loader').fadeOut();
                form.find('button[type="submit"]').prop('disabled', false).html('<i class="fa fa-save"></i> Save')
            }).fail(function(){
                $('#filterFindingsChartModal').modal('hide');
                // $('#loader').fadeOut();
                form.find('button[type="submit"]').prop('disabled', false).html('<i class="fa fa-save"></i> Save');
            });
        });

        $('#filterFindingsByAgeForm').on('submit', function(event){
            event.preventDefault()
            let form = $(this);
            $.ajax({
                type: "GET",
                url: form.attr('action') + '/filter-findings-by-patient-age-chart',
                data: form.serialize(),
                beforeSend: function(){
                    // $('#loader').fadeIn();
                },
                success: function(response){
                    generateChart(response.chart, '#findingsByAgeChartContainer');
                    let dateOption = response.dateOption;
                    let dateFilter = response.dateFilter;
                    let dateFrom = response.dateFrom;
                    let dateTo = response.dateTo;
                    let dateFilterText;

                    if(dateOption == 'today' || dateOption == 'yesterday'){
                        dateFilterText = dateOption + ' ('+ dateFilter + ')';
                    } else if(dateOption == 'range') {
                        dateFilterText = ' ('+ dateFrom + ' - ' + dateTo + ')';
                    } else {
                        dateFilterText = dateOption + ' ('+ dateFrom + ' - ' + dateTo + ')';
                    }

                    $('#findingsByAgeChartDateFilter').text(dateFilterText);
                    $('#filterFindingsByAgeModal').modal('hide');
                },
                error: function(xhr, ajaxOptions, thrownError){
                    $('#filterFindingsByAgeModal').modal('hide');
                    ajax_error(xhr, ajaxOptions, thrownError)
                    // $('#loader').fadeOut();
                }
            }).done( function(){
                $('#filterFindingsByAgeModal').modal('hide');
                // $('#loader').fadeOut();
                form.find('button[type="submit"]').prop('disabled', false).html('<i class="fa fa-save"></i> Save')
            }).fail(function(){
                $('#filterFindingsByAgeModal').modal('hide');
                // $('#loader').fadeOut();
                form.find('button[type="submit"]').prop('disabled', false).html('<i class="fa fa-save"></i> Save');
            });
        });

        function generateChart(chart, containerID){
            let chartID = chart.id
            $(containerID).html('<canvas id="'+chartID+'"></canvas>');
            var ctvChart = document.getElementById(chartID).getContext('2d');
            // let createChart = function (data) {
            rendered = true;
            // document.getElementById(chartID+"_loader").style.display = 'none';
            // document.getElementById(chartID).style.display = 'block';
            $('#'+chartID).css({
                'display': 'block',
                'height': '400px'
            })
            let dataset = [];
            chart.datasets.forEach(element => {
                dataset.push({
                    label: element.label == undefined ? element.name : element.label,
                    data: element.values,
                    backgroundColor: element.options.backgroundColor,
                    borderWidth: element.options.borderWidth,
                    borderColor: element.options.borderColor,
                });
            });
            let createChart = new Chart($('#'+chartID), {
                type: chart.datasets[0].type,
                data: {
                    labels: chart.labels,
                    datasets: dataset
                },
                options: chart.options,
                plugins: []
            });
            // }
            /* let rendered = false;
            let load = function () {
                console.log("load()");
                if (document.getElementById(chartID)) {
                    createChart(chart)
                }
            }; */
            // window.addEventListener("load", load);
            // document.addEventListener("turbolinks:load", load);
        }
    })
</script>
<script>
    $(function () {
        // $('#filterAppointments').modal('show')
        $(document).on('change', '.date-option', function(){
            changeDateOption($(this));
        });

        $('.date-option').on('each', function(){
            changeDateOption($(this));
        });
        function changeDateOption(dateOption){
            let target = dateOption.data('target');
            if(dateOption.val() == 'range'){
                $(target).removeClass('d-none');
            }else{
                $(target).addClass('d-none');
            }
        }
    });
</script>
@endsection
