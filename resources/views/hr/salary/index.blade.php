@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
            <div class="card-body" id="all_leave_tb">
                @if(session('status'))
                    <p class="alert alert-success " x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show">
                        {{session('status')}}
                    </p>
                @endif
                <h4 style="font-weight: bold;" class="mt-4 text-info">{{$data['header']}}</h4>
                <form class="d-flex col-md-8 offset-md-2 mt-4"  action="{{ route('hr.salary.index') }}" method="GET" >
                    @csrf
                    <a href="{{ route('hr.salary.index', ['perPage' => $data['salarys']->perPage()]) }}" style="color: black;">
                        <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                    </a>
                    <input type="hidden" name="perPage" value="{{ $data['salarys']->perPage() }}">
                    <input class="form-control border-info" type="text" name="search" value="{{ $data['search'] }}" placeholder="Search by name" aria-label="Search">
                    <input type="date" class="form-control border-info" name="created_at" value="{{ $data['created'] }}" >
                    <button class="btn btn-outline-info " type="submit">Search</button>
                </form>
                @include('layout.pageLimit')
                <table style="width: 100%;"  class="table table-hover table-striped table-bordered mt-4">
                    @if(count($data['salarys']) > 0 )
                        <thead>
                            <tr class="text-center">
                                <th>Image</th>
                                <th>Name</th>
                                <th>OT</th>
                                <th>OT Amount</th>
                                <th>Dedution</th>
                                <th>Leave</th>
                                <th>Salary</th>
                                <th>Net Salary</th>
                                <th>Bonus</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['salarys'] as $salary)
                                    <tr class="text-center">
                                        <td>
                                            @if(!empty($salary->user->img))
                                                <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $salary->user->img)}}">  
                                            @else
                                                <div class="mt-4" style="height:50px">no img</div>
                                            @endif   
                                        </td>
                                        <td>{{ $salary->user->name }}</td>                                   
                                        <td>{{ $salary->ot_time }} Hrs</td>
                                        <td>{{ $salary->ot_amount }}</td>
                                        <td>{{ $salary->dedution }}</td>
                                        <td>{{ $salary->leave }}</td>
                                        <td>{{ $salary->salary }}</td>
                                        <td>{{ $salary->net_salary }}</td>
                                        <td>
                                            @if($salary->bonus == null)
                                                N/A
                                            @else
                                                {{ $salary->bonus }}
                                            @endif
                                        </td>  
                                        <td>{{ $salary->created_at->format('F j, Y ') }}</td>                                
                                    </tr>
                            @endforeach                           
                        </tbody>
                    @else
                        <h3 class="text-danger text-center mt-5">no salary result!</h3>
                    @endif
                </table>
                <div id="paginagtion">
                    {{$data['salarys']->links()}}
                </div>
            </div>
    </div>
@endsection