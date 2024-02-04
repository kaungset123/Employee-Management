@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
            <div class="card-body" id="all_leave_tb">
                @include('layout.flashmessage')
                <h4 style="font-weight: bold;" class="mt-3 text-info">{{$data['header']}}</h4>
                <form class="d-flex col-md-8 offset-md-2 mt-4"  action="{{ route('salary.deleteList') }}" method="GET" >
                    @csrf
                    <a href="{{ route('salary.deleteList', ['perPage' => $data['salarys']->perPage()]) }}" style="color: black;">
                        <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                    </a>
                    <input type="hidden" name="perPage" value="{{ $data['salarys']->perPage() }}">
                    @include('layout.searchbar')
                </form>
                <div class="">
                    @include('layout.pageLimit')
                    <a href="{{ route('salary.index') }}" class="me-2 text-info" style="font-size:31px;margin-top:-4px;position:absolute;right:27px;">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                    </a>
                </div>
                <table style="width: 100%;"  class="table table-hover table-bordered mt-4">
                    @if(count($data['salarys']) > 0 )
                        <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Department</th>
                                <th>OT</th>
                                <th>OT Amount</th>
                                <th>Dedution</th>
                                <th>Leave</th>
                                <th>Salary</th>
                                <th>Net Salary</th>
                                <th>Bonus</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['salarys'] as $salary)
                                <tr class="text-center">
                                    <td>{{ $salary->user->name }}</td> 
                                    <td>{{ $salary->user->department->name }}</td>                                  
                                    <td>{{ $salary->ot_time }} Hrs</td>
                                    <td>{{ $salary->ot_amount }}</td>
                                    <td>{{ $salary->dedution }}</td>
                                    <td>{{ $salary->leave }}</td>
                                    <td>{{ $salary->salary }}</td>
                                    <td>{{ $salary->net_salary }}</td>
                                    <td>
                                        <div class="my-2">
                                            @if($salary->bonus == null)
                                                N/A
                                            @else
                                                {{ $salary->bonus }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        {{ $salary->created_at->format('F j, Y ') }}
                                    </td>   
                                    <td>
                                        <a href="{{ route('salary.restore',$salary->id) }}" class="text-primary" style="border:none;background:none;text-decoration:none;">
                                            Restore
                                        </button>
                                    </td>                               
                                </tr>
                            @endforeach                           
                        </tbody>
                    @else
                        <h4 class="text-danger text-center mt-5">no salary result!</h4>
                    @endif
                </table>
                <div id="paginagtion">
                    {{$data['salarys']->links()}}
                </div>
            </div>
    </div>
@endsection