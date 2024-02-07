@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
        <div class="mt-4">
            <div class="card col-md-10 mt-3 offset-md-1 p-5">
                @include('layout.flash_message')
                <div class="">
                    <h3 class="mb-3 text-info" style="font-weight: bold;">{{$data['header']}}</h3>
                    <a href="{{ route('hr.dashboard') }}" class="me-2 text-info" style="font-size: 28px;margin-top:-48px;position:absolute;right:43px;">
                        <i class="fas fa-arrow-alt-circle-left"></i>
                    </a>               
                </div>
                <form action="{{ route('attendance.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $data['user']->id }}">
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" class="form-control" value="{{ $data['user']->name }}">
                                @error('name')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Date</label>
                                <input type="date" class="form-control" name="date" value="{{ old('date') }}">
                                @error('date')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="form-group col-md-6">
                            <label for="clock_in">Clock-in Time</label>
                            <input type="time" class="form-control" name="clock_in" value="{{ old('clock_in') }}">
                            @error('clock_in')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="clock_out">Clock-out Time</label>
                            <input type="time" class="form-control" name="clock_out" value="{{ old('clock_out') }}">
                            @error('clock_out')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3 ">
                        <button type="reset" class="btn btn-sm bg-danger me-4 text-white " style="box-shadow: 1px 2px 9px black;">
                            cancel
                        </button>
                        <button type="submit" class="btn btn-sm bg-primary text-white" style="box-shadow: 1px 2px 9px black;margin-left:1rem;">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection