<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div style="margin-bottom:10px;">
        <b>HR :</b> {{ $hr->name }}<br>
        <b>Staff : </b> {{ $staff->name }}<br>
        <b>Department :</b> {{ $staff->department->name }} department <br>
        <b>Released Date : </b> {{ $released_date->format('F j, Y') }}
    </div>
    <table style="width: 100%;" class="table table-hover table-bordered ">
        <thead>
            <tr class="text-center">
                <th>Date</th>
                <th>Clock-in</th>
                <th>Clock-out</th>
                <th>Ot Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr style="text-align:center;">
                    <td>{{ $attendance->date->format('F j, Y ') }}</td>
                    <td>{{ $attendance->clock_in->format('h:i A')}}</td>
                    <td>{{ $attendance->clock_out->format('h:i A')}}</td>
                    <td>{{ $attendance->overtime}}</td>
                </tr>   
            @endforeach
        </tbody>
    </table>
</body>

</html>