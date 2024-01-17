@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
            <div class="card-body" id="all_leave_tb">
                @include('layout.flashmessage')
                <h4 style="font-weight: bold;" class="mt-4">{{$data['header']}}</h4>
                <form class="d-flex col-md-8 offset-md-2 mt-3"  action="{{ route('admin.attendance.index') }}" method="GET" >
                    @csrf
                    <a href="{{ route('admin.attendance.index', ['perPage' => $data['attendances']->perPage()]) }}" style="color: black;">
                        <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                    </a>
                    <input type="hidden" name="perPage" value="{{ $data['attendances']->perPage() }}">
                    @include('layout.searchbar')
                </form>

                <div class="mt-3">
                    @include('layout.pageLimit')
                </div>

                <table style="width: 100%;"  class="table table-hover table-striped table-bordered mt-4">
                    @if(count($data['attendances']) > 0 )
                        <thead>
                            <tr class="text-center">
                                <th>Image</th>
                                <th>Name</th>
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
                                    <td>{{$attendance->date->format('F j, Y g:i a')}}</td>
                                    <td>{{$attendance->clock_in->format('h:i A')}}</td>
                                    <td>{{$attendance->clock_out->format('h:i A')}}</td>
                                    <td>{{$attendance->overtime}} Hrs</td>
                                    <td>
                                        <form method="post" action="{{ route('attendance.destroy',$attendance->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border:none;cursor:pointer;background:none;" class=" text-danger">
                                                Delete
                                            </button>
                                        </form>
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