@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer mt-4">
    <div class="mb-3 col-md-6 offset-md-3 p-5 card">
        <div class="">
            @include('layout.flashmessage')
        </div>
        <h4 class="mb-3 text-center" style="font-weight:bold;">{{$data['header']}}</h4>
        <form method="post" action="{{ route('leave.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <div class="">
                <div class="">
                    <div class="form-group">
                        <label for="name">Leave Type</label>
                        <select class="form-control" name="name">
                            <option value="annual leave">annual leave</option>
                            <option value="other leave">other leave</option>
                        </select>
                        @error('name')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="form-group">
                        <label for="is_half_day">Half Day</label>
                        <input type="checkbox" class="ms-3" name="is_half_day" value="1">
                    </div>
                </div>
                <div class="">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input type="date" class="form-control" name="start_date" value="{{ old('start_date') }}">
                        @error('start_date')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control" name="end_date" value="{{ old('end_date') }}">
                        @error('end_date')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mt-3 ">
                <button type="reset" class="btn btn-sm bg-danger me-5 text-white " style="box-shadow: 1px 2px 9px black;">
                    cancel
                </button>
                <button type="submit" class="btn btn-sm bg-primary text-white " style="box-shadow: 1px 2px 9px black;margin-left:1rem;">submit</button>
            </div>
        </form>
    </div>
</div>
@endsection