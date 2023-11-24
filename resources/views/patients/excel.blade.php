<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Excel</title>

    <link href="{{ asset('bootstrap-5.2.3/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <table class="table table-bordered table-sm">
            <tr>
                <th rowspan="2">Date</th>
                <th rowspan="2">Age</th>
                <th rowspan="2">Sex</th>
                @if($patientVisits->first()->eyePrescriptions->count() > 0)
                    @foreach ($patientVisits->first()->eyePrescriptions->first()->result as $result)
                        @if($result->parent_id == null)
                        <th class="text-center" colspan="{{ $result->children->count() }}">
                            {{ $result->name }}
                        </th>
                        @endif
                    @endforeach
                @endif
                <th rowspan="2">Findings</th>
            </tr>
            <tr>
                @if($patientVisits->first()->eyePrescriptions->count() > 0)
                    @foreach ($eyePrescriptions->first()->result as $result)
                        @if($result->parent_id != null)
                        <td>
                            {{ $result->name }}
                        </td>
                        @endif
                    @endforeach
                @endif
            </tr>
            @foreach ($patientVisits as $patientVisit)
                @foreach ($patientVisit->eyePrescriptions as $eyePrescription)
                    <tr>
                        <td>{{ Carbon::parse($patientVisit->visit_date)->format('M-d-Y') }}</td>
                        <td>{{ $patientVisit->patient->age(Carbon::parse($patientVisit->visit_date)) }}</td>
                        <td>{{ $patientVisit->patient->sex }}</td>
                            @foreach ($eyePrescription->result as $result)
                                @if($result->parent_id != null)
                                <td>
                                    {{ $result->value }}
                                </td>
                                @endif
                            @endforeach
                        <td>
                            @if(!is_null($patientVisit->findings))
                                @foreach (json_decode($patientVisit->findings, true) as $finding)
                                    {{ $finding }}@if(!$loop->last), @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>
</body>
</html>