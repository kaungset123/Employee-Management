@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
            <div class="card-body" id="all_leave_tb">
                @include('layout.flash_message')
                <h4 style="font-weight: bold;" class="mt-3 text-info">{{$data['header']}}</h4>
                <form class="d-flex col-md-6 offset-md-3 mt-4"  action="{{ route('employee.salary.index') }}" method="GET" >
                    @csrf
                    <a href="{{ route('employee.salary.index', ['perPage' => $data['salaries']->perPage()]) }}" style="color: black;">
                        <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                    </a>
                    <input type="hidden" name="perPage" value="{{ $data['salaries']->perPage() }}">
                    <input type="date" class="form-control border-info" name="created_at" value="{{ $data['created'] }}" >
                    <button class="btn btn-outline-info " type="submit">Search</button>
                </form>
                <div class="">
                    @include('layout.pageLimit')
                </div>
                <table style="width: 100%;"  class="table table-hover table-bordered mt-4">
                    @if(count($data['salaries']) > 0 )
                        <thead>
                            <tr class="text-center">
                                <th>Image</th>
                                <th>Name</th>
                                <th>OT</th>
                                <th>OT Amount</th>
                                <th>Deduction</th>
                                <th>Leave</th>
                                <th>Salary</th>
                                <th>Bonus</th>
                                <th>Net Salary</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['salaries'] as $salary)
                                    <tr class="text-center">
                                        <td>
                                            @if(!empty($salary->user->img))
                                                <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $salary->user->img)}}">     
                                            @else
                                                <img class="manager_img" src="{{ asset('/images/user.jpg') }}">
                                            @endif
                                        </td>
                                        <td>{{ $salary->user->name }}</td>                                   
                                        <td>
                                            @if($salary->ot_time <= 1)
                                                {{ $salary->ot_time }} Hr
                                            @else
                                                {{ $salary->ot_time }} Hrs
                                            @endif
                                        </td>
                                        <td>{{ $salary->ot_amount }}</td>
                                        <td>{{ $salary->deduction }}</td>
                                        <td>{{ $salary->leave }}</td>
                                        <td>{{ $salary->salary }}</td>
                                        <td>
                                            @if($salary->bonus == null)
                                                N/A
                                            @else
                                                {{ $salary->bonus }}
                                            @endif
                                        </td>
                                        <td>{{ $salary->net_salary }}</td>
                                        <td>{{ $salary->created_at->format('F j, Y ') }}</td>                                  
                                    </tr>
                            @endforeach                           
                        </tbody>
                    @else
                        <h4 class="text-danger text-center mt-5">no salary result!</h4>
                    @endif
                </table>
                <div id="pagination">
                    {{$data['salaries']->links()}}
                </div>
            </div>
    </div>
@endsection