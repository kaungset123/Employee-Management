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

    <table style="width: 100%;" class="table table-hover table-bordered mt-4">
        <thead>
            <tr class="text-center">
                <th>Date</th>
                <th>From</th>
                <th>To</th>
                <th>Leave Type</th>
                <th>Total Day</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaves as $leave)
                <tr style="text-align:center;">
                    <td>{{ $leave->created_at->format('F j, Y ') }}</td>
                    <td>{{ $leave->start_date->format('F j, Y ')}}</td>
                    <td>{{ $leave->end_date->format('F j, Y ')}}</td>
                    <td>{{ $leave->name }}</td>
                    <td>{{ $leave->total_days }}</td>
                    <td>
                        @if($leave->status == 1)
                            Accepted
                        @elseif($leave->status == 2)
                            Rejected
                        @endif
                    </td>
                </tr>   
            @endforeach
        </tbody>
    </table>
</body>

</html>