@extends("layout.master")
@section("title",$data['title'])

@section('content')
        <div class="app-main__outer mt-5">
            <div class="card col-md-10 offset-md-1 p-5" style="flex: none;">
                @include('layout.flashmessage')
                <div class="" style="position: relative;">
                    <h4 class="mb-3 text-info" style="font-weight: bold;">{{$data['header']}}</h4>
                    <a href="{{ route('attendance.index') }}" class="me-2 text-info" style="font-size: 28px;margin-top:-43px;position:absolute;right:0px;">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                    </a>
                </div>
                <form action="{{ route('attendance.update',$data['attendance']->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" value="{{ $data['attendance']->user->id }}">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" class="form-control"  value="{{ $data['attendance']->user->name }}">
                                @error('name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Date</label>
                                <input type="date" class="form-control" name="date" value="{{ $data['attendance']->date->format('Y-m-d') }}" >
                                @error('date')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="form-group col-md-6">
                            <label for="clock_in">Clock-in Time</label>
                            <input type="time" class="form-control" name="clock_in" value="{{ $data['attendance']->clock_in->format('H:i:s')  }}">
                            @error('clock_in')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="clock_out">Clock-out Time</label>
                            <input type="time" class="form-control" name="clock_out" value="{{ $data['attendance']->clock_out->format('H:i:s')  }}" >
                            @error('clock_out')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>               
                    <div class="d-flex justify-content-end mt-3 ">
                        <button type="reset" class="btn btn-sm bg-danger me-5 text-white " style="box-shadow: 1px 2px 9px black;">
                            cancel
                        </button>
                        <button type="submit" class="btn btn-sm bg-primary text-white" style="box-shadow: 1px 2px 9px black;margin-left:1rem;">Update</button>
                    </div>
                </form>
            </div>
        </div>
@endsection