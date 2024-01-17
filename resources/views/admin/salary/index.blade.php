@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
            <div class="card-body" id="all_leave_tb">
                @include('layout.flashmessage')
                <h4 style="font-weight: bold;" class="mt-4">{{$data['header']}}</h4>
                <form class="d-flex col-md-8 offset-md-2 mt-4"  action="{{ route('salary.index') }}" method="GET" >
                    @csrf
                    <a href="{{ route('salary.index', ['perPage' => $data['salarys']->perPage()]) }}" style="color: black;">
                        <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                    </a>
                    <input type="hidden" name="perPage" value="{{ $data['salarys']->perPage() }}">
                    @include('layout.searchbar')
                </form>
                <div class="mt-3">
                    @include('layout.pageLimit')
                </div>
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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['salarys'] as $salary)
                                <tr class="text-center">
                                    <td>
                                        <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $salary->user->img)}}">     
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
                                    <td>
                                        {{ $salary->created_at->format('F j, Y g:i a') }}
                                    </td>   
                                    <td>
                                        <form action="{{ route('salary.destroy', $salary->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger" style="border:none;background:none;">
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