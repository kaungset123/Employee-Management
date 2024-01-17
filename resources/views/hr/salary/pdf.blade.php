<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="mb-3 col-md-6 offset-md-3 p-5 card">
        <h2 style="text-align: center;">{{ $title }}</h2>
        <p>Date: {{  $date->format('F j, Y') }}</p>
        <p>Staff Name: {{ $user->name }}</p>
        <p>Basic Salary : {{ $user->basic_salary }}</p>
        <p>OT Rate : {{ $user->ot_rate }}</p>
        <p>Hourly Rate : {{ $user->hourly_rate }}</p>
        <hr>
        <p>Annual Leave : {{ $salary['annual_leave'] }}</p>
        <p>Other Leave : {{ $salary['leave'] }}</p>
        <p>OT Time : {{ $salary['ot_time'] }}</p>
        <p>OT Amount : {{ $salary['ot_amount'] }}</p>
        <p>Salary : {{ $salary['salary'] }}</p>
        <p>Dedution : {{ $salary['dedution'] }}</p>
        <p>Net Salary : {{ $salary['net_salary'] }}</p>
        <p>
            @if($salary['bonus'] != null)
                Bonus : {{ $salary['bonus'] }}
            @else
                Bonus : 0
            @endif
        </p>
       
    </div>
</body>
</html>