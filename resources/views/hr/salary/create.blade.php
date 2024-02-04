@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer mt-4">
    <div class="mb-3 col-md-6 offset-md-3 p-4 card">
        @include('layout.flashmessage')
        <div class="">
            <h4 class="mb-4 text-center" style="font-weight:bold;">{{$data['header']}}</h4>
            <a href="{{ route('hr.dashboard') }}" class="me-2 text-info" style="font-size: 28px;margin-top:-55px;position:absolute;right:20px;">
                <i class="fas fa-arrow-alt-circle-left"></i>
            </a>  
        </div>
        <div class="offset-md-1">
            <p>Date: {{ $data['salary']['date']->format('F j, Y') }}</p>
            <p>User Name: {{ $data['user']->name }}</p>
            @if(now()->month == 12)
                <p>Rating : {{ $data['salary']['rating'] }}</p>
            @endif
            <p>Basic Salary : {{ $data['user']->basic_salary }}</p>
            <p>OT Rate : {{ $data['user']->ot_rate }}</p>
            <p>Hourly Rate : {{ $data['user']->hourly_rate }}</p>
            <hr>
            <p>Annual Leave : {{ $data['salary']['annual_leave'] }}</p>
            <p>Other Leave : {{ $data['salary']['leave'] }}</p>
            <p>OT Time : {{ $data['salary']['ot_time'] }}</p>
            <p>OT Amount : {{ $data['salary']['ot_amount'] }}</p>
            @if(now()->month == 12)
                <p>Leave Bonus : {{ $data['salary']['bonus'] }} (basic salary)</p>
                <p>Rating Bonus : {{ $data['salary']['rating_bonus'] }}</p>
            @endif
            <p>Salary : {{ $data['salary']['salary'] }}</p>
            <p>Dedution : {{ $data['salary']['dedution'] }}</p>
            <p>Net Salary : {{ $data['salary']['net_salary'] }}</p>
     
            <a href="{{ route('generate.pdf',$data['user']->id) }}" style="text-decoration: none;" class="mb-2">
                generate pdf
            </a>  
        </div>       
        <form method="post" action="{{ route('hr.salary.store',$data['user']->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="">
                <div class="d-flex justify-content-end mt-3 ">
                    <button type="reset" class="btn btn-sm bg-danger me-5 text-white " style="box-shadow: 1px 2px 9px black;">
                        cancel
                    </button>
                    <button type="submit" class="btn btn-sm bg-primary text-white " style="box-shadow: 1px 2px 9px black;margin-left:1rem;">submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection