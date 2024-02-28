@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
            <div class="card-body" id="all_leave_tb">
                @include('layout.flash_message')
                <h4 style="font-weight: bold;" class="mt-3 text-info">{{$data['header']}}</h4>
                <form class="d-flex col-md-6 offset-md-3 mt-4"  action="{{ route('employee.attendance.index') }}" method="GET" >
                    @csrf
                    <a href="{{ route('employee.attendance.index', ['perPage' => $data['attendances']->perPage()]) }}" style="color: black;">
                        <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                    </a>
                    <input type="hidden" name="perPage" value="{{ $data['attendances']->perPage() }}">
                    <input type="date" class="form-control border-info" name="created_at" value="{{ $data['created'] }}" >
                    <button class="btn btn-outline-info " type="submit">Search</button>
                </form>
                <div class="">
                    @include('layout.pageLimit')
                </div>
                <table style="width: 100%;"  class="table table-hover table-bordered mt-4">
                    @if(count($data['attendances']) > 0 )
                        <thead>
                            <tr class="text-center">
                                <th>Image</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Clock-in</th>
                                <th>Clock-out</th>
                                <th>Ot Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['attendances'] as $attendance)
                                    <tr class="text-center">
                                        <td>
                                            @if(!empty($attendance->user->img))
                                                <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $attendance->user->img)}}">  
                                            @else
                                                <img class="manager_img" src="{{ asset('/images/user.jpg') }}">
                                            @endif   
                                        </td>
                                        <td>{{$attendance->user->name}}</td>                                   
                                        <td>{{$attendance->date->format('F j, Y')}}</td>
                                        <td>{{$attendance->clock_in->format('h:i A')}}</td>
                                        <td>{{$attendance->clock_out->format('h:i A')}}</td>
                                        <td>
                                            @if($attendance->overtime <= 1)
                                                {{$attendance->overtime}} Hr
                                            @else
                                                {{$attendance->overtime}} Hrs
                                            @endif                                
                                        </td>                                 
                                    </tr>
                            @endforeach                           
                        </tbody>
                    @else
                        <h4 class="text-danger text-center mt-5">no attendance yet!</h4>
                    @endif
                </table>
                <div id="pagination">
                    {{$data['attendances']->links()}}
                </div>
            </div>
    </div>
@endsection