@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
            <div class="card-body" id="all_leave_tb">
                @include('layout.flashmessage')
                <h4 style="font-weight: bold;" class="mt-3 text-info">{{$data['header']}}</h4>
                <form class="d-flex col-md-8 offset-md-2 mt-3"  action="{{ route('attendance.deleteList') }}" method="GET" >
                    @csrf
                    <a href="{{ route('attendance.deleteList', ['perPage' => $data['attendances']->perPage()]) }}" style="color: black;">
                        <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                    </a>
                    <input type="hidden" name="perPage" value="{{ $data['attendances']->perPage() }}">
                    @include('layout.searchbar')
                </form>

                <div class="mt-3">
                    @include('layout.pageLimit')
                    <a href="{{ route('admin.attendance.index') }}" class="me-2 text-info" style="font-size:31px;margin-top:-4px;position:absolute;right:27px;">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                    </a>
                </div>

                <table style="width: 100%;"  class="table table-hover table-bordered mt-4">
                    @if(count($data['attendances']) > 0 )
                        <thead>
                            <tr class="text-center">
                                <th>Image</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Date</th>
                                <th>Clock-in</th>
                                <th>Clock-out</th>
                                <th>Ot Time</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['attendances'] as $attendance)
                                <tr class="text-center">
                                    <td>
                                        <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $attendance->user->img)}}">     
                                    </td>
                                    <td>{{$attendance->user->name}}</td>     
                                    <td>{{$attendance->user->department->name}}</td>
                                    <td>{{$attendance->date->format('F j, Y ')}}</td>
                                    <td>{{$attendance->clock_in->format('h:i A')}}</td>
                                    <td>{{$attendance->clock_out->format('h:i A')}}</td>
                                    <td>{{$attendance->overtime}} Hrs</td>
                                    <td>
                                        <a href="{{ route('attendance.restore',$attendance->id) }}" style="border:none;text-decoration:none;" class=" text-success" >
                                            Restore
                                        </a>
                                    </td>                                  
                                </tr>
                            @endforeach                           
                        </tbody>
                    @else
                        <h4 class="text-danger text-center mt-5">no attendance result!</h4>
                    @endif
                </table>
                
                <div id="paginagtion">
                    {{$data['attendances']->links()}}
                </div>
            </div>
    </div>
@endsection