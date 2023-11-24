@extends('adminlte.app')

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
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Appointments This Week</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                {!! $appointmentsThisWeekChart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Findings This Month</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                {!! $findingsThisMonthChart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">Findings by Patient Age</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4">
                                {!! $findingsByPatientAgeChart->container() !!}
                            </div>
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
@endsection
@section('script')
{!! $findingsByPatientAgeChart->script() !!}
{!! $appointmentsThisWeekChart->script() !!}
{!! $findingsThisMonthChart->script() !!}
{{-- <script type="text/javascript">
    // Custom JavaScript to display labels inside the pie chart
    $(document).ready(function() {
        var chart = {{ $findingsThisMonthChart->id }};
        chart.update({
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            }
        });
    });
</script> --}}
@endsection
