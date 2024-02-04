@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
            <div class="card-body" id="all_leave_tb">
                @include('layout.flashmessage')
                <h4 style="font-weight: bold;" class="mt-3 text-info">{{$data['header']}}</h4>
                <form class="d-flex col-md-8 offset-md-2 mt-4"  action="{{ route('salary.index') }}" method="GET" >
                    @csrf
                    <a href="{{ route('salary.index', ['perPage' => $data['salarys']->perPage()]) }}" style="color: black;">
                        <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                    </a>
                    <input type="hidden" name="perPage" value="{{ $data['salarys']->perPage() }}">
                    @include('layout.searchbar')
                </form>
                <div class="" style="position: relative;">
                    @include('layout.pageLimit')
                    <div class="" style="position: absolute;right:1rem;top:3px;">
                        <a href="{{ route('salary.deleteList') }}" id="project_delete_list">
                            @include('component.deleteButton')
                        </a>
                    </div>
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
                                    <td>
                                        @if($salary->ot_time <= 1)
                                            {{ $salary->ot_time }} Hr
                                        @else
                                            {{ $salary->ot_time }} Hrs
                                        @endif
                                    </td>
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
                                        <form action="{{ route('salary.destroy', $salary->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger" style="border:none;background:none;" onclick="return confirm('Are you sure you want to delete this item?')">
                                                Delete
                                            </button>
                                        </form>  
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